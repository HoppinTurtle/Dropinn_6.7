 <?php
	 
	 if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
?>
			
<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
	 <h1 class="page-header1"><?php echo translate_admin('Add Room type'); ?></h1>
	 </div>
	
	 
<form action="<?php echo admin_url('room_type/addrooms'); ?>" method="post">
<div class="col-xs-12 col-md-12 col-sm-12">
<table class="table" cellpadding="2" cellspacing="0">
<tr>
<td><?php echo translate_admin("Additional Room type"); ?><span style="color:#FF0000">*</span></td>
<td><input type="text" name="addroom" value=""></td>
</tr>


<tr>
<td></td>
<td>

<input type="submit" name="update_price" value="<?php echo translate_admin("Add"); ?>" style="width:90px;" />


</td>
</tr>


</table> 
</form>

