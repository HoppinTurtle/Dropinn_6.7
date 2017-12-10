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
class theme_select extends CI_Controller {

	//Global variable  
    public $outputData;		//Holds the output data for each view
	   
	/**
	* Constructor 
	*
	* Loads language files and models needed for this controller
	*/
	function theme_select()
	{
	
	 parent::__construct();


		//load validation library
		$this->load->library('form_validation');
		$this->load->model('common_model');
		
		//Load Form Helper
		$this->load->helper('form');
		$this->dx_auth->check_uri_permissions();

	}//Controller End 
	
		// --------------------------------------------------------------------
	function index(){
			redirect(admin_url()."/theme_select/viewtheme_select") ; 
	}
	/**
	 * Loads Faqs settings page.
	 *
	 * @access	private
	 * @param	nil
	 * @return	void
	 */
	public function viewtheme_select()
	{
		$site=array();$i=1;	

		$query = $this->db->get_where("theme_select",array("status"=>1))->row()->color;
		
		$data['get_table'] = $this->db->get("theme_select");
		$data['color']= $query ;
		$data['message']="";
	 	$data['message_element'] = "administrator/viewtheme_select";
		$this->load->view('administrator/admin_template', $data);
	   			
	}
	  /*  With Out CDN
		public function updatetheme_select()
	{
		if($this->input->post()){
		$color=$this->input->post('color');
		
		$data['status']    = 1;
		$this->db->update('theme_select', array('status' => '0'));
		$this->db->where('color', $color );
		$this->db->update('theme_select',$data);	
		$data['get_table'] = $this->db->get("theme_select");
		$data['color']= $color ;
		
		copy(css_url()."/map_icons/map_pins_sprite_001.png", FCPATH."images/map_icons/map_pins_sprite_001.png");
		copy(css_url()."/logo/logo.png", FCPATH."logo/logo.png");
		
		$this->recurse_copy(FCPATH."css_".$color."/templates/blue/overwrite_images", FCPATH."images/" ) ; 
			
		$data['message']= translate_admin("Updated Successfully");
	 	$data['message_element'] = "administrator/viewtheme_select";
		$this->load->view('administrator/admin_template', $data);
		}else{
		redirect(admin_url()."/theme_select/viewtheme_select") ;
		}
	}*/
	
	//========= With CDN ============//
	
		public function updatetheme_select()
	{
		if($this->input->post()){
		$color=$this->input->post('color');
		
		$data['status']    = 1;
		$this->db->update('theme_select', array('status' => '0'));
		$this->db->where('color', $color );
		$this->db->update('theme_select',$data);	
		$data['get_table'] = $this->db->get("theme_select");
		$data['color']= $color ;
		
		/*
		copy(css_url()."/map_icons/map_pins_sprite_001.png", FCPATH."images/map_icons/map_pins_sprite_001.png");
				copy(css_url()."/logo/logo.png", FCPATH."logo/logo.png");
				
				$this->recurse_copy(FCPATH."css_".$color."/templates/blue/overwrite_images", FCPATH."images/" ) ; */
				
		      require_once APPPATH.'libraries/cloudinary/autoload.php';
        \Cloudinary::config(array( 
                        "cloud_name" => cdn_name, 
                         "api_key" => cdn_api, 
                         "api_secret" => cloud_s_key
              ));
              
               try{
                      $cloud_mapsprite=\Cloudinary\Uploader::upload(css_url()."/map_icons/map_pins_sprite_001.png",
                           array("invalidate"=> true, "overwrite"=> true,
                                "public_id" => "images/map_icons/map_pins_sprite_001",));
                    }
                catch (Exception $e) {
                       $error = $e->getMessage();
					 //  print_r($error);
                  }
				
          $api = new \Cloudinary\Api();
	$get_allimages=	$api->resources(array("type" => "upload", "prefix" => "css_".$color."/templates/blue/overwrite_images/", "max_results"=> 15 ));
	//echo "<pre>" ; 
	$total_images = $get_allimages['resources'];
	$total_images_count = count($get_allimages['resources']);
	for($i=0; $i< $total_images_count; $i++){
				$img_url = $total_images[$i]['url'];
		 		$tmp_name = $total_images[$i]['public_id'];
                $temp = explode('/', $tmp_name);
                $name  = end($temp);
                try{
                      $cloudimage=\Cloudinary\Uploader::upload($img_url,
                           array("invalidate"=> true, "overwrite"=> true,
                                "public_id" => "images/".$name,));
                    }
                catch (Exception $e) {
                       $error = $e->getMessage();
					 //  print_r($error);
                  }
	}
	
	  		
	
		$data['message']= translate_admin("Updated Successfully");
	 	$data['message_element'] = "administrator/viewtheme_select";
		$this->load->view('administrator/admin_template', $data);
		}else{
		redirect(admin_url()."/theme_select/viewtheme_select") ;
		}
	}
	
	function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
	//Function end	
}
//End  Page Class

/* End of file Page.php */ 
/* Location: ./app/controllers/admin/Page.php */
