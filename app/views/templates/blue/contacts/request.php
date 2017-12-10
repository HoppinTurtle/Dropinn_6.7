<script src="<?php echo base_url(); ?>js/jquery.countdown.js" type="text/javascript"></script>
<link href="<?php echo css_url().'/reservation.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<?php
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
$confirmation .= '<td>'.get_user_times($checkin, get_user_timezone()).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Check out").'</td>';
$confirmation .= '<td>'.get_user_times($checkout, get_user_timezone()).'</tr>';
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
$confirmation .= '<td>'.translate("Message").'</td>';
$confirmation .= '<td>'.$message.'</tr>';
$confirmation .= '</tr>';

if($price_original=='')
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Rate").'( '. translate("per night") .' )'.'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$per_night).'</tr>';
$confirmation .= '</tr>';
}
else {
	$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Rate").'( '. translate("per night") .' )'.'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$price_original).'</tr>';
$confirmation .= '</tr>';
}
if($cleaning != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Cleaning Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$cleaning).'</tr>';
$confirmation .= '</tr>';
}
if($security != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Security Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$security).'</tr>';
$confirmation .= '</tr>';
 } 
if(isset($extra_guest_price))
{
if($extra_guest_price != 0)
{
$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Additional Guest Fee").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$extra_guest_price).'</tr>';
$confirmation .= '</tr>';
 }
} 
 if($result->offer ==1)
	{
	/*	$special_offer = '(Special offer used.)';
	}
	else
		{
		 	
			$special_offer = '';
		}*/

 $special_offer = '(Special offer used.)';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Subtotal").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal).$special_offer.'</tr>';
$confirmation .= '</tr>';

}
else 
{
 $confirmation .= '<tr>';
 $confirmation .= '<td>'.translate("Subtotal").'</td>';
 $confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal).$special_offer = ''.'</tr>';
 $confirmation .= '</tr>';	
	
	
}





$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Total Payout").'</td>';
$confirmation .= '<td>'.get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Status").'</td>';
$confirmation .= '<td>'.translate($result->name).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '</table>';

?>

	<script type="text/javascript">
	function print_confirmation() {
		var myWindow;
		myWindow=window.open('','_blank','width=800,height=500');
		myWindow.document.write("<p><?php echo addslashes($confirmation); ?></p>");
		myWindow.print();
	}
	
	
		$(document).ready(function()
	{
		
		if($('#expire').text() == '0:0:0')
		{
			
			$('#timeout').hide();
			$('#expired1').show();
			$('#expires_in').hide();
			var ida='<?php echo $this->uri->segment(3); ?>';
			 var status ="2";
			$.ajax({
   type: "POST", 
   url: "<?php echo base_url();?>contacts/expire",
    data: {
                cid: ida,
                status: status
            },
   success: function(msg){
if(msg=="hai")
    {
     window.reload();
    }
   
}
   
	})
	}
	})
	
</script>
<div id="book_it" class="container_bg container">
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
      <div class="clearfix"></div>
    </div>

</div>
<div id="main_reserve" class="col-md-9 col-sm-9 col-xs-12 padding-zero_12 pad_list_req">
 <div class="Box">
        <div class="Box_Head">
		<h2 class="req_head padding-zero_12"><?php echo "Contact Request"; ?> </h2><!--<span class="View_MyPrint padding-zero">
	 <a href="javascript:void(0);" onclick="javascript:print_confirmation();"><?php echo translate("Print");  ?></a>
		</span>--></div>
        <div class="Box_Content res_cent col-md-12 col-sm-12 col-xs-12">
								
		<?php if($result->status != 1) { ?>
		
		<?php } ?>
<ul id="details_breakdown_1" class="dashed_table_1 clearfix">
<li class="top clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Property"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_list_by_id($result->list_id)->title; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check in"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_user_times($checkin, get_user_timezone()); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check out"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_user_times($checkout, get_user_timezone()); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Night"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $nights; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Guest"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $no_quest; ?></span></span>
</li>

<li class="bottom">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Message"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo $message; ?></span></span>
</li>
</ul>


<ul id="details_breakdown_1" class="dashed_table_1 clearfix">

<li class="top clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Average Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner">
<!-- <li class="top clearfix"> 
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Average Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data"><span class="inner"> -->

	<?php 
	if($price_original != '')
	{
	echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$per_night); 
	}
	else {
		echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$price_original);
	}
	?></span></span>
</li>

<?php if($cleaning != 0)
{
	?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Cleaning Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$cleaning); ?></span></span>
</li>
<?php } ?>

<?php if($security != 0)
{
?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Security Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$security); ?></span></span>
</li>
<?php } ?>

<?php 
if(isset($extra_guest_price))
{
if($extra_guest_price != 0)
{
?>
<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Additional Guest Fee"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$extra_guest_price); ?></span></span>
</li>
<?php }
} ?>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Subtotal"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner">
	<?php 
	
	//echo $result->price;
	/*if($price_original == '' || $price_original == $subtotal)
	{
		$special_offer = '';
	}
	else
		{
		 	$special_offer = '(Special offer used.)';
		}
	
		echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal).$special_offer; 	*/
		
    //echo $result->status;   
    if($result->offer ==1)
	{
		$special_offer = '(Special offer used.)';
	}
	else
		{	
		 	
			$special_offer = '';
		}
	
		echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal).$special_offer; 
	
	?>
	
	</span></span>
</li>

<!--<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo "Host fee"; ?></span></span>
<span class="data"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$commission); ?></span></span>
</li>-->

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Total Payout"); ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal); ?></span></span>
<!--<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Total Payout"); ?></span></span>
<span class="data"><span class="inner">-->
	<?php 
	 

	  	// echo get_currency_symbol($result->list_id).get_currency_value_lys($result->currency,get_currency_code(),$subtotal); 

	  
	  ?>
	</span></span>
</li>

<li class="clearfix bottom">
	
<span class="label status1 col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span>

<!---->
<?php if($result->status == 1) { ?>
	

	<span id="expires_in">
<?php echo translate("Expires in"); ?></span>
<div id="expired1" style="display: none"><?php echo translate('Expired');?></div>
<?php
$hourdiff = round((time() - $result->send_date)/3600, 0);
$contact_id   	= $this->uri->segment(3);

 $timestamp = $result->send_date;
$send_date = date('m/d/Y', $timestamp);
 $gmtTime   = get_gmt_time(strtotime('+24 hours',$timestamp));
 $send_date;
$date      = gmdate('D, d M Y H:i:s \G\M\T', $gmtTime);
?>
<div id="expire"></div>
<?php } else { ?>
<?php echo translate("Status"); ?>
<?php } ?>
</span></span>

<?php if($result->status == 1) { 
	?>
<span id="timeout" class="data status2 col-md-8 col-sm-7 col-xs-12">
	<span class="inner">
<input type="hidden" name="contact_id" id="contact_id" value="<?php echo $result->id; ?>" />
<!-- Pre-Approve -->
<br><br>
<div id="approve">
<a class="Reserve_approve" id="req_approve" href="javascript:show_hide(1);"><?php echo "Allow the guest to book"; ?></a>
</div>
<div id="approve_form" style="display:none">
<p class="padding_topbottom"><input type="radio" name="comment" class="approve_option" value="approve" checked/> <label class="choosed_comment customTitle"><?php echo translate('Pre-approve ').$userBy->username.translate(' to book'); ?></label></p>		
<div class="col-md-12 col-sm-12 col-xs-12" id="approve_container">
<form name="approve_req" action="<?php echo site_url('contacts/accept'); ?>" method="post">
<input type="hidden" id="title" name="title" value="<?php echo $list; ?>" />
<input type="hidden" id="checkin" name="list" value="<?php echo $result->checkin; ?>" />
<input type="hidden" id="checkout" name="checkout" value="<?php echo $result->checkout; ?>" />
<input type="hidden" id="guests" name="guests" value="<?php echo $no_quest; ?>" />
<input type="hidden" id="price_approve" name="price_approve" value="<?php echo get_currency_value_lys($result->currency,get_currency_code(),$subtotal); ?>" />	
<p class="list_details"><b><?php echo $userBy->username; ?> will be able to book the reservation automatically for the next 24 hours, without additional confirmation.</b></p>
<p><?php echo translate("Optional message")."..."; ?></p>
<p><textarea class="comment_contact" name="comment_approve" id="comment_approve"></textarea></p>
<p>
<input type="button" class="accept_button" name="approved" value="<?php echo "Send message"; ?>" onclick="javascript:req_action('approve');" />
</p>
</form>
</div>

<p class="padding_topbottom"><input type="radio" name="comment" class="approve_option" value="special"/> <label class="choosed_comment customTitle"><?php echo translate('Send ').$userBy->username.translate(' a Special Offer'); ?></label></p>
<div id="special"></div>
<div id="special_form" style="display:none">
	<p class="list_details"><b><?php echo $userBy->username.translate(' could make a reserve automatically stop range price selected dates indicated.'); ?></b></p>	
<form name="special_req" action="<?php echo site_url('contacts/accept'); ?>" class="col-md-12 col-sm-12 col-xs-12 padding-zero" method="post">

<input type="hidden" id="title" name="title" value="<?php echo $list; ?>" />
<input type="hidden" id="hostID" name="listID" value="<?php echo $result->list_id; ?>" />
<input type="hidden" id="checkin" name="list" value="<?php echo $result->checkin; ?>" />
<input type="hidden" id="checkout" name="checkout" value="<?php echo $result->checkout; ?>" />
<input type="hidden" id="guests" name="guests" value="<?php echo $no_quest; ?>" />
<input type="hidden" id="currency_code" name="guests" value="<?php echo get_currency_code(); ?>" />	
<p class="list_details"><b><?php echo $userby->username.translate(' could make a reserve automatically stop range price selected dates indicated.'); ?></b></p>

<div class="col-md-12 col-sm-12 col-xs-12">
	<label class="col-md-12 col-sm-12 col-xs-12 list_details padding-zero marginzero">
		<b><?php echo translate('Property'); ?></b>
	</label>	
<p class="col-md-12 col-sm-12 col-xs-12">
		<select class="col-md-12 col-sm-12 col-xs-12 noradius" id="hostLists">
			<?php
	foreach($hostLists->result() as $hostList){
	if($hostList->id==$result->list_id){
		$selected = 'selected';
	} else {
		$selected = '';
	}	
	echo '<option value="'.$hostList->id.'" '.$selected.'>'.$hostList->title.'</option>';
	}
	?>

			</select>
	</p>
</div>
<p class="col-md-4 col-sm-4 col-xs-12 padding-zero">
	<label class="col-md-12 col-sm-12 col-xs-12 list_details marginzero">
		<b><?php echo translate('Check in'); ?></b>
	</label>
	<label class="col-md-12 col-sm-12 col-xs-12">
		<input class="checkin col-md-12 col-sm-12 col-xs-12 noradius" id="checkindate" name="checkin_new" type="text" value="<?php echo $result->checkin; ?>" readonly="readonly"/>
	</label>	
</p>

<p class="col-md-4 col-sm-4 col-xs-12 padding-zero">
	<label class="col-md-12 col-sm-12 col-xs-12 list_details marginzero">
		<b><?php echo translate('Check out'); ?></b>
	</label>
	<label class="col-md-12 col-sm-12 col-xs-12">
		<input class="checkout col-md-12 col-sm-12 col-xs-12 noradius" id="checkoutdate" name="checkout_new" type="text" value="<?php echo $result->checkout; ?>" readonly="readonly"/>
	</label>	
</p>
<p class="col-md-4 col-sm-4 col-xs-12 padding-zero">
	<label class="col-md-12 col-sm-12 col-xs-12  list_details marginzero">
		<b><?php echo translate('Guests'); ?></b>
	</label>
	<label class="col-md-12 col-sm-12 col-xs-12">
		<select class="col-md-12 col-sm-12 col-xs-12 noradius" id="Guests" onchange="checkCapability()">
			<?php
			for($i=1;$i<=16;$i++){
				if($i==$result->no_quest){
					$gSelected = 'selected';
				} else {
					$gSelected = '';
				}
				echo '<option value="'.$i.'" '.$gSelected.' >'.$i.'</option>';
			}
			?>
		</select>
	</label>	
</p>

<p class="col-md-12 col-sm-12 col-xs-12 padding-zero" id="checkError" style="display: none;">
<label class="col-md-12 col-sm-12 col-xs-12 Error"><?php echo translate('Those dates are not available in the specified property.'); ?></label>
</p>
<p class="col-md-12 col-sm-12 col-xs-12 padding-zero" id="capableError" style="display: none;">
<label class="col-md-12 col-sm-12 col-xs-12 Error"><?php echo translate('You have exceed capable of specified property.'); ?></label>
</p>
	
<?php $currency_symbol = $this->Common_model->getTableData('currency',array('currency_code'=>get_currency_code()))->row()->currency_symbol; ?>
<p class="col-md-12 col-sm-12 col-xs-12">
	<label class="col-md-12 col-sm-12 col-xs-12  list_details marginzero">
		<b><?php echo translate('Price'); ?></b>
	</label>
	<label class="col-md-12 col-sm-12 col-xs-12">
		<span class="col-md-2 col-sm-2 col-xs-2 specialSymbol"><?php echo $currency_symbol;?></span>
		<span class="col-md-10 col-sm-10 col-xs-10">
			<input type="text" class="col-md-12 col-sm-12 col-xs-12 specialPrice" id="price_special" name="price_special" value="<?php echo get_currency_value_lys($result->currency,get_currency_code(),$subtotal); ?>" />
			<input type="hidden" id="price_original" name="price_original" value="<?php echo get_currency_value_lys($result->currency,get_currency_code(),$price_original); ?>" />
		</span>	
	</label>	
</p>

<p class="list_details"><b><?php echo translate('The price should reflect any additional expenses you want to include.'); ?></b></p>

<p class="list_details"><b><?php echo translate('Service fee: ').$currency_symbol;?></b><span style="font-weight: bold;" id="admin_fee" name="admin_fee" ><?php echo $host_commission; ?></span></p>

<p class="list_details"><b><?php echo translate('You will receive: ').$currency_symbol;?></b><span style="font-weight: bold;" id="host_fee" name="host_fee" ><?php echo $receive_expect; ?></span></p>

<p><textarea class="comment_contact" name="comment_special" id="comment_special"></textarea></p>
<p>
<input type="button" class="accept_button btn_site_default" name="offered" id="special_button" value="<?php echo "Send message"; ?>" onclick="javascript:req_action('special');" />
</p>

</form>
</div>
</div>
<br><br>


<!-- Disscuss-More -->
<div id="discuss">
<a class="Reserve_discuss" id="req_accept" href="javascript:show_hide(3);"><?php echo "Write back to learn more before you decide"; ?></a>
</div>
<div id="discuss_form" style="display:none">
<form name="discuss_req" action="<?php echo site_url('contacts/discuss'); ?>" method="post">
<p>
<input type="hidden" id="title" name="title" value="<?php echo $list; ?>" />
<input type="hidden" id="checkin" name="checkin" value="<?php echo $result->checkin; ?>" />
<input type="hidden" id="checkout" name="checkout" value="<?php echo $result->checkout; ?>" />	
<p>I need to answer a question from this guest, or ask them for more information.</p>
<p><?php echo translate("Add a personal message here")."..."; ?></p>
<p><textarea class="comment_contact" name="comment_discuss" id="comment_discuss"></textarea></p>
<p>
<input type="button" class="accept_button" name="discussed" value="<?php echo "Send message"; ?>" onclick="javascript:req_action('discuss');" />
</p>
</form>
</div>
<br><br>

<!-- Decline -->
<div id="decline_option">
<a class="Reserve_decline_contact" id="req_decline" href="javascript:show_hide(4);"><?php echo translate("Tell the guest your listing is unavailable "); ?></a>
</div>
<div id="decline" style="display:none">
<form name="decline_req" action="<?php echo site_url('contacts/decline'); ?>" method="post">

<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/><label class="choosed_comment customTitle"> <?php echo 'These dates are not available. Block this dates on my calendar.'; ?></label></p>
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'I do not comfortable with this client.'; ?></label></p>
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'My listing is not a good fit for the guest\'s needs (children, pets, etc.)'; ?></label></p>
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'I am waiting for more attractive reservation'; ?></label></p>
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'The guests is asking for different dates than the ones selected in this request'; ?></label></p>
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'This message is spam'; ?></label></p>	
	<p class="padding_topbottom"><input type="radio" name="comment" class="decline_comment"/> <label class="choosed_comment customTitle"><?php echo 'Other'; ?></label></p>
	
<div id="other_decline" style="display: none;width:100%;overflow: hidden;">	
<p class="list_details"><b><?php echo translate("Type optional message to guest")."..."; ?></b></p>
<p><textarea class="comment_contact col-md-12 col-sm-12 col-xs-12" rows="3" name="comment_decline" id="comment_decline"></textarea></p>
</div>
<p><input type="hidden" id="decline_message" value="" /></p>

<p style="margin-top: 10px;">
<input type="hidden" id="checkin" name="checkin" value="<?php echo $result->checkin; ?>" />
<input type="hidden" id="checkout" name="checkout" value="<?php echo $result->checkout; ?>" />
<input type="button" class="decline_button" name="decliend" value="<?php echo translate("Decline"); ?>" onclick="javascript:req_action('decline');" />
</p>
</form>
</div>
</span>


</span>
<?php } else { ?>

<span class="data status2 col-md-8 col-sm-7 col-xs-12"><span class="inner">
<?php 
echo translate($result->name);
?>
</span></span>

<?php } ?>
</li>
</ul>
<div class="clearfix"></div>
</div>
        
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 main_concervation">
        	
        	
		<?php 	$contact_id = $this->uri->segment(3);
				$query1 = $this->db->where('contact_id',$contact_id)->get('messages')->row();
				
				$query2=$this->db->where('id',$query1->userto)->get('users')->row();?>
				<div class="Box_Head">
				<li class="center"><h3 class="mar_top"><?php echo translate("Conversation with"); ?> <?php echo $query2->username; ?></h3></li>
        </div>

			<div class="center" >
                            	<p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><img height="50" width="50" id="circle" alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(),2); ?>" /></a></p>
                                <p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><?php echo translate("You"); ?></a></p>
                            </div>
				
	<?php echo form_open('trips/res_conversation/'.$query1->conversation_id.'/request',array('id'=>'form_res')); ?>
                            <div class="clsType_Conver clsFloatLeft col-md-12 col-sm-12 col-xs-12">
                            	<textarea name="comment"  id="comment" ></textarea>
                            	
																													<input type="hidden" name="list_id" value="<?php echo $query1->list_id; ?>" />
																													<input type="hidden" name="reservation_id" value="0" />
																													<input type="hidden" name="contact_id" value="<?php echo $contact_id; ?>" />
																													<input type="hidden" name="userto" value="<?php echo $query1->userby; ?>" />
																													<input type="hidden" name="userby" value="<?php echo $this->dx_auth->get_user_id(); ?>" />
                                <br />
																																<?php if(form_error('comment')) { ?>
																																<?php echo form_error('comment'); ?>
																																<?php } ?>
                                <p class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding: 15px 0px 0px 0px;margin:0px;">
                                <button name="submit" class="btn_dash" id="submit_btn" type="submit"><span><span><?php echo translate("Send Message"); ?></span></span></button>
                                </p>
                                <span class="clsTypeCon_LArrow"></span>
                            </div>
                            
							<?php echo form_close(); ?>
	<?php 
	$query = $this->db->where('contact_id',$contact_id)->order_by('id','desc')->get('messages');
	$query1= $this->db->where('contact_id',$contact_id)->order_by('id','desc')->get('messages')->row()->conversation_id;
if($query1 != 0) {
	foreach($query->result() as $mes)
	{
		
		if($mes->conversation_id != 0){
		
		if($mes->userby == $this->dx_auth->get_user_id())
		{
		?><div class="col-xs-12 padding_top_15">
			<div class="clsConSamll_Pro_Img clsFloatLeft col-md-2 col-sm-2 col-xs-4">
				<p><a target="_blank"   href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>" title="<?php echo get_user_by_id($mes->userby)->username; ?>" ><img height="30" width="30" id="circle"  alt="<?php echo get_user_by_id($mes->userby)->username; ?>" src="<?php echo $this->Gallery->profilepic($mes->userby,2); ?>" /></a></p>
				<p><a target="_blank"   href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>"><?php echo translate("You");?></a></p>
			</div>
			<div class="TypeConver_Ans_old col-md-8 col-sm-8 col-xs-8 arrow_box"><?php echo $mes->message;?></div>
		</div><?php
		}
		else {
				?><div class="col-xs-12 padding_top_15">
				<div class="TypeConver_Ans_old col-md-offset-2 col-md-8 arrow_box1 col-sm-8 col-sm-offset-2 col-xs-8"><?php echo $mes->message;?></div>
				<div class="clsConSamll_Pro_Img col-md-2 col-sm-2 col-xs-4">
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>" title="<?php echo get_user_by_id($mes->userby)->username; ?>" ><img height="30" id="circle" width="30" alt="<?php echo get_user_by_id($mes->userby)->username; ?>" src="<?php echo $this->Gallery->profilepic($mes->userby,2); ?>" /></a></p>
						<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$mes->userby ; ?>"><?php echo get_user_by_id($mes->userby)->username; ?></a></p>
					</div>
				</div><?php
		}

	}
	}
	}
	
	?>
	<?php
	$query2 = $this->db->where('contact_id',$contact_id)->where('conversation_id','0')->order_by('id','asc')->get('messages')->row();
	
	?>
	
	<div class="col-xs-12 padding_top_15">
				<div class="TypeConver_Ans_old col-md-offset-2 col-md-8 arrow_box1 col-sm-8 col-sm-offset-2 col-xs-8"><?php echo $query2->message;?></div>
				<div class="clsConSamll_Pro_Img col-md-2 col-sm-2 col-xs-4">
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$query2->userby ; ?>" title="<?php echo get_user_by_id($query2->userby)->username; ?>" ><img height="30" width="30" id="circle" alt="<?php echo get_user_by_id($query2->userby)->username; ?>" src="<?php echo $this->Gallery->profilepic($query2->userby,2); ?>" /></a></p>
					<p><a target="_blank" href="<?php echo base_url().'users/profile/'.$query2->userby ; ?>"><?php echo get_user_by_id($query2->userby)->username; ?></a></p>
					</div>
				</div>
</div>
        
								</div>
								<div class="clearfix"></div>
								</div>
							</div></div>
<script>
$(document).ready(function()
{
$('#submit_btn').live('click',function() {
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
		layout:'{dn}:'+'{hn}:'+'{mn}:'+'{sn}',
		onExpiry: liftOff,
		expiryText:"Expired"
	});
 
	
function liftOff()
{ 
  var contact_id = $("#contact_id").val();
	
   	 $.ajax({
				 type: "POST",
					url: "<?php echo site_url('contacts/out'); ?>",
					async: true,
					data: "contact_id="+contact_id,
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
		 $('#approve_form').show('slow');
		 $('#special_form').hide('slow');
		 $('#discuss_form').hide('slow');
		 $('#decline').hide('slow');
		 
		 $('.preapprove_before').hide();
		 $('.preapprove_after').show();
		 $('.decline_before').show();
		 $('.decline_after').hide();
		 $('.discuss_before').show();
		 $('.discuss_after').hide();
		}
		else if(id == 2)
		{
		 $('#approve_form').show('slow');
		 $('#special_form').show('slow');
		 $('#discuss_form').hide('slow');
		 $('#decline').hide();	
		}
		else if(id == 3)
		{
		 $('#approve_form').hide('slow');
		 $('#special_form').hide('slow');
		 $('#discuss_form').show('slow');
		 $('#decline').hide('slow');
		 
		 $('.preapprove_before').show();
		 $('.preapprove_after').hide();
		 $('.decline_before').show();
		 $('.decline_after').hide();
		 $('.discuss_before').hide();
		 $('.discuss_after').show();
		 
		}
		else
		{
		 $('#approve_form').hide('slow');
		 $('#special_form').hide('slow');
		 $('#discuss_form').hide('slow');
		 $('#decline').show('slow');
		 
		 $('.preapprove_before').show();
		 $('.preapprove_after').hide();
		 $('.decline_before').hide();
		 $('.decline_after').show();
		 $('.discuss_before').show();
		 $('.discuss_after').hide();
		}	
}


function req_action(id)
{
	
	 var message = $('#comment_approve').val();
	 var guest = '';
	 	
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
         
            var message2 = $('#comment_special').val();
            
          
		 if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message2))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            else if(message2.match('@') || message2.match('hotmail') || message2.match('gmail') || message2.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');return false;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message2))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
          
            var message3 = $('#comment_discuss').val();
            
		 if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message3))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            else if(message3.match('@') || message3.match('hotmail') || message3.match('gmail') || message3.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');return false;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message3))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
           
             
            var message4 = $('#comment_decline').val();
            
            
		 if(/\b(\w)+\@(\w)+\.(\w)+\b/g.test(message4))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            else if(message4.match('@') || message4.match('hotmail') || message4.match('gmail') || message4.match('yahoo'))
				{
					alert('Sorry! Email or Phone number is not allowed');return false;
				}
         	if(/\+?[0-9() -]{7,18}/.test(message4))
            {
            	alert('Sorry! Email or Phone number is not allowed');return false;
            }
            
            
 var contact_id = $("#contact_id").val();
 var hostLists = '';	 
 if(id == "approve")
	{
	var price    = $("#price_approve").val();
	var comment  = $("#comment_approve").val();
	var action = "accept";
	
	}
else if(id == "special")
	{
	var price    = $("#price_special").val();
	var original_price = $("#price_original").val();	
	var comment  = $("#comment_special").val();
	var action	 = "special";
	var guest = $('#Guests').val();
	var hostLists = $('#hostLists').val();
	
	}
else if(id == "discuss")
	{
	var comment  = $("#comment_discuss").val();
	var action	 = id;
	}
else
	{
		
	var comment  = $("#decline_message").val();
	if(comment=='Other'){
		comment = $('#comment_decline').val();
	}
	var action	 = id;
	}
	
	var checkin   = $("#checkin").val();
	var checkout  = $("#checkout").val();
	var checkin_new   = $("#checkindate").val();
	var checkout_new  = $("#checkoutdate").val();
	
	if(id == "discuss")
	var ok=confirm("Are you sure to "+action+"?");
	else
	var ok=confirm("Are you sure to "+action+" request?");
		if(!ok)
		{
			return false;
		}
		else
		{
		 $("input.accept_button").attr("disabled", true);
		  $("input.decline_button").attr("disabled", true);
		}
		
		document.getElementById(id).innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
		
	   $.ajax({
				 type: "POST",
					url: "<?php echo site_url('contacts'); ?>/"+action,
					async: true,
					data: "comment="+comment+"&contact_id="+contact_id+"&checkin="+checkin+"&checkout="+checkout+"&checkin_new="+checkin_new+"&checkout_new="+checkout_new+"&price="+price+"&price_original="+original_price+"&guest="+guest+"&listId="+hostLists,
					success: function(data)
		  			{	
		  				if(data)
		  				{
		  				//alert(data);
		  				}
					 //document.getElementById(id).innerHTML = data;
					 location.reload(true);
			 	}
		  });
}

$(document).ready(function(){
	
$('.approve_option').change(function(){
	optionVal = $(this).val();
	if(optionVal=='approve'){
		$('#special_form').hide('slow');
		$('#approve_container').show('slow');
	} else {
		$('#special_form').show('slow');
		$('#approve_container').hide('slow');
	}
})	

$('input[name="comment"]').change(function(){
			decline_comment = $(this).next('.choosed_comment').text();
			$('#other_decline').hide('slow');
		if(decline_comment=='Other'){
			$('#other_decline').show('slow');
			//decline_comment = $('#comment_decline').val();
			}
			$('#decline_message').val(decline_comment);
			//alert(decline_comment);
			})
	
		var p_spl = $("#price_special").val();
	 
	      $("#price_special").keyup(function(){
            var rate = $(this).val().replace(/,/,'.');
            if(!isNaN(rate)){
	      	gefee(rate);
	      	}else{
	      		$(this).val(p_spl);
	      		gefee(p_spl);
	      	alert("Enter valid number!");
	      	}
	      })
	      
	 function gefee(rate){      
	            $.ajax({
				 type: "POST",
					url: "<?php echo site_url('contacts/get_adminfee'); ?>",
					async: true,
					dataType:"json",
					data: "rate="+rate+'&currency='+$("#currency_code").val(),
					success: function(data)
		  			{	
		  				
		  				$("#admin_fee").text(data.commission);
		  				$("#host_fee").text(data.receive_expect);
			 	}
		  });
		 }
});

$(function() {
       var date = new Date();
var currentMonth = date.getMonth();
var currentDate = date.getDate();
var currentYear = date.getFullYear();
	   $( "#checkoutdate" ).datepicker({
                minDate: 0,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                // closeText: "Clear Dates",
               // currentText: Translations.today,
                showButtonPanel: true,
                onClose: function(dateText,inst){
                	checkAvailability();
                }
	    });
	    $( "#checkindate" ).datepicker({
			minDate: date,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
              //  currentText: Translations.today,
                showButtonPanel: true,
	 onClose: function(dateText, inst) { 
          d = $('#checkindate').datepicker('getDate');
		  d.setDate(d.getDate()+1); // add int nights to int date
		$("#checkoutdate").datepicker("option", "minDate", d);
		checkAvailability();
		setTimeout(function () {
                                    $("#checkoutdate").datepicker("show")
                                }, 0)
     }
	   });
       
    });

$('#hostLists').change(function(){
	checkAvailability();
})    
    
var checkAvailability = function(){
	var checkIn  = $('#checkindate').val();
	var checkOut = $('#checkoutdate').val();
	var listId   = $('#hostLists').val();
	$.ajax({
		type: 'POST',
		url: base_url+'contacts/checkAvailability',
		data: {
			checkIn: checkIn,
			checkOut: checkOut,
			listId: listId
		},
		success: function(e){
			if(e=='success'){
				$('#special_button').show();
				$('#checkError').hide();
			} else {
				$('#special_button').hide();
				$('#checkError').show();
			}
		}
	})
}    

var checkCapability = function(){
	var listId = $('#hostLists').val();
	var Guest = $('#Guests').val();
	$.ajax({
		type: 'POST',
		url: base_url+'contacts/checkCapability',
		data: {
			listId: listId,
			guest: Guest
		},
		success: function(e){
			if(e=='success'){
				$('#capableError').hide();
				$('#special_button').show();
			} else {
				$('#capableError').show();
				$('#special_button').hide();
			}
		}
	})
}
    
</script>
<style>
	@media (max-width: 767px) and (min-width: 300px){
#details_breakdown_1 .data {
border: none !important;
border-radius: 0 !important;
}
#details_breakdown_1 .bottom .data {
border-radius: 0 0 10px 10px !important;
}
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
.arrow_box1::after {
    border-color: rgba(255, 255, 255, 0) rgba(255, 255, 255, 0) rgba(255, 255, 255, 0) #ffffff;
    border-width: 10px;
    margin-top: -10px;
}
.arrow_box1::after, .arrow_box1::before {
    border: medium solid rgba(0, 0, 0, 0);
    content: " ";
    height: 0;
    left: 100%;
    pointer-events: none;
    position: absolute;
    top: 20px;
    width: 0;
}
.arrow_box::before {
    border-color: rgba(220, 224, 224, 0) #dce0e0 rgba(220, 224, 224, 0) rgba(220, 224, 224, 0);
    border-width: 11px;
    margin-top: -11px;
}
.arrow_box::after, .arrow_box::before {
    border: medium solid rgba(0, 0, 0, 0);
    content: " ";
    height: 0;
    pointer-events: none;
    position: absolute;
    right: 100%;
    top: 20px;
    width: 0;
}
.main_concervation
{
	background: #ffffff none repeat scroll 0 0;
    border-radius: 10px;
    margin: 15px 0;
    padding: 15px;
}
.Error {
	color: red;
}


#details_breakdown_1 #decline p, #details_breakdown_1 #accept p, #discuss_form p, #approve_form p, #special_form p {
    padding: 0 0 10px;
}

#details_breakdown_1 #decline p, #details_breakdown_1 #accept p, #discuss_form p, #approve_form p, #special_form p {
    padding: 0 0 10px;
}
input:hover, select:hover, textarea:hover, input:focus, select:focus, textarea:focus {
    border: 1px solid #EB3C44 !important;
}
#submit_btn{
	float:right;
}
#circle {
  
  border :1px solid #c3c3c3;
  border-radius: 50%;
 
  
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
.center{
	float:middle;
}

</style>
