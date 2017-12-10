<style>
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
	.res_table td:nth-of-type(1):before { content: "S. No"; }
	.res_table td:nth-of-type(2):before { content: "List Name" ; }
	.res_table td:nth-of-type(3):before { content: "Traveller Name (ID)"; }
	.res_table td:nth-of-type(4):before { content: "Total Prices"; }
	.res_table td:nth-of-type(5):before { content: "Status"; }
	.res_table td:nth-of-type(6):before { content: "Is Payed?"; }
	.res_table td:nth-of-type(7):before { content: "Options"; }
}
._blank {
    color: rgb(0, 0, 0);
}
</style>


<div id="Reservation_List">

	<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
	 <h1 class="page-header1"><?php echo translate_admin('Reservation List'); ?></h1>
	 </div>
<?php echo form_open('administrator/payment/finance'); ?>

<?php  				
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
		
		// Show error
		echo validation_errors();
		
				$tmpl = array (
                    'table_open'          => '<div class="col-xs-12 col-md-12 col-sm-12"><table id="sort_list" class="table1 res_table"  cellpadding="2" cellspacing="0">
',

					'thead_open'		=> '<thead >',
					'thead_close'		=> '</thead>',
					
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                    
					'tbody_open'		=> '<tbody>',
					'tbody_close'		=> '</tbody>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

		$this->table->set_template($tmpl); 
		
		$this->table->set_heading(translate_admin('S.No'), translate_admin('List Name'), translate_admin('Traveller Name(ID)'), translate_admin('Total Price'), translate_admin('Status'), translate_admin('Is Payed?'), translate_admin('Invoice'), translate_admin('Options'));
		
		if($result->num_rows() > 0)
		{
  		$i = 1;
		foreach ($result->result() as $row) 
		{
		$query          = $this->Users_model->get_user_by_id($row->userby);
		$booker_name    = $query->row()->username;
		
			$query1        = $this->Users_model->get_user_by_id($row->userto);
	 	
	 		//$hotelier_name = $query1->row()->username;
  	        //print_r($hotelier_name);
  	        //$hotelier_id   = $query1->row()->id;
			
			if($row->is_payed == 1)
			{
			 $is_payed =  translate_admin('Yes'); 
			}
			else
			{
			 $is_payed =  translate_admin('No');
			}
			$check_list_id = $this->db->where('id',$row->list_id)->get('list');
			if($check_list_id->num_rows()!=0)
			{
				$attr =array( 'target'=>'_blank', 'class'=>'_blank');
			$this->table->add_row(
				form_checkbox('check[]', $row->id).' '.
				$i,
				anchor(base_url().'rooms/'.$row->list_id, get_list_by_id($row->list_id)->title, $attr),
				anchor(base_url().'users/profile/'.$row->userby, $row->username.'('.$row->userby.')', $attr),
				$row->currency .' '.$row->price,
				$row->name,
				$is_payed,
				anchor(admin_url('payment/download/'.$row->id), translate_admin('View PDF')),
				anchor(admin_url('payment/details/'.$row->id), translate_admin('View Details'))
				);
				$i++;
			}
		}
		}
		else
		{
		$this->table->add_row(
		'',
		translate_admin('There is no reservation yet !'),
		''
		);
		
		}
		
		
		echo $this->table->generate(); 
		
		echo form_close();

			
	?>
	</div>
</div></div>