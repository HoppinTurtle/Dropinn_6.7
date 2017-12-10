<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<center>
<form id="checkout" method="post" class="checkout1" action="<?php echo base_url().'trips/braintree_success'?>">
	<h3 class="creditcardtext">Creditcard Payment</h3>
  <div id="dropin"></div>
  <input type="submit" value="Pay" class="creditsubmit">
</form></center>
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
	form#checkout:hover 
		{
		border: none!important;
		}
		.creditsubmit 
		{
		/* margin-top: 18px; */
		color: #fff;
		padding: 10px 18px!important;
		}
</style>