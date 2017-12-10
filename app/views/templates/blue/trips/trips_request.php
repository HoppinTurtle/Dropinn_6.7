<link rel="stylesheet" href="<?php echo  css_url();?>/dashboard.css" type="text/css">
<script src="<?php echo base_url(); ?>js/jquery.countdown.js" type="text/javascript"></script>
<link href="<?php echo css_url().'/reservation.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
@media print{
  #Header { display:none; }
  body { background-color:#FFFFFF; background-image:none; color:#000000 }
  ul { color:#330200;}
  li { padding:10px 0 10px 0;  
	   list-style-type: none; }
  #details_breakdown_1 { border-radius: 10px 10px 10px 10px;
border: 1px solid rgb(252, 178, 128);
margin: 0px 0px 20px 0px; }
  #left { display:none; }
  #printPrint { display:none; }
  #Footer { display:none; }

}
  #circle {
  
  border :1px solid #c3c3c3;
  border-radius: 50%;
 
  
}
#submit_btn{
	float:right;
}
a:link {
	text-decoration:none;
}
a:hover {
	text-decoration:none;
}
a:visited{
	text-decoration:none;
}
	.clsType_Conver_old {
	padding: 15px;
	/*border: 1px solid #dce0e0;*/
	background: #fff;
}
.clsType_Conver_old textarea {
	border: 1px solid #dce0e0 !important;
	
}	
.TypeConver_Ans_old {
	border: 1px solid #dce0e0;
	background: #ffffff;
	padding:20px;
}
.padding_top_15
{
	padding-top:15px;
}
.main_concervation
{
	background: #ffffff none repeat scroll 0 0;
    border-radius: 10px;
    margin: 15px 0;
    padding: 15px;
}
</style>
<script>
$(document).ready(function()
{
	$('.button1').click(function()
	{
		var message = $('#comment').val();
		 if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            else if(message.match('@') || message.match('hotmail') || message.match('gmail') || message.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');return false;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
	})
})
</script>
<script type="text/javascript">
	function print_confirmation() {
		var myWindow;
		myWindow=window.open('','_blank','width=800,height=500');
		myWindow.document.write("<p><?php echo addslashes($confirmation); ?></p>");
		myWindow.print();
	}
</script>

<?php
$night_price = get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$per_night);

// Print The Confrmation

$confirmation = '';
$confirmation .= '<p style="padding:5px 5px 5px 725px"><a style="color:#38859B;cursor:pointer;" onClick="javascript:window.print();"><strong>'.translate('Print').'</strong></a></p>';
$confirmation .= '<table border="1" width="100%">';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Property").'</td>';
$confirmation .= '<td>'.get_list_by_id($result->list_id)->title.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Check in").'</td>';
$confirmation .= '<td>'.get_user_times($result->checkin, get_user_timezone()).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Check out").'</td>';
$confirmation .= '<td>'.get_user_times($result->checkout, get_user_timezone()).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Nights").'</td>';
$confirmation .= '<td>'.$nights.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Guests").'</td>';
$confirmation .= '<td>'.$no_quest.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Cancellation Policy").'</td>';
$confirmation .= '<td>'.$policy.'</tr>';
$confirmation .= '</tr>';


$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Average Rate").'( '. translate("Per night") .' )'.'</td>';
$confirmation .= '<td>'.$night_price.'</tr>';
$confirmation .= '</tr>';


$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Base Price").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$base_price)." [ ".$night_price." x ".$nights." nights ] ".'</tr>';
$confirmation .= '</tr>';

if($cleaning != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Cleaning Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$cleaning).'</tr>';
$confirmation .= '</tr>';
}
if($security != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Security Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$security).'</tr>';
$confirmation .= '</tr>';
 } 
if(isset($extra_guest_price))
{
if($extra_guest_price != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Additional Guest Fee").'."X".'.$nights.'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$extra_guest_price).'</tr>';
$confirmation .= '</tr>';
 }
}

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Subtotal").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$subtotal).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Service Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$commission).'</tr>';
$confirmation .= '</tr>';


$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Total amount").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$total_amount).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Status").'</td>';
$confirmation .= '<td>'.translate($result->name).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '</table>';

?>
<div class="container_bg container">
<div id="Reserve_Continer">
<div id="View_Request" class="clearfix">
<div id="left" class="col-md-3 col-sm-3 col-xs-12 pad_rig">

    <!-- /user -->
    <div class="Box" id="quick_links">
      <div class="Box_Head">
        <h2><?php echo translate("Quick Links");?></h2>
      </div>
      <div class="Box_Content">
        <ul>
          <li><a href=<?php echo base_url().'listings'; ?>> <?php echo translate("View/Edit Listings"); ?></a></li>
          
         <li><a href="<?php echo site_url('listings/my_reservation'); ?>"><?php echo translate("Reservations"); ?></a></li>  
        </ul>
     
      </div>
      <div style="clear:both"></div>
    </div>

</div>
<div id="main_reserve" class="col-md-9 col-sm-9 col-xs-12 padding-zero pad_list_req">
 <div class="Box">
        <div class="Box_Head">
		<h2 class="req_head padding-zero"><?php echo translate("Reservation Request Sent"); ?> 
		</h2><span class="View_MyPrint padding-zero">
	 <a href="javascript:void(0);" onclick="javascript:print_confirmation();"><?php echo translate("Print Confirmation");  ?></a></span></div>
        <div class="Box_Content res_cent col-md-12 col-sm-12 col-xs-12">
								
		<?php if($result->status != 1) { ?>
		
		<?php } ?>
		
<ul id="details_breakdown_1" class="dashed_table_1 clearfix">
<li class="top clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Property"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><a target="_blank" href="<?php echo base_url().'rooms/'.$result->list_id;?>" ><?php echo get_list_by_id($result->list_id)->title; ?></a></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check in"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo date("F j, Y",$result->checkin); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check out"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo date("F j, Y",$result->checkout); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Nights"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $nights; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Guests"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $no_quest; ?></span></span>
</li>
<li class="bottom">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Cancellation Policy"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $policy; ?></span></span>
</li>

</ul>


<ul id="details_breakdown_1" class="dashed_table_1 clearfix">

<li class="top clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$per_night); ?></span></span>
</li>

<li class="top clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Base Price"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$base_price)." [ ".$night_price." x ".$nights." nights ] "; ?></span></span>
</li>

<?php if($cleaning != 0)
{
	?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Cleaning Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$cleaning); ?></span></span>
</li>
<?php } ?>

<?php if($security != 0)
{
?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Security Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$security); ?></span></span>
</li>
<?php } ?>

<?php 
if(isset($extra_guest_price))
{
if($extra_guest_price != 0)
{
?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Additional Guest Fee").' x '.$nights.' nights ' ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$extra_guest_price*$nights); ?></span></span>
</li>
<?php }
} ?>
<?php if($result->contacts_offer == 1)
{
 $special_offer = '(Special offer used.)';
}
else
{
	$special_offer='';
} ?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Subtotal"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner">
<?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$subtotal); ?>
</span>
</span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Service Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner">
<?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$commission); ?>
</span>
</span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Total amount"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id)." ".get_currency_value_lys($result->currency,get_currency_code(),$total_amount); ?></span>
</span>
</li>

<li class="clearfix bottom">
<span class="label col-md-4 col-sm-5 col-xs-12" ><span class="inner"><span class="checkout_icon" id="icon_cal"></span>
<?php if($result->status == 1) { ?>
<?php echo translate("Expires in"); ?>
<?php
$timestamp = $result->book_date;
$book_date = date('m/d/Y', $timestamp);
$gmtTime   = get_gmt_time(strtotime('+24 hours',$timestamp));
$gmtTime   = get_gmt_time(strtotime('-18 minutes',$gmtTime));
$date      = gmdate('D, d M Y H:i:s \G\M\T', $gmtTime);
?>
<div id="expire" style="font-size:20px;"></div>
<?php } else { ?>
<?php echo translate("Status"); ?>
<?php } ?>
</span></span>

<?php if($result->status == 1) { ?>

<span class="data col-md-8 col-sm-7 col-xs-12" style="padding: 10px 10px 34px;"><span class="inner">
<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $result->id; ?>" />
<div id="expired" style="display: none"><?php echo translate('Expired');?></div>
<div id="pending" style="display: none"><?php echo translate('Pending');?></div>
</span>


</span>
<?php } else { ?>

<span class="data col-md-8 col-sm-7 col-xs-12" style="padding: 10px 10px 34px;"><span class="inner">
<?php 
echo translate($result->name);
?>
</span></span>

<?php } ?>
</li>
</ul>
<div style="clear:both"></div>
</div>



<div class="col-md-12 col-sm-12 col-xs-12 main_concervation">
      		
        	
           <?php 	$reservation_id = $this->uri->segment(3);
				$query1 = $this->db->where('reservation_id',$reservation_id)->where('conversation_id',0)->order_by('id','desc')->get('messages')->row();
				$query2=$this->db->where('id',$query1->userto)->get('users')->row();?>
	<div class="Box_Head">
				<li class="center"><h3 class="mar_top"><?php echo translate("Conversation with"); ?> <?php echo $query2->username; ?></h3></li>
			</div>
			<div class="Box_Content">
				<div class="center">
                            	<p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><img height="50" width="50" id="circle" alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(),2); ?>" /></a></p>
                                <p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><?php echo translate("You"); ?></a></p>
                            </div>
	<?php echo form_open('trips/request_sent/'.$reservation_id,array('id'=>'form_res')); ?>
                             <div class="clsType_Conver clsFloatLeft col-md-12 col-sm-12 col-xs-12">
                            	<textarea name="comment" id="comment" ></textarea>
                            	
																													<input type="hidden" name="list_id" value="<?php echo $query1->list_id; ?>" />
																													<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" />
																													<input type="hidden" name="contact_id" value="0" />
																													<input type="hidden" name="userto" value="<?php echo $query1->userto; ?>" />
																													<input type="hidden" name="userby" value="<?php echo $this->dx_auth->get_user_id(); ?>" />
                                <br />
																																<?php if(form_error('comment')) { ?>
																																<?php echo form_error('comment'); ?>
																																<?php } ?>
                                <p class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding: 15px 0px 0px 0px;margin:0px;">
                                <button name="submit" class="btn_dash" id="send_request" type="submit"><span><span><?php echo translate("Send Message"); ?></span></span></button>
                                </p>
                            </div>
							<?php echo form_close(); ?>
	<?php 
	$query3=$this->db->where('conversation_id',$reservation_id)->order_by('id','asc')->get('messages');
	$offset=$query3->num_rows();
	if($offset==1){
		$query = $this->db->where('reservation_id',$reservation_id)->order_by('id','desc')->get('messages',$offset,0);
	} else {
	$query = $this->db->where('reservation_id',$reservation_id)->order_by('id','desc')->get('messages',$offset-1,0);
	}
	$query1= $this->db->where('reservation_id',$reservation_id)->order_by('id','desc')->get('messages')->row()->conversation_id;
if($query1 != 0) {
	foreach($query->result() as $mes)
	{
		
		if($mes->conversation_id != 0){
		
		if($mes->userby == $this->dx_auth->get_user_id())
		{
		?><div class="col-xs-12 padding_top_15">
			<div class="clsConSamll_Pro_Img clsFloatLeft col-md-2 col-sm-2 col-xs-4">
				<p><a target="_blank"   href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>" title="<?php echo get_user_by_id($mes->userby)->username; ?>" ><img height="30" width="30" id="circle" alt="<?php echo get_user_by_id($mes->userby)->username; ?>" src="<?php echo $this->Gallery->profilepic($mes->userby,2); ?>" /></a></p>
				<p><a target="_blank"   href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>"><?php echo translate("You");?></a></p>
			</div>
			<div class="TypeConver_Ans_old col-md-8 col-sm-8 col-xs-8 arrow_box"><?php echo $mes->message;?></div>
		</div><?php
		}
		else {
				?><div class="col-xs-12 padding_top_15">
				<div class="TypeConver_Ans_old col-md-offset-2 col-md-8 arrow_box1 col-sm-8 col-sm-offset-2 col-xs-8"><?php echo $mes->message;?></div>
				<div class="clsConSamll_Pro_Img col-md-2 col-sm-2 col-xs-4">
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>" title="<?php echo get_user_by_id($mes->userby)->username; ?>" ><img height="30" width="30" id="circle" alt="<?php echo get_user_by_id($mes->userby)->username; ?>" src="<?php echo $this->Gallery->profilepic($mes->userby,2); ?>" /></a></p>
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>"><?php echo get_user_by_id($mes->userby)->username; ?></a></p>
					
					</div>
				</div><?php
		}

	}
	}
	}
	?>
	<?php
	$query2 = $this->db->where('conversation_id',$reservation_id)->order_by('id','asc')->get('messages')->row();
	
	?>
	
	<div class="col-xs-12 padding_top_15">
				
				<div class="clsConSamll_Pro_Img clsFloatLeft col-md-2 col-sm-2 col-xs-4">
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$query2->userto ; ?>" title="<?php echo get_user_by_id($query2->userto)->username; ?>" ><img height="30" width="30" id="circle" alt="<?php echo get_user_by_id($query2->userto)->username; ?>" src="<?php echo $this->Gallery->profilepic($query2->userto,2); ?>" /></a></p>
					<p></p><a target="_blank" href="<?php echo base_url().'users/profile/'.$query2->userto ; ?>"><?php echo translate("You");?></a></p>
					</div>
					<div class="TypeConver_Ans_old col-md-8 col-sm-8 col-xs-8 arrow_box"><?php echo $query2->message;?></div>
				</div>
	
	
</div>
            
 </div>     
								</div>
								<div style="clear:both"></div>
								</div>
							</div></div>
							
<script>
$(document).ready(function()
{
$('#send_request').live('click',function() {
	str = $("#comment").val();
	if(str.trim() == '')
	{
		alert('enter the comment');
		return false;
	}
    $(this).hide();
    $('#form_res').submit();
   // return false;
})
});

</script>
							
<script type="text/javascript">

<?php if($result->status == 1) { ?>	

$('#expire').countdown({
		until: new Date("<?php echo $date; ?>"),
		format: 'dHMS',
		layout:'{hn}:'+'{mn}:'+'{sn}',
		onExpiry: liftOff,
		expiryText:"Expired"
	});
	
	$(document).ready(function()
	{
		if($('#expire').text() == '0:0:0')
		{
			$('#req_accept').hide();
			$('#req_decline').hide();
				  
			$('#expired').show();
			$('#expired1').show();
			$('#expires_in').hide();
		}
		else
		{
			$('#pending').show();
		}
	})
	
function liftOff()
{ 
  var reservation_id = $("#reservation_id").val();
	
   	 $.ajax({
				 type: "POST",
					url: "<?php echo site_url('trips/out'); ?>",
					async: true,
					data: "reservation_id="+reservation_id,
					success: function(data)
		  	{	
						location.reload(true);
			 	}
		  });			
}

<?php } ?>

function show_hide(id)
{
		if(id == 1)
		{
		document.getElementById('req_accept').className  = 'Reserve_click';
		document.getElementById('req_decline').className = 'Reserve_Decline';
		 $('#decline').hide();
		 $('#accept').show();
		}
		else
		{
		document.getElementById('req_accept').className  = 'Reserve_Accept';
		document.getElementById('req_decline').className = 'Reserve_click';
		 $('#decline').show();
		 $('#accept').hide();
		}	
}


function req_action(id)
{
	 var message = $('#comment').val();
		 if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            else if(message.match('@') || message.match('hotmail') || message.match('gmail') || message.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');return false;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            
     var reservation_id = $("#reservation_id").val();
	 
 if(id == "accept")
	{
 var is_block = $("#block_date").val();
	var comment  = $("#comment").val();
	}
	else
	{
 var is_block = $("#block_date2").val();
	var comment  = $("#comment2").val();
	}
	
	var checkin   = $("#checkin").val();
	var checkout  = $("#checkout").val();
	
	var ok=confirm("Are you sure to "+id+" request?");
		if(!ok)
		{
			return false;
		}
		
		document.getElementById(id).innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
		
	   $.ajax({
				 type: "POST",
					url: "<?php echo site_url('trips'); ?>/"+id,
					async: true,
					data: "is_block="+is_block+"&comment="+comment+"&reservation_id="+reservation_id+"&checkin="+checkin+"&checkout="+checkout,
					success: function(data)
		  	{	
					 document.getElementById(id).innerHTML = data;
						location.reload(true);
			 	}
		  });
}

</script>

     <div style="clear:both"></div>
</div>