<style>
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
	.res_table td:nth-of-type(1):before { content: "S. No"; }
	.res_table td:nth-of-type(2):before { content: "Room Type" ; }
	.res_table td:nth-of-type(3):before { content: "Action"; }
}
</style>



    <div id="View_Pages">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>
    

			
        <div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
          <h1 class="page-header3"><?php echo translate_admin("Manage Room Types"); ?></h1>
			<div class="but-set">
			<!--<span3><input type="submit" onclick="window.location='<?php echo admin_url('room_type/view_room')?>'" value="<?php echo translate_admin('Add Room type'); ?>"></span3>-->
			</div>	
      </div>
	
	
	<form action="<?php echo admin_url('room_type/delete_room') ?>" name="managepage" method="post">
<div class="col-xs-12 col-md-12 col-sm-12">
  <table class="table1 res_table" id="sort_list" cellpadding="2" cellspacing="0">		 								<thead>
											<th><?php echo translate_admin('S.No'); ?></th>
											<th><?php echo translate_admin('Room Type'); ?></th>
											<th><?php echo translate_admin('Action'); ?></th>
        								</thead>
        
					<?php $i=1;
						if(isset($room) and $room->num_rows()>0)
						{  
							foreach($room->result() as $room)
							{
					?>
					
			 <tr>
			  <td><input type="checkbox" class="clsNoborder" name="propertylist[]" id="propertylist[]" value="<?php echo $room->id; ?>"  /> <?php echo $i++; ?></td>
			  <td><?php echo $room->type; ?></td>	
			
			  <td><a href="<?php echo admin_url('room_type/editroom/'.$room->id)?>">
                <img src="<?php echo base_url()?>images/edit-new.png" alt="Edit" title="Edit" /></a>
				
			 <!--<a href="<?php echo admin_url('room_type/delete_room/'.$room->id)?>" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo base_url()?>images/Delete.png" alt="Delete" title="Delete" /></a>-->
			  </td>
        	</tr>
			
   <?php
				}//Foreach End
			}//If End
			else
			{
			echo '<tr><td colspan="5">'.translate_admin('No room type Found').'</td></tr>'; 
			}
		?>
		</table>
		<br />
		<!--<p style="text-align:left">
			<?php
				$data = array(
    'name' => 'delete',
    'class' => 'Blck_Butt',
    'value' => translate_admin('Delete List'),
    );
		echo form_submit($data);?></p>-->
		</form> 
    </div>


