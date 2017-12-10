<?php
/**
 * DROPinn Admin Contact Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Contact
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com
 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Popup extends CI_Controller {

	public function Popup() {
		parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('form_validation');

		$this->load->model('Users_model');	
		$this->load->model('faq_model');			
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	
	public function index()
	{
	  
	    
        $data['popup']        = $this->Common_model->getTableData('page_popup');
	    
		$data['message_element'] = "administrator/view_popup";
		$this->load->view('administrator/admin_template', $data);
		
	}
		function addpopup()
	{
		
		
		if($this->input->post())
		{	
			  //prepare insert data
				  $insertData                  	   = array();
				  $insertData['name'] 		       = $this->input->post('page_name');
				  $insertData['content']      = $this->input->post('page_content');
                  $insertData['status']      	   =  $this->input->post('page_status');
						
				  //Add Groups
				  $this->faq_model->addpopup($insertData);
				  
				  //Notification message
				  $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Added successfully'));
				  redirect_admin('popup');
		 	 
		} //If - Form Submission End
		
		//Load View
		$data['message_element'] = 'administrator/addpopup';
		$this->load->view('administrator/admin_template',$data);
	
	}//Function addPage End 
	
    	public function editpopup($param = '')
	{ 
		if($this->input->post())
		{

			
	  		$id                         = $this->uri->segment(4,0);
		 
			$updateData 	               = array();
			$updateData['name']         = $this->input->post('page_name');
			$updateData['content']  = $this->input->post('page_content');
			$updateData['status']  = $this->input->post('page_status');
	
			
			$condition                  = array('id' => $id);
			$this->Common_model->updateTableData('page_popup', $id, $condition, $updateData);
			
	 	$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Updated successfully.'));
	    redirect_admin('popup'); 
			
		}
		
	$conditions				= array("page_popup.id" => $param);
	$data['popups']			= $this->Common_model->getTableData('page_popup',$conditions)->row();
	$conditions				= array("page_popup.id" => $param);
	
	$data['message_element'] = "administrator/editpopup";
	
	$this->load->view('administrator/admin_template',$data);
	}
		function delete_record()
	{
		$table_name=$this->input->post("delete_record");
		
		$current_id=$this->input->post("id");
		
		$result=$this->db->delete($table_name, array('id' => $current_id)); 
		
		if($result)
			echo $current_id;
		else
			echo 0;
		exit;
	}

	}
