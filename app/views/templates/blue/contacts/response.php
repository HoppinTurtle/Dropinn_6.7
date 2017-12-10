<script src="<?php echo base_url(); ?>js/jquery.countdown.js" type="text/javascript"></script>

<style>
	#urle{
		display:none;
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

<link href="<?php echo css_url().'/reservation.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
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
        <div class="Box_Head padding-zero_12">
		<h2 class="req_head"><?php echo "Contact Response"; ?> </h2></div>
<div class="Box_Content res_cent col-md-12 col-sm-12 col-xs-12">
<ul id="details_breakdown_1" class="dashed_table_1 clearfix">
<li class="top clearfix">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Property"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo get_list_by_id($result->list_id)->title; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check in"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo date("F j, Y",strtotime($checkin)); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check out"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo date("F j, Y",strtotime($checkout)); ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Night"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo $nights; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Guest"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo $no_quest; ?></span></span>
</li>

<li class="clearfix">
<span class="label col-md-4 col-sm-5 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Average Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data col-md-8 col-sm-7 col-xs-12"><span class="inner"><?php echo get_currency_symbol($result->list_id).get_currency_value1($result->list_id,$per_night); ?></span></span>
<!-- <li class="top clearfix"> 
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Average Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data"><span class="inner"> -->

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


<?php if($status==4) { ?>
<li class="bottom">
<span class="label col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Message"); ?></span></span>
<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><?php echo $message; ?></span></span>
</li>

<?php } else if($status != 1){ ?>
	
<li class="bottom">
	<span class="label status1 col-md-4 col-sm-4 col-xs-12"><span class="inner"><span class="checkout_icon" id="icon_cal"></span>
<!---->
<?php echo translate("Booking"); ?>
<?php
if($status == 3) {?>
	<span id="expires_in">
<?php echo translate("Expires in"); ?></span>
<?php
$hourdiff = round((time() - $result->send_date)/3600, 0);
$reservation_id   	= $this->uri->segment(3);

$timestamp = $result->send_date;
$send_date = date('m/d/Y', $timestamp);
$gmtTime   = get_gmt_time(strtotime('+24 hours',$timestamp));

$date      = gmdate('D, d M Y H:i:s \G\M\T', $gmtTime);
?>
<div id="expire"></div>
<?php }?>
</span></span>

<span class="data col-md-8 col-sm-8 col-xs-12"><span class="inner"><form action="<?php echo $url;?>">
	<p class="col-md-12 col-sm-12 col-xs-12 text-center" style="padding: 15px 0px 0px 0px;margin:0px;">
	<a href="<?php echo $url;?>" class="btn_dash" id="pay_now"><span><span><?php echo translate("Pay Now");?></span></span></a>
	</p>
	</form>
	<a href="#" id="urle"><?php echo Expired; ?></a>
</span></span>
<?php }?>
</li>	
</ul>
</form>

</div>


	
	
			<?php 	$contact_id = $this->uri->segment(3);
				$query1 = $this->db->where('contact_id',$contact_id)->where('conversation_id',0)->order_by('id','desc')->get('messages')->row();
				$query2=$this->db->where('id',$query1->userby)->get('users')->row();?>
	<div class="Box_Head">
				<li class="center"><h3 class="mar_top"><?php echo translate("Conversation with"); ?> <?php echo $query2->username; ?></h3></li>
			</div>
			<div class="Box_Content">
				<div class="center">
                            	<p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><img height="50" width="50" id="circle" alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(),2); ?>" /></a></p>
                                <p><a href="<?php echo site_url('users/profile').'/'.$query1->userby; ?>"><?php echo translate("You"); ?></a></p>
                            </div>
	<?php echo form_open('trips/res_conversation/'.$query1->conversation_id.'/response',array('id'=>'form_res')); ?>
                             <div class="clsType_Conver clsFloatLeft col-md-12 col-sm-12 col-xs-12">
                            	<textarea name="comment" id="comment" ></textarea>
                            	
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
                                <button name="submit" class="btn_dash" id="send_request" type="submit"><span><span><?php echo translate("Send Message"); ?></span></span></button>
                                </p>
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
	$query2 = $this->db->where('contact_id',$contact_id)->where('conversation_id','0')->order_by('id','desc')->get('messages')->row();
	
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
							<div class="clearfix"></div>
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

<?php if($status== 3) { ?>	

$('#expire').countdown({
		until: new Date("<?php echo $date; ?>"),
		format: 'dHMS',
		layout:'{hn}:'+'{mn}:'+'{sn}',
		onExpiry:liftOff,
		expiryText:"0:0:0"
		
	});

	
function liftOff()
{ 
  var contact_id = $("#contact_id").val();
	
   	 $.ajax({
				 type: "POST",
					url: "<?php echo site_url('contacts/expire'); ?>",
					async: true,
					data: "contact_id="+contact_id,
					success: function(data)
		  	{	
  location.reload("true");		
			 	}
		  });	
}

$(document).ready(function()
	{
	
		if($('#expire').text() == '0:0:0')
		{ 
			//location.reload(true);
			$('#urle').show();
			$('#url').hide();
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
if(msg=='true')
    {
     location.reload(true);
    }
   
}
   
	})
	}
	})
	
<?php } ?>
</script>
</div>
</div>
</div>
</div>
</div>
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


</style>
