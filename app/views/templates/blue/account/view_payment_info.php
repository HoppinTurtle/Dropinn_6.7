  <script src="<?php echo base_url().'js/jquery.validate.min.js'; ?>"> </script>
  <script type="text/javascript">
	jQuery(document).ready(function(){
			var curr= "<?php echo get_currency_code(); ?>";
	
		 jQuery('#currency_type').val(curr);
		 
		jQuery("#form").validate({
			debug: false,
			rules: {
				email: {
          required: true,
          email: true
          }
			},
			messages: {
		        email:
                    { 
                    	required: "You must enter the email-id",
                    	email: "Please enter the correct email-id"
                    	
                  }
			},
		});
	});
	</script>
	<style>
	label.error { width: 250px; display: inline; color: red; margin-left: 0px;}
	.btn_em-list1 {
	padding-left:12px;
}
	</style>
<div id="paypal_payout">
<h3><?php echo $payout_name; ?> <?php echo translate("Information"); ?></h3>

<form method="post" id="form" action="<?php echo site_url('account/payout_paypal'); ?>">        
<input type="hidden" value="<?php echo $country; ?>" name="country" id="country">
<input type="hidden" value="<?php echo $payout_type; ?>" name="payout_type" id="email">

<?php if($payout_type == 2) { ?>

	<div class="col-md-12 col-sm-12 col-xs-12 padding-zero">	
	<p class="col-md-4 col-sm-6 col-xs-12"><?php echo translate("To what e-mail should we send the money?"); ?></p>
	<div class="col-md-3 col-sm-6 col-xs-12 no_padding">
	<input type="text" value="" size="30" name="email" id="email" class="name-input-dash" style="width: 100%;">
	<br>
	<span style="font-size:13px;color:#8b8b8b;"><?php echo translate("This email address must be associated with a valid Paypal account."); ?></span><br>
	<a target="_blank" style="font-size:12px;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_registration-run"><?php echo translate("Don't have a paypal account?"); ?></a>
	</div>
	</div>	
	<div class="col-md-12 col-sm-12 col-xs-12 padding-zero" style="padding: 15px 0px;">	
	<p class="col-md-4 col-sm-6 col-xs-12"><?php echo translate("In what currency would you like to be paid?"); ?></p>
	<div class="col-md-3 col-sm-6 xol-xs-12 no_padding">
         	<select id="currency_type" name="currency" style="width: 100%;" class="recomm-select">
										<option value="USD">USD</option>
										<option value="GBP">GBP</option>
										<option value="EUR">EUR</option>
										<option value="AUD">AUD</option>
										<option value="SGD">SGD</option>
										<option value="SEK">SEK</option>
										<option value="DKK">DKK</option>
										<option value="MXN">MXN</option>
										<option value="BRL">BRL</option>
										<option value="MYR">MYR</option>
										<option value="PHP">PHP</option>
										<option value="CHF">CHF</option>
							 			</select>
	</div>
	</div>
	

<?php } ?>
<div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
<div class="btn_em-list1">	
<button type="submit" class="btn_dash" id="blue-home-sub" name="commit" id="next2"><span><span><?php echo translate("Save"); ?></span></span></button>
<?php echo translate("or"); ?><a class="blue-home-dash "  id="blue-home-sub" onclick="$('#payout_new_select').hide();$('#payout_new_initial').show();return false;" href="#"><?php echo translate("Cancel"); ?></a></p>
</div>
</div>
</form>
</div>