<?php
/**
 * DROPinn Info Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Info
 * @subpackage	Controllers
 * @category	Info
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 
 */


 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notfound extends CI_Controller {
	
 	public	function not_found()
 {
				$data['title']            = "404 page not found";
				$data["meta_keyword"]     = "";
				$data["meta_description"] = "";
			
				$data['message_element']  = 'view_notfound';
				$this->load->view('template',$data);		
	}
}