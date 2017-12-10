<?php
/**
 * DROPinn Trips Controller Class
 *
 * Helps to control the trips functionality
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Trips
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	public $stripe_secret;
 	public $stripe_pub ;

	public function Cron()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->helper('payment');
		
		
		require_once APPPATH.'libraries/stripe/lib/Stripe.php';
		
		$SecretKey      = $this->db->get_where('payment_details', array('code' => 'SecretKey'))->row()->value;
		$PublishableKey       = $this->db->get_where('payment_details', array('code' => 'PublishableKey'))->row()->value;
		$LSecretKey      = $this->db->get_where('payment_details', array('code' => 'LSecretKey'))->row()->value;
		$LPublishableKey       = $this->db->get_where('payment_details', array('code' => 'LPublishableKey'))->row()->value;
		$paymode     = $this->Common_model->getTableData('payments', array('payment_name' => 'Stripe'))->row()->is_live;
		if($paymode == 0)
		{
			$this->stripe_secret = $SecretKey ; 	
			$this->stripe_pub = $PublishableKey ;
		}
		else {
			$this->stripe_secret = $LSecretKey ; 	
			$this->stripe_pub = $LPublishableKey ;
		}
		
		
		$this->load->library('Form_validation');
		
		$this->load->model('Users_model'); 
		$this->load->model('Email_model');
		$this->load->model('Message_model');
		$this->load->model('Trips_model');
		$this->load->model('Rooms_model');
		
		$this->facebook_lib->enable_debug(TRUE);
	}
	
	function _remap($method)
	{
	  if (method_exists($this, $method))
	  {
	    $this->$method();
	  }
	  else {
	    //$this->index($method);
	    redirect('info/deny');
	  }
	}
	
	public function expire()
	{
			$sql="select *from reservation";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			$date=date("F j, Y, g:i a");
			$date=get_gmt_time(strtotime($date));
			
			foreach($res as $reservation)
			{
	            $timestamp=$reservation['book_date'];
				$book_date=date("F j, Y, g:i a",$timestamp);
				$book_date=strtotime($book_date);
			    $gmtTime   = get_gmt_time(strtotime('+1 day',$timestamp));
				
				if($gmtTime<=$date && $reservation['status']==1)		
				{
					$reservation_id    = $reservation['id'];
					$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 				$admin_name  						= $this->dx_auth->get_site_title();
					$conditions    				= array('reservation.id' => $reservation_id);
					$row           				= $this->Trips_model->get_reservation($conditions);
					if($row->num_rows() != 0)
					{
					$row = $row->row();
					$query1     				= $this->Users_model->get_user_by_id($row->userby);
					
					$traveler_name 				= $query1->row()->username;
					$traveler_email 			= $query1->row()->email;
		
					$query2     						 = $this->Users_model->get_user_by_id($row->userto);
					$host_name 								= $query2->row()->username;
					$host_email 							= $query2->row()->email;
		
					$list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
				 
					$updateKey      		  = array('id' => $reservation_id);
					$updateData               = array();
					$updateData['status ']    = 2;
					$this->Trips_model->update_reservation($updateKey,$updateData);
					
					// payment_helper called for refund amount for host and guest as per host and guest cancellation policy
			
					refund($reservation_id);
					
					$currency = $this->Common_model->getTableData('currency',array('currency_code'=>$row->currency))->row()->currency_symbol;		
					$price = $row->price;
					//echo $currency;exit;
					$checkin  = date('m/d/Y', $row->checkin);
					$checkout = date('m/d/Y', $row->checkout);		
					
					//Send Mail To Traveller
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'traveler_reservation_expire';}
					else {$email_name = 'traveler_reservation_expire_'.$session_lang;}
					
					$splVars    = array("{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
					//Send Mail To Host
					if($session_lang == "") {
					$email_name = 'host_reservation_expire';}
					else {$email_name = 'host_reservation_expire_'.$session_lang;}
					
					$splVars    = array("{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
				//if($host_email != $admin_email && $traveler_email != $admin_email)
				//	{
					//Send Mail To Administrator
					if($session_lang == "") {
					$email_name = 'admin_reservation_expire';}
					else {$email_name = 'admin_reservation_expire_'.$session_lang;}
					
					$splVars    = array("{traveler_email}"=>$traveler_email,"{host_email}"=>$host_email,"{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
				//	}
				}
				}
				
			}	
echo '<h2>Cron Successfully Runned.</h2>'; 	
			
	}

public function calendar_sync()
{
	require_once("app/views/templates/blue/rooms/codebase/class.php");
	
	$exporter = new ICalExporter();
	
	$ical_urls = $this->db->get('ical_import');
	
	if($ical_urls->num_rows() != 0)
	{
		foreach($ical_urls->result() as $row)
		{
			
		$ical_content = file_get_contents($row->url);
		
	$events = $exporter->toHash($ical_content);
	$success_num = 0;
	$error_num = 0;
	
	$id = $row->list_id;
	
	/*! inserting events in database */
	
	$check_tb = $this->db->select('group_id')->where('list_id',$id)->order_by('id','desc')->limit(1)->get('calendar');
	//$query = $this->db->last_query();
	//echo $query;exit;
	//print_r($check_tb->num_rows());exit;
	if($check_tb->num_rows() != 0)
	{
		$i1 = $check_tb->row()->group_id;
	}
	else {
		$i1 = 1;
	}
	
		
	for ($i = 1; $i <= count($events); $i++) 
	{
	$event = $events[$i];
	
	
	$days = (strtotime($event["end_date"]) - strtotime($event["start_date"])) / (60 * 60 * 24);
	$created=$event["start_date"];
	
	for($j=1;$j<=$days;$j++)
	{	
							if($days == 1)
							{
								$direct = 'single';
							}
							else if($days > 1)
							{

								if($j == 1)
								{
								$direct = 'left';
								}
								else if($days == $j)
								{
								$direct = 'right';
								}
								else
								{
								$direct= 'both';
								}
							}	

							
		$startdate1=$event["start_date"];
				
		$check_dates = $this->db->where('list_id',$id)->where('booked_days',strtotime($startdate1))->get('calendar');
		
		if($check_dates->num_rows() != 0)
		{
			$conflict = $i;
		}
		else { 
			
			$data = array(
							'id' =>NULL,
							'list_id' => $id,
							'group_id' => $i+$i1,
							'availability' 		  => "Booked",
							'value' 		  => 0,
							'currency' 	=> "EUR",
							'notes' => "Not Available",                      //   $event["text"]
							'style' 	=> $direct,
							'booked_using' 	=> $ical_id,
							'booked_days' 	=>strtotime($startdate1),
							'created' 	=> strtotime($created)
				
							);
							
							$this->Common_model->insertData('calendar', $data);
				}
		
	//	if(isset($conflict))
	//	{
	//		$this->db->where('list_id',$id)->where('group_id',$conflict)->delete('calendar');
	//	}
	
						$abc =  $event["start_date"];
						$newdate = strtotime ( '+1 day' , strtotime ( $abc ) ) ;
						$event["start_date"]=date("m/d/Y", $newdate);
	}		
	
			$success_num++;
		
	}//for loop end
	}
	}

	echo '<h2>Cron Successfully Runned.</h2>';
}

	public function mysql_backup()
	{
				// Load the DB utility class
$this->load->dbutil();

$date = new DateTime();
$time = $date->format('Y-m-d_H-i-s');

// Backup your entire database and assign it to a variable
$prefs = array(
                'tables'      => array(),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => 'sql_backup_'.$time.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );

$backup = $this->dbutil->backup($prefs); 

// Load the file helper and write the file to your server
$this->load->helper('file');
write_file('./backup/sql_backup_'.$time.'.sql', $backup);

	echo '<h2>Cron Successfully Runned.</h2>'; 

	}

function coupon_expire()
{
	$expired_date = time();
	$this->db->where('expirein <=',$expired_date)->update('coupon',array('status'=>1));
	echo '<h2>Cron Successfully Runned.</h2>'; 
}
	
function accept_status()
{

$date=date("F j, Y, g:i a");
$date=get_gmt_time(strtotime($date));

$result = $this->Common_model->getTableData('reservation',array('status'=>3));
	
	if($result->num_rows() != 0 )
	{
		foreach($result->result() as $row_status)
		{
			$timestamp = $row_status->checkin;
			
			$checkin = date("F j, Y, g:i a",$timestamp);
			
			$checkin = strtotime($checkin);
			
			$gmtTime = get_gmt_time(strtotime('+1 day',$timestamp));
				
			if($gmtTime <= $date)		
			{
				
				$reservation_id    = $row_status->id;
					$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 				$admin_name  						= $this->dx_auth->get_site_title();
					$conditions    				= array('reservation.id' => $reservation_id);
					$row           				= $this->Trips_model->get_reservation($conditions)->row();
					$query1     				= $this->Users_model->get_user_by_id($row->userby);
					$traveler_name 				= $query1->row()->username;
					$traveler_email 			= $query1->row()->email;
		
					$query2     						 = $this->Users_model->get_user_by_id($row->userto);
					$host_name 								= $query2->row()->username;
					$host_email 							= $query2->row()->email;
		
					$list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
				 
					$updateKey      		  = array('id' => $reservation_id);
					$updateData               = array();
					$updateData['status ']    = 2;
					$this->Trips_model->update_reservation($updateKey,$updateData);
					
					$conversation = $this->db->where('userto',$row->userto)->where('userby',$row->userby)->order_by('id','desc')->get('messages');
			
			if($conversation->num_rows() != 0)
			{
				foreach($conversation->result() as $row3)
				{
					if($row3->conversation_id != 0)
					{
						$conversation_id = $row3->conversation_id;
				    }
					else 
						{
					$conversation1 = $this->db->where('userto',$row->userby)->where('userby',$row->userto)->order_by('id','desc')->get('messages');
				
				if($conversation1->num_rows() != 0)
			{
				foreach($conversation1->result() as $row2)
				{
					if($row2->conversation_id != 0)
					{
						$conversation_id = $row2->conversation_id;
					}
				}
			}
				else
					{
						$conversation_id = 0;
					}
				}
			}
			}
			else {
				$conversation1 = $this->db->where('userto',$row->userby)->where('userby',$row->userto)->order_by('id','desc')->get('messages');
				
				if($conversation1->num_rows() != 0)
			{
				foreach($conversation1->result() as $row1)
				{
					if($row1->conversation_id != 0)
					{
						$conversation_id = $row1->conversation_id;
					}
				}
			}
				else
					{
						$conversation_id = 0;
					}
			}
			
			if(!isset($conversation_id))
			{
				$insertData = array(
			'list_id'         => $row->list_id,
			'reservation_id'  => $reservation_id,
			'userby'          => 1,
			'userto'          => $row->userto,
			'message'         => "Your list reservation is expired.",
			'created'         => date('m/d/Y g:i A'),
			'message_type '   => 3
			);	
			
				$insertData1 = array(
			'list_id'         => $row->list_id,
			'reservation_id'  => $reservation_id,
			'userby'          => 1,
			'userto'          => $row->userby,
			'message'         => "Your reservation is expired.",
			'created'         => date('m/d/Y g:i A'),
			'message_type '   => 3
			);
			
			}
			else {
				$insertData = array(
			'list_id'         => $row->list_id,
			'reservation_id'  => $reservation_id,
			'conversation_id'  => $conversation_id,
			'userby'          => 1,
			'userto'          => $row->userto,
			'message'         => "Your list reservation is expired.",
			'created'         => date('m/d/Y g:i A'),
			'message_type '   => 3
			);	
			
				$insertData1 = array(
			'list_id'         => $row->list_id,
			'reservation_id'  => $reservation_id,
			'conversation_id' => $conversation_id,
			'userby'          => 1,
			'userto'          => $row->userby,
			'message'         => "Your reservation is expired.",
			'created'         => date('m/d/Y g:i A'),
			'message_type '   => 3
			);	
			
			}
					
		$this->Message_model->sentMessage($insertData);
		$this->Message_model->sentMessage($insertData1);
		
		$currency = $this->Common_model->getTableData('currency',array('currency_code'=>$row->currency))->row()->currency_symbol;		
		$price = $row->price;
		
		$checkin  = date('m/d/Y', $row->checkin);
		$checkout = date('m/d/Y', $row->checkout);		
					
					//Send Mail To Traveller
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'traveler_reservation_expire';}
					else {$email_name = 'traveler_reservation_expire_'.$session_lang;}
					$splVars    = array("{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
					//Send Mail To Host
					if($session_lang == "") {
					$email_name = 'host_reservation_expire';}
					else {$email_name = 'host_reservation_expire_'.$session_lang;}
					$splVars    = array("{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
				//if($host_email != $admin_email && $traveler_email != $admin_email)
				//	{
					//Send Mail To Administrator
					if($session_lang == "") {
					$email_name = 'admin_reservation_expire';}
					else {$email_name = 'admin_reservation_expire_'.$session_lang;}
					$splVars    = array("{traveler_email}"=>$traveler_email,"{host_email}"=>$host_email,"{checkout}"=>$checkout,"{checkin}"=>$checkin,"{currency}"=>$currency,"{price}"=>$price,"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
				//	}
				
			}
		}
	}
	echo '<h2>Cron Successfully Runned.</h2>'; 
} 

function after_checkin()
{
	$date=date("F j, Y, g:i a");
$date=get_gmt_time(strtotime($date));

$result = $this->Common_model->getTableData('reservation',array('status'=>7));
	
	if($result->num_rows() != 0 )
	{
		foreach($result->result() as $row_status)
		{
			$timestamp = $row_status->checkout;
			
			$checkout = date("F j, Y, g:i a",$timestamp);
			
			$checkout = strtotime($checkout);
			
			$gmtTime = get_gmt_time(strtotime('+1 day',$timestamp));
				
			if($gmtTime <= $date)		
			{
					
				$reservation_id           = $row_status->id;
				$admin_email 						= $this->dx_auth->get_site_sadmin();
			$admin_name  						= $this->dx_auth->get_site_title();
	
			$conditions    				= array('reservation.id' => $reservation_id);
			$row           				= $this->Trips_model->get_reservation($conditions)->row();
			
			
			$updateKey      										= array('id' => $reservation_id);
			$updateData               = array();
			$updateData['status ']    = 8;
			$this->Trips_model->update_reservation($updateKey,$updateData);
			
			$conditions    				= array('reservation.id' => $reservation_id);
	 		$row           				= $this->Trips_model->get_reservation($conditions)->row();
			$before_status = $row->status;
									
		    if($this->Users_model->get_user_by_id($row->userby))
			{
			$query1     				= $this->Users_model->get_user_by_id($row->userby);
			}
			else 
				{	
			//$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',translate('Your List was deleted.')));
			//redirect('travelling/your_trips');
				}
			
			$traveler_name 				= $query1->row()->username;
			$traveler_email 			= $query1->row()->email;
			
			$query2     						 = $this->Users_model->get_user_by_id($row->userto);
			$host_name 								= $query2->row()->username;
			$host_email 							= $query2->row()->email;
			
			$list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
						
			$username = $traveler_name;
			
			if($row->list_id)
			{

			$insertData = array(
			'list_id'         => $row->list_id,
			'reservation_id'  => $reservation_id,
			'userby'          => $row->userby,
			'userto'          => $row->userto,
			'message'         => "$username wants the review from you.",
			'created'         => date('m/d/Y g:i A'),
			'message_type '   => 4
			);			
			
		$this->Message_model->sentMessage($insertData);
				
		//Send Mail To Traveller
		$session_lang = $this->session->userdata('locale');
		if($session_lang == "") {
			$email_name = 'checkout_traveler';}
		else {$email_name = 'checkout_traveler_'.$session_lang;}
		
		$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
		$this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
		//Send Mail To Host
		if($session_lang == "") {
			$email_name = 'checkout_host';}
		else {$email_name = 'checkout_host_'.$session_lang;}

		$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
		$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
		//Send Mail To Administrator
		if($session_lang == "") {
			$email_name = 'checkout_admin';}
		else {$email_name = 'checkout_admin_'.$session_lang;}
		$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
		$this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
		//$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success',translate('You are successfully checked out.')));	
		//redirect('travelling/previous_trips'); 
			
          }
	
			}
		}	
	}
echo '<h2>Cron Successfully Runned.</h2>'; 
}

public function bankwirestatus()
	{
			$sql="select * from refund";
			$query=$this->db->query($sql);
			$res=$query->result_array();
		$count = 0 ;
		$message_content = "" ;
	$this->load->dbutil();
    $this->load->helper('file');
    $report = $this->db->get('refund');
    $new_report = $this->dbutil->csv_from_result($report);
	write_file( FCPATH.'/uploads/refund_backup'.time().'.csv',$new_report);
	
	foreach($res as $reservation)
			{//echo "Id--".$reservation['bankwire_id']."--Status--" ;
				if($reservation['transaction_id'] != "")
				{
			 	
		error_reporting(E_ALL);
		
		Stripe::setApiKey($this->stripe_secret); 
		$result = Stripe_Transfer::retrieve($reservation['transaction_id']);

 if( $result->status == "failed" || $result->status == "canceled"  )
 {
 	$current_id = $reservation['id'] ;
 	$count++;
	
	$username = $this->db->get_where('users', array('id' => $reservation['userto'] ))->row()->username;
	$toemail = $this->db->get_where('users', array('id' => $reservation['userto'] ))->row()->email;
	
 	if($reservation['accept_status']==0)
	{
		$userto = $this->Common_model->getTableData('reservation',array('id'=> $reservation['reservation_id'] ))->row()->userto;
		
		if($reservation['userto'] == $userto)
		{
			$this->db->where('id',$reservation['reservation_id'])->update('reservation',array('is_payed_host'=> 0 ));
		}
		else{
			$this->db->where('id',$reservation['reservation_id'])->update('reservation',array('is_payed_guest'=> 0 ));
		}
		$this->db->where('id',$reservation['reservation_id'])->update('reservation',array('is_payed'=> 0 ));
		
			    
	}
	else
	{
		$this->db->where('reservation_id',$reservation['reservation_id'])->update('accept_pay',array('status'=> 0 ));
	}
	
	
	$this->db->delete('refund', array('id' => $current_id)); 
	$message_content .= anchor('administrator/payment/details/'.$reservation['reservation_id'],translate('Link for reservation id:'.$reservation['reservation_id']))."<br>";
				
				$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 			$admin_name  						= $this->dx_auth->get_site_title();
				$email_name = 'failed_bankwire_notification';
				$splVars    = array("{username}" => ucfirst($username), "{site_name}" => $this->dx_auth->get_site_title(),"{content}" => "" );
				$this->Email_model->sendMail( $toemail ,$admin_email,ucfirst($admin_name),$email_name,$splVars);

 }
		}
				
			}
				$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 			$admin_name  						= $this->dx_auth->get_site_title();
				$message_content .= "You have ".$count." failed transfers!" ;
				$email_name = 'admin_failed_bankwire';
				$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{content}" => $message_content );
				$this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
					
				echo $message_content."<br>" ;
				echo "An automated mail sent to the admin email id" ; 	
				echo '<h2>Cron Successfully Runned.</h2>'; 	
	}






	function notify(){
		$date=date("F j, Y");
		//echo $date=get_gmt_time(strtotime($date));
		$result = $this->Common_model->getTableData('reservation',array('status'=>3));
	
	if($result->num_rows() != 0 )
	{
		foreach($result->result() as $row_status)
		{
			$timestamp = $row_status->checkin;
			$timestamp1=$row_status->checkout;
			$checkind = date("F j, Y",$timestamp);
			$checkoutd = date("F j, Y",$timestamp1);
			$checkin = strtotime($checkind);
			$checkout=strtotime($checkoutd);
			$gmtTime = strtotime('-1 day',$timestamp);
			$gmtTime = date("F j, Y",$gmtTime);	
			if($gmtTime == $date)		
			{
					
				$reservation_id           = $row_status->id;
				$admin_email 						= $this->dx_auth->get_site_sadmin();
				$admin_name  						= $this->dx_auth->get_site_title();
	
			$conditions    				= array('reservation.id' => $reservation_id);
			$row           				= $this->Trips_model->get_reservation($conditions)->row();
			$before_status = $row->status;
									
		    if($this->Users_model->get_user_by_id($row->userby))
			{
			$query1  = $this->Users_model->get_user_by_id($row->userby);
			$query2  = $this->Users_model->get_user_by_id($row->userto);
			}
			else 
				{	
			//$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',translate('Your List was deleted.')));
			//redirect('travelling/your_trips');
				}
				$query=	$this->Common_model->getTableData('user_notification',array('user_id' => $row->userto));
   					$result=$query->row();
 					$notify=$result->upcoming_reservation;
			if($notify==1)
	{
				
			
			 $traveler_name 				= $query1->row()->username;
			 $traveler_email 			= $query1->row()->email;
			
			 $query2     						 = $this->Users_model->get_user_by_id($row->userto);
			 $host_name 								= $query2->row()->username;
			 $host_email 							= $query2->row()->email;
			
			$list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
						
			$username = $traveler_name;
				
		//Send Mail To Host
		$session_lang = $this->session->userdata('locale');
		if($session_lang == "") {
		$email_name = 'host_notification';}
		else {$email_name = 'host_notification_'.$session_lang;}
		$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{traveler_name}" => ucfirst($traveler_name), "{host_name}"=>ucfirst($host_name), "{traveler_email_id}"=>$traveler_email,"{list_title}" => $list_title, "{checkout}" => $checkoutd,"{checkin}"=>$checkind,);
		
		$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
		
          }
	
			}}
		}
echo '<h2>Cron Successfully Runned.</h2>';	
	}
function calendar_notify(){
		$date=date("F j, Y");
		//echo $date=get_gmt_time(strtotime($date));
		$result = $this->Common_model->getTableData('users');
	
	if($result->num_rows() != 0 )
	{
		foreach($result->result() as $row_status)
		{
			$id= $row_status->id;
			$query=	$this->Common_model->getTableData('user_notification',array('user_id' => $id));
   			$result1=$query->row();
			if($result1){
				$notify=$result1->rank_search;
			}
 			if($notify==1){
				$query1=$this->Common_model->getTableData('list',array('user_id' => $id));
				$rooms=$query1->row();
				if($rooms){
					foreach($query1->row() as $rooms){
					$rooms_id= $query1->row()->id;
					$conditions	= array('list_id' => $rooms_id);
					$orderby=array('book_date');
					//$result2= $this->Trips_model->get_reservation($conditions	= array('list_id' => $rooms_id));
					//$result2=$this->Common_model->getTableData($table='reservation',$conditions,$fields='', $like=array(), $limit=array(), $orderby = array(), $like1=array(), $orderby, $conditions1=array() );
					//$this->db->oreser_by
					$result2=$this->db->query("SELECT MAX( `book_date` ) 
						FROM  `reservation` 
						WHERE  `list_id` =".$rooms_id);
					//	$result2);
					
					 $res_data=$result2->result_array();
 					 foreach($res_data as $data)
						{
						$page_v= $data;
						}
						//print_r ($page_v);
						foreach($page_v as $data1){
							 $max_book=$data1;
						}
			 		
					
					
					}
					$now=time();
					
					
				  date("F j, Y",$now);
				    $last_booking=date("F j, Y",$max_book);
				  $gmtTime = strtotime('-1 month',$now);
				  	 $checking=date("F j, Y",$gmtTime);
				 //$checking=
				  $rooms_id;
				 if($gmtTime>$max_book){
				 	
				 	$reserv=$this->Common_model->getTableData('list',array('id'=>$rooms_id));
				 $list_name=$reserv->row()->title;
					 $user=$reserv->row()->user_id;
					$usert=$this->Common_model->getTableData('users',array('id'=>$user));
					$userf=$this->Common_model->getTableData('users',array('id'=>1));
					 $admin_email=$userf->row()->email;
					 $admin_name=$userf->row()->username;
				  $host_name=$usert->row()->username;
				 $host_email=$usert->row()->email;
					//Send Mail To Host
		$session_lang = $this->session->userdata('locale');
		if($session_lang == "") {
		$email_name = 'list_notification';}
		else {$email_name = 'list_notification_'.$session_lang;}
		$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{host_name}"=>ucfirst($host_name), "{list_name}" => $list_name, );
		
		$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
					 //echo $user
				 	
				 }
				 }
				
			}
				
				
			}}
echo '<h2>Cron Successfully Runned.</h2>';	
}


function cloudinary_cron()
{
	 set_time_limit(0);
        require_once APPPATH.'libraries/cloudinary/autoload.php';
          \Cloudinary::config(array( 
                          "cloud_name" => cdn_name, 
                           "api_key" => cdn_api, 
                           "api_secret" => cloud_s_key
                ));
           $error = 0 ; 
  	 try{
           $api = new \Cloudinary\Api();
  		 $msg = $api->ping() ;
		}catch (Exception $e) {
    $msg = $e->getMessage();
	$error = 1 ; 
    }
   if($error == 1){
   	echo "Cannot connect to Cloudinary!!<br> Check the clouidnary account and make necessry changes of API key in database and try again."; exit; 
   }

	/*
			  require_once APPPATH.'libraries/cloudinary/autoload.php';
			\Cloudinary::config(array( 
							"cloud_name" => "duidtvpap", 
							 "api_key" => "467224546749428", 
							 "api_secret" => "jaY19u-n9VXbP56JRPZ3EwurDl0"
				  ));  
		*/
			 /*
			   try{
				  $api = new \Cloudinary\Api();
				 $api->delete_all_resources();
				}catch (Exception $e) {
				 $error = $e->getMessage();
						 } */
			 
			  
	echo "<pre>";
	
$path   = array('./Cloud_data/logo','./Cloud_data/images','./Cloud_data/css','./Cloud_data/js','./Cloud_data/css_red','./Cloud_data/css_pink','./Cloud_data/css_green','./Cloud_data/css_yellow','./Cloud_data/css_orange','./Cloud_data/uploads');
//$path   = array('./css');
$count = 0 ;
foreach ($path as $incldePath) {
	

$result = array('files' => array());

$DirectoryIterator = new RecursiveDirectoryIterator($incldePath);
$IteratorIterator  = new RecursiveIteratorIterator($DirectoryIterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($IteratorIterator as $file) {

    $currPath = $file->getRealPath();
	
	if ($file->isDir()) {
        //$result['directories'][] = $file->getFilename();
    } elseif ($file->isFile()) {
        $result['files'][] = $currPath;
		/*
		$name = $file->getFilename() ;
				 $temp = explode('.', $name);
						$ext  = array_pop($temp);*/
		
         //      echo realpath(FCPATH) ; 
                   
				 $path= pathinfo($currPath); 
				 $public_id_tmp = $path['dirname']."/".$path['filename']; // Works from PHP 5.2
				 $public_id = str_replace(realpath(FCPATH)."/Cloud_data/","", $public_id_tmp); 
				 
		 		try{
  
                     $cloudimage=\Cloudinary\Uploader::upload($currPath,
                               array(
                                     "public_id" => $public_id , "resource_type" => "auto"));
									 
        			$getcssImg  = explode('/',$path['dirname']); 
					
					if($public_id == "loading16" || $public_id == "lys_hv" || $public_id == "down_arrow" || $public_id == "tick" || $public_id == "welcome" || $public_id == "calender_list-1" || $public_id == "calender_list-2" || $public_id == "calender_list-3" || $public_id == "preview-btn" || $public_id == "back_arrow" || $public_id == "list_your_space"  ) 
					{
					$cloudimage=\Cloudinary\Uploader::upload($currPath,
                               array(
                                     "public_id" => $public_id , "resource_type" => "raw"));		
					}// For Some images in CSS 
					
					if(end($getcssImg)=="images" && prev($getcssImg)=="blue"){
					 $cloudimage=\Cloudinary\Uploader::upload($currPath,
                               array(
                                     "public_id" => $public_id , "resource_type" => "raw"));
					} 
    				print_r($cloudimage);
					// echo $public_id; 
                    }
                catch (Exception $e) {
                       $error = $e->getMessage();
					   print_r($error);
                  }
				
    }
	
}
$count = $count + count($result['files']); 
//print_r($result);
echo "Uploaded ".$count." files to Cloudinary";
}

}



function cleanup_cloudinary(){
	
	   require_once APPPATH.'libraries/cloudinary/autoload.php';
        \Cloudinary::config(array( 
                        "cloud_name" => cdn_name, 
                         "api_key" => cdn_api, 
                         "api_secret" => cloud_s_key
              ));
		 try{
     $api = new \Cloudinary\Api();
    $data = $api->delete_all_resources();
   }catch (Exception $e) {
    $error = $e->getMessage();
            }
   print_r($data); exit;
	
}


public function inactive_days()
	{
		
		$date=date("F j, Y, g:i a");
		$date=get_gmt_time(strtotime($date));
		
		$result = $this->Common_model->getTableData('users',array('banned'=>0));
			
			if($result->num_rows() != 0 )
			{
				foreach($result->result() as $row_status)
				{
					$timestamp = $row_status->last_login;
					
					$last_login = date("F j, Y, g:i a",$timestamp);
					
					$lastlogin = strtotime($last_login);
					
					$gmtTime = get_gmt_time(strtotime('+30 day',$timestamp));
					$gmtTimemonth = get_gmt_time(strtotime('+180 day',$timestamp));	
						
					if($gmtTime <= $date && $gmtTimemonth > $date)		
					{
						
						$user_id           = $row_status->id;
						
						if($this->Users_model->get_user_by_id($user_id))
						{
						$query1  = $this->Users_model->get_user_by_id($user_id);
						}
						$session_lang = $this->session->userdata('locale');
						if($session_lang == "") {
						$email_name = 'user_inactive_days';}
						else {$email_name = 'user_inactive_days_'.$session_lang;}
						$user_name 	= $query1->row()->username;
						$user_email = $query1->row()->email;
						
						$admin = get_user_by_rollid(2);
						$admin_name 				= $admin->username;
						$admin_email = $admin->email;
						
						$datediff =  $date - $lastlogin;
						$days = floor($datediff / (60 * 60 * 24));
						
						$user_email = $query1->row()->email;
						$num_list = $this->Common_model->getTableData('list',array('user_id'=>$user_id));
						$num_reserved_list = $this->Common_model->getTableData('reservation',array('userby'=>$user_id));
						$link = anchor('users/profile/'.$user_id,translate('Click here'));
						
						$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{click_here}" => $link,"{num_reserved_list}" => $num_reserved_list->num_rows(),"{num_list}" => $num_list->num_rows(),"{days}" => $days, "{user_name}" => ucfirst($user_name));
						$this->Email_model->sendMail($user_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);	
					}  
				}
			}	
		    echo "Cron has been executed successfully";  
	}
public function inactive_months()
	{
		
		$date=date("F j, Y, g:i a");
		$date=get_gmt_time(strtotime($date));
		
		$result = $this->Common_model->getTableData('users',array('banned'=>0));
			
			if($result->num_rows() != 0 )
			{
				foreach($result->result() as $row_status)
				{
					$timestamp = $row_status->last_login;
					
					
					$last_login = date("F j, Y, g:i a",$timestamp);
					
					$lastlogin = strtotime($last_login);
					
					$gmtTime = get_gmt_time(strtotime('+180 day',$timestamp));
					$gmtTimeyear = get_gmt_time(strtotime('+365 day',$timestamp));	
						
					if($gmtTime <= $date && $gmtTimeyear > $date)		
					{
						$user_id           = $row_status->id;
						
						if($this->Users_model->get_user_by_id($user_id))
						{
						$query1  = $this->Users_model->get_user_by_id($user_id);
						}
						$session_lang = $this->session->userdata('locale');
						if($session_lang == "") {
						$email_name = 'user_inactive_months';}
						else {$email_name = 'user_inactive_months_'.$session_lang;}
						$user_name 	= $query1->row()->username;
						$user_email = $query1->row()->email;
						
						$admin = get_user_by_rollid(2);
						$admin_name 				= $admin->username;
						$admin_email = $admin->email;
						
						
						$datediff =  $date - $timestamp;
						$days = floor($datediff / (60 * 60 * 24));
						
						$month = ($days % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
						$month = floor($month)+1;
					
						$user_email = $query1->row()->email;
						$num_list = $this->Common_model->getTableData('list',array('user_id'=>$user_id));
						$num_reserved_list = $this->Common_model->getTableData('reservation',array('userby'=>$user_id));
						$link = anchor('users/profile/'.$user_id,translate('Click here'));
						
						$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{click_here}" => $link,"{num_reserved_list}" => $num_reserved_list->num_rows(),"{num_list}" => $num_list->num_rows(),"{months}" => $month, "{user_name}" => ucfirst($user_name));
						$this->Email_model->sendMail($user_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);	
					}   
				}
			}	
		    echo "Cron has been executed successfully";  
	}
public function inactive_year()
	{
		
		$date=date("F j, Y, g:i a");
		$date=get_gmt_time(strtotime($date));
		
		$result = $this->Common_model->getTableData('users',array('banned'=>0));
			
			if($result->num_rows() != 0 )
			{
				foreach($result->result() as $row_status)
				{
					$timestamp = $row_status->last_login;
					
					$last_login = date("F j, Y, g:i a",$timestamp);
					
					$lastlogin = strtotime($last_login);
					
					$gmtTime = get_gmt_time(strtotime('+365 day',$timestamp));
						
						
					if($gmtTime <= $date)		
					{
						$user_id           = $row_status->id;
						
						if($this->Users_model->get_user_by_id($user_id))
						{
						$query1  = $this->Users_model->get_user_by_id($user_id);
						}
						$session_lang = $this->session->userdata('locale');
						if($session_lang == "") {
						$email_name = 'user_inactive_year';}
						else {$email_name = 'user_inactive_year_'.$session_lang;}
						$user_name 	= $query1->row()->username;
						$user_email = $query1->row()->email;
						
						$admin = get_user_by_rollid(2);
						$admin_name 				= $admin->username;
						$admin_email = $admin->email;
						
						
						$datediff =  $date - $lastlogin;
						$days = floor($datediff / (60 * 60 * 24));
						
						$years = ($days / 365) ; // days / 365 days
						$years = floor($years); // Remove all decimals
						
						
						$user_email = $query1->row()->email;
						$num_list = $this->Common_model->getTableData('list',array('user_id'=>$user_id));
						$num_reserved_list = $this->Common_model->getTableData('reservation',array('userby'=>$user_id));
						$link = anchor('users/profile/'.$user_id,translate('Click here'));
						
						$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{click_here}" => $link,"{num_reserved_list}" => $num_reserved_list->num_rows(),"{num_list}" => $num_list->num_rows(),"{year}" => $years, "{user_name}" => ucfirst($user_name));
						$this->Email_model->sendMail($user_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);	
					}   
				}
			}	
		    echo "Cron has been executed successfully";  
	}

// Auto checkin 
function auto_checkin()
{
    $date=date("F j, Y");
    $date=get_gmt_time(strtotime($date));
    $result = $this->Common_model->getTableData('reservation',array('status'=>3,'checkin'=>$date));
    
    if($result->num_rows() != 0 )
    {
        foreach($result->result() as $row_status)
        {
                    
            $timestamp = $row_status->checkin;
            
            $checkin = date("F j, Y, g:i a",$timestamp);
            
            $checkin = strtotime($checkin);
                
            if($checkin == $date)        
            {
                
             $reservation_id               = $row_status->id;
            $updateKey                = array('id' => $reservation_id);
            $updateData               = array();
            $updateData['status ']    = 7;
            $this->Trips_model->update_reservation($updateKey,$updateData);
            
            $query1                     = $this->Users_model->get_user_by_id($row_status->userby);
            if($query1)
            {  /// user(booker) exist or not
            refund($reservation_id); 
            
            $conditions                    = array('reservation.id' => $reservation_id);
            $row                           = $this->Trips_model->get_reservation($conditions)->row();
            
            $traveler_name                 = $query1->row()->username;
            $traveler_email             = $query1->row()->email;
            
            $query2                              = $this->Users_model->get_user_by_id($row->userto);
            $host_name                                 = $query2->row()->username;
            $host_email                             = $query2->row()->email;
            
            $admin_email                         = $this->dx_auth->get_site_sadmin();
            $admin_name                          = $this->dx_auth->get_site_title();
            
            $list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
                        
            $username = ucfirst($this->dx_auth->get_username());
            
            $checkin  = date('m/d/Y', $row->checkin);
            $checkout = date('m/d/Y', $row->checkout);    
            $price    = $row->price;
            
            $currency = $this->db->where('currency_code',$row->currency)->get('currency')->row()->currency_symbol;
            
            $conversation = $this->db->where('userto',$row->userto)->where('userby',$row->userby)->order_by('id','desc')->get('messages');
            
            if($conversation->num_rows() != 0)
            {
                foreach($conversation->result() as $row3)
                {
                    if($row3->conversation_id != 0)
                    {
                        $conversation_id = $row3->conversation_id;
                    }
                    else 
                        {
                    $conversation1 = $this->db->where('userto',$row->userby)->where('userby',$row->userto)->order_by('id','desc')->get('messages');
                
                if($conversation1->num_rows() != 0)
            {
                foreach($conversation1->result() as $row2)
                {
                    if($row2->conversation_id != 0)
                    {
                        $conversation_id = $row2->conversation_id;
                    }
                }
            }
                else
                    {
                        $conversation_id = 0;
                    }
                }
            }
            }
            else {
                $conversation1 = $this->db->where('userto',$row->userby)->where('userby',$row->userto)->order_by('id','desc')->get('messages');
                
                if($conversation1->num_rows() != 0)
            {
                foreach($conversation1->result() as $row1)
                {
                    if($row1->conversation_id != 0)
                    {
                        $conversation_id = $row1->conversation_id;
                    }
                }
            }
                else
                    {
                        $conversation_id = 0;
                    }
            }
            
            if(!isset($conversation_id))
            {
                $insertData = array(
            'list_id'         => $row->list_id,
            'reservation_id'  => $reservation_id,
            'userby'          => $row->userby,
            'userto'          => $row->userto,
            'message'         => "$username checkin to $list_title.",
            'created'         => date('m/d/Y g:i A'),
            'message_type '   => 3
            );    
            
            }
            else {
                $insertData = array(
            'list_id'         => $row->list_id,
            'reservation_id'  => $reservation_id,
            'conversation_id'  => $conversation_id,
            'userby'          => $row->userby,
            'userto'          => $row->userto,
            'message'         => "$username checkin to $list_title.",
            'created'         => date('m/d/Y g:i A'),
            'message_type '   => 3
            );    
            }
            
            if($row->list_id)
            {            
        $this->Message_model->sentMessage($insertData);
        
		$session_lang = $this->session->userdata('locale');
        //Send Mail To Traveller
        if($session_lang == "") {
        $email_name = 'auto_checkin_traveller';}
		else {$email_name = 'auto_checkin_traveller_'.$session_lang;}
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{currency}"=>$currency,"{traveler_email}"=>$traveler_email,"{host_email}"=>$host_email,"{traveler_name}" => ucfirst($traveler_name),"{checkin}"=>$checkin,"{checkout}"=>$checkout,"{price}"=>$price, "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);        
        
    
        //Send Mail To Host
        if($session_lang == "") {
        $email_name = 'auto_checkin_host';}
		else {$email_name = 'auto_checkin_host_'.$session_lang;}
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{currency}"=>$currency,"{traveler_email}"=>$traveler_email,"{host_email}"=>$host_email,"{traveler_name}" => ucfirst($traveler_name),"{checkin}"=>$checkin,"{checkout}"=>$checkout,"{price}"=>$price, "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
        
        
        //Send Mail To Administrator
        
        $admin_to_email = $this->db->where('id',1)->get('users')->row()->email;
        if($session_lang == "") {
        $email_name = 'auto_checkin_admin';}
		else {$email_name = 'auto_checkin_admin_'.$session_lang;}
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(),"{currency}"=>$currency,"{traveler_email}"=>$traveler_email,"{host_email}"=>$host_email,"{traveler_name}" => ucfirst($traveler_name),"{checkin}"=>$checkin,"{checkout}"=>$checkout,"{price}"=>$price, "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($admin_to_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);

            }
            }
    
            }    
            
        }
        
        }  
        echo "Cron has been executed successfully";  
}


// Auto checkout
function auto_checkout()
{
    

$date=date("F j, Y, g:i a");
$date=get_gmt_time(strtotime($date) + 12 * 3600);

$result_check = $this->Common_model->getTableData('reservation',array('status'=>7));
    
    if($result_check->num_rows() != 0 )
    {
        foreach($result_check->result() as $row_status)
        {
            
            $timestamp = $row_status->checkout;
            
            $checkout = date("F j, Y, g:i a",$timestamp);
            
            $checkout = strtotime($checkout);
			
			// $checkdate = $row_status->checkin;
			// $checkin = get_gmt_time(strtotime($checkdate) + 12 * 3600);
			
			//$gmtTime = get_gmt_time(strtotime('+1 day',$timestamp));
				
			//if($gmtTime <= $date)	
			
                
            if($checkout <= $date)        
            {
                    
                $reservation_id           = $row_status->id;
                $admin_email                         = $this->dx_auth->get_site_sadmin();
            $admin_name                          = $this->dx_auth->get_site_title();
    
            $conditions                    = array('reservation.id' => $reservation_id);
            $row                           = $this->Trips_model->get_reservation($conditions)->row();
            
            
            $updateKey                                              = array('id' => $reservation_id);
            $updateData               = array();
            $updateData['status ']    = 8;
            $this->Trips_model->update_reservation($updateKey,$updateData);
            
           	$conditions                    = array('reservation.id' => $reservation_id);
            $row                           = $this->Trips_model->get_reservation($conditions)->row();
            $before_status = $row->status;
              // $before_status = "7";                      
            if($this->Users_model->get_user_by_id($row->userby))
            {
            $query1                     = $this->Users_model->get_user_by_id($row->userby);
            }
            else 
                {    
            //$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',translate('Your List was deleted.')));
            //redirect('travelling/your_trips');
                }
            
            $traveler_name                 = $query1->row()->username;
            $traveler_email             = $query1->row()->email;
            
            $query2                              = $this->Users_model->get_user_by_id($row->userto);
            $host_name                                 = $query2->row()->username;
            $host_email                             = $query2->row()->email;
            
            $list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
                  
				  $review = '<a href="'.base_url().'trips/review_by_traveller/'.$row->id.'">Click here</a>';
			$host_review = '<a href="'.base_url().'trips/review_by_host/'.$row->id.'">Click here</a>';      
            $username = $traveler_name;
            
            if($row->list_id)
            {

            $insertData = array(
            'list_id'         => $row->list_id,
            'reservation_id'  => $reservation_id,
            'userby'          => $row->userby,
            'userto'          => $row->userto,
            'message'         => "$username wants the review from you.",
            'created'         => date('m/d/Y g:i A'),
            'message_type '   => 4
            );            
            
        $this->Message_model->sentMessage($insertData);
                
        //Send Mail To Traveller
        $session_lang = $this->session->userdata('locale');
		if($session_lang == "") {
        $email_name = 'auto_checkout_traveler'; }
		else {$email_name = 'auto_checkout_traveler_'.$session_lang; }
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{Click_here}"=>$review, "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);        
                
        //Send Mail To Host
        if($session_lang == "") {
        $email_name = 'auto_checkout_host';}
		else {$email_name = 'auto_checkout_host_'.$session_lang;}
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{Click_here}"=>$host_review, "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
        
        //Send Mail To Administrator
        if($session_lang == "") {
        $email_name = 'auto_checkout_admin';}
		else {$email_name = 'auto_checkout_admin_'.$session_lang;}
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{Click_here}"=>$review, "{Click_here}"=>$host_review, "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
        
        //$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success',translate('You are successfully checked out.')));    
        //redirect('travelling/previous_trips'); 
            
          }
          }
        }   
    }
echo "Cron has been executed successfully";
}

function test_email()
{
		$admin_email = "aravind.b@cogzidel.com";
		$email_name = "test_email";
		$host_email = "siva.s.m@cogzidel.com";
		$admin_name = "mail_test";
		
		
        $splVars    = array("{site_name}" => $this->dx_auth->get_site_title());
        $this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
}

function make_review(){
		$room_id = $this->db->where('review !=', 0)->get('list');
		foreach ($room_id -> result() as $valroom_id) {
			$valroom_id = $valroom_id->id; 
			$overall = review_star_overall($valroom_id);
			$update_overall = review_star_overall($valroom_id);
			$data1      = array('overall_review' => $update_overall);
			$this->db->where('id', $valroom_id);
			$this->db->update('list', $data1);
		}			
}

//// run this cron function once in a week ///

public function Incomplete_listing_host()
{
	
	$arr = array();
	$query_list = "";
	
	  $this->db->select('list.id,list.created,list.user_id')->join('lys_status',"lys_status.id=list.id");        
      $query =    $this->db->where("list.is_enable",'0')->where("list.status",'0')->or_where("lys_status.calendar",0)->or_where("lys_status.price",0)->or_where("lys_status.overview",0)->or_where("lys_status.photo",0)->or_where("lys_status.address",0)->or_where("lys_status.listing",0)->get('list');
	//echo $this->db->last_query();	     
  // echo "<pre>";  print_r($query->result());
	// exit;
	 
	  if($query->num_rows() > 0)
	 {
	 $query_list = $query->result() ;
	 	
	 }else{
	$query_list = "";	 	
	 }

			if($query_list != "")
			{

		foreach ($query_list as $row) {
			
	   $date_later  = strtotime('+7 days',$row->created);
	   $current_date = time();
			if($current_date >= $date_later)
			{				
				$arr[] = $row->user_id;					
			}
						
		}
		$arr = array_unique($arr);
		$new_array = array_values($arr);
//echo "<pre>";print_r($new_array);exit;
		if(count($new_array) > 0)
		{
			for($i=0;$i<count($new_array);$i++)
			{
		$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 	$admin_name  	= $this->dx_auth->get_site_title();
		$user_result = get_profile_by_id($new_array[$i]);
		//print_r($user_result);
		$no_user = $user_result -> phnum;  // phone number
		
		$user_result_2 = get_user_by_id($new_array[$i]);		
		$name = ucfirst( $user_result_2 -> username);  // User name
		$host_email = ucfirst( $user_result_2 -> email);  // User email
		//echo $host_email;
		//echo $name;
		//Send Mail To Host
		//echo "hai";exit;
		$email_name = 'Incomplete_listing_host';
		$splVars    = array("{site_title}" => $this->dx_auth->get_site_title(), "{host_name}" => $name);
		$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);

		// send sms to host //		
		$msg_content = 'Dear '.$name.'. It seems that your some of the listings from '.$admin_name.' are not published or completed yet. You can contact us if you have any trouble on this and we will support you and fix the issues.';
		send_sms_user($no_user, $msg_content);
		echo $host_email."<br>";  // User email
		////////////////////// send sms to host /////////
		}	
		echo "Cron has been executed successfully";
		}else{
			echo "No related users are found";
		}

		}
exit;
}
public function new_listing_user()
{
	$arr = array();
	$query_list = "";
	$image_name = "";
	$current_date = time();
	$date_before  = strtotime('-3 days',$current_date);
    $query =    $this->db->select('id,title,user_id,room_type,country')->where("list.is_enable",'1')->where("list.status",'1')->where('created >=',$date_before)->order_by('created','desc')->get('list');
	 
	 if($query->num_rows() > 0)
	 {
	 $query_list = $query->result() ;
	 	
	 }else{	 	
	 $query_list = "";			
	 }

	if($query_list != "")
	{
		$count = 0;
		$content = "";		
		foreach ($query_list as $row) {
						
		$arr[] = $row->user_id;
					
			if($count<4)
			{
				$list_id = $row->id;
				$title = $this->dx_auth->get_site_title();
				$room_type = $row->room_type; 
				$country = $row->country;	
				//$street_address = $row->street_address;			
				$img_name = getListImage($row->id);
				$noimage = cdn_url_images()."images/no_image.jpg";
				$rooms_id = base_url()."rooms/".$list_id."";
				$image_name = $image_name.''."<div style='float: left;'><a href='".$rooms_id."'><img src=".$img_name." onerror=this.src='".cdn_url_images()."images/no_image.jpg' height='200px' width='300px' style='padding: 1px 20px'>
				<p style='padding: 0 30px; margin-top:-10px; color: #484848; text-decoration: none;'>".$room_type." in  ".$country."</p>
				</a></div>";
				$count++;
				
			}
				
		}
				
	$arr = array_unique($arr);
	$new_array = array_values($arr);  // host ids
    
    $query_user =    $this->db->select('id,username,email')->where("banned",'0')->where_not_in('id',$new_array)->get('users');
    //print_r($query_list);exit;
			foreach($query_user->result() as $row)
			{
		$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 	$admin_name  	= $this->dx_auth->get_site_title();
		$link = base_url();
		//$title = $row->title;
		$user_name = ucfirst($row->username);  // User name
		$user_email = ucfirst($row->email);  // User email
		//Send Mail To Host
		$email_name = 'new_listing_user';
		$splVars    = array("{content}" => $content,"{site_title}" => $this->dx_auth->get_site_title(), "{user_name}" => $user_name, "{user_email}" => $user_email,"{img_name}" => $image_name,"{room_type}" => $room_type, "{link}" => $link, "{country_name}" => $country,"{site_title}" => $title);
		$this->Email_model->sendMail($user_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
//print_r($list_id);exit;
echo $user_email."<br>";  // User email
			}	
		echo "Cron has been executed successfully";


		}else{
			echo 'No result found';
		}
exit;
}

}// End
?>