 <?php
	 
	 if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
?>
<style>
td p{
	color: red;
}
</style>
<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
<h1 class="page-header1"><?php echo translate_admin('Change Password'); ?></h3></div>

<form action="<?php echo admin_url('members/changepassword/'.$this->uri->segment(4,0)); ?>" method="post">
<div class="col-xs-12 col-md-12 col-sm-12">
<table class="table" cellpadding="2" cellspacing="0">
<tr>
<td valign="top"><?php echo translate_admin("New Password"); ?><span style="color: red;">*</span></td>
<td> 
<input type="password" name="new_password"  value="<?php echo set_value('new_password');?>" />
<?php echo form_error('new_password');?>
</td>
</tr>
										
<tr>
<td valign:top;"><?php echo translate_admin("Confirm Password"); ?><span style="color: red;">*</span></td>
<td>
<input type="password" name="confirm_new_password"  value="<?php echo set_value('confirm_new_password');?>">
<?php echo form_error('confirm_new_password');?>
</td>
</tr>                
<tr>
	<td></td>
	<td><input type="submit" name="commit" value="<?php echo translate_admin("Update"); ?>"></td>
</tr>
</table>


</form>
</div>