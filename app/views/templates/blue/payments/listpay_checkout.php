<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<center>
<form id="checkout" method="post" class="checkout1" action="<?php echo base_url().'listpay/braintree_success'?>" >
	<h3 class="creditcardtext">Creditcard Payment</h3>
  <div id="dropin"></div>
  <input type="hidden"name="custom" value="<?php echo $list_id;?>">
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
