<!-- Newer date picker required stuff -->
<script src="<?php echo base_url(); ?>js/pops.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery_lib.js"></script>
<link href="<?php echo css_url(); ?>/popup_carousel.css" media="screen" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url(); ?>js/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/popup_responsive.js" type="text/javascript"></script>
<script language="Javascript" type="text/javascript" src="<?php echo base_url().'js/jquery.ui.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/prototype.js"></script>

<style>
.Sat_List_overall .Sat_Star_Nor_1 {
    margin-top: 6px;
}
.Sat_List_overall {
    margin-top: 17px;
}
.Sat_List_overall .Sat_Attribute {
    font-size: 14px;
    font-weight: bold;
}
.rightcolumn{
	width:400px;
}
.Sat_Star_Nor.over {
    width: 25% !important;
}
#book_it_disabled {
	text-align: center;	
}
#book_it_disabled_message {
font-weight: 700;
color: #FF5A5F;
}
.top-overview {
    display: inline-flex;
}
.top-overview .Sat_Attribute {
    font-size: 14px;
    padding: 0 20px 0 0;
}

label#price_amount:before {
content: "From";
padding-right: 5px;
}
label#price_amount {
padding: 0 0 0 3px !important;
}
	#instant > img {
    border: 0 none;
    float: ;
    height: 30px;
    margin: -7px 0px 10px -25px;
    position: absolute;
    vertical-align: middle;
    width: 17px;
   
   
   
}
#calendar2 .book_date {
background-color:#ff0066 !important ;
}
#calendar2 .line_reg span.endcap
{
margin-left: 10px;
width: 85px !important;
float: none !important;
}
.load_sym {
    text-align: center !important;
    width: 100%;
}
.ui-datepicker-buttonpane:after {
content: "<?php echo $list->min_stay; ?> <?php echo translate("night(s) minimum stay"); ?>" !important;	
float:right;
color:#757575;
padding-top:2px;
padding-bottom:2px;
text-align:center;
border:0;
margin:5px;
width:93px;
}
#ui-datepicker-div button{
width:44%;
}
button.ui-datepicker-current {
     display: none;
}
.ui-highlight  {
			background: #8C8989 !important;
			border-color: black !important;
			color: white !important;
		}

.message{
display: none;
text-align: center;
color: #2E3031;
position: absolute;
top: 30px;
left: 53px;
background: #fff;
padding: 5px;
line-height: 22px;
width: 230px;
box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
 
}
.anchor:hover + .message{
    display:block !important;
    /*z-index:10;*/
   z-index:99;
    float:left;
    margin:5px 0px 0px -5px;
   top: 24px;
   left: 0;
   -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.message:before {
	content: '';
    display: block;
    position: absolute;
    left: 97px;
    bottom: 100%;
    width: 0;
    height: 0;
    border-bottom: 10px solid transparent;
    border-top: 10px solid #D0D0D0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    top: 31px;
}

.message_1{
display: none;
text-align: center;
color: #2E3031;
position: absolute;
top: 30px;
left: 53px;
background: #fff;
padding: 5px;
line-height: 22px;
width: 200px;
box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
 
}
.anchor_1:hover + .message_1{
    display:block !important;
    /*z-index:10;*/
   z-index:99;
    float:left;
    margin:5px 0px 0px -9px;
   top: 22px;
   left: 0;
}

.message_1:before {
	content: '';
    display: block;
    position: absolute;
    left: 87px;
    bottom: 100%;
    width: 0;
    height: 0;
    border-bottom: 10px solid transparent;
    border-top: 10px solid #D0D0D0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    top: 76px;
}
.dates_availables {
    text-align: center;
    padding-bottom: 6px;
    background-color: #f5f5f5;
    padding-top: 6px;
    margin-bottom: 20px;
}
.det_par{
	display: none !important;
}
  .ui-state-dis { background:#F30 !important; }
    .ui-datepicker-calendar tr td.ui-datepicker-unselectable {
    background: #cccccc none repeat scroll 0 0 !important;
    }

@media only screen and (max-width:767px){
	#video_div {
	     height: auto;
    	min-height: auto;
	}
	#room #left_column #Rooms_Slider #photos_div {
    height: auto !important;
	}
}
  #search_body{
  	margin-bottom: 30px;
  	}
@media only screen and (max-width:640px){
.top-overview {
       display: block;
    float: none !important;
    margin: 0 auto !important;
}
.top-overview .Sat_Attribute {
    padding-right: 0 !important;
}
.top-overview .Sat_Star_Nor_1 {
    margin: 0 auto;
}
	}  	  
</style>

<script>
	var jayquery = jQuery.noConflict( true );

	
		jayquery(document).ready(function () {
		load_map_wrapper('load_google_map');
        jayquery("#slider1").owlCarousel({
            autoPlay: false, //Set AutoPlay to 3 seconds
 			navigation :true,
    	  items : 3,
      	 itemsCustom : [
        [0, 1],
        [450, 1],
        [600, 2],
        [700, 2],
        [980, 2],
        [1000, 3],
        [1200, 3],
        [1400, 3],
        [1600, 3]
      ],
        });

    });
</script>

			<script src="<?php echo base_url().'js/jquery.prettySocial.js'; ?>"></script>
			<script type='text/javascript'>
			<?php $list_desc = $list->title; ?>
			
			jQuery(document).ready(function() {
				jQuery('#closecnd').click(function(){
			jQuery('#hidecaln').hide();
			});
			jQuery('#show_calnd').click(function(){
			jQuery('#hidecaln').show();
				});
			  jQuery('#photos_div_top,.slide-banner').bind('click', function() {
			Fresco.show([ /*Showing Fresco Popup*/
			<?php 
			if($images->num_rows() > 0) //Check list have images
			{
				$i1=1;
				foreach ($images->result() as $image) //List out the list images
					{										
					$url_banner =base_url().'images/'.$image->list_id.'/'.$image->name; // Slideshow banner image path
					$url_icon = base_url().'images/'.$image->list_id.'/'.$image->name; // Slideshow thumbnail image path
					if($i1==1){
						$Img = base_url().'images/'.$image->list_id.'/'.$image->name;
					}
			?>
			  {
			    url: '<?php echo $url_banner; //Banner image ?>',
			caption: "<?php echo $image->highlights; //Image highlight ?>",
			options: {
			thumbnail: '<?php echo $url_icon; //Thumbnail image ?>'
			    }
			  },
			 	<?php		
					$i1++;					
					} 
			} ?>           
			        ]
			        
			        );
			        
			      });
			
			});
			  </script>

<!-- Displayed only to the people who have logged in -->
<?php 
	$set = 0;
	
	if( $this->dx_auth->is_logged_in())
	{
		$userid = $this->dx_auth->get_user_id();
		if( $list->user_id == $userid )
		{
			$set = 1;
		}
	}
?>
<!--  end of the top yellow bit -->



<div id="photos_div_top" class="">
              	<!-- Discount label 1 start -->  	
    <?php
              	   
         if($discount!=0){ ?>
		<div class="list_new_room_left ">
	<?php echo round($discount).'%';?>
	</div>
	<?php }  ?>
              	
  <!--Discount label 1 end -->
              	
                <?php  
								echo '<div class="galleria_wrapper">';

								if($images->num_rows() > 0)
								{
									  $banner_Img = $images->row()->name;
									  $banner_ImgId = $images->row()->list_id;
									  $url_banner1 =base_url().'images/'.$banner_ImgId.'/'.$banner_Img;
									  $noimage = base_url()."images/no_image.jpg";
									?>			
								<!--	echo '<div class="image-placeholder"><img alt="Large" height="100%" src="'.$url_banner1.'" width="100%" title="'.$bannerImage->row()->highlights.'" /></div>';--> 				
									
										<div class="image-placeholder" style="background:url(<?php echo $url_banner1; ?>),url(<?php echo $noimage ?>);background-size:cover;"></div>
								<?php }
								else
								{ $noimage = base_url()."images/no_image.jpg"; ?>
										<div class="image-placeholder" style="background:url(<?php echo $noimage;?>);background-size:cover;"></div>
								<?php }
								echo '</div>';
								?>
              </div>




<div id="the_roof_left" class="">
      	<div class="container">
      	
      	 <?php $profiles = $this->Common_model->getTableData('profiles', array('id' => $list->user_id ))->row(); ?>
            <?php $user = $this->Common_model->getTableData('users',array( "id" => $list->user_id ))->row(); 
			?>
            
            <div class="col-xs-12 col-md-8 col-sm-12 padding-zero listdetails">
            <div class="col-xs-12 col-md-3 col-sm-4 userprfl">
            <img id="trigger_id" class="userprfl" width="80" height="80" alt="" src="<?php    
		  	 echo $this->Gallery->profilepic($list->user_id,2);
            ?>" title=""/>
            <span class="hidden-xs"> <a class="user_name" href="<?php echo site_url('users/profile').'/'.$user->id; ?>"><?php echo $user->username; ?></a></span>
             </div>
            
            
      	
      	<div class="col-xs-12 col-md-9 col-sm-8 textcenter">
          <h1><?php echo $list->title; ?></h1>
          <h3><?php echo $property_type ; ?> - <?php echo $list->room_type; ?> <span class="middot">&middot;</span> 
										<span id="display_address" class="no_float"><?php 
										if($list->user_id == $this->dx_auth->get_user_id())
										{
											  $pieces = explode(",",$list->address); $i = count($pieces);
                                                  if($city!='')
												  {
												  	echo $city.', '.$state.', '.$country;
												  }
												  else {
													  
													  {
													  	echo $state.', '.$country;
													  }
												  }

											$fb_share_address = $city.', '.$state.', '.$country;
										}
										else {
											echo $city.', '.$state.', '.$country;
											$fb_share_address = $city.', '.$state.', '.$country;
										}
										 ?></span> </h3>
										 
		<?php $overallreview = $this->db->where('id',$room_id)->get('list')->row()->overall_review; 
		if($overallreview > 0){
		?>		
		<div class="top-overview col-xs-12 col-sm-11 col-md-12 padding-zero">
			<div class="Sat_Attribute"><?php echo translate("Overall Review"); ?></div>
            <div class="Sat_Star_Nor_1" title="<?php echo $overallreview * 20; ?>%">
              <div class="Sat_Star_Act_1" style="width:<?php echo $overallreview * 20; ?>%;"> </div>
            </div>
        </div>    
		<?php } ?>					 
		 <div class="col-xs-6 col-sm-3 col-md-3 prvt_detl">
		 	<img src="<?php echo cdn_url_images();?>/images/entire_home.png" height="35">
		 	<span><?php echo $list->room_type; ?></span>
		 </div>
		 <div class="col-xs-6 col-sm-3 col-md-3 prvt_detl prvt_detl_1">
		 	<img src="<?php echo base_url();?>images/grop.png" height="35">
		 	<span><?php if($list->beds != 0) {  echo $list->capacity." Guest";} else { echo "No Guest"; } ?></span>
		</div>
		 <div class="col-xs-6 col-sm-3 col-md-3 prvt_detl">
		 	<img src="<?php echo cdn_url_images();?>/images/private_room.png" height="35">
		 	<span><?php if($list->beds != 0) {echo $list->bedrooms." Bedrooms";}  else { echo "No Bedrooms"; } ?></span>
		 </div>
		 <div class="col-xs-6 col-sm-3 col-md-3 prvt_detl prvt_detl_2">
		 	<img src="<?php echo base_url();?>images/beds.png" height="35">
		 	<span><?php if($list->beds != 0) {  echo $list->beds." Beds";} else { echo "No Beds"; } ?></span>
		</div>					 
		 
										 
        </div>
</div>
			
<div id="" class="col-md-4 col-sm-12 col-xs-12">
	<div id="right_column" class="rightcolumn">
      <div id="book_it">

            <div id="pricing" class="book_it_section col-md-12">
       
              <label id="price_amount" class="price_left col-md-6 col-sm-6 col-xs-6"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$list->price); ?></label>
              <p class="col-md-6 col-sm-6 col-xs-6" ><?php echo "Per Night";?></p>

              <div id="includesFees" class="disblock"> 
                <p class="col-md-6 col-xs-6"><?php echo translate("Includes all fees"); ?> <a title="This is the final price, including any fees from the host and <?php echo $this->dx_auth->get_site_title(); ?>." class="tooltip"><img class="icon1" src="<?php echo base_url(); ?>images/questionmark_hover.png" alt="Questionmark_hover"></a></p></div>
            </div>
            <?php echo form_open('payments/index/'.$room_id, array('class' => "info room_form col-md-12", 'id' => "book_it_form" ,'name' => "book_it_form")); ?>
            <div id="dates" class="book_it_section">
              <input id="hosting_id" name="hosting_id" type="hidden" value="<?php echo $room_id; ?>" />
              
              <div class="book_head col-md-12" style="padding:0px;">
           <div class="check_label col-md-4 col-xs-4 col-sm-4">   <label  for="checkin"><?php echo translate("Check_in"); ?></label>
              <input class="checkin" id="checkin" name="checkin"  type="text" readonly="readonly"/></div>
              <div class="check_label col-md-4 col-xs-4 col-sm-4"> <label for="checkout"><?php echo translate("Check_out"); ?></label>
              <input class="checkout" id="checkout" name="checkout" type="text" readonly="readonly"/></div>
             <div class="check_label col-md-4 col-xs-4 col-sm-4">  <label for="number_of_guests"><?php echo translate("Guests"); ?></label>
               <select id="number_of_guests1" class="recomm-select" name="number_of_guests" onChange="refresh_subtotal();">
                  		<?php for($i = 1; $i <= 16; $i++) { ?>
													       	<option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> </option>
														       <?php } ?>
                </select></div>
                
                </div>  
      <input type="hidden" value='<?php echo $list->min_stay; ?>' id="min_stay" /> 

            </div>
            
            <p id="load_sym" class="load_sym" style="display:none" ><img  src="<?php echo base_url(); ?>images/spinner.gif" class="spinner" height="16" width="16" alt="" />
             	  </p>
            <div style="display: none;" id="book_it_disabled">
                <p class="bad gust_alt" id="book_it_disabled_message"><?php echo translate("Those dates are not available"); ?></p>
                <p class="apt_submit"><a href="<?php echo base_url(); ?>search" onClick="clean_up_and_submit_search_request(); return false;" id="view_other_listings_button" class="clsLink2_Bg"> <?php echo translate("View Other Listings"); ?> </a> </p>
              </div>
            <div class="book_it_section round_bottom" id="book_it_status">
            	
              <div id="book_it_enabled" class="clearfix" style="display: none;">
              	
                <div style="display: none;" id="show_more_subtotal_info" class="col-md-12 col-sm-12 col-xs-12">
                	<table><tr><td id="id"><div class="dates_availables"><span>These dates are available</span></div></td></tr></table>
                	<style>
						table
						{
						width: 100%;
						}                	
                		#td
                		{
                		font-family:Circular,Helvetica Neue,Helvetica,Arial,sans-serif;
                		color: #484848;
                		font-size: 14px;
                		border-top: 1px solid #dce0e0;
                		padding-right: 2px;
                		padding-top: 15px;
                	    text-align: left;
                		}
                		p#subtotal_area {
   						margin-left: 0px !important;
						}
                		#td2,#subtotal
                		{
                		font-family:Circular,Helvetica Neue,Helvetica,Arial,sans-serif;
                		color: #484848;
                		font-size: 14px;
                		border-top: 1px solid #dce0e0;
    					padding-left: 55px;
    					padding-top:15px;
    					text-align: right;
    					}
    					.value
    					{
    					font-family:Circular,Helvetica Neue,Helvetica,Arial,sans-serif;
    					color: #757575;
    					padding-bottom:10px;
    					}
    					div#show_more_subtotal_info {
    					margin-top: 10px;
    					padding: 5px !important;
						}
      
                	</style>
  																			
                <table id="base_price">
                <tr>
                <td id="td" style="border-top:none;">
               <label  id="price_amount1"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$list->price); ?> </label>
                x <span id="total_nights"></span>
                <img src="<?php echo base_url();?>images/question_mark_2.png" height="15" class="anchor" />
                <p class="message">Average nightly rate is rounded.</p>
                </td>
                 <td id="td2" style="border-top:none;">
                 <span id="mul_price"></span>
                 </td>
                 </tr>    	
                </table> 
                		
                <?php if($guest_price != 0) { ?>
 
               <table  id="show_more_subtotal_info1">
             	<tr>
                <td id="td">
               <span class="value" id="guest_price"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$guest_price); ?></span>
                 x <span id="to_nights"></span> x <span id="diif_guest"></span>
                  <img src="<?php echo base_url();?>images/question_mark_2.png" height="15" class="anchor" />
                <p class="message">Additional guest fee applied</p>
                 <td id="td2">
                 <span class="value" id="extra_guest_price"></span>
                <br />
                </td>
                </tr>
                </table>
                
                
                <?php } ?>
                
             <?php if($cleaning != 0) { ?>  
             	<table>
             	<tr>
             	<td id="td">   
                 <?php echo translate("Cleaning fee"); ?></td>
                <td id="td2">
               <span class="value" id="cleaning_fee_string"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$cleaning); ?></span>
                <br />
                </td>
                </tr>
                </table>
                <?php } ?>
                 
                <?php if($security != 0) { ?>
                <table>
                <tr>
                <td id="td"> 
                <?php echo translate("Security fee"); ?>
                </td>
                <td id="td2">
                <span class="value" id="security_fee_string"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$security); ?></span>
                 <br />
                 </td>
                 </tr>
                 </table>
                 <?php } ?> 
             
              	<table>
 				  <tr>
 				  <td id="td">            
                  <p id="subtotal_area" class="clsFloatLeft" style="display: none;"></p>
                  <?php echo "Subtotal"; ?></td>
                 <td id="td2">
                 <h2 class="det_pri" style="border-top:none;" id="subtotal">
                 <img width="16" height="16" alt="" src="<?php echo base_url("images/spinner.gif"); ?>" style="z-index: 2"; />
                 </h2>
                 </td>
                 </tr>
                 </table>
                    
                <table>
                <tr>
                <td id="td"><?php echo translate("Service fee"); ?>
                <img src="<?php echo base_url();?>images/question_mark_2.png" height="15" class="anchor_1" />
                <p class="message_1">This helps us run our platform and offer services like 24/7 support on your trip.</p>
                </td> 
                <td id="td2">
                <span class="value" id="service_fee"><?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$commission); ?></span>
                </td>
                </tr>
                </table>
       
                  <table>
 				  <tr>
 				  <td id="td">            
                  <p id="total_area" class="clsFloatLeft" style="display: none;"></p>
                  <?php echo "Total"; ?></td>
                 <td id="td2">
                 <h2 class="det_pri" style="border-top:none;font-size:22px !important;" id="total">
                 <img width="16" height="16" alt="" src="<?php echo base_url("images/spinner.gif"); ?>" style="z-index: 2"; />
                 </h2>
                 </td>
                 </tr>
                 </table>
                 
             </div>
             </div>
             <?php if($this->dx_auth->is_logged_in()) { ?>
             <button id="book_it_button" style="z-index:999" class="btn large btn_dash bokbtn" type="submit" oncontextmenu="return false">
 <?php
 if($instance_book==1){
?>
<span id="instant"><img src="<?php echo base_url() ?>images/svg_7.png"></span>
<span class="book-it"> <?php echo translate("Instant Booking"); ?>!</span>
<?php }else {?>
	<span class="book-it"> <?php echo translate("Book it"); ?>!</span>
	<?php } ?>
</button>
 <?php } 
				else
					{ ?>
						<button type="button" class="btn large btn_dash bokbtn col-xs-12" onclick="signin_popup()" data-toggle="modal" data-target="#signin_popup">
							 <?php
 if($instance_book==1){
?>
<span id="instant"><img src="<?php echo base_url() ?>images/svg_5.png"></span>
<span class="book-it"> <?php echo translate("Instant Booking"); ?>!</span>
<?php }else {?>
	<span class="book-it"> <?php echo translate("Book it"); ?>!</span>
	<?php } ?>
</button>
 <?php } ?>
 			
 			<div style="box-sizing: border-box;font-size:13px;color: #757575;text-align: center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;line-height: 1.43;"><br><br><span>Your credit card won’t be charged</span></div>
 			</div>
              </div>
              <div class="clearfix"></div>
              	
             
            <?php echo form_close(); ?> 

      <!-- wishlist -->
   <div class="save_wishlist">
      <div class="savewish_but">
      <?php 
      	$short_listed=0;
		$count_wishlist=0;
		$cur_user_id=$this->dx_auth->get_user_id();
		if($cur_user_id)
		{
			$shortlist=$this->Common_model->getTableData('user_wishlist',array('user_id' => $cur_user_id,'list_id'=>$this->uri->segment(2)));
			if($shortlist->num_rows() != 0)
			{
				$short_listed = 1;
			}
			$count_wishlist = $this->Common_model->getTableData('user_wishlist',array('list_id'=>$this->uri->segment(2)))->num_rows();
		}
?>
<?php 
if($short_listed == 0)
	   {  ?>	                 

	   <input style="border-bottom: 10px;padding-bottom: 10px;" class="save_wish detail col-md-12 col-xs-12 col-md-12" type="button" oncontextmenu="return false" value="<?php echo translate("Save To Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<?php echo $room_id; ?>,<?php echo $count_wishlist; ?>,this);"><!-- SAVE TO WISH LIST -->
	  <?php } 
	  else { ?>	 
<input style="border-bottom: 10px;padding-bottom: 10px;" class="accept_button_save_wish save_wish detail col-xs-12 col-sm-12 col-md-12" type="button" oncontextmenu="return false" value="<?php echo translate("Saved To Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<?php echo $room_id; ?>,<?php echo $count_wishlist; ?>,this);"><!-- Remove from Wishlist-->
 <?php } ?>	 
   <!-- wishlist count 1 start-->  
	 <!-- wishlist count 1 end -->
     	  
	 <div style="box-sizing: border-box;font-size:15px;color: #757575;text-align: center;font-family:Helvetica;"><br><br><span><br>&nbsp;<?php echo $count_wishlist." travelers saved this place "; ?></span></div>
	 </div> </div>
</div>
      <!-- wishlist -->      
      <div id="Room_User" class="Box1 col-xs-12 hidden">
          <div id="user_info_big" class="disblock">
            
           
              <div id="element_to_pop_up" style="display:none">
              	<div class="pop_element">
              <div id="status">
                <?php echo form_open('payments/index/'.$room_id, array('class' => "info", 'id' => "book_it_form" ,'name' => "book_it_form")); ?>
             <div id="dates" class="book_it_section" >
              <input id="hosting_id" name="hosting_id" type="hidden" value="<?php echo $room_id; ?>" />
                <h2><?php echo translate("Send_Message_to"); ?> <?php echo $user->username; ?>

                	           <a class="close" href="#"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="45" height="45" /> </a>

                </h2>
                 <div class="book_head label_text col-md-12" style="padding:0px;">
                <li class="check_list_label col-md-4 col-sm-4 col-xs-12">
                    <label class="col-md-12 col-xs-12 col-sm-12"   for="checkindatelabel"><?php echo translate("Check in"); ?></label>
                    <input class="checkin ui-datepicker-target apt_checkin1 check_pop col-md-12 col-xs-12 col-sm-12" id="checkindate" name="checkin" type="text" size="10" value="mm/dd/yy" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off readonly="readonly" />
                </li>
              <li class="check_list_label col-md-4 col-sm-4 col-xs-12">
                <label class="col-md-12 col-xs-12 col-sm-12"   for="checkoutdatelabel"><?php echo translate("Check out"); ?></label>
                <input class="checkout ui-datepicker-target apt_checkin1 check_pop col-md-12 col-xs-12 col-sm-12" id="checkoutdate" class="chec_pop_select" name="checkout" type="text" size="10" value="mm/dd/yy" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off readonly="readonly"  />
              </li>
              <li class="check_list_label col-md-4 col-sm-4 col-xs-12">
                <label class="col-md-12 col-xs-12 col-sm-12"   for="number_of_guests"><?php echo translate("Guests"); ?></label>
                <select class="apt_guest col-md-12 col-xs-12 col-sm-12" id="number_of_guest2" name="number_of_guest2" onChange="refresh_subtotal();">
                  		<?php for($i = 1; $i <= 16; $i++) { ?>
													       	<option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> </option>
														       <?php } ?>
                </select>
              </li>
              </ul>
              </div>
<div class="messagearea col-md-12 col-xs-12">
              
<?php /*?>                 <label for="checkout"><?php echo translate("Message"); ?></label><?php */?>
			<p class="apt_message"><?php echo translate("Tell"); ?> 
				
				<?php echo $user->username; ?>
				<?php echo translate("what you like about their place, what matters most about your accommodations, or ask them a question"); ?>.</p>	
              <p class="col-md-12 col-xs-12">  <textarea class="message_popup" id="message" name="message"   ></textarea>
              </p>
            <?php /*?>  <p class="reuse"><input type="checkbox" id="check" name="reuse" />Reuse this message next time I contact a host </p><?php */?>
              </div>
<p><div class="border"></div></p>
              <div class="send"> 
                 <button id="sendmessage" type="button" class="btn blue gotomsg btn_dash">
                <span>
                 <span><?php echo translate("Send Message"); ?></span>
                </span>
                </button>
                </div>
            </div>
           <?php echo form_close(); ?> 
            </div>
            <div id="status_contact_login" style="display:none">
           <h2>Sign up to send your message</h2>
		   <div class="log_siz">
		   	<br>                 
            <a href="<?php echo base_url(); ?>users/signin"><h3>Already an member?</h3></a>
            </div>

            <br>
            <p><center><b>OR</b></center><br></p>
            <div class="createaccount">
            <center><a href="<?php echo base_url(); ?>users/signup"><h3><?php echo translate("Create an account with your mail address"); ?></h3></a></center>
            </div>

             </div>
             <div id="status_availablity" style="display:none">
             <h2><?php echo translate("Sorry Accomodataion Not available."); ?>
             <a class="close" href="#"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="45" height="45" /> </a>
			 </h2>
             <div class="dont">
             
             </div>
             </div>
             <div id="status_already" style="display:none">
             <h2><?php echo translate("Sorry You're already contact this List for the same dates."); ?>
            <a class="close" href="#"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="45" height="45" /> </a>
			 </h2>
             <div class="dont">
             
             </div>
             </div>
             <div id="status_your_list" style="display:none">
             <h2><?php echo translate("You can't contact your own List."); ?>
            <a class="close" href="#"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="45" height="45" /> </a>
			 </h2>
             <div class="dont">
             
             </div>
             </div>
             <div id="status_contact" style="display:none">
             <h2><img src="<?php echo base_url(); ?>images/has_amenity.png" alt="close" width="22" height="22"/>&nbsp;&nbsp;<?php echo translate("Message Sent"); ?> 
             <a class="close" href="#"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="45" height="45" /> </a>
			 </h2>
             <div class="dont">
             <h4><?php echo translate("Don't stop now-keep contacting other listings."); ?></h4>
             <p><?php echo translate("Contacting several places considerably improves your odds of a booking."); ?></p>
             <p><a href="<?php echo base_url(); ?>search?location=<?php echo $city.', '.$state.', '.$country; ?>"><?php echo translate("Return to your search"); ?></a></p>
             </div>
             </div>
 </div>

          </div>
    
            <div class="clear"></div>
      </div>
          <div class="clear"></div>
      </div>
      
    </div>					

		</div>								
								
      </div>
</div>


<div class="container">
<div id="rooms" class="maincontain">  

  <div id="room">
 

<!-- AddThis Button BEGIN -->
<?php
if($images->num_rows() > 0)
								{
foreach ($images->result() as $image)
									{			
									  $url_link = base_url().'images/'.$image->list_id.'/'.$image->name;
									}
								}
else {
	$url_link = base_url().'images/no_image.jpg';
}
	?>

  <div class="detail_drop">
 
   <div class="detail_drop">
    <div id="left_column" class="col-md-8 col-sm-12 col-xs-12">

      <div id="Rooms_Details" class="">

          	<div id="house_rules" class="details_content brdr_btm">
              	<h4 class="subhdngs subligns"><?php echo translate("About the Listing");?>
              		
              		<?php if($set): ?>

 <?php echo anchor ('rooms/lys_next/edit/'.$room_id,translate("(Edit this Listing)")); ?> </h4>

<?php endif; ?>
              		
              	</h2>
              	
                <?php if($list->house_rule == '') { ?>
                <div id="house_rules_text">
                  <p> <?php echo translate("This host has not specified any house rules."); ?> </p>
                </div>
                <?php } else { ?>
                <div id="house_rules_text">
                  <p><?php echo $list->house_rule; ?></p>
                </div>
                <?php } ?>
                <?php 	
						$userid = $this->dx_auth->get_user_id();
						if( $list->user_id != $userid )
						{
				?>	
				<span>
                <a href="javscript:void(0)" id="my-button"><?php echo translate("Contact Me"); ?></a>
                </span>
               	 <?php } ?>
                <span><a class="convert_field_spam" href="<?php echo site_url('rooms/spam/'.$room_id.''); ?>">Report as spam</a></span>
                
              </div>
    
              <div id="description_details" class="col-md-12 col-sm-12 col-xs-12 padding-zero  padding_zero_1 brdr_btm">
      	<h2 class="subhdngs col-md-3 col-sm-3 col-xs-12 padding-zero"><?php echo translate("The Space");?></h2>
          <ul class="col-sm-9 col-md-9 col-xs-12 padding-zero">

                       <li class="col-md-6 col-sm-6 col-xs-12">
                       	<span class="property"> <?php echo translate("Room type:"); ?> </span>
                       	<span class="value"><?php echo $list->room_type; ?></span>
                       	</li>
                      
                      <?php
                      if($list->bedrooms!=0)
					  { 
                      echo '<li class="col-md-6 col-sm-6 col-xs-12"><span class="property">'.translate("Bedrooms:").'</span><span class="value">'.$list->bedrooms.'</span></li>';
                      }
					  ?>
					  <li class="col-md-6 col-sm-6 col-xs-12 ">
                      	<span class="property">                     	
                      	 <?php echo translate("Bed type:"); ?> </span>
                      	 <span class="value">  <?php if($list->bed_type == '') echo translate("Not Available"); else echo $list->bed_type; ?> </span></li>
                      	<?php 
                      if($list->bathrooms!=0)
					  { 
                      echo '<li class="col-md-6 col-sm-6 col-xs-12"><span class="property">'.translate("Bathrooms:").'</span><span class="value">'.$list->bathrooms.'</span></li>';
                      }
                      ?>
                      
                    <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Beds:"); ?> </span><span class="value"><?php echo $list->beds; ?></span></li>
                    <li class="col-md-6 col-sm-6 col-xs-12">
                       	<span class="property"> <?php echo translate("Property type:"); ?> </span>
                       	<span class="value"><?php echo $property_type; ?></span>
                       	</li>
                    <?php 
                      if($list->min_stay!=0)
					  { ?>
                      <li class="col-md-6 col-sm-6 col-xs-12">
                       	<span class="property"> <?php echo translate("Minimum Stay:"); ?> </span>
                       	<span class="value"><?php echo $list->min_stay; ?></span>
                       	</li>
                       	<?php } ?>
                       	<?php 
                      if($list->max_stay!=0)
					  { ?>
                       	<li class="col-md-6 col-sm-6 col-xs-12">
                       	<span class="property"> <?php echo translate("Maximum Stay:"); ?> </span>
                       	<span class="value"><?php echo $list->max_stay; ?></span>
                       	</li>
                       	<?php } ?>
                     <?php
                     if($prices->guests < $list->capacity)
					 {
                     ?>
                      <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Extra people:"); ?> </span><span class="value" id="extra_people_price">
                      <?php if($prices->addguests == 0) echo "No Charge"; else echo get_currency_symbol($room_id).get_currency_value1($room_id,$prices->addguests).'/guest after '.$prices->guests; ?>
                        </span>
                        <?php } ?>
                        </li>

                      <li class="round_bottom col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Cancellation:"); ?> </span><span class="value"> 
                      	<?php if($policy !='') { ?>
                      	<a target="_blank" href="<?php echo site_url('pages/cancellation_policy/Flexible#'.$policy.''); ?>">
                      	<?php echo $policy;?> </a>
                      	 <?php } else { echo translate("Not Available"); } ?>
                      	</span></li>
                    </ul>
      </div>
              
              
              <div id="amenities" class="details_content  padding_zero_1 brdr_btm">
              	<h2 class="subhdngs col-md-3 col-sm-3 col-xs-12 padding-zero"><?php echo translate("Amenities");?></h2>
              	<ul class="col-sm-9 col-md-9 col-xs-12 padding-zero">
                <?php 
                $in_arr = explode(',', $list->amenities);
                $tCount = $amnities->num_rows();
                //$i = 1; $j = 1; 
                foreach($amnities->result() as $rows) { ?>
                <li class="col-md-6 col-sm-6 col-xs-12">
                  <?php if(in_array($rows->id, $in_arr)) { ?>
                  	<i class="fa fa-check amenity-icon times-check" aria-hidden="true"></i>
                  <?php } else { ?>
                  <i class="fa fa-times amenity-icon times-check" aria-hidden="true"></i>
                  <?php } ?>
                  <p><?php echo $rows->name; ?> <a class="tooltip" title="<?php echo $rows->description; ?>"><img alt="Questionmark_hover" src="<?php echo base_url(); ?>images/questionmark_hover.png" class="apt_aminities"/></a></p>
                </li>
                <?php } ?>
                </ul>
                <div class="clear"></div>
              </div>
              
              
              <div id="" class="col-sm-12 col-md-12 col-xs-12 padding-zero details_content  padding_zero_1 brdr_btm">
              	<h2 class="subhdngs col-md-3 col-sm-3 col-xs-12 padding-zero"><?php echo translate("Prices");?></h2>
              	<ul class="col-sm-9 col-md-9 col-xs-12 padding-zero pricelist">
              	 <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Cleaning Fee:"); ?> </span><span class="value"> <?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$prices->cleaning); ?></span> </li>
                      <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Security Fee:"); ?> </span><span class="value"> <?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$prices->security); ?></span> </li>
                      <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Weekly Price:"); ?> </span> <span class="value">
                        <?php if($prices->week == 0) echo translate("Not Available"); else echo get_currency_symbol($room_id).get_currency_value1($room_id,$prices->week); ?>
                        </span> </li>
                      <li class="col-md-6 col-sm-6 col-xs-12"><span class="property"> <?php echo translate("Monthly Price:"); ?> </span> <span class="value">
                        <?php if($prices->week == 0) echo translate("Not Available"); else echo get_currency_symbol($room_id).get_currency_value1($room_id,$prices->month); ?>
                        </span> </li>
              	</ul>
              </div>
              
              
                 
              <div id="description1" class="col-sm-12 col-md-12 col-xs-12 padding-zero details_content brdr_btm">
              	
              	<p class="col-sm-3 col-md-3 col-xs-3 subhdngs"><?php echo translate("Description");?></p>
              
                <div id="description_text" class="col-md-9 col-sm-9 col-xs-12">
                  <div id="new_translate_button_wrapper" style="display: none;">
                    <div id="new_translate_button"> <span class="label"> <?php echo translate("Translate this description to English");?> </span> </div>
                  </div>
                  <div id="description_text_wrapper" class="trans">
                    <p><?php //echo str_replace('^nl;^','<br />',$list->desc); 
                    	echo nl2br($list->desc);
                    	?></p>
                  </div>
                
                </div>
              </div>
              
              
              <div id="house_rules" class="col-sm-12 col-md-12 col-xs-12 padding-zero details_content brdr_btm">
                 	<p class="subhdngs col-sm-3 col-md-3 col-xs-12"><?php echo translate("House rules");?></p>
                <div id="description_text" class="col-md-9 col-sm-9 col-xs-9">
                <?php if($list->house_rule == '') { ?>
                <ul id="house_rules_text">
                  <li> <?php echo translate("This host has not specified any house rules."); ?> </li>
                </ul>
                <?php } else { ?>
                	
                <ul id="actions">
                	<?php if($set && $preview != 'preview'): ?>
               <!--<h2  class="" style="position: relative;font-size: 20px;"> <?php echo anchor ('rooms/lys_next/edit/'.$room_id.'/detail',("Edit")); ?> <span class=""> </span> </h2>-->
<?php 
	$set = 0;
	
	if( $this->dx_auth->is_logged_in())
	{
		$userid = $this->dx_auth->get_user_id();
		if( $list->user_id == $userid )
		{
			$set = 1;
		}
	}
?>

                                <?php endif; ?>

                     <li><?php echo $list->house_rule; ?></li>
</ul>
                <?php } ?>
              </div>
              </div>
              
              
              
                <div id="Rooms_Slider" class="col-sm-12 col-md-12 col-xs-12 padding-zero details_content brdr_btm" >
      	
		  <div>
					  <ul id="slider_sub_nav" class="rooms_sub_nav clearfix padding-zero">
						  <li onClick="select_tab('main', 'photos_div', jQuery(this));" class="main_link selected col-md-3 col-sm-3 col-xs-12 padding-zero_4"><a class="col-md-12  col-sm-12 col-xs-12" href="#photos"><?php echo translate("Photos"); ?></a></li>
						  <li onClick="select_tab('main', 'video_div', jQuery(this));" class="main_link col-md-3 col-sm-3 col-xs-12 padding-zero_4"><a class="col-md-12 col-sm-12 col-xs-12" href="#video"><?php echo translate("Videos"); ?></a></li>
						  <!--<li onClick="select_tab('main', 'maps_div', jQuery(this)); load_map_wrapper('load_google_map');" class="main_link"><a href="#maps"><?php echo translate("Maps"); ?></a><a href="#guidebook" style="display:none;"></a></li>-->
						  <?php //if($list->street_view != 0) { ?>
						  <!--<li onClick="select_tab('main', 'street_view_div', jQuery(this)); load_map_wrapper('load_pano');" class="main_link"><a href="#street-view"><?php echo translate("Street View"); ?></a></li>-->
						  <?php //} ?>
						  <li onClick="select_tab('main', 'calendar_div', jQuery(this)); load_initial_month(<?php echo date('Y'); ?>);" class="main_link col-md-3 col-sm-3 col-xs-12 padding-zero_4"><a class="col-md-12 col-sm-12 col-xs-12" href="#calendar"><?php echo translate("Calendar"); ?></a></li>
												   </ul>
				  </div>
		  
        <div class="Box_Content padding-zero">   
              
              <div id="photos_div" class="main_content">
						
                  <div id="description_text_" class="col-xs-12 col-md-12 col-sm-12 nopadding">
         
                        <?php
                        $photo_galary = $this->db->where('list_id',$room_id)->get('list_photo');
                        if($photo_galary->num_rows() > 0)
                            {
                            $i = 1;
                                    foreach ($photo_galary->result() as $image_row)
                                    {
                                    	$noimage =base_url()."images/no_image.jpg";
                                        $phots_count =$photo_galary->num_rows();
                                        $name_view = $image_row->name;
                                        $name_id = $image_row->list_id;      
                                       $url_banner1 =base_url().'images/'.$name_id.'/'.$name_view; //Banner image path
                                          
                                            if($i == 1)
                                            {
                                            ?>
                                            <div class='slide-banner col-md-6 col-xs-12 col-sm-6' id='Showslideshow' style="position: relative">
                                              <img class="fullbanimg my_view_img" src='<?php echo $url_banner1; ?>' onerror="this.src='<?php echo $noimage; ?>'" alt=''/ width="100%"  style="cursor: pointer;position: relative;float: none;display: block;">
                                            
                                            </div> 
                                            <?php                                          
                                            }
                                            else if($i == 2)
                                            {
                                            ?>
                                          
                                            <div class='slide-banner col-md-6 col-xs-12 col-sm-6' id='Showslideshow' style="position: relative">
                                              <img class="fullbanimg my_view_img" src='<?php echo $url_banner1; ?>' onerror="this.src='<?php echo $noimage; ?>'" alt=''/ width="100%"  style="cursor: pointer;position: relative;float: none;display: block;">
                                            
                                            </div>
                                            <?php                                          
                                            }
                                            if($i == 3)
                                            {
                                            ?>
                                      
                                            <div class='slide-banner col-md-6 col-xs-12 col-sm-4' id='Showslideshow' style="position: relative">
                                              <img class="fullbanimg view_image" src='<?php echo $url_banner1; ?>' onerror="this.src='<?php echo $noimage; ?>'" alt=''/ width="100%"  style="cursor: pointer;position: relative;float: none;display: block;">
                                            
                                            </div>
                                            <?php                                          
                                            }
                                            if($i == 4)
                                            {
                                            ?>
                                          
                                            <div class='slide-banner col-md-4 col-xs-12 col-sm-4' id='Showslideshow' style="position: relative">
                                              <img class="fullbanimg view_image" src='<?php echo $url_banner1; ?>' onerror="this.src='<?php echo $noimage; ?>'" alt=''/ width="100%"  style="cursor: pointer;position: relative;float: none;display: block;">
                                            
                                            </div>
                                            <?php                                          
                                            }
                                            if($i == 5)
                                            {
                                            ?>
                                          
                                            <div class='slide-banner col-md-4 col-xs-12 col-sm-4' id='Showslideshow1' style="position: relative">
                                              <img class="fullbanimg view_image" src='<?php echo $url_banner1; ?>' onerror="this.src='<?php echo $noimage; ?>'" alt=''/ width="100%"  style="cursor: pointer;position: relative;float: none;display: block;">
                                              <div class="desc_content_galary">
                                            <label style="text-align:center !important;" class="details_list_d">
                                            <p class="title_of_photo">See all <?php echo $phots_count;?> photos</p>
                                            </label>
                                            </div>
                                            </div>
                                            <?php                                          
                                            }
                                            $i++;               
                                  
                                    }
                                    }
                                else
                                {
                                ?>
                            <!--Showing No image(If don't have a image)-->
                            <div class='slide-banner' id='dorhout-mees'>
                            <img alt="" src="<?php echo base_url();?>/images/no_image.jpg" width="100%" height="500px"  class="fullbanimg"/>
                            </div>
                            <?php } ?>        
                            </div>
              </div>
              
 


                     <div id="video_div" class="main_content" style="display: none">
                                       <?php //echo $list->video_code;
                                     if($list->video_code!= ''){
                                      $video = explode("=",$list->video_code);
                                     // print_r($video[1]);
                                      $code= $video[1];
                                                                                    ?>
                                        <iframe width="640" id="video" height="507" src="//www.youtube.com/embed/<?php echo $code;?>" frameborder="0" allowfullscreen></iframe>
                                        <?php }else{
                                            echo "No Video Found";?>
                                        	<style>
                                        		#video_div {
												    padding-bottom: 2.2%!important;
												}
                                        	</style>
                                        <?php }?>
                              </div>
                     
         
          <!-- Video grabber 1 end -->

													<div id="street_view_div" class="main_content" style="display:none;">
																												<div id="pano_error" style="display:none;">
																											<p>
																												<?php echo translate("Unable to find street view of this location."); ?>
																											</p>
																											</div>
																								
																												<div id="pano_no_error">
																														<div data-lat="<?php if($list->street_view == 2) echo round($list->lat, 6); else echo $list->lat; ?>" data-lng="<?php if($list->street_view == 2) echo round($list->long, 6); else echo $list->long; ?>" id="pano"></div>
																														<div class="floatright">
																																<input checked="checked" id="auto_pan_pano" name="auto_pan_pano" type="checkbox" value="true" /> <?php echo translate("Rotate Street View"); ?>
																														</div>
																												
																												</div>
																										</div>
													
														
              <div id="calendar_div" class="main_content" style="display: none">
                <div id="calendar_tab_container" >
                  <div id="calendar_tab">
                      <div id="calendar2">
                        <div class="clearfix">
                          <div class="Edit_Cal_Top_left clsFloatLeft"> <?php echo translate("Select Month :");?>
                            <select id="cal_month" name="cal_month" onChange="change_month2(this.options[this.selectedIndex].title);">
                              <?php for ($x=0; $x < 12; $x++) {
																$time = strtotime('+' . $x . ' months', strtotime(date('Y-M' . '-01')));
																$key  = date('m', $time);
																$name = date('F', $time);
																$year = date('Y', $time);
																echo '<option title="'.$year.'" value="'.$key.'">'.$name.' '.$year.'</option>';
       														 }
															 ?>
                            </select>
                          <img style="display: none;" id="calendar_loading_spinner" class="apt_calendar" src="<?php echo cdn_url_images(); ?>images/spinner.gif" />
                          </div>
                          <div class="Edit_Cal_Top_Right clsFloatRight">
                          	<div id="legend">
                          		<div>
                          <div class="available key">&nbsp;</div>
                          <div class="key-text"> <?php echo translate("Available"); ?> </div>
                          </div>
                          <div>
                          <div class="unavailable key">&nbsp;</div>
                          <div class="key-text"> <?php echo translate("Unavailable"); ?> </div>
                          </div>
                          <div>
                          <div class="in_the_past key">&nbsp;</div>
                          <div class="key-text"> <?php echo translate("Past"); ?> </div>
                          </div>
                          <div class="clear"></div>
                        </div>
                          </div>
                          <div class="clear"></div>
                        </div>
                        <div id="calendar_tab_variable_content"></div>
                        
                      </div>
                    <p> <?php //echo translate("The calendar is updated every five minutes and is only an approximation of availability. We suggest that you contact the host to confirm.");?> </p>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
         </div>
      </div> <!-- Room slider !-->
            
        </div>
      </div>
           
              
        
      </div>
      
      
 
      
      </div>
</div>
      
      <!-- Reputation division was once here -->
      <!-- End of reputation division -->
      <script type="text/javascript">
  jQuery('#reputation .pagination a').live('click', function() {
    var $this = jQuery(this);
    $this.parent().append('<img src="<?php echo cdn_url_images(); ?>images/spinner.gif" class="spinner" height="16" width="16" alt="" />'); 

    jQuery.ajax({
      url: $this.attr('href'),
      success: function(data) {
        $this.closest(".rep_content").html(data);
        jQuery('html, body').animate({scrollTop: jQuery('#reputation').offset().top}, 'slow');
      }
    });

    return false;
  });
      select_tab('rep', 'this_hosting_reviews', jQuery('#this_hosting_reviews_link'));
</script>

   <script type="text/javascript">
     
   var checkout;
  
   ;(function($) {
        jQuery(function() {
        
			jQuery('#my-button').bind('click', function(e) {
				
				
				 
			var instance_book1='<?php echo $instance_book; ?>';
			if(instance_book1 != 1)
				{
					clearInterval(checkout);
					
<?php if($this->dx_auth->get_user_id() != ""){?>
	
jQuery("#status").css("display","block");
jQuery("#status_contact_login").css("display","none");
jQuery("#status_availablity").css("display","none");
jQuery("#status_already").css("display","none");
jQuery("#status_your_list").css("display","none");
jQuery("#status_contact").css("display","none");
jQuery("#sendmessage").attr("disabled", false);

<?php } else {?>
	//window.location.reload;
jQuery('#status').hide();
jQuery('#status_contact_login').css("display","inline");				

<?php } ?>
				
	                	e.preventDefault();
	                	
		jQuery('#element_to_pop_up').bPopup({
			closeClass:'close',
			
			fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
			followSpeed: 1500, //can be a string ('slow'/'fast') or int
			modalColor: 'black',
			contentContainer:'.content',
			 zIndex: 1,
			 modalClose: true
});  
       }
       else 
       { 
       	alert("Since it is an Instant booking list you can't contact host.");
       	
       }           

	 });
         });
     })(jQuery);	
     	
   </script>
        
<style>
.per_night_drop
{
	margin-bottom: 4%;
	margin-left: 4%;
}
#main_content .container_bg{
	width:100%;

.container_bg
{
width: 980px !important;

}
</style>
    
    <!-- /right_column -->
    <div id="lwlb_overlay"></div>
    <div id="lwlb_needs_to_message" class="lwlb_lightbox2" style="display:none;">
      <div class="header">
        <div class="h1">
          <h1> <?php echo translate("Please confirm availability"); ?> </h1>
        </div>
        <div class="close"><a href="#" onClick="lwlb_hide_and_reset('lwlb_needs_to_message');return false;"><img src="/images/lightboxes/close_button.gif" /></a></div>
        <div class="clear"></div>
      </div>
      <br/>
      <br/>
      <p> <?php echo translate("This host requires that you confirm availability before making a reservation.  Please send a message to the host and wait for a response before booking.");?> </p>
      <br/>
      <br/>
      <p><span class='v3_button v3_blue' onClick="jQuery('#lwlb_needs_to_message').hide();jQuery('#user_contact_link').click();"> <?php echo translate("Contact Host"); ?> </span></p>
    </div>
    <div id="lwlb_contact_container"></div>
    <!-- set up a dummy link that we click later with js -->
    <a style="display:none;" id="fb_share_dummy_link" name="fb_share" type="icon_link" href="http://www.facebook.com/sharer.php"> <?php echo translate("Share"); ?> </a>
    <div class="clear"></div>
  </div>
  <!-- /rooms -->
		 
</div>
</div>
</div>




<div class="" id="reputation">
	<div class="container">

        <div id="comments" class="reputation_content" style="display: none">
       <div id="fb-root">  
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>

 window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $fb_app_id; ?>', // App ID
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
  };
  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId="+<?php echo $fb_app_id; ?>;
  fjs.parentNode.insertBefore(js, fjs);
  document.getElementById(id).innerHTML='';
    parser=document.getElementById(id);
    //parser.innerHTML='<div style="padding-left:5px; min-height:500px" class="fb-comments" data-href="'+newUrl+'" data-num-posts="20" data-width="380"></div>';
    FB.XFBML.parse(parser);
    }(document, 'script', 'facebook-jssdk'));
</script>
</div>  
<style>
 .fb-comments, .fb-comments span, .fb-comments iframe[style]
{
    width: 100% !important;
    min-height:200px !important;
}
 </style>              
<div class="fb-comments" data-href=<?php echo base_url().'rooms/'.$room_id; ?> data-width="100%" data-num-posts="10"></div>
</div>
										<!-- Top Rating Blk -->
		<div id='reviews' class="reputation_content col-xs-12 col-sm-12 col-md-8" style="border: none;">
		<h2 class="subhdngs1 col-md-3 col-sm-3 col-xs-12 padding-zero"><?php echo translate("Reviews");?></h2>									

            <?php			

	 if($result->num_rows() > 0) 
		{     
				$accuracy      = (($stars->accuracy *2) * 10) / $result->num_rows();
				$cleanliness   = (($stars->cleanliness *2) * 10) / $result->num_rows();
				$communication = (($stars->communication *2) * 10) / $result->num_rows();
				$checkin       = (($stars->checkin *2) * 10) / $result->num_rows();
				$location      = (($stars->location *2) * 10) / $result->num_rows();
				$value         = (($stars->value *2) * 10) / $result->num_rows();
				$overall       = ($accuracy + $cleanliness + $communication + $checkin + $location + $value) / 6;
                                                    
             ?>
            <div id="Sati_Top_Blk" class="col-md-9 col-sm-9 col-xs-12 padding-zero">

              <div class="Sat_Top_Right clsFloatRight col-md-12 col-sm-12 col-xs-12 padding-zero">
                <!-- First ul start -->

                <ul class="Sat_List_1 col-xs-12 col-sm-6 col-md-6">
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Accuracy"); ?></div>
                    <div class="Sat_Star_Nor_1" title="<?php echo $accuracy; ?>%">
                      <div class="Sat_Star_Act_1" style="width:<?php echo $accuracy; ?>%;"> </div>
                    </div>
                  </li>
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Cleanliness"); ?></div>
                    <div class="Sat_Star_Nor_1" title="<?php echo $cleanliness; ?>%">
                      <div class="Sat_Star_Act_1" style="width:<?php echo $cleanliness; ?>%;"> </div>
                    </div>
                  </li>
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Checkin"); ?></div>
                    <div class="Sat_Star_Nor_1" title="<?php echo $checkin; ?>%">
                      <div class="Sat_Star_Act_1" style="width:<?php echo $checkin; ?>%;"> </div>
                    </div>
                  </li>
                </ul>
                <!-- End of ul -->
                <!-- Second ul start -->
                <ul class="Sat_List_2 col-xs-12 col-sm-6 col-md-6">
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Communication"); ?></div>
                    <div class="Sat_Star_Nor_2" title="<?php echo $communication; ?>%">
                      <div class="Sat_Star_Act_2" style="width:<?php echo $communication; ?>%;"> </div>
                    </div>
                  </li>
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Location"); ?></div>
                    <div class="Sat_Star_Nor_2" title="<?php echo $location; ?>%">
                      <div class="Sat_Star_Act_2" style="width:<?php echo $location; ?>%;"> </div>
                    </div>
                  </li>
                  <li class="clearfix">
                    <div class="Sat_Attribute"><?php echo translate("Value"); ?></div>
                    <div class="Sat_Star_Nor_2" title="<?php echo $value; ?>%">
                      <div class="Sat_Star_Act_2" style="width:<?php echo $value; ?>%;"> </div>
                    </div>
                  </li>
                </ul>
                <!-- End of ul -->
              </div>
              <div class="clearfix"></div>
            </div>
            <?php } ?>
            <!-- End of Top Rating Blk -->
          
           
            
            <!-- Status Bottom Blk -->
            <div class="Sta_Bttm_Blk col-md-9 col-xs-12 col-sm-12 padding-zero">
              <ul>
                <?php 
                if($result->num_rows() > 0) { 
                foreach($result->result() as $row) { 
              ?>
                <li class="clearfix">
                  <div class="Sta_Rat_Prof clsFloatLeft apt_profile col-md-3 col-sm-4 col-xs-12 padding-zero"> 
					<a href="<?php echo site_url('users/profile').'/'.$row->userby; ?>">
					<img height="65" width="65" src="<?php echo $this->Gallery->profilepic($row->userby, 2); ?>" alt="Profile" /> 
					</a>
                    <left><span class="apt_username1"><?php echo ucfirst(get_user_by_id($row->userby)->username); ?></span>
                  </left></div>
                  <div class="Sta_Rat_Msg clsFloatRight col-md-9 col-sm-8 col-xs-12 textcenter">
                  	
                  	<?php
                	
				$accuracy1      = (($row->accuracy *2) * 10);
				$cleanliness1   = (($row->cleanliness *2) * 10);
				$communication1 = (($row->communication *2) * 10);
				$checkin1       = (($row->checkin *2) * 10);
				$location1      = (($row->location *2) * 10);
				$value1         = (($row->value *2) * 10);
				$overall1       = ($accuracy1 + $cleanliness1 + $communication1 + $checkin1 + $location1 + $value1)/ 6; 

              ?>
                <div class="Sat_Star_Nor over" title="<?php echo $overall1; ?>%">
                  <div class="Sat_Star_Act" style="width:<?php echo $overall1; ?>%;"> </div>
                </div>
                  	
                    <p><?php echo $row->review; ?></p>

                    <p class="apt_review"><?php echo get_user_times($row->created, get_user_timezoneL($row->userby)); ?></p>

                    <span class="StaMsg_LeftArrow"></span> </div>
                  <div class="clearfix"></div>
                </li>

                <?php } }
				 else { echo translate("No reviews found.");
				?>
		  <div class="reputation_content">
		  	     <?php //echo translate("No reviews found."); ?> </li></div>
                <?php 
               
				 } ?>
              </ul></div>
              <div class="clearfix"></div>
            
            </div>
            <!-- End of Status Bottom Blk -->
        	
          		  
      </div>
      </div>

<div class="container abouthost">
	<div class="col-xs-12 col-sm-12 col-md-8 brdr_btm">
	<h2 class="subhdngs subhdngs_1"><?php echo translate("About the Host");?></h2>
	<div class="col-xs-12 col-md-3 col-sm-3 hostprfl">
		<img id="trigger_id" class="userprfl" width="75" height="75" alt="" src="<?php echo $this->Gallery->profilepic($list->user_id,2);?>" title=""/>
	</div>
	<div class="col-xs-12 col-md-9 col-sm-9 textcenter">
<?php if(isset($profiles->describe)) { echo $profiles->describe; } if(($profiles->describe)==''){ echo "No details given";} ?>

            </div>
	
	</div>
	
	
	<div class="col-xs-12 col-sm-12 col-md-8 brdr_btm" style="border: none;">
	<div class="col-xs-12 col-md-3 col-sm-3 padding-zero">
	<h2 class="subhdngs1"><?php echo "Comments";?></h2>
	</div>
	<div class="col-xs-12 col-md-9 col-sm-9">
		<div class="fb-comments" data-href=<?php echo base_url().'rooms/'.$room_id; ?> data-width="100%" data-num-posts="10"></div>
	</div>
	</div>
	
<div id="mapsdiv1" class="main col-md-12 col-xs-12 col-sm-12 padding-zero">
	<h2 class="subhdngs1"><?php echo "Location";?></h2>
                <div id="map" data-lat="<?php echo $list->lat; ?>" data-lng="<?php echo $list->long; ?>"> </div>
                <ul id="guidebook-recommendations" style="display: none;">
                </ul>
              </div>
					
          		  
      </div>
      </div>

<div class="container">
<div class="related_listings col-xs-12" id="my_other_listings" style="padding:0px;">
        	<div class="">
              <h2 class="similar"> <?php echo translate("Similar Listings"); ?> </h2>
            </div>
            <div class="related_listings_content">
            
           <?php 
           if($count_similar <= 0) { ?>  <h4> <?php echo translate("N/A"); ?></h4><?php }else{
           	?>
                <ul id="slider1">
            <?php 
                  foreach($similar_listing->result() as $a ):
		 $CI = &get_instance();
		 $distance  = $CI->getDistanceBetweenPointsNew($list->lat,$list->long,$a->lat,$a->long);
		 
					 $date_new = strtotime(date("Y-m-d", strtotime("-3 days")));
					  
					  $created = $list->created;
					  
					  if($created != 0)
					  {
						  if($created >= $date_new )
						  {
						  	$temp = '<div class="map_number">New</div>';
						  }else
						  {
						  	$temp = '<div class="map_number" style="display:none;"></div>';
						  }
					  }else{
					  	$temp = '<div class="map_number" style="display:none;"></div>';
					  }
					  
					 $url = getListImage($a->id); 
					 $noimage ="'".base_url()."images/no_image.jpg"."'";
					 $userid = $a->user_id;
					echo '<li class="item">
					<div class="related_listing_left col-xs-12">
					<a href='.base_url().'rooms/'.$a->id.' id="related_listing_photo"">'.$temp.'<img alt="no image" height="250" src="'.$url.'" onerror="this.src='.$noimage.'" title="no image" width="100%" />
					</a>
					<div class="subtitle">'.get_currency_symbol($a->id).get_currency_value1($a->id,$a->price).'/night </div>
					<a href='.base_url().'users/profile/'.$a->user_id.'><img class="proimg" height="50" width="50" alt="" src="'.$this->Gallery->profilepic($a->user_id,2).'" /></a></div>';				
		
					echo '<div class="related_listing_right col-xs-12">';
					echo anchor('rooms/'.$a->id , $a->title);
					echo '<p>'.$a->room_type.'</p>';
					echo '<div class="distance">'.$distance." Miles".'</div></div>';
					
					
					echo '<div class="clear"></div>
					</li>';
           endforeach; 
											?>
            </ul>
                   	
           <?php }
		   ?>
          </div>
          <div class="clear"></div>
      </div>
</div>

<script type="text/javascript">

function block_datepicker()
{	
		///////////// Block the reserved dates in datepicker (checkin & checkout)
		
		var array = [];
		var dates = new Array();
  	jQuery.ajax({
 		type: 'POST',
        url: "<?php echo site_url('rooms/get_reserved_date');?>",
        data:"roomid="+<?php echo $room_id;?>,
 		success: function(response)
 		{
if(response != "" && response != "no")
{
		var seasonal = response ;
		var parsed = seasonal.split(",");
				        for(var count=0;count<parsed.length;count++)
		                {
  							dates.push('"'+parsed[count]+'"');
  		                }
		            
		            array = "["+dates+"]"; 
}else{
	array = [];
}
 		}
 	});
 

  jQuery("#checkout, #checkin, #checkindate, #checkoutdate").datepicker('change',{
 	minDate: 0,
 	maxDate: "+2Y",
    nextText: "",
    prevText: "",
    numberOfMonths: 1,
        beforeShowDay: function(date){
        var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
       //console.log(array);
        return [ array.indexOf(string) == -1 ]
        
    }
     
 });


	/////////////////////////////////////////////////////////////////////////	
	
}
	jQuery(document).ready(function(){
		
		jQuery("#checkin").attr("placeholder", "mm/dd/yy");
		jQuery("#checkout").attr("placeholder", "mm/dd/yy");


		block_datepicker();
		load_google_map();
		
		var winsize = jQuery(window).width();
		var distance = jQuery('.rightcolumn').offset().top;
		var distance1 = jQuery('.abouthost').offset().top;

         jQuery(window).bind('scroll', function () {

jQuery(function(jQuery){ 

        if (jQuery(window).scrollTop() > distance) {
        	//alert();
  jQuery(".rightcolumn").hide().css({"position": "fixed", "top": "42px", "width": "400px","z-index":"1"}).show().data('positioned', 'true');
            
        }
        else if (jQuery(window).scrollTop() <= 610 ) {
        	//alert();
            jQuery(".rightcolumn").show(function() {
                jQuery(this).css({"position": "absolute", "top": "0px"}).show();
            }).data('positioned', 'false');
        }
        if (jQuery(window).scrollTop() > distance1) {
        	//alert();
            jQuery(".rightcolumn").hide();
            
        } 
    });

	jQuery('select option:contains("Per Night")').prop('selected',true);
		

});
	jQuery("#book_it_button").click(function(){
			if(jQuery("#checkin").val() && jQuery("#checkin").val() == 'mm/dd/yy')
            {
			alert('Please choose the dates');
            return false;
            }
			else
            {
			jQuery('#book_it_form').submit();
            }
	});
	
	});

	if (!window.Cogzidel) {Cogzidel = {};}
	Cogzidel.tweetHashTags = "#Travel";


		(function() {
  		var initOptions = {
  			userLoggedIn: true,
  			showRealNameFlow: false,
  			locale: "en"
  		};

  		if (jQuery.cookie("_name")) {
  			initOptions.userLoggedIn = true;
  		}

  		Cogzidel.init(initOptions);
		})();
  
  jQuery(document).ready(function() {
  	load_google_map();
		Cogzidel.init({userLoggedIn: false});
		//My Wish List Button-Add to My Wish List & Remove from My Wish List
		add_shortlist = function(item_id,count_wishlist,that) {
			jQuery.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin?rooms=1&id="+item_id);
      				}
      				});
		
		
		 jQuery('body').css({'overflow':'hidden'});

		jQuery('#hidden_room_id').val(item_id);
		 
		jQuery.ajax({
  				url: "<?php echo site_url('rooms/wishlist_popup'); ?>",
  				type: "GET",
  				data: "list_id="+item_id+"&status=rooms&id="+item_id,
  				success: function(data) {
  					jQuery('.modal_save_to_wishlist').replaceWith(data);	
  					setTimeout(function() {
  						jQuery('.modal_save_to_wishlist').show();
  						}, 200);
  				}
   				});
		
		if(value == "Save To Wish List" || value == '')	
		{	
			//jQuery('.modal_save_to_wishlist').show();
   		}
   		else
   		{
   			//jQuery('.modal_save_to_wishlist').show();  			
   		}			
    	};
    	//My Wish List Menu-Check whether the user is login or not 
    	view_shortlist =  function(that){
    			var value = jQuery('#short').val();
    			if(value=="short")
    			{
    				jQuery.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin");
      				else
      				{
      				jQuery('#search_type_short').attr('id','search_type_photo');
      				jQuery('#short').attr('value', 'photo');
      				jQuery("#search_type_photo").trigger("click");
      				}
      				}
      				});
      			}
    	};	
    			
		});
  		
	jQuery(function() {
		var eventDates={};
       var date = new Date();
var currentMonth = date.getMonth();
var currentDate = date.getDate();
var currentYear = date.getFullYear();
	   jQuery( "#checkoutdate" ).datepicker({
                minDate: 0,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                // closeText: "Clear Dates",
                currentText: Translations.today,
                showButtonPanel: true
	    });
	    jQuery( "#checkindate" ).datepicker({
			minDate: date,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                currentText: Translations.today,
                showButtonPanel: true,
	 onClose: function(dateText, inst) { 
	 	eventDates=[];
          d = jQuery('#checkindate').datepicker('getDate');
		 eventDates[d]=d;
		 if(parseInt(jQuery("#min_stay").val())){  
                        	var r= parseInt(jQuery("#min_stay").val());                     
                       // d.setDate(d.getDate()+r); 
                        for (var x=1 ; x<=r ; x++) {
                       d.setDate(d.getDate() + 1);
                       eventDates[d]=d;
                        }
                        }
                        if(! parseInt(jQuery("#min_stay").val())) {                        
                        	d.setDate(d.getDate()+1); 
                        	eventDates[d]=d;
                        }
		 
		 
		  //d.setDate(d.getDate()+1); // add int nights to int date
		jQuery("#checkoutdate").datepicker("option", "minDate", d);
		setTimeout(function () {
                                    jQuery("#checkoutdate").datepicker("show")
                                }, 0)
     }
	   });
       
    });
  jQuery(document).ready(function() {
jQuery('#sendmessage').live("click", function(){	
	 			jQuery("#sendmessage").attr("disabled", true);
    				jQuery.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin");
      				
      				}
      				});
      			

		var checkin = jQuery("#checkindate").val();
		var checkout = jQuery("#checkoutdate").val();
		var room_id = jQuery("#hosting_id").val();
		var guests = jQuery('#number_of_guest2 :selected').text();
		var message = jQuery("#message").val();
		if(jQuery.trim(message) == jQuery.trim("Add a Recommend") || jQuery.trim(message) == "" || checkin == "mm/dd/yy" || checkout == "mm/dd/yy" || checkout == "mm/dd/yy") { 	
			alert('Please enter all valid informations. Like checkin or checkout or Message ');
			jQuery("#sendmessage").attr("disabled", false);
		}
		else {
		var postdata = 'checkin='+checkin+'&checkout='+checkout+'&id='+room_id+'&message='+message+'&guests='+guests;
				
               if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');
            	jQuery("#sendmessage").attr("disabled", false);exit;
            }
            else if(message.match('@') || message.match('hotmail') || message.match('gmail') || message.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');
					jQuery("#sendmessage").attr("disabled", false);exit;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');
            	jQuery("#sendmessage").attr("disabled", false);exit;
            }
           
		jQuery.ajax({
            //this is the php file that processes the data and send mail
            url: "<?php echo base_url()?>payments/contact",             
            //GET method is used
            type: "POST",
            //pass the data        
            data: postdata,             
            //Do not cache the page
            cache: false,             
            //success
			dataType: "json",
            success: function (result) {  
            	//alert(result.status);return false;
            if(result.status == 'redirect')
            {
            //	window.location.reload();
            jQuery("#message").val('');
				jQuery("#checkindate").val('mm/dd/yy');
				jQuery("#checkoutdate").val('mm/dd/yy');
            	jQuery("#number_of_guest2").val('1');
            }	
			else if(result.status == "error") {
						     jQuery('#status').hide();
				jQuery('#status_contact_login').css("display","inline");				
			}
			else if(result.status == "not_available")
			{
				jQuery('#status').hide();
				jQuery('#status_availablity').css("display","inline");
			//	location.reload();
			jQuery("#message").val('');
				jQuery("#checkindate").val('mm/dd/yy');
				jQuery("#checkoutdate").val('mm/dd/yy');
            	jQuery("#number_of_guest2").val('1');
			}
			else if(result.status == "your_list")
			{
				jQuery('#status').hide();
				jQuery('#status_your_list').css("display","inline");
				//location.reload();
				jQuery("#message").val('');
				jQuery("#checkindate").val('mm/dd/yy');
				jQuery("#checkoutdate").val('mm/dd/yy');
            	jQuery("#number_of_guest2").val('1');
			}
			else if(result.status == "already")
			{
				jQuery('#status').hide();
				jQuery('#status_already').css("display","inline");
				jQuery("#message").val('');
				//location.reload();
				jQuery("#message").val('');
				jQuery("#checkindate").val('mm/dd/yy');
				jQuery("#checkoutdate").val('mm/dd/yy');
            	jQuery("#number_of_guest2").val('1');
			}
			else
			{ 
			
			jQuery('#status').hide();
				jQuery('#status_contact').css("display","inline");
				jQuery("#message").val('');
				//alert("else");
			//location.reload(); 
			jQuery("#message").val('');
				jQuery("#checkindate").val('mm/dd/yy');
				jQuery("#checkoutdate").val('mm/dd/yy');
            	jQuery("#number_of_guest2").val('1');
			}
			}	
		});
		}
	});
});
//window.onload = initPhotoGallery; 
<?php if($images->num_rows() > 0) { ?>
function preloader() 
{
     // counter
     var i = 0;
     // create object
     imageObj = new Image();
     // set image list
     images = new Array();
					<?php $i = 0; foreach($images->result() as $image)	{  $url = base_url().'images/'.$image->list_id.'/'.$image->name; ?>
     images[<?php echo $i; ?>]="<?php echo $url; ?>"
					<?php $i++; } $num_rows = $images->num_rows(); $total_rows = $num_rows-1; ?>
     // start preloading
     for(i=0; i<=<?php echo $total_rows; ?>; i++) 
     {
          imageObj.src=images[i];
     }
} 
<?php } ?>
</script>
<!-- Scripts required for this page -->
<script type="text/javascript">
			 var needs_to_message = true;
    var ajax_already_messaged_url = "";
    var ajax_lwlb_contact_url = "<?php echo site_url('rooms/ajax_contact').'/'.$room_id; ?>";

    function action_email() {
            lwlb_show('lwlb_email');
    }

        function redo_search(opts) {
        opts = (opts === undefined ? {} : opts);

        opts.useAddressAsLocation = (opts.useAddressAsLocation === undefined ? true : opts.useAddressAsLocation);

        var urlParts = [base_url+"search?"];

        if(opts.useAddressAsLocation === true){
            //need to make this backwards compatible with cached versions
            var locationParam = '';

            if(jQuery('#display_address')){
                locationParam += jQuery('#display_address').data('location');
            } else if(jQuery('.current_crumb .locality')){ //we can remove this else if block after Oct 12, 2010 -Chris
                locationParam += jQuery('.current_crumb .locality').html();
                if(jQuery('.current_crumb .region')){
                    locationParam += ', ';
                    locationParam += jQuery('.current_crumb .region').html();
                }
            }

            if(locationParam && locationParam != 'null' && locationParam != ''){
                urlParts = urlParts.concat(["location=", locationParam, '&sort_by=2&']);
            }
        }

        var checkinValue = jQuery('#checkin').val();
        var checkoutValue = jQuery('#checkout').val();

        if(checkinValue !== 'mm/dd/yyyy' && checkoutValue !== 'mm/dd/yyyy'){
            urlParts = urlParts.concat(["checkin=", checkinValue, "&checkout=", checkoutValue, '&']);
        }

        urlParts = urlParts.concat(["number_of_guests=", jQuery('#number_of_guests').val()]);

        url = urlParts.join('');

        window.location = url;

        return true;
    }

	function change_month2(cal_year) {
var d = new Date();
var gmtHours = -d.getTimezoneOffset()/60;
var timezone_offset = String(gmtHours);
        // now load the calendar content
        
        		    jQuery.ajax({
		        type:"post",
		        url: "<?php echo site_url('rooms/calendar_tab_inner').'/'.$room_id; ?>",
		        data: {cal_month: jQuery('#cal_month').val(), cal_year: cal_year,offset: timezone_offset},
		        dataType:"HTML",
		        cache: false,
		        success: function(response)          //on recieve of reply
		        {
		        	jQuery('#calendar_tab_variable_content').html(response);
            jQuery('#calendar_loading_spinner').hide();	
		        }
		        });

	}

  var initial_month_loaded = false;
		
	function load_initial_month(cal_year) {

var d = new Date();
var gmtHours = -d.getTimezoneOffset()/60;
var timezone_offset = String(gmtHours);
    if (initial_month_loaded === false) {
      jQuery('#calendar_loading_spinner').show();
      
              		    jQuery.ajax({
		        type:"post",
		        url: "<?php echo site_url('rooms/calendar_tab_inner').'/'.$room_id; ?>",
		        data: {cal_month: jQuery('#cal_month').val(), cal_year: cal_year,offset: timezone_offset},
		        dataType:"HTML",
		        cache: false,
		        success: function(response)          //on recieve of reply
		        {
		        	jQuery('#calendar_tab_variable_content').html(response);
            jQuery('#calendar_loading_spinner').hide();	
		        }
		        });

    }
  }

  var Translations = {
    translate_button: {
      
      show_original_description : 'Show original description',
      translate_this_description : 'Translate this description to English'
    },
    per_month: "per month",
    long_term: "Long Term Policy",
    clear_dates: "Clear Dates"
  }
		
		function preloaderUser() 
		{
		heavyImage = new Image(); 
		heavyImage.src = "<?php echo $this->Gallery->profilepic($list->user_id); ?>";
		}

    /* after pageload */
    jQuery(document).ready(function() {
        // initialize star state
        Cogzidel.Bookmarks.starredIds = [1,2];
        Cogzidel.Bookmarks.initializeStarIcons();

								<?php if($images->num_rows() > 0) { ?>
        preloader();
								<?php } ?>
								preloaderUser();
        //Code for back to page2
          var backToSearchHtml = ['<a rel="nofollow" onclick="if(redo_search({useAddressAsLocation : true})){return false;}" href="/search" id="back_to_search_link">', "View Nearby Properties", '</a>'].join('');

        jQuery('#back_to_search_container').append(backToSearchHtml);

        /* target specifically a#view_other_listings_button so no conflict with input#view_other_listings_button in cached pages */
        if(jQuery('a#view_other_listings_button')){
            jQuery('a#view_other_listings_button').attr('href', jQuery('#back_to_search_link').attr('href'));
        }
        /* end code for back to page2 */


        // init the flag widget handler too
        jQuery('.flag-container').flagWidget();

        CogzidelRooms.init({inIsrael: false, 
                          hostingId: <?php echo $room_id; ?>,
                          videoProfile: false,
                          isMonthly: false,
                          nameLocked: false,
						  staggeredPrice: "<?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$Mprice); ?>",
                          nightlyPrice: "<?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$price); ?>",
                          weeklyPrice: "<?php echo  get_currency_symbol($room_id).get_currency_value1($room_id,$Wprice); ?>",
                          monthlyPrice: "<?php echo get_currency_symbol($room_id).get_currency_value1($room_id,$Mprice); ?>"});

        page3Slideshow.enableKeypressListener();
								
							<?php if($this->session->userdata('checkin') != '') { ?>
							jQuery("#checkin").val('<?php echo $this->session->userdata('checkin'); ?>');
								jQuery("#checkindate").val('<?php echo $this->session->userdata('checkin'); ?>');
							<?php }  ?>
							<?php if($this->session->userdata('checkout') != '') { ?>
							jQuery("#checkout").val('<?php echo $this->session->userdata('checkout'); ?>');
												jQuery("#checkoutdate").val('<?php echo $this->session->userdata('checkout'); ?>');
							<?php } ?>

							<?php if($this->session->userdata('Vnumber_of_guests') != '') { ?>
							jQuery("#number_of_guests").val('<?php echo $this->session->userdata('Vnumber_of_guests'); ?>');
							<?php } else { ?>
							jQuery("#number_of_guests").val('1');
							<?php } ?>


        add_data_to_cookie('viewed_page3_ids', <?php echo $room_id; ?>);
		
    });

			</script>
			
			<script type="text/javascript">
			var addthis_config = {"data_track_addressbar":true};
			</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525c2c194313da57"></script>

<input type="hidden" value="" id="hidden_room_id">

<div class="modal_save_to_wishlist" style="display: none;">
</div>


<!-- End of this scripts section -->

<style>
*
{
    box-sizing: border-box;
}
.modal_save_to_wishlist {
    opacity: 1;
}

.modal_save_to_wishlist {
    background-color: rgba(0, 0, 0, 0.75);
   bottom: 0;
    left: 0;
    opacity: 1;
    overflow-y: auto;
    position: fixed;
    right: 0;
    top: 0;
    transition: opacity 0.2s ease 0s;
    z-index: 2000;
}
.modal-table {
    display: table;
    height: 100%;
    table-layout: fixed;
    width: 75%;
}
.modal-cell {
    display: table-cell;
    height: 100%;
    padding: 50px;
    vertical-align: middle;
    width: 100%;
}
.wishlist-modal {
    max-width: 700px;
    overflow: visible;
    width: 700px;
}

.modal-content {
    background-color: #fff;
    border-radius: 2px;
    margin-left: auto;
    margin-right: auto;
    max-width: 700px;
    overflow: hidden;
    position: relative;
}
.panel-dark, .panel-header {
    background-color: #edefed;
}
.panel-header {
    border-bottom: 1px solid #dce0e0;
    color: #565a5c;
    font-size: 16px;
    padding-bottom: 14px;
    padding-top: 14px;
}
.panel-header, .panel-body, ul.panel-body > li, ol.panel-body > li, .panel-footer {
    border-top: 1px solid #dce0e0;
    margin: 0;
    padding: 20px;
    position: relative;
    text-align:left;
}
.popup_title {
font-weight: bold;
font-size: 19px;
text-align: left !important;
color: #393C3D;
}
.panel-footer {
    text-align: right;
}
.panel-footer {
    border-top: 1px solid #dce0e0;
    margin: 0;
    padding: 20px;
    position: relative;
}
.addnote{
font-weight: bold;
font-size: 14px;
}
.wishlist-modal .dynamic-listing-photo-container {
    height: 64px;
}
.panel-close, .alert-close, .modal-close {
    color: #cacccd;
    cursor: pointer;
    float: right;
    font-size: 2em;
    font-style: normal;
    font-weight: normal;
    line-height: 0.7;
    vertical-align: middle;
}
.row > .col-1, .row > .col-2, .row > .col-3, .row > .col-4, .row > .col-5, .row > .col-6, .row > .col-7, .row > .col-8, .row > .col-9, .row > .col-10, .row > .col-11, .row > .col-12 {
    padding-left: 12.5px;
    padding-right: 12.5px;
}
.col-2 {
    width: 16.6667%;
}
.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
    float: left;
    min-height: 1px;
    position: inherit;
}
.img-responsive-height {
    height: 100%;
    width: auto;
}
.media-cover, .media-cover-dark:after {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.wishlist-modal .dynamic-listing-photo-container {
    height: 64px;
}
.media-photo-block {
    display: block;
}
.row > .col-1, .row > .col-2, .row > .col-3, .row > .col-4, .row > .col-5, .row > .col-6, .row > .col-7, .row > .col-8, .row > .col-9, .row > .col-10, .row > .col-11, .row > .col-12 {
    padding-left: 12.5px;
    padding-right: 12.5px;
}
.col-10 {
    width: 83.3333%;
    text-align: left;
}
.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
    float: left;
    min-height: 1px;
    position: inherit;
}
.text-lead {
    font-size: 16px;
}
.row-space-2 {
    margin-bottom: 12.5px;
}
.row {
    margin-left: -12.5px !important;
    margin-right: -12.5px !important
}
#panel-body {
    margin-left: -12.5px !important;
    margin-right: -12.5px !important
}
#panel-body
{
    padding-left: 12.5px;
    padding-right: 12.5px;
}
#panel-body:before, #panel-body:after {
    content: "";
    display: table;
    line-height: 0;
    
}
#panel-body:after {
	
    clear: both;
    
}

.wishlist-modal .selectContainer {
	
    overflow: inherit;
    
}

.wishlist-modal .selectContainer {
	
    border: 1px solid #dce0e0;
    
}

.wishlist-modal .selectContainer:hover{
	
	border: 1px solid #00b0ff;
	
}

.select-block {
	
    display: block;
    width: 100%;
    
}

.select {
	
    display: inline-block;
    
    position: relative;
    
    vertical-align: bottom;
    
} 
.wishlist-modal #selected { 
    display: block; 
    height: 43px; 
    line-height: 43px; 
    margin-left: 20px; 
    overflow: hidden; 
    width: 252px; 
} 
.col-12 { 
    width: 100%; 
} 
.noteContainer label { 
    display: block; 
    padding-bottom: 8px; 
    padding-top: 9px; 
}  
.wishlist-note {
			    line-height: inherit;
			    padding-bottom: 10px;
			    padding-top: 10px;
			    resize: vertical;
			      display: block;
			    padding: 8px 10px;
			    width: 100%;
			}
			.wishlist-modal .selectWidget {
			    /*background-color: white;
			border: 1px solid #dce0e0;
			margin: -1px 0 0 -1px;*/
			    position: absolute;
			    width: 100%;
			    z-index: 99999;
			}
			.wishlist-modal .selectList {
			    margin: 0;
			    max-height: 180px;
			    overflow: auto;
			    padding: 0;
			}
			.wishlist-modal .selectList li {
			    border-bottom: 1px solid #dce0e0;
			}
			.wishlist-modal .selectContainer .checkbox.text-truncate {
			    white-space: normal;
			}
			.wishlist-modal .selectList label {
			    padding: 10px 15px;
			}
			.checkbox {
			    cursor: pointer;
			}
			.text-truncate {
			    overflow: hidden;
			    text-overflow: ellipsis;
			    white-space: nowrap;
			}
			.wishlist-modal .selectList input {
			    display: inline-block;
			    margin-top:0px;
			}
			input[type="radio"], input[type="checkbox"] {
			    height: 1.25em;
			    margin-bottom: -0.25em;
			    margin-right: 5px;
			    position: relative;
			    vertical-align: top;
			    width: 1.25em;
			}
			.wishlist-modal .selectList label span {
			    margin-left: 25px;
			    width: 245px;
			}
			.wishlist-modal .newWLContainer {
			    /*border-top: 1px solid #dce0e0;*/
			    padding: 8px;
			}
			.wishlist-modal .newWLContainer .doneContainer {
			    overflow: hidden;
			}
			.tooltip-bottom-left:before {
			    -moz-border-bottom-colors: none;
			    -moz-border-left-colors: none;
			    -moz-border-right-colors: none;
			    -moz-border-top-colors: none;
			    border-color: rgba(0, 0, 0, 0.1) transparent -moz-use-text-color;
			    border-image: none;
			    border-left: 10px solid transparent;
			    border-right: 10px solid transparent;
			    border-style: solid solid none;
			    border-width: 10px 10px 0;
			    bottom: -10px;
			    content: "";
			    display: inline-block;
			    left: 14px;
			    position: absolute;
			    top: auto;
			}
			.tooltip-bottom-left:before {
			    -moz-border-bottom-colors: none;
			    -moz-border-left-colors: none;
			    -moz-border-right-colors: none;
			    -moz-border-top-colors: none;
			    border-color: rgba(0, 0, 0, 0.1) transparent -moz-use-text-color;
			    border-image: none;
			    border-left: 10px solid transparent;
			    border-right: 10px solid transparent;
			    border-style: solid solid none;
			    border-width: 10px 10px 0;
			    bottom: -10px;
			    content: "";
			    display: inline-block;
			    left: 50%;
			    position: absolute;
			    top: auto;
			}
			.tooltip-bottom-left:after {
			    -moz-border-bottom-colors: none;
			    -moz-border-left-colors: none;
			    -moz-border-right-colors: none;
			    -moz-border-top-colors: none;
			    border-color: #fff transparent -moz-use-text-color;
			    border-image: none;
			    border-left: 9px solid transparent;
			    border-right: 9px solid transparent;
			    border-style: solid solid none;
			    border-width: 9px 9px 0;
			    bottom: -9px;
			    content: "";
			    display: inline-block;
			    left: 50%;
			    position: absolute;
			    top: auto;
			}
			.tooltip{
			     background-color: #fff;
			    border-radius: 2px;
			    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
			    left: 0;
			    top: -196px;
			    max-width: 280px;
			    display:none;
			    position: absolute;
			    transition: opacity 0.2s ease 0s;
			    z-index: 3000;
			}
			#privacy-tooltip-trigger:hover + .tooltip{
			    display:block !important;
			    z-index:3000;
			    float:left;
			    display:block;
			    margin:190px 0px 0px 250px;
			}
			.hosting_address {
			    margin-bottom: 15px;
			}
			.wishlist-modal .hide {
			    border: 0 none;
			    clip: rect(0px, 0px, 0px, 0px);
			    height: 1px;
			    margin: -1px;
			    opacity: 0;
			    overflow: hidden;
			    padding: 0;
			    pointer-events: none;
			    position: absolute;
			    width: 1px;
			}
			.selectList li
			{
				padding: 10px;
			}
			#new_wishlist {
			    overflow:hidden;
			}
			#slider_sub_nav a:focus{
				outline: none!important;
				text-decoration: none;
			}
			#slider_sub_nav a:active{
				text-decoration: none;
			}
			</style>