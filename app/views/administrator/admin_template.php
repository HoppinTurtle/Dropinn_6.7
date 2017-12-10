<?php $this->load->view('administrator/includes/header'); ?>

<?php
	echo '<div id="wrapper"><div id="content" class="col-md-12 col-sm-12 col-xs-12 paddingzero">';
		//echo($this->dx_auth->is_admin());
		//exit;
		if($this->dx_auth->is_admin()):
				$this->load->view('administrator/includes/sidebar');
	endif;
	
	
	 if($this->uri->segment(1) == 'administrator'  && $this->uri->segment(2) == 'login')
	 {
	echo '<div id="main" class="col-md-12 col-sm-12 col-xs-12 paddingzero">';
	 } else {
		 echo '<div id="main" class="col-md-10 col-sm-10 col-xs-12 paddingzero">';
	 }
	
	
	$this->load->view($message_element);
	echo '</div></div></div></div></div>';
?>
	
<?php 
	$this->load->view('administrator/includes/footer.php');
?>

<style>
	.paddingzero
	{
		padding: 0px !important;
	}
	.table
	{
		margin: auto !important;
		width: 50%;
	}
	@media(max-width: 768px)
	{
		.table
		{
			width: 100% !important;
		}
	}
</style>
<script>
	$('.message').fadeOut(3000);
	$('.login_msg').fadeOut(3000);
	
</script>
