<?php
/**
 * DROPinn Admin List Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin property type
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 
 */
class Room_type extends CI_Controller
{
	function Room_type()
	{
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('form_validation');
		
		$this->load->helper('form');
		$this->load->helper('url');
 	$this->load->helper('file');
		
		$this->load->model('Users_model');
		$this->load->model('Rooms_model');

		$this->path = realpath(APPPATH . '../images');	
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	function index()
	{
		$query = $this->db->get('list');
 
		// Get offset and limit for page viewing
		$start = (int) $this->uri->segment(4,0);
		
	 // Number of record showing per page
		$row_count = 10;
		
		if($start > 0)
		   $offset			 = ($start-1) * $row_count;
		else
		   $offset			 =  $start * $row_count; 
		
		
		// Get all users
		$data['users'] = $this->db->order_by('id','asc')->get('list', $row_count, $offset)->result();
		
		// Pagination config
		$p_config['base_url']    = admin_url('room_type/index');
		$p_config['uri_segment'] = 4;
		$p_config['num_links']   = 5;
		$p_config['total_rows']  = $query->num_rows();
		$p_config['per_page']    = $row_count;
				
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links2();
		
		
	$data['message_element'] = "administrator/view_lists";
	$this->load->view('administrator/admin_template', $data);
	}
	

public function view_all_room()
	{	
		//Get Groups
		 $this->load->model('roomtype_model');
			$data['room']	=	$this->roomtype_model->getroom();
		//print_r($data['room']);exit;
		//$data['area']   =   $this->place_model->getplace1();
		
		//Load View	
	 $data['message_element'] = "administrator/room_type/view_room";
		$this->load->view('administrator/admin_template', $data);
	   
	}

	function view_room()
	{


	$data['message_element'] = "administrator/view_add_room";
	$this->load->view('administrator/admin_template', $data);

	}
	
	
public function editroom()
	{		
	
	$this->load->model('roomtype_model');

	
		//Get id of the category	
	 $id = is_numeric($this->uri->segment(4))?$this->uri->segment(4):0;
		
		//Intialize values for library and helpers	
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
		
		if($this->input->post('submit'))
		{	
           	//Set rules
			$this->form_validation->set_rules('type','Type','required|trim|xss_clean');
						
			if($this->form_validation->run())
			{	
				  //prepare update data
				  $updateData                  	  	= array();	
			   $updateData['type']  		    = $this->input->post('type');
						
				  $check = $this->db->where('type',$updateData['type'])->get('room_type');
  
  if($check->num_rows() != 0)
  {
  	$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please give different one, its already entered.')));
	redirect_admin('room_type/editroom/'.$id);
  }
				  $check_data = $this->db->where('id',$this->uri->segment(4))->get('room_type');
				  
				  if($check_data->num_rows() == 0)
				  {
				  	$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('This Room type is already deleted.')));
				  	redirect_admin('room_type/view_all_room');
				  }
				  
				  //Edit Faq Category
				  $updateKey 							= array('room_type.id'=>$this->uri->segment(4));
				  
				  $this->roomtype_model->updateroom($updateKey,$updateData);
				  
				  //Notification message
				  $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Room type updated successfully')));
				  redirect_admin('room_type/view_all_room');
		 	} 
		} //If - Form Submission End
		
		//Set Condition To Fetch The Faq Category
		$condition = array('room_type.id'=>$id);
			
	 //Get Groups
		$data['room']	=	$this->roomtype_model->getroom($condition);

         if($data['room']->num_rows() == 0)
          {
          	$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('This Room type is already deleted.')));
          	redirect_admin('room_type/view_all_room');
          }
			//Load View	
	 $data['message_element'] = "administrator/room_type/edit_room";
		$this->load->view('administrator/admin_template', $data);
   
	}

	
	
	public function delete_room()
	{	
	$this->load->model('roomtype_model');
	$id = $this->uri->segment(4,0);
		
	if($id == 0)	
	{
		$getproperty	 =	$this->roomtype_model->getroom();
		$propertylist  =   $this->input->post('roomlist');
		if(!empty($propertylist))
		{	
				foreach($propertylist as $res)
				 {
					$condition = array('room_type.id'=>$res);
					$this->roomtype_model->deleteroom(NULL,$condition);
				 }
			} 
		else
		{
		$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please select Room type')));
	 redirect_admin('room_type/view_all_room');
		}
	}
	else
	{
		$getproperty	 =	$this->roomtype_model->getroom();
		$result = $this->db->where('room_id',$id)->get('list');
		if($result->num_rows() != 0)
		{
			//Notification message
		$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('This Room type is used by some lists.')));
		redirect_admin('room_type/view_all_room');
		}
		if($getproperty->num_rows() > 3)
		{
	$condition = array('room_type.id'=>$id);
	$this->roomtype_model->deleteroom(NULL,$condition);
	//Notification message
		$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Room Type deleted successfully')));
		redirect_admin('room_type/view_all_room');
	}
		else {
			//Notification message
		$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin("Minimum Room type is 3. So you aren't able to delete.")));
		redirect_admin('room_type/view_all_room');
		}
	}		
		//Notification message
		$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Room Type deleted successfully')));
		redirect_admin('room_type/view_all_room');
	}

    function addroom()
  {
  $prop = $this->input->post('addroom'); 
  $property=trim($prop);
   
  if(empty($property))
			{
			 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Sorry, You have to select atleast one!')));
				redirect_admin('room_type');
			}else
			{
			$nul ="NULL";
			$data = array(
											'id'         => NULL,
											'type'       => $this->input->post('addroom')
											
											);
			$this->Common_model->insertData('room_type',$data);
		
			echo "<p>Additional Room type added successfully</p>";
			
			}
			
  }
  
  
    function addrooms()
  {
  $prop = $this->input->post('addroom'); 
  $property=trim($prop);
  
   $check = $this->db->where('type',$property)->get('room_type');
  
  if($check->num_rows() != 0)
  {
  	$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please give different one, its already entered.')));
	redirect_admin('room_type/view_room');
  }
  
  if(empty($property))
			{
			 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Sorry, You have to fill all fields!')));
				redirect_admin('room_type/view_room');
			}else
			{
			$nul ="NULL";
			$data = array(
											'id'         => NULL,
											'type'       => $this->input->post('addroom')
											
											);
			$this->Common_model->insertData('room_type',$data);
			
			 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Room type added successfully!')));
			redirect_admin('room_type/view_all_room');
			
			}
			
  }
	
}
?>
