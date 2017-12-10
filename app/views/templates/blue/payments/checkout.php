<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
$('#submit').click(function()
{
	var number = $('#number').val();
		$.ajax({
				type: 'POST',
		data: 'number='+number,
		url: '<?php echo base_url().'payments/credit_card_validation'; ?>',
		success : function(data){
			alert(data);
			return false;
		}
		})return false;
})
	
});
</script>-->
<div class="container"><center>
<form id="checkout" method="post" class="credit_bor" action="<?php echo base_url().'payments/braintree_success'?>" >
	<h3 class="creditcardtext">Creditcard Payment</h3>
  <div id="dropin" class="credit_card"></div>
  <div class="btn_list finish credit_pay"><input type="submit" value="Pay" class="creditsubmit"></div>
</form></center>
</div>
<!--<form id="checkout" method="post" action="<?php echo base_url().'payments/braintree_success'?>">
  Creditcard Number :<input name="number" data-braintree-name="number" id="number" value="4111111111111111"><br>
  Expiration Date :<input name="expiration_date" data-braintree-name="expiration_date" value="10/20"><br>
  <input type="submit" id="submit" value="Pay">
</form>-->
<script>
var token = "<?php echo $clientToken; ?>" ;
braintree.setup(token, 'dropin', {
 container: 'dropin',
  paypal: {
    singleUse: true
  }
});
</script>
<script>
braintree.setup("<?php echo $clientToken; ?>", "custom", {id: "checkout"});
</script>
<style>
	.indicator{
		margin-left: -58px !important;
	}
	#location:focus, #location:hover, #checkin:hover, #checkin:focus, #checkout:hover, #checkout:focus{
		border:0px !important;
	}
</style>