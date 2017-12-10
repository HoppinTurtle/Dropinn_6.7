  <!-- stripe payment view start-->
    <style>
    	.error{
    		color:red;
    	}
.btn_em-list1 {
	padding-left:12px;
}
    </style>
<div class="" id="dashboard_container">
 <form method="POST" id="inst-form" action="<?php echo base_url().'account/payout_stripe'; ?>"  >    
 	
 	 <div id="book_it" class=""> 
  <div id="trip_details" class="Box">
<div class="Box_Head msgbg">
  <h2><?php echo translate("Bank Account (ACH) Information"); ?></h2>
</div>
<div class="Box_Content" style="overflow: hidden">
	
    <div class="payment-errors" style="color:red;"></div>
    <div  class="form-row col-md-12 col-sm-12 col-xs-12 padding-none" style="padding-top:15px !important;padding-bottom:15px !important;">
      <label class="col-md-4 col-sm-4 col-xs-12 padding-none">Bank Location(Country)</label>
      <label class="col-md-6 col-sm-8 col-xs-12 padding-none">
            <select data-stripe="country" name="country" id="country" class = "country recomm-select" style="width:100%;" >
                           <?php foreach($countries as $count) { ?>
            <option value="<?php echo $count->country_symbol; ?>" <?php if($count->country_symbol == $country) echo "selected=selected"; ?> ><?php echo $count->country_name; ?></option>
            <?php } ?>
            </select>
     </label>
    </div>
	<div  class="form-row col-md-12 col-sm-12 col-xs-12 padding-none" style="padding-top:15px !important;padding-bottom:15px !important;">
      <label class="col-md-4 col-sm-4 col-xs-12 padding-none">Recipient's full name</label>
      <label class="col-md-3 col-sm-4 col-xs-12 padding-none" style="padding-bottom: 3px !important;">
            <input type="text" class="first-name name-input-dash" style="width:100%;" size="9" id ="firstname" name ="firstname" placeholder="First Name"/></label>
            <label class="col-md-3 col-sm-4 col-xs-12 padding-none flt-ryt">
            <input type="text" class="last-name name-input-dash" style="width:100%;" size="9" id ="lastname" name ="lastname" placeholder="Last Name"/></label>
      
    </div>
    
    <div  class="form-row col-md-12 col-sm-12 col-xs-12 padding-none" style="padding-top:15px !important;padding-bottom:15px !important;">
      <label class="col-md-4 col-sm-4 col-xs-12 padding-none"> Routing Number </label>
      <label class="col-md-6 col-sm-8 col-xs-12 padding-none">
            <input type="text" class="routing-number  name-input-dash" style="width:100%;" size="9" data-stripe="routingNumber" id="routingNumber" name="routingNumber" />
     </label>
    </div>

    <div  class="form-row col-md-12 col-sm-12 col-xs-12 padding-none" style="padding-top:15px !important;padding-bottom:15px !important;">
      <label class="col-md-4 col-sm-4 col-xs-12 padding-none"> Account Number</label>
      <label class="col-md-6 col-sm-8 col-xs-12 padding-none">
            <input style="width:100%;" type="text" class ="account-number  name-input-dash" size="17" data-stripe="accountNumber" name= "accountNumber"  id= "accountNumber" />
   </label>
    </div>
<div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
<div class="btn_em-list1">	
<button type="submit" class="btn_dash" id="blue-home-sub" name="commit" id="next2"><span><span><?php echo translate("Save"); ?></span></span></button>
<?php echo translate("or"); ?><a class="blue-home-dash "  id="blue-home-sub" onclick="$('#payout_new_select').hide();$('#payout_new_initial').show();return false;" href="#"><?php echo translate("Cancel"); ?></a></p>
</div>
</div>
    </div>    
</div>
</div>
</form>
</div>
</div>

 <script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey("<?php echo $publishable_key; ?>");

    function stripeResponseHandler(status, response) {
    	//alert(token)
    	if (response.error) {
            // re-enable the submit button
            $('.submit-button').removeAttr("disabled");
            // show the errors on the form
            $(".payment-errors").html(response.error.message+": Provide 111000025 as routing number and 000123456789 as account number for testmode");
        } else {
            var form$ = $("#inst-form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
            form$.get(0).submit();
        }
    }	

jQuery(document).ready(function() {
	
			jQuery("#inst-form").validate({
			debug: false,
			rules: {
				firstname: {
          required: true
        },
        				lastname: {
          required: true
        },
        				routingNumber: {
          required: true,
          number: true
        },
        				accountNumber: {
          required: true,
          number: true
        }
			},
		submitHandler: function(form) {
           // disable the submit button to prevent repeated clicks
            jQuery('.submit-button').attr("disabled", "disabled");
            // createToken returns immediately - the supplied callback submits the form if there are no errors
          var valid_rout = Stripe.bankAccount.validateRoutingNumber($('.routing-number').val(),$('.country').val()) ; 
          var valid_acc =  Stripe.bankAccount.validateAccountNumber($('.account-number').val(), $('.country').val() ) ;
		  valid_rout = valid_acc = true ;
   			if(valid_rout && valid_acc ){
           Stripe.bankAccount.createToken({
		  country: $('.country').val(),
		  routingNumber: $('.routing-number').val(),
		  accountNumber: $('.account-number').val()
		}, stripeResponseHandler);

			  $('.submit-button').removeAttr("disabled");
		return true;
		}
		else{
			  $('.submit-button').removeAttr("disabled");
			return false ; 
		}
  	}
		});

});
</script>
  <!-- stripe payment view end -->