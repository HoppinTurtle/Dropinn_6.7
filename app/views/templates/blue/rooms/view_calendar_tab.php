 <!-- Required Stylesheets -->
<link href="<?php echo css_url(); ?>/edit_listing.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/calendar_single.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
jQuery.noConflict();
var global_grid = null;
    var select_range_start = null;
    var select_range_stop = null;
    var select_range_click_count = 0;
var reservationHash = new Hash({});
var schedules = [];
var r = null;

function get_square(rowIndex,colIndex) {
return schedules[rowIndex][colIndex];
}
/* A span is selectable if it contains no atomic groups */
function is_selectable(gridRow,gridCol) {
    if (is_address_line(gridRow)) return false;

    var schedule = get_square(gridRow,gridCol);
    if (schedule.gid || schedule.confirmation) {
        return false;
    } else {
        return true;
    }
}

/* If atomic span / grouping, what are the bounds of the span? */
function getAtomicBounds(gridRow,gridCol) {
    var minCol = gridCol;
    var maxCol = gridCol;

    var grouping_uid = get_square(gridRow,gridCol).gid;
    while (get_square(gridRow,maxCol+1) && (get_square(gridRow,maxCol+1).gid==grouping_uid)) {
        maxCol+=1;
    }
    while (get_square(gridRow,minCol-1) && (get_square(gridRow,minCol-1).gid==grouping_uid)) {
        minCol-=1;
    }
    return [minCol,maxCol];
}

function getSpanBounds(gridRow,gridCol) {
    var minCol = gridCol;
    var maxCol = gridCol;

    if (get_square(gridRow,gridCol).sty=='single') return [minCol,maxCol];
    while (get_square(gridRow,maxCol+1) && (get_square(gridRow,maxCol+1).sty!='right')) {
        maxCol+=1;
    }
    return [minCol,maxCol+1];
}
function getSquareText(square,gridRow,gridCol) {
    var dataRow = gridRowToDataRow(gridRow);
    var dataCol = gridColToDataCol(gridCol);

    var hosting = hostings[dataRow];
    
    if (("left"==square.sty) || ("single"==square.sty)) {
        switch(square.st) {
        case 0:
            if (square.daily_price) {
                return hosting.currency_symbol + square.daily_price;
            } else {
                return hosting.currency_symbol + hosting.price;
            }
        case 2:
            if (decodeURIComponent(square.notes)) {
                return decodeURIComponent(square.notes)
            } else {
                return 'Not available';
            }
        case 5:
            if (decodeURIComponent(square.notes)) {
                return decodeURIComponent(square.notes)
            } else {
                return 'Not available';
            }
        case 3:
            if (decodeURIComponent(square.notes)) {
                return square.sst + ": " + decodeURIComponent(square.notes)
            } else {
                return square.sst + ': Not available';
            }
        case 4:
            return "Booked" + (decodeURIComponent(square.notes) ? ": "+decodeURIComponent(square.notes) : '');

        default: return hosting.currency_symbol + hostings[dataRow].price;
        }
    } else if ((dataCol==0) && square.isa) {
        if (square.daily_price) {
            return hosting.currency_symbol + square.daily_price;
        } else {
            return hosting.currency_symbol + hosting.price;
        }
    } else {
        return "&nbsp;";
    }
}


function date_parse_datestamp(datestamp) {
    // yyyy-mm-dd
    var parts = datestamp.split("-");
    return new Date(parts[0],parts[1]-1,parts[2]);
    //return new Date(get_month_abbrev(parts[1]-1)+" "+parts[2]+", "+parts[0]+" 00:00:00 "); // parts[0],parts[1]-1,parts[2]
}
function date_parse_usa_date(datestamp) {
    // mm/dd/yyyy
    var parts = datestamp.split("/");
    return new Date(parts[2],parts[0]-1,parts[1]);
}
function date_print_usa_date(dt) {
    // 2010-03-11: KEEP IT IN THE LOCAL TIMEZONE; OTHERWISE DATE OFFSET PROBLEMS!
    return (dt.getMonth()+1) + "/" + dt.getDate() + "/" + dt.getFullYear();
}
function date_print_simplified(dt) {
    //return get_month_abbrev(dt.getUTCMonth()) + " " + dt.getUTCDate();
    // 2010-03-11: KEEP IT IN THE LOCAL TIMEZONE; OTHERWISE DATE OFFSET PROBLEMS!
    return get_month_abbrev(dt.getMonth()) + " " + dt.getDate();
}

function range_add(i){

				if (select_range_stop == null) return;
				if (i < select_range_start) return;
				if (i < select_range_stop) range_remove(i+1);

				for (var tmp=select_range_stop; tmp <= i; tmp++) {
					jQuery(function($){ 
								if (!is_selectable(0,tmp)) return;
					})			
								rollover('tile_' + tmp, 'tile', 'tile_selected');
								
				}
				select_range_stop = i;
}


function gridColToDataCol(gridCol) {
				return (gridCol);
}

function gridRowToDataRow(gridRow) {
				return (gridRow);
}


function is_address_line(row) {
				return false;
}


function range_remove(i) {
				if (select_range_stop == null) return;
				if (i <= select_range_start) return;
				if (select_range_click_count>=2) return;
				if (i>select_range_stop) return;

				for (; select_range_stop >= i; select_range_stop--) {
								rollover('tile_' + select_range_stop, 'tile_selected', 'tile');
				}

				select_range_stop = i;
}


function range_remove_all() {
				for (var i=select_range_start; i <= select_range_stop; i++) {
								rollover('tile_' + i, 'tile_selected', 'tile');
				}

				select_range_click_count = 0;
				select_range_start = null;
				select_range_stop = null;
}

function click_down(i) {
				select_range_click_count++;

				if (select_range_click_count > 2) {
								range_remove_all();
								return;
				}

				if (select_range_stop != null) return; // abort on second click

				   jQuery(function($){ 
				if (!is_selectable(0, i)) {
								var matches = getAtomicBounds(0,i);
								select_range_start = matches[0];
								select_range_stop = matches[1];
								show_calendar();
								return;
				}
				
				})

				select_range_start = i;
				select_range_stop = i;
				rollover('tile_'+i,'tile','tile_selected');
}

function click_up(i) {
	
	
				if (select_range_click_count == 2) {
					show_calendar();
					range_remove_all();
								
				}
				else
				{
					lwlb_hide('lwlb_calendar2');
				}
					
				
}
function show_calendar() {
				
				prepareLightbox(<?php echo $list_id; ?>,"<?php echo $list_title; ?>",0,select_range_start,select_range_stop);

}

jQuery('#calendar_loading_spinner').hide();

</script>
                <script type="text/javascript">
jQuery.noConflict();


var columnInfo = [<?php echo substr($columnInfo, 0, -1); ?>];

var hostings = [{"price":<?php echo get_currency_value1($list_id,$list_price); ?>,"name":"<?php echo $list_title; ?>","available":1,"row":0,"id":<?php echo $list_id; ?>,"currency_symbol":"<?php  echo get_currency_symbol($list_id); ?>","currency":"<?php  echo get_currency_code(); ?>","lc_name":"<?php echo strtolower($list_title); ?>"}];

schedules = [[<?php echo substr($schedules, 0, -1); ?>]];


var g_start_date = date_parse_datestamp('<?php echo $firstDay; ?>');

var g_stop_date = date_parse_datestamp('<?php echo $lastDay; ?>');
var g_today_index = 19;

var g_enable_change_dates = true;
</script>


<script type="text/javascript">

jQuery.noConflict();
function prepareLightbox(hosting_id,hosting_name,gridRow,gridMinCol,gridMaxCol) {
	var r = null;
    var firstSquare = get_square(gridRow,gridMinCol);
    var lastSquare = get_square(gridRow,gridMaxCol);
    var g_start_date = date_parse_datestamp('<?php echo $firstDay; ?>');
    var startDate = new Date(g_start_date.getTime()); //date_parse_datestamp(firstSquare.dt);
    var stopDate = new Date(g_start_date.getTime()); //date_parse_datestamp(lastSquare.dt);
     var dataRow = gridRowToDataRow(gridRow);
    hostings = [{"price":<?php echo get_currency_value1($list_id,$list_price); ?>,"name":"<?php echo $list_title; ?>","available":1,"row":0,"id":<?php echo $list_id; ?>,"currency_symbol":"<?php  echo get_currency_symbol($list_id); ?>","currency":"<?php  echo get_currency_code(); ?>","lc_name":"<?php echo strtolower($list_title); ?>"}];
    var hosting = hostings[dataRow];

    startDate.setDate(startDate.getDate() + gridColToDataCol(gridMinCol));
    stopDate.setDate(stopDate.getDate() + gridColToDataCol(gridMaxCol));
    if (firstSquare.st==1) {
        g_enable_change_dates = false;
        var r = reservationHash.get(firstSquare.confirmation);
                // Setup the date spanalert()
    var chkin = date_print_usa_date(date_parse_datestamp(r.start_date));
    var chkout = date_print_usa_date(date_parse_datestamp(r.end_date));
}else{
	    g_enable_change_dates = true;
	var chkin =     date_print_usa_date(startDate);
	var chkout = date_print_usa_date(stopDate);
}

    if(chkin != "" && chkout != "" && chkin != chkout)
    {
    	var guest = jQuery('#guests').val();	
jQuery("#book_it_button").hide();
jQuery("#load_sym").show(); 
    	 	 			jQuery.ajax({
            url: "<?php echo base_url()?>rooms/ajax_refresh_subtotal",             
            //GET method is used
            type: "GET",
            //pass the data        
            data: {checkin : chkin,checkout : chkout, hosting_id : hosting_id, number_of_guests : guest},             
            //Do not cache the page
            cache: false,             
            //success
			dataType: "json",
            success: function (data) { 
            	
             			if(jQuery.trim(data.reason_message) != "Those dates are not available")
		  {
		  	jQuery("#book_it_button").removeAttr('disabled');
		  	
		  	refresh_subtotal(data);
		  	jQuery("#load_sym").hide(); 
 
		  } else {
 
		  	   jQuery("#book_it_enabled").hide();
		  	   jQuery("#load_sym").hide();
		  	   jQuery("#show_more_subtotal_info").hide();   
			   jQuery("#book_it_disabled_message").html("Those dates are not available");
			   jQuery("#book_it_disabled").show();
		  }
			}	 	
		});
    
        jQuery('#checkin').val(chkin);	
    jQuery('#checkout').val(chkout);
    jQuery('html, body').animate({
                     scrollTop: '200px'
                 },
                 20);
                 return false;
    }else{
    	alert('Checkin and Checkout dates should not be same');
    	return false;
    }
    

}
/***** SELECTION *****/

</script>			  

<style>

.calender a {
    padding: 0;
}
.row {
	margin-left:0;
}

.calendar-header, .calender_bottom {
    display: none;
}

.calendar-header, .calender_bottom {
    display: none;
}
.Box.editlist_Box {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
}
#calendar2 .tile, #calendar2 .tile_selected {
    width: 89px;
}
#calendar2 .day_header{
	width: 87px;
}
#calendar2 .tile .tile_container, #calendar2 .tile_selected .tile_container{
	background-color:#66CCCC;
}
#calendar2 .tile.disabled .tile_container {
    background-color: rgb(255, 255, 255);
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.41) inset;
}
#calendar2 .tile_selected .tile_container{
	background: rgb(0,166,90) none repeat scroll 0 0 !important;
}
</style>
<!-- Start Alexa Certify Javascript -->
<!-- End Alexa Certify Javascript -->

<div class="row-fluid">
	<div class="span12">
    <div class="View_Edit_Main_Content">
      <div id="notification-area"></div>
      <div id="dashboard-content">
        <div id="dashboard_v2" class="edit_room">
          <div class="row">
            <div class="col three-fourths content">
              <div id="notification-area"></div>
              <div id="dashboard-content">
  <?php
  		
		$first_day     = mktime(0,0,0,$month,1,$year);
		$days_in_month = cal_days_in_month(0,$month,$year);
		$day_of_week   = date('N',$first_day);
		
		$months        = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$title         = $months[date('n',mktime(0,0,0,$month,$day,$year))-1]; 
		
		if ($day_of_week == 7) { $blank = 0; } else { $blank = $day_of_week; }
		
		if (($month-1) == 0) 
		{
		$prevmonth = 1;
		$prevyear  = ($year-1);
		}
		else 
		{
		$prevmonth = ($month-1);
		$prevyear  = $year;
		}
		$day_prevmonth=cal_days_in_month(0,$prevmonth,$prevyear)-($blank-1);
		
		if($month == 01)
		{
		$prev_month = 12; $prev_year = $year - 1;
		}
		else
		{
		$prev_month = $month - 1; $prev_year = $year;
		}
		
		if($month == 12)
		{
		$next_month = 01; $next_year = $year + 1;
		}
		else
		{
		$next_month = $month+1; $next_year = $year;
		}

		$day_num    = 1;
		$day_count  = 1;
		$datenow    = time();
		$monthnow   = date('n',$datenow);
		$yearnow    = date('Y',$datenow);
		$daynow     = date('j',$datenow);
		?> 
                <div>
                  <div class="Box editlist_Box">
                <!--  <div class="Box_Head1">
                    <h2 class="step"><span class="edit_room_icon calendar"></span>Calendar</h2></div>-->
                    	  <div class="full_bubble">
                            <div class="inner">
              <div>
                                <!-- Table -->
                                <div class="calendar-header" style="padding:0px;">
                                	<div><p style="font-size: 20px;">You can also select your check-in and check-out dates by clicking this calendar</p></div>
                                 <!-- <div class="prev-month"> <a href="<?php echo site_url('rooms/calendar_tab/'.$list_id.'?month='.$prev_month.'&year='.$prev_year); ?>"> <img alt="Previous" height="34" src="<?php echo base_url(); ?>images/bttn_month_prev.png" width="35" /> </a> </div>
                                  <div class="next-month"> <a href="<?php echo site_url('rooms/calendar_tab/'.$list_id.'?month='.$next_month.'&year='.$next_year); ?>"> <img alt="Next" height="34" src="<?php echo base_url(); ?>images/bttn_month_next.png" width="35" /> </a> </div>-->
                                  <div class="display-month"><?php echo "$title $year"; ?></div>
								  
                                  <div class="clear"></div>
                                </div>
                                <div>
                                  <div>
                                    <div class="day_header">Sun</div>
                                    <div class="day_header">Mon</div>
                                    <div class="day_header">Tue</div>
                                    <div class="day_header">Wed</div>
                                    <div class="day_header">Thu</div>
                                    <div class="day_header">Fri</div>
                                    <div class="day_header">Sat</div>
                                    <div class="clear"></div>
                                  </div>
                                  <?php $k = 1; $i = 0; $j = 48;	while ($blank > 0) { if($k == 1) echo '<div>'; ?>
                                  <?php if(strtotime($prev_year.'-'.$prev_month.'-'.$day_prevmonth) < time()) { ?>
                                  <div class="tile disabled" id="tile_<?php echo $i; ?>">
                                  	<div class="tile_container">
                                      <div class="day"><?php echo $day_prevmonth; ?></div>
                                      <div class="line_reg" id="square_<?php echo $i; ?>"><span class="endcap"></span> </div>
                                   </div>
                                  </div>
                                  <?php }  else { 
                                  		//seasonal rate
                                  		$date=$prev_month.'/'.$day_prevmonth.'/'.$prev_year;
                                  		$price=getDailyPrice($list_id,get_gmt_time(strtotime($date)),$list_price);

										if((!empty($array_book)) && in_array(get_gmt_time(strtotime($date)),$array_book))
									{
															 ?> 
								 <div class="tile" id="tile_<?php echo $i; ?>" >
                                    <div class="tile_container book_date">
                                      <div class="day"><?php echo $day_prevmonth; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"><span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>
									 <?php	}else{ ?>
									 	
	                                  <div class="tile" id="tile_<?php echo $i; ?>" onMouseDown="click_down(<?php echo $i; ?>);" onMouseUp="click_up(<?php echo $i; ?>);" onMouseOver="range_add(<?php echo $i; ?>);" onMouseOut="range_remove(<?php echo $i; ?>);">
                                    <div class="tile_container ">
                                      <div class="day"><?php echo $day_prevmonth; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"> <span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>	
									<?php } ?>

                                  <?php } ?>
                                  <?php $blank = $blank-1; $day_count++; $day_prevmonth++; $i++; $j--; if($k == 7) { $k = 0; echo '<div class="clear"></div></div>'; } $k++; } ?>
                                  <?php while ($day_num <= $days_in_month) { if($k == 1) echo '<div>';  ?>
                                  <?php 
                                  
                                  if(strtotime($year.'-'.$month.'-'.$day_num) < time() && $day_num < date("j",time())) { ?>
                                  <div class="tile disabled" id="tile_<?php echo $i; ?>">
                                      <div class="tile_container">
                                      <div class="day"><?php echo $day_num; ?></div>
                                      <div class="line_reg" id="square_<?php echo $i; ?>"><span class="endcap"></span> </div>
                                   </div>
                                  </div>
                                  <?php } else {
                                  		//seasonal rate
                                  		$date=$month.'/'.$day_num.'/'.$year;
                                  		$price=getDailyPrice($list_id,get_gmt_time(strtotime($date)),$list_price);
										if((!empty($array_book)) && in_array(get_gmt_time(strtotime($date)),$array_book))
											{
									 ?>
									     <div class="tile" id="tile_<?php echo $i; ?>" >
                                    <div class="tile_container book_date">
                                      <div class="day"><?php echo $day_num; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"><span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>
                                  <?php }else{ ?>
                                  <div class="tile" id="tile_<?php echo $i; ?>" onMouseDown="click_down(<?php echo $i; ?>);" onMouseUp="click_up(<?php echo $i; ?>);" onMouseOver="range_add(<?php echo $i; ?>);" onMouseOut="range_remove(<?php echo $i; ?>);">
                                    <div class="tile_container">
                                      <div class="day"><?php echo $day_num; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"> <span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>
                                  <?php } 
												} ?>
                                  <?php $day_num++; $day_count++; if ($day_count > 7) { echo "</tr><tr>"; $day_count = 1; } $i++; $j--; if($k == 7) { $k = 0; echo '<div class="clear"></div></div>'; } $k++; } ?>
                                  <?php $day_nextmonth = 1; while ($day_count > 1 && $day_count <= 7 ) { if($k == 1) echo '<div>'; ?>
                                  <?php if(strtotime($next_year.'-'.$next_month.'-'.$day_nextmonth) < time()) { ?>
                                  <div class="tile disabled" id="tile_<?php echo $i; ?>">
                                  	<div class="tile_container">
                                      <div class="day"><?php echo $day_nextmonth; ?></div>
                                      <div class="line_reg" id="square_<?php echo $i; ?>"><span class="endcap"></span> </div>
                              </div>
                                  </div>
                                  <?php } else { 
                                  		//seasonal rate
                                  		$date=$next_month.'/'.$day_nextmonth.'/'.$next_year;
                                  		$price=getDailyPrice($list_id,get_gmt_time(strtotime($date)),$list_price);
										if((!empty($array_book)) && in_array(get_gmt_time(strtotime($date)),$array_book))
											{
                                  	?>
                                  	
                                  	                 <div class="tile" id="tile_<?php echo $i; ?>" >
                                    <div class="tile_container book_date">
                                      <div class="day"><?php echo $day_nextmonth; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"> <span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>
                                  <?php }else{ ?>
                                  <div class="tile" id="tile_<?php echo $i; ?>" onMouseDown="click_down(<?php echo $i; ?>);" onMouseUp="click_up(<?php echo $i; ?>);" onMouseOver="range_add(<?php echo $i; ?>);" onMouseOut="range_remove(<?php echo $i; ?>);">
                                    <div class="tile_container">
                                      <div class="day"><?php echo $day_nextmonth; ?></div>
                                      <div class="line_reg" style="z-index:<?php echo $j; ?>;" id="square_<?php echo $i; ?>"><span class="endcap"><b><?php echo get_currency_symbol($list_id).get_currency_value1($list_id,$price); ?></b></span> </div>
                                    </div>
                                  </div>
                                  <?php } } ?>
                                  <?php $day_count++; $day_nextmonth++; $i++; $j--; if($k == 7) { $k = 0; echo '<div class="clear"></div></div>'; } $k++; } ?>
                                </div>
                              </div>
                            </div>
                          </div> 
                                                    <script>
				  
function render_grid(start_idx, stop_idx) {
    var prev_square;

    // ignore the first and last week of data (since it is padding)
    for(var i = start_idx; i <= stop_idx; i++){
      var square = schedules[0][i];
      var e = jQuery('#square_' + i);

      if(e.length == 0 || square === undefined)
        continue;

      var text = getSquareText(square, 0);

      // append to the square text if we detect that it's blocked out because the host denied a reservation
      if(prev_square != null && ((prev_square.st != square.st && square.st == 2 && square.gid != null) ||
        (prev_square.st == square.st && square.st == 2 && prev_square.gid == null && square.gid != null)))
        text += " (denied booking)";

      var span = getSpanBounds(0, i);

      var width = span[1] - span[0] + 1;

      if(text.length > (width * 8)){
        e.attr('title', text);
        text = text.substr(0, (width * 16) - 4) + "...";
      }

      e.find('span.content').html(text);
      var baseClass = e.attr('class').split(' ')[0];
      e.attr('class', baseClass + " " + square.cl + " " + square.sty);

      prev_square = square;

    }
}
render_grid(0, <?php if($i == 35) echo '34'; else echo '41'; ?>);
</script>

                          
                        </div>
                        <div class="clear"></div>
                      </div>
                      <!-- backdrop -->
                    </div>
                    <!-- calendar2 -->
				
					
                  </div>
                </div>
				<div>
				</div>	
                <!-- export instructions -->
              </div>
            </div>
          </div>
          <div class="clear"></div><span class="calender_bottom"> The calender is updated every five minutes and is only an approximation of availability. We suggest that you contact the host to confirm.</span>
        </div>
      </div>
    </div>
  </div>
  </div>