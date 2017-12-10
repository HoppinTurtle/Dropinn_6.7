<?php
/**
 * DROPinn Admin Google_Analytics Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Social
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_Analytics extends CI_Controller
{

	public function Google_Analytics()
	{
			parent::__construct();
			$this->load->library('form_validation');
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	public function index()
	{
			
	  	if($this->input->post('update'))
		{
			$this->form_validation->set_rules('google_analytics', 'Google Account Client ID', 'required');
			
			if($this->form_validation->run())
						{
								
			$google_analytics['transaction_id'] = $this->input->post('google_analytics');
			$this->db->update('google_analytics',$google_analytics);
			$data['message_element'] = "administrator/google_analytics";
			
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Changes successfully updated')));
	        redirect_admin('Google_Analytics');
	        }
else {
	$data['message_element'] = "administrator/google_analytics";
	$this->load->view('administrator/admin_template', $data);
}
	      //  $this->load->view('administrator/admin_template', $data);
			
		}
		else
		{
	   $google_analyze = $this->db->select('transaction_id')->get('google_analytics')->row()->transaction_id;
		$data['message_element'] = "administrator/google_analytics";
	 $this->load->view('administrator/admin_template', $data);
		
		
		}
   		

	}
	
	
}

?>
