<?php
class Superhost extends CI_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;
	
	function Superhost()
	{
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->helper('security');
		$this->load->helper('form');
		$this->load->helper('url');
 		$this->load->helper('file');
		// Export CSV
		$this->load->helper('download');
		// Export CSV

		$this->path = realpath(APPPATH . '../images');
		
		$this->load->model('Users_model');	
	   $this->load->model('Contacts_model');		
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	
	function index()
	{
		
		if($this->input->post('Accept')){
			if($this->input->post('checkbox_')){
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Updated Successfully!')));
			$userid= $this->input->post('checkbox_');	
			$this->db->query('Update `users` SET `superhost`=1 where `id`='.$userid);
				header("Refresh:0");
			}
		else{
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please Select atleast one!')));
				header("Refresh:0");
			}
			}
		if($this->input->post('Decline'))
			{
			if($this->input->post('checkbox_'))
			{
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Removed Successfully!')));
			$userid= $this->input->post('checkbox_');
			$this->db->query('Update `users` SET `superhost`=0 where `id`='.$userid);
				header("Refresh:0");
			
			}
			else
			{
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please Select atleast one!')));
				header("Refresh:0");
			}
			}
		
		$this->db->select('');
		$users=$this->db->get('users')->result_array();
		//print_r($users); exit;		
		foreach($users as $use){
			$this->db->select();
			$this->db->where('userto',$use['id'])->where('status',10);
			$total_reserv=$this->db->get('reservation')->num_rows(); 
			$total_reservation[$use['id']]=$total_reserv;
			
	}
//print_r($total_reservation);
	foreach($users as $user){
		$this->db->select();
		$this->db->where('userto',$user['id'])->where('status',5);
		$this->db->or_where('userto',$user['id'])->where('status',6);
		$this->db->or_where('userto',$user['id'])->where('status',11);
		$this->db->or_where('userto',$user['id'])->where('status',12);
		$total_can=$this->db->get('reservation')->num_rows();
		$total_cancel[$user['id']]=$total_can;
		
	}
	//	print_r($total_cancel);
		foreach($users as $ruser){
			$this->db->select();
			$this->db->where('userto',$ruser['id']);
			$review=$this->db->get('reviews')->num_rows();
			$total_reviews[$ruser['id']]=$review;
			
		}
	//	print_r($total_reviews);
		foreach($users as $fuser){
			$this->db->select();
			$this->db->where('userto',$fuser['id']);
			$this->db->where('communication',5);
			$this->db->where('cleanliness',5);
			$this->db->where('accuracy',5);
			$this->db->where('checkin',5);
			$this->db->where('location',5);
			$this->db->where('value',5);
			
			$five_review=$this->db->get('reviews')->num_rows();
			$total_five[$fuser['id']]=$five_review;
		}

	//	print_r($total_five);
		foreach($users as $puser){
			$this->db->select('username','email','role_id');
			$this->db->where('id',$puser['id']);
			$total_prof=$this->db->get('users');
			$total_profile[$puser['id']]=$total_prof;			
		}
		foreach($users as $suser){
		if($total_reservation[$suser['id']]>=10 && $total_cancel[$suser['id']]==0 && $total_reviews[$suser['id']]>=(0.5*$total_reservation[$suser['id']]) 
		&& $total_five[$suser['id']] >= (0.8*$total_reviews[$suser['id']]) ){
			$superid[]=$suser['id'];
		}
		}
		//print_r($total_profile);
		//$data['superid']=$superid;
		if($this->input->post('Search')){
		$keyword=$this->input->post('search');
			//$this->db->like('username',$keyword);
			$this->db->select('id');
			for($i=0; $i<count($superid); $i++)
			{
				if($i=0){
				$this->db->where('id',$superid[$i])->like('username',$keyword);	
				
				}
				else{
					$this->db->or_where('id',$superid[$i])->like('username',$keyword);
					
				}
			
			}
			
			//$this->db->like('email',$keyword);
			$filter_id=$this->db->get('users')->row();
			//echo $this->db->last_query(); exit;
			foreach($filter_id as $filter){
				$searched[]=$filter;
			}
			
			
				$data['searched']=$searched;
				
				
		}
else{
	$data['superid']=$superid;
}
		
$data['message_element'] = "administrator/members/view_superhost";
$this->load->view('administrator/admin_template',$data);


			
				
}


	
} // Class
?>
