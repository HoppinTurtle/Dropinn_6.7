<div class="Edit_Page">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($room) and $room->num_rows()>0)
		{
			$room = $room->row();
	  ?>

	 	<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
	 		<h1 class="page-header1"><?php echo translate_admin('Edit Room type'); ?></h1></div>
			<form method="post" action="<?php echo admin_url('room_type/editroom')?>/<?php echo $room->id;  ?>">
 	<div class="col-xs-12 col-md-12 col-sm-12">
   <table class="table" cellpadding="2" cellspacing="0">
			
		 		<tr>
					<td><?php echo translate_admin('Room type'); ?><span style="color: red;">*</span></td>
					<td>
					<input class="" type="text" name="type" id="type" value="<?php echo $room->type; ?>">
<?php echo form_error('type');?>
					</td>
				</tr>
				
		  
		<tr>
		<td>
		  <input type="hidden" name="id"  value="<?php echo $room->id; ?>"/></td><td>
   <input  name="submit" type="submit" value="Submit"></td>
	  	</tr>  
        
	  </table>
	</form>
	  <?php
	  }
	  ?>
    </div>

