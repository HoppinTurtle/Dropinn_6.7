    <!-- CSS for styles --> 
    <link href="<?php echo css_url(); ?>/normalize_stripe.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?php echo css_url(); ?>/style_stripe.css" media="screen" rel="stylesheet" type="text/css" />

  	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey("<?php echo $publishable_key; ?>");

    function stripeResponseHandler(status, response) {
    	if (response.error) {
            // re-enable the submit button
            $('.submit-button').removeAttr("disabled");
            // show the errors on the form
            $(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#payment-form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
            form$.get(0).submit();
        }
    }

    $(document).ready(function() {
        $("#payment-form").submit(function(event) {
            // disable the submit button to prevent repeated clicks
            $('.submit-button').attr("disabled", "disabled");
            // createToken returns immediately - the supplied callback submits the form if there are no errors
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
            return false; // submit from callback
        });
    });

    </script>

<center><div class="container stripe_page" style="min-height: 390px;">
    <h2 style="margin-top: 125px;">Stripe payment gateway</h2>

<?php $logo= $this->Common_model->getTableData('settings',array('code' => 'FAVICON_IMAGE'))->row()->string_value; ?>
<!--<form id="payment-form" action="<?php echo base_url().'payments/charge' ; ?>" method="post">
    <!-- to display errors returned by createToken
    <span class="payment-errors"></span>
    <form action="" method="POST" id="payment-form">
        <div class="form-row">
            <label>Card Number</label>
                <input type="text" size="20" autocomplete="off" class="card-number" />
        </div>
        <div class="form-row">
            <label>CVC</label>
            <input type="text" size="4" autocomplete="off" class="card-cvc" />
        </div>
        <div class="form-row">
            <label>Expiration (MM/YYYY)</label>
            <input type="text" size="2" class="card-expiry-month"/>
            <span> / </span>
            <input type="text" size="4" class="card-expiry-year"/>
        </div>
        <input type="hidden" name="total_amount" value="<?php echo $amount ;?>" />
        <button type="submit" class="submit-button">Pay now</button>
    </form>
</form>-->


<form id="payment-form" action="<?php echo base_url().'payments/charge' ; ?>" method="post" style="margin-top: 50px;" >
	  <input type="hidden" name="total_amount" value="<?php echo $amount*100 ;?>" />
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $publishable_key; ?>"
     data-image="<?php echo base_url().'logo/'.$logo; ?>"
    data-name="<?php echo $site_title= $this->db->query("select `string_value` from `settings` where `id`=1")->row()->string_value; ?>"
    data-description="2 widgets ($<?php echo $amount ;?>)"
    data-amount="<?php echo $amount*100 ;?>">
  </script>
</form>
 
<!--<form method="POST" id="inst-form">    

    <div class="form-row">
      <label>
        <span>Bank Location</span>
            <select data-stripe="country" class = "country" >
                <option value="US">United States</option>
            </select>
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>Routing Number</span>
            <input type="text" class="routing-number" size="9" data-stripe="routingNumber"/>
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>Account Number</span>
            <input type="text" class ="account-number" size="17" data-stripe="accountNumber"/>
      </label>
    </div>


    <button class="submit-button" type="submit">Make Recipient!</button>
</form>-->

 <script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey("<?php echo $publishable_key; ?>");

    function stripeResponseHandler(status, response) {
    	alert(response.error)
    	if (response.error) {
            // re-enable the submit button
            $('.submit-button').removeAttr("disabled");
            // show the errors on the form
            $(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#inst-form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
            //form$.get(0).submit();
        }
    }

    $(document).ready(function() {
    	
    	
        $("#inst-form").submit(function(event) {
            // disable the submit button to prevent repeated clicks
            $('.submit-button').attr("disabled", "disabled");
            // createToken returns immediately - the supplied callback submits the form if there are no errors
          var valid_rout = Stripe.bankAccount.validateRoutingNumber($('.routing-number').val(),$('.country').val()) ; 
          var valid_acc =  Stripe.bankAccount.validateAccountNumber($('.account-number'), $('.country').val() ) ;
alert(valid_rout) ;
alert(valid_acc) ;
   if(valid_rout && valid_acc ){
           Stripe.bankAccount.createToken({
  country: $('.country').val(),
  routingNumber: $('.routing-number').val(),
  accountNumber: $('.account-number').val()
}, stripeResponseHandler);
}
            return false; // submit from callback
            
        });
    });

    </script>
    
  </div></center><!-- #container --> 	