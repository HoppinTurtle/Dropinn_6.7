<html>
	<head></head>
<style>
	th {
		background-color:#2F9CF4;
		text-align:center;
		font-weight:bold;
		color:white;
	}
	
	table{
		
		text-align:center;
	}
	@media(max-width: 768px)
	{
		.res_table td:nth-of-type(0):before { content: "User Id"; }
	.res_table td:nth-of-type(1):before { content: "Periodic Offers"; }
	.res_table td:nth-of-type(2):before { content: "Company News" ; }
	.res_table td:nth-of-type(3):before { content: "Upcoming Reservation"; }
	.res_table td:nth-of-type(4):before { content: "New Review"; }
	.res_table td:nth-of-type(5):before { content: "Leave Review"; }
	.res_table td:nth-of-type(6):before { content: "Standby Guests"; }
	.res_table td:nth-of-type(7):before { content: "Rank Search"; }
	table{
		
		text-align:left;
	}
}  
</style>
 <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
				
			echo $msg;
		}
	  ?>

<div id="User_notification">
<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
	 <h1 class="page-header1"><?php echo translate_admin('User Notification'); ?></h1>
	 </div>
	
<div class="col-xs-12 col-md-12 col-sm-12">
<table class="col-xs-12 col-md-12 col-sm-12 res_table" id="sort_list" cellpadding="2" cellspacing="0" style="width: 100% !important;">
	<thead>
		<th>User Id</th>
		<th>Periodic Offers</th>
		<th>Company News</th>
		<th>Upcoming Reservation</th>
		<th>New Review</th>
		<th>Leave Review</th>
		<th>Standby Guests</th>
		<th>Rank Search</th>
		</thead>
	<?php foreach($result as $row) :?>
	<tr>	
	<td><?php echo $row->user_id ?></td>	
	
	<td><?php if($row->periodic_offers==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
		
		<td><?php if($row->company_news==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
		
	<td><?php if($row->upcoming_reservation==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
	<td><?php if($row->new_review==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
	<td><?php if($row->leave_review==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
	<td><?php if($row->standby_guests==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
	<td><?php if($row->rank_search==1) {
		echo "Yes";
	}
		else {
			echo "No";
		} ?> </td>	
	
	</tr>	
	<?php endforeach;?>
	
	
</table>


</html>