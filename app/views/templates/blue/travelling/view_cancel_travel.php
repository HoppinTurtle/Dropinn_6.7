<link rel="stylesheet" href="<?php echo  css_url();?>/dashboard.css" type="text/css">

<script src="<?php echo base_url().'js/jquery-1.9.1.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'js/jquery.validate.min.js'; ?>"></script>
<style>
	.Box_Head1 h2{
		margin:5px 0px 0px !important;
	}
</style>
<!-- <a id="fancybox-close" class="closeLink" style="display: inline;"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a> -->
<div id="View_Cancel_Travel" class="Box">
	
<div class="Box_Head1">
<h2> <?php echo translate("Cancel Reservation"); ?> </h2>
</div>
<div class="Box_Content">
<p><?php echo translate("Changes to this reservation are governed by the following Standardized policy."); ?></p>

<ul>
	<?php
	if(isset($non_nights))
	{
		?>
	<li><?php echo translate("No of non-refundable nights").' : '.$non_nights ; ?></li>	
		<?php
	}
	?>
<!--<li><?php echo translate("No of refundable nights").' : '.$nights ; ?></li>-->
<li><?php echo translate("Service fee is not refundable."); ?></li>
</ul>
</ul>

<form id="cancellationHost" name="cancel_host" action="<?php echo site_url('travelling/cancel_travel'); ?>" method="post">
<p><?php echo translate("Agree the "); ?>
	<?php
	
	if($user_type == 'guest')
	{
		?>
	<a href="<?php echo base_url(); ?>pages/cancellation_policy#<?php echo str_replace(" ","-",$policy_name);?>">cancellation policy</a>
		<?php
	}
	else
	{
		?>
	<a href="<?php echo base_url(); ?>pages/view/host_cancellation_policy">cancellation policy</a>		
		<?php
	}
	?>
	
<input style="float:left; margin:3px 10px 0 0;" type="checkbox" name="cancel_policy" class="required" />

</p>
<?php if($user_type == 'guest')
	{ ?>
<p>Type a Message to Host</p>
<?php }else{?>
	<p>Type a Message to Guest</p>
	<?php } ?>


<p><textarea name="comment" id="comment" class="required"></textarea></p>

<p>
<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" >
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" >

<button name="cancel" type="submit" class="btn_dash"><span><span><?php echo translate("Cancel"); ?></span></span></button>

<!--<button name="cancel" type="submit" class="button1"><span><span><?php echo translate("Cancel"); ?></span></span></button> -->

</p>
</form>

</div></div>

<script type="text/javascript">

$(document).ready(function(){
	// var $= jQuery.noConflict();
	  // $(".closeLink").click(function () {
        // $.fancybox.close();
    // });
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
$("#cancellationHost").validate({
   errorElement:"p",
			errorClass:"Frm_Error_Msg",
			focusInvalid: false,
			submitHandler: function(form) 
			{
					var ok=confirm("Are you sure to cancel the reservation?");
					if(!ok)
					{
						return false;
					}
					jQuery('.button1').attr("disabled", "disabled");
					$.post("<?php echo site_url('travelling/cancel_travel'); ?>", $("#cancellationHost").serialize(),
							function(data)
							{
								//alert(data);return false;
								if("<?php echo $this->uri->segment(5);?>" == 'host')
								{
									window.location = "<?php echo site_url('listings/my_reservation'); ?>";
								}
								else
								{
									window.location = "<?php echo site_url('travelling/your_trips'); ?>";
								}
							}
						);
				}
			});
})

</script>
<style>
	#fancybox-wrap #checkin:hover {
    border: medium none!important;
}
#fancybox-overlay{
	height: 1783px !important;
	background: rgba(0, 0, 0, 0.7) !important;
	opacity: 1!important;
}
#View_Checkin {
    margin: 0;
    padding: 10px 30px;
    text-align: center;
}
#View_Checkin h2{
    margin: 0 !important;
    padding: 6px 0;
}	
#fancybox-outer{
	background: none!important;
	padding: 0;
}
#fancybox-content{
	border: none!important;
}
#fancybox-wrap{
	background: #FFFFFF;
	border-radius: 7px;
}
#View_Cancel_Travel {
    border: medium none;
}
#View_Cancel_Travel h2 {
    margin: 0;
    padding: 3px;
}
#cancellationHost #comment{
	max-width: 400px !important;
	max-height: 181px !important;
	min-width:  202px !important;
	min-height: 62px !important;
	}
.fa.fa-times-circle-o {
    font-size: 19px;
    float: right;
}
#checkin span span {
text-transform: capitalize !important;
}	
#fancybox-close {
    cursor: pointer;
    float: right;
    color: rgb(0, 0, 0)!important;
    font-size: 16px;
    position: static !important;
    z-index: 1103;
}#View_Checkin .Box_Head1 {
    margin: 30px 10px 0;
}
</style>