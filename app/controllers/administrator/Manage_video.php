<?php
/**
 * Dropinn system page Class
 *
 * Permits admin to handle the FAQ System of the site
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Skills 
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @created		December 22 2008
 * @link		http://www.cogzidel.com
 
 */
class Manage_video extends CI_Controller
{
	function index()
	{
			if (!$this->dx_auth->is_logged_in())
			{
				redirect_admin('login','refresh');
			}else {		
					if($this->input->post()){
						
						if($_FILES["media"]["name"])
								{
									
									 
									
				 require_once APPPATH.'libraries/cloudinary/autoload.php';
                \Cloudinary::config(array( 
                  "cloud_name" => cdn_name, 
                  "api_key" => cdn_api, 
                  "api_secret" => cloud_s_key
                ));
				$temp1 = explode('.', $_FILES["media"]["name"]);
                $ext1  = array_pop($temp1);
                $name2 = implode('.', $temp1);
        
                try{
                    $cloudimage=\Cloudinary\Uploader::upload($_FILES["media"]["tmp_name"],
                    array("public_id" => "uploads/home/".$name2, "resource_type" => "video"));
					//print_r($cloudimage);exit;
								$media = $this->db->get_where('settings', array('code' => 'MANAGE_VIDEO'))->row()->string_value;
								$real_logo = $this->path.'/uploads/home/'.$media;	
								$file_name    = $upload_data['file_name'];
								$data1['string_value']    = $_FILES["media"]["name"];
								$this->db->where('code', 'MANAGE_VIDEO');
								$this->db->update('settings',$data1);
								$data2['int_value']    = 0;
								$this->db->where('code', 'MANAGE_VIDEO');
								$this->db->update('settings',$data2);
								$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success',translate_admin('Video uploaded successfully')));
								redirect_admin('Manage_video');
								
                }
                catch (Exception $e) {
                    $error = $e->getMessage();
					//print_r($error = $e->getMessage());exit;
					echo "<script>alert('Unsupported File Type');</script>";
                    }
				}
else
	{
		//$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error',translate_admin('Please Upload Correct File or MP4 Video')));
										//redirect_admin('Manage_video');
	}
			
					}			
                     
	 $data['message_element'] = "administrator/View_Manage_video";
	 $this->load->view('administrator/admin_template', $data);
	 
}
}
}
?>