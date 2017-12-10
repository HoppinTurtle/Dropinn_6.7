<?php
/**
 * DROPinn Users Controller Class
 *
 * It helps shows the home page with slider.
 *
 * @package		Users
 * @subpackage	Controllers
 * @category	Referrals
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 */
	
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

		public $stripe_secret;
 		public $stripe_pub;   

		//Constructor
		public function Home()
		{
			parent::__construct();
		//	$this->output->enable_profiler(TRUE);
	$this->load->database();
	$this->load->model('Common_model');
			
		
		$this->load->helper('url');
		
		$this->load->library('DX_Auth');  
			
			if($this->uri->segment(1)=="rooms"){
			
				$jh = $this->uri->segment(2);
				if(!is_numeric ($jh)){
					redirect('info');
				}
			}
			
			
			require_once APPPATH.'libraries/stripe/lib/Stripe.php';
		
			$SecretKey      = $this->db->get_where('payment_details', array('code' => 'SecretKey'))->row()->value;
			$PublishableKey       = $this->db->get_where('payment_details', array('code' => 'PublishableKey'))->row()->value;
			$LSecretKey      = $this->db->get_where('payment_details', array('code' => 'LSecretKey'))->row()->value;
			$LPublishableKey       = $this->db->get_where('payment_details', array('code' => 'LPublishableKey'))->row()->value;
			$paymode     = $this->Common_model->getTableData('payments', array('payment_name' => 'Stripe'))->row()->is_live;
			if($paymode == 0)
			{
				$this->stripe_secret = $SecretKey;
				$this->stripe_pub = $PublishableKey; 
			}
			else {
				$this->stripe_secret = $LSecretKey ; 	
				$this->stripe_pub = $LPublishableKey ;
			}
		
		$this->load->database();
		
		$this->config_data->db_config_fetch();
		
		//Manage site Status 
		if($this->config->item('site_status') == 1)
		{
			redirect('maintenance');
		}			
	    $this->load->model('Common_model');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('cookie');
			$this->load->library('twconnect');
			$this->load->library('Form_validation'); 
			$this->load->library('Pagination');
			
			$this->load->model('Referrals_model');
			$this->load->model('Message_model');
			$this->load->model('Rooms_model');
			$this->load->model('Trips_model');
			$this->load->model('Users_model');
		    $this->load->model('Email_model');
			$this->facebook_lib->enable_debug(TRUE);
		}

	
		public function index()
		{		
			$conditions                 = array("list.is_featured" => 1, "list.is_enable" => 1, "list.status" => 1, "list_photo.is_featured" => 1,"list_photo.is_featured" => 1,"list.banned" =>0);
			$limit                      = array(30);
			$data['lists']              = $this->Rooms_model->get_rooms_byImage($conditions, NULL, $limit);
		
			$limit                      = array(3);
			$orderby                    = array("id", "desc");
			$conditionL                 = array("list.is_enable" => 1, "list.status" => 1);
			$data['latest_ads']         = $this->Rooms_model->get_rooms($conditionL, NULL, $limit, $orderby);
			$site_title= $this->db->query("select `string_value` from `settings` where `id`=1")->row()->string_value;
			$site_slogan= $this->db->query("select `string_value` from `settings` where `id`=2")->row()->string_value;
			
					
		$this->db->distinct()->select('neigh_city.city_name')->select('neigh_city.id')->where('neigh_city.is_home',1);
$this->db->from('neigh_city');

$data['cities']  = $this->db->get();
			  
			// Advertisement popup 1 start
			$data['media']=$this->Common_model->getTableData('settings', array('code' => 'MANAGE_VIDEO'))->row()->string_value;
			$data['PagePopupContent'] = GetPagePopupContent('home');
			$data['site_title']=$site_title;
			$data['site_slogan']=$site_slogan;
			// Advertisement popup 1 end
			
			
			$data["title"]              = $this->dx_auth->get_site_title();
			$data["meta_keyword"]       = $this->Common_model->getTableData('settings', array('code' => 'META_KEYWORD'))->row()->string_value;
			$data["meta_description"]   = $this->Common_model->getTableData('settings', array('code' => 'META_DESCRIPTION'))->row()->string_value;
			$data['message_element']    = "home/view_home";
			$this->load->view('template', $data);	
		}
		

  //Ajax page
		public function view_most()
	 {
		  $view_most = $this->input->post('view');
				
				if($view_most == 'most_viewed')
				{
				$conditions     = array("list.is_enable" => 1, "list.status" => 1);
				$limit          = array(4);
	  	$orderby        = array("page_viewed", "desc");
	  	$data['mosts']  = $this->Rooms_model->get_rooms($conditions, NULL, $limit, $orderby);
				
				}
				else if($view_most = 'most_booked')
				{
				$conditions    	= array('reservation.status >=' => 8);
				$limit          = array(4);
				$data['mosts']  = $this->Trips_model->get_reservation_most($conditions, NULL, $limit);
				
				}
				else
				{
				$conditions     = array('status'=> 1, 'review !='=> 0);
				$limit          = array(4);
				$orderby        = array('review','desc');
	  	$data['mosts']  = $this->Rooms_model->get_rooms($conditions, NULL, $limit, $orderby);
				
				}
				
				$this->load->view(THEME_FOLDER.'/home/view_most', $data);
		}
		     
			
			
 	public	function not_found()
 {
				$data['title']            = "404 page not found";
				$data["meta_keyword"]     = "";
				$data["meta_description"] = "";
			
				$data['message_element']  = 'view_notfound';
				$this->load->view('template',$data);		
	}
			
	public function dashboard()
	{
	 
	 if($this->uri->segment(3) != '')
	 {
	 	//redirect('info/deny');
	 }
		
		if( ( $this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()))
		{	

		
			$details                 = $this->Referrals_model->get_details_refamount('165');
   
			if($details->num_rows() == 0)
			{
			$data['travel_credit']   = 0;
			}
			else
			{
			$amount                  = $details->row()->amount;
			$data['travel_credit']   = $amount;
			}
			
			$conditions              = array("messages.userto" => $this->dx_auth->get_user_id(), "messages.is_read !=" => 1);
			$check      = $this->Message_model->get_messages($conditions, NULL, array('messages.id','desc'));
			
			if($check->num_rows()!=0)
			{
				foreach($check->result() as $row)
				{
					$result = $this->db->where('id',$row->list_id)->get('list');
					if($result->num_rows() == 0)
					{
						//$this->db->delete('messages',array('list_id'=>$row->list_id));
					}
				}
			}
			
			$conditions              = array("messages.userto" => $this->dx_auth->get_user_id(), "messages.is_read !=" => 1);
			$query_msg     = $this->Message_model->get_messages($conditions, NULL, array('messages.id','desc'));
			
			$conditions              = array("messages.userto" => $this->dx_auth->get_user_id(), "messages.is_read" => 0);
			$data['new_notify_rows'] = $this->Message_model->get_messages($conditions)->num_rows();
		 	
		 	$query                   = $this->Common_model->getTableData( 'profiles',array('id' => $this->dx_auth->get_user_id()) )->row();
			
		 	if($this->dx_auth->get_username() == "")
			{
				$data['name']            = $query->Fname.' '.$query->Lname;
			}
   			else
			{
			$data['name']            = $this->dx_auth->get_username();
			}
			
			$param = (int) $this->uri->segment(4,0);
		
		 // Number of record showing per page
		$data['row_count'] = 10;
		
		if($param > 0)
		   $data['offset']			 = ($param-1) * $data['row_count'];
		else
		   $data['offset']			 =  $param * $data['row_count']; 
		
		$this->db->limit($data['row_count'],$data['offset']);
		$conditions              = array("messages.userto" => $this->dx_auth->get_user_id(), "messages.is_read !=" => 1);
		$data['new_notify']     = $this->Message_model->get_messages($conditions, NULL, array('messages.id','desc'),array($data['row_count'],$data['offset']));
		
			// Pagination config
		$p_config['base_url']    = site_url('home/dashboard/index');
		$p_config['uri_segment'] = 4;
		$p_config['num_links']   = 5;
		$p_config['total_rows']  = $query_msg->num_rows();
		$p_config['per_page']    = $data['row_count'];
				
		// Init pagination
		$this->pagination->initialize($p_config);
				
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links2();
		if(isset($query->phnum))
		{
			$data['phone_number'] = substr($query->phnum,-2);	
		}
		else 
		{
			$data['phone_number'] = 0;
		}
		if(isset($data['referral_code']))
		{	
            $data['referral_code'] = $this->db->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_code;
        }else {
        	$data['referral_code'] =0;
        }	
			$data['verification']  = $this->db->where('id',$this->dx_auth->get_user_id())->get('users')->row();
			$data['payout'] = $this->db->where('user_id',$this->dx_auth->get_user_id())->get('payout_preferences');
			$data['title']           = get_meta_details('Dashboard','title');
			$data["meta_keyword"]    = get_meta_details('Dashboard','meta_keyword');
			$data["meta_description"]= get_meta_details('Dashboard','meta_description');
			$data['message_element'] = "home/view_dashboard";
			$data['fb_app_id'] = fb_api;
			$data['fb_app_secret'] = fb_secret;
			$this->load->view('template', $data);
			//$this->load->view(THEME_FOLDER.'/home/view_dashboard',$data);
		}
		else
		{
			redirect('users/signin');
	    }
	}
function fun_invite_mail()
	{
	
	  if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()))
			{
		 	$this->load->library('email');
			
	   $username    = $this->dx_auth->get_username();
	  
	   $user_id     = $this->dx_auth->get_user_id(); 
      
	   if($this->input->post())
	   {
	   	$message = $this->input->post('msg');
		$count = count($this->input->post());
        $referral_code = $this->db->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_code;
				//$xss_email       = $this->security->xss_clean($this->input->post('email_id')); 
			$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
				for($i=1; $i<=$count; $i++)
			{
				$this->form_validation->set_rules("email_id1", 'Email', 'trim|xss_clean|callback__check_user_email');
			}
				if($this->form_validation->run())
		{	
            for($i=1; $i<=$count; $i++)
			{
				//$this->form_validation->set_rules("email_id$i", 'Email', 'trim|xss_clean|callback__check_user_email');
				
				$email_to = $this->input->post('email_id'.$i);
								
						
				$admin_email = $this->dx_auth->get_site_sadmin();
				$session_lang = $this->session->userdata('locale');
				if($session_lang == "") {
				$email_name  = 'invite_friend';}
				else {$email_name  = 'invite_friend_'.$session_lang;}
				$mailer_mode = $this->Common_model->getTableData('email_settings', array('code' => 'MAILER_MODE'))->row()->value;
				
				if($mailer_mode == 'html')
				{
					$anchor      = anchor(base_url()."users/signup?airef=".$referral_code,'Click here');
				}
				else
					{
				$anchor      = 'Click this link'.'  '.base_url()."users/signup?airef=".$referral_code;
					}
							
			    $splVars     = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($username), "{click_here}" => $anchor, "{dynamic_content}" => $message);
					
											//Send Mail
											$this->Email_model->sendMail($email_to,$admin_email,$this->dx_auth->get_site_title(),$email_name,$splVars);	
											}
								
								$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success',translate('Mail sent successfully.')));		
								redirect('referrals');
					
				}
			
			$data['title']               = get_meta_details('Invite Friends Via Email','title');
			$data["meta_keyword"]        = get_meta_details('Invite Friends Via Email','meta_keyword');
			$data["meta_description"]    = get_meta_details('Invite Friends Via Email','meta_description');
			
			$data['message_element']     = "home/referrals";
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',translate('You are enter the already user email address.')));
			redirect('referrals');
			$this->load->view('template',$data);
	 }
	 else
	 {
 		redirect('users/signin');
	 }
			
	}
	}
function _check_user_email($email)
	{
		if ($this->dx_auth->is_email_available($email))
		{
			return true;			
		} 
		else 
		{
			$this->form_validation->set_message('_check_user_email', translate('Sorry this email has already been registered'));
			return false;
		}//If end 
	}	
function fun_invite_fb()
{
			$fb_app_id = fb_api;
			$fb_app_secret = fb_secret;
			$user_fb_id = $this->input->post('fb_id'); 
			$img_path=base_url().'images/close_red.png';
			echo '<script type="text/javascript">
			$("#close_fb").click(function(){
	$("#overlay_form_fb").fadeOut(500);
});</script>';
			echo "<div class='fb_popup_css'><div class='overlay_form_fb'><img src='".$img_path."' alt='quit' class='close_fb' id='close_fb'/>";
	     $facebook = array(
            'appId'  => $fb_app_id,
            'secret' => $fb_app_secret,
            'cookie' => true
        );
        $this->load->library('facebook',$facebook);
  $user = $user_fb_id;
if($user){
	try{
		//get the facebook friends list
	  $user_friends = $this->facebook->api('/'.$user.'/friends');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
	}		
}
if(isset($user_friends)){ 
echo '<h2> Facebook Friends List </h2> 
<div class="demo">';
	foreach($user_friends['data'] as $user_friend)
	{
echo '<br><table><tr><td>
<img src="https://graph.facebook.com/'.$user_friend["id"].'/picture" width="30" height="30"/></td><td>
<div  class="frnd_list">'.$user_friend["name"].'</td><td><a href="#" style="text-decoration: none" onclick="send_invitation('.$user_friend["id"].');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invite </a></div>
</td></tr></table>';
 }
}
else
{
	echo 'Sorry! You are not loggedin or you have no friends';
	}
	echo '</div></div></div>';
}
function popular()
{
	
	$result = $this->Common_model->popular();
	
	$data['shortlist'] = $result;
	$data['title']               = get_meta_details('Popular','title');
	$data["meta_keyword"]        = get_meta_details('Popular','meta_keyword');
	$data["meta_description"]    = get_meta_details('Popular','meta_description');
			
	$data['message_element']     = "home/view_popular";
	$this->load->view('template',$data);
}


function neighborhoods()
{
	        $conditions                 = array("list.is_featured" => 1, "list.is_enable" => 1, "list.status" => 1, "list_photo.is_featured" => 1,"list_photo.is_featured" => 1);
			$data['lists']              = $this->Rooms_model->get_rooms_byImage($conditions, NULL); 
			//print_r($data['lists']->result());
	        $data['title']               = get_meta_details('Neighborhoods','title');
			$data["meta_keyword"]        = get_meta_details('Neighborhoods','meta_keyword');
			$data["meta_description"]    = get_meta_details('Neighborhoods','meta_description');
						
		$this->db->distinct()->select('neigh_city.city_name')->select('neigh_city.id')->select('neigh_city.image_name')->where('neigh_city.is_home',1);
$this->db->from('neigh_city');
$this->db->join('neigh_city_place', 'neigh_city_place.city_name = neigh_city.city_name'); 
$this->db->join('neigh_post', 'neigh_post.city = neigh_city_place.city_name'); 
$this->db->where('neigh_city_place.is_featured',1)->where('neigh_post.is_featured',1);
$data['cities']  = $this->db->get();
//echo '<br>=========<br>';
//print_r($data['cities']->result());exit;
			
			$data['message_element']     = "home/view_neighborhoods";
			$this->load->view('template',$data);
}
function friends()
{
	 $data['fb_app_id'] = fb_api;
	 
//	if( ( $this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()))
//		{
		//	$data['name']  	= $this->dx_auth->get_username();
	        $data['title']               = get_meta_details('Friends','title');
			$data["meta_keyword"]        = get_meta_details('Friends','meta_keyword');
			$data["meta_description"]    = get_meta_details('Friends','meta_description');
			
			$data['message_element']     = "home/view_friends";
			$this->load->view('template',$data);
/*		}
	else
		{
			$this->session->set_userdata('redirect_to', 'home/friends');
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',translate('You must logged in.')));
			redirect('users/signin');
		}*/
}
 function email_exists($email)
		{
			$query = $this->Common_model->getTableData('users', array('email' => $email));
			$q     = $query->num_rows();
			if($q == 1)
				return TRUE;
			else return FALSE;
		}
		function ajax_email_exists()
		{
			$email = $this->input->post('email');
			//echo $email;exit;
			$query = $this->Common_model->getTableData('users', array('email' => $email));
			$q     = $query->num_rows();
			if($q == 1)
				echo '0';
			else 
			echo '1';
		}
		 function fb_exists($id)
		{
			$query = $this->Common_model->getTableData('users', array('fb_id' => $id));
			$q     = $query->num_rows();
			if($q == 1)
				return TRUE;
			else return FALSE;
		}
function fun_friends_fb_id()
{
	
	$id = $this->input->post('fb_id');
	$name = $this->input->post('fb_name');
	$friends_count = $this->input->post('friends_count');
	
	$i=0;  // Count for fb user contained Lists
	
	if($id != '')
	{
	foreach($id as $fb_id)
	{
		
	$result = $this->db->select('*')->where('fb_id',$fb_id)->from('users')->get();
	
	if($result->num_rows() != 0)
	{
		
		$user_id = $result->row()->id; 
		
		$list_user_id = $this->db->where('user_id',$user_id)->get('list');
		
			if($list_user_id->num_rows() != 0)
			{
				 $i++;
				foreach($list_user_id->result() as $list_row)
				{
					$conditions              = array('list_id' => $list_row->id);
					$limit                   = array(1);
			        $result_img          = $this->Gallery->get_imagesG(NULL, $conditions,$limit);
					
					if($result_img->num_rows()!=0)
					{
						foreach($result_img->result() as $image)
   						{
   							
						 	echo '<div class="fb_main"><a href="'.base_url().'rooms/'.$image->list_id.'">
					       <img src="'.base_url().'images/'.$image->list_id.'/'.$image->name.'" width="995" height="427"/></a>';
																
						}
			     }
					else {
					echo '<div class="fb_main"><a href="'.base_url().'rooms/'.$list_row->id.'">
					<img src="'.base_url().'images/no_image.jpg" width="995" height="427"/></a>';
						
					}
					    echo '<div class="connect_fb">';
						echo '<img src="https://graph.facebook.com/'.$fb_id.'/picture" width="30" height="30"/><br>'.$result->row()->username.' Saved<br>';
						echo '<a class="fb_title" href="'.base_url().'rooms/'.$list_row->id.'">'.$list_row->title.'</a><br></div>';
						echo '<div class="fb_price_bg"><div class="fb_price"><p class="fb_dollar">'.get_currency_symbol($list_row->id).'<p>'.get_currency_value1($list_row->id,$list_row->price).'<br><p class="per_night">'.translate('per night').'</p></div></div></div>';
			     }
			    }

			 }
}
}
if($i == 0)
{
	echo '<br><br><div class="list-view" data-feed-container="">
<div class="no-fb-friends-container">
<h2 style="font-size: 24px; line-height: 1.5;">'.translate('Looks like none of your friends have signed up for').' '.$this->dx_auth->get_site_title().' '.translate('yet.').'</h2>
<br><a class="btn_list" href="'.base_url().'referrals/">'.translate('Invite them now').'!</a>
</div>
</div>';
}
      
/*else {
	echo '<br><br><img src="'.base_url().'images/page2_spinner.gif">';
}*/
}
function help($refer='', $pages='')
{
	$query = $this->db->where('status',0)->where('id',$refer)->get('help');
	
	if($query->num_rows() == 0)
	{
		$query = $this->db->where('status',0)->where('page_refer',$refer)->get('help');
	}
	
	$page = $this->Common_model->getHelpData('help',array('page_refer' => $pages));
	$guide = $this->Common_model->getHelpData('help',array('page_refer' => 'guide'));
	$result = $this->Common_model->getHelpData('help');
	
	$home_help = $this->db->where('page_refer','home')->where('status',0)->get('help');
	
	if($home_help->num_rows() != 0)
	{
		$data['home_help_value'] = $home_help->row()->page_refer;
	}
	
	$guide_help = $this->db->where('page_refer','guide')->where('status',0)->get('help');
	
	if($guide_help->num_rows() != 0)
	{
		$data['guide_help_value'] = $guide_help->row()->page_refer;
	}

$account_help = $this->db->where('page_refer','account')->where('status',0)->get('help');
	
	if($account_help->num_rows() != 0)
	{
		$data['account_help_value'] = $account_help->row()->page_refer;
	}

$dashboard_help = $this->db->where('page_refer','dashboard')->where('status',0)->get('help');
	
	if($dashboard_help->num_rows() != 0)
	{
		$data['dashboard_help_value'] = $dashboard_help->row()->page_refer;
	}
	
		if($query->num_rows() == 0)
			{
				if($guide->num_rows()!=0)
			{
			$row_guide=$guide->row();
			
			$data['guide_question']								= $row_guide->question;
			$data['guide_description']							= $row_guide->description;
			$data['guide_status']                               = $row_guide->status;
			}
			$data['question'] 								    = '';
			$data['description'] 								= '';
			$data['page_refer'] 								= '';
			$data['result'] 								= $result;
			$data['guide'] 								= $guide;
			$data['title']               = get_meta_details('Help','title');
			$data["meta_keyword"]        = get_meta_details('Help','meta_keyword');
			$data["meta_description"]    = get_meta_details('Help','meta_description');
			$data['message_element'] 					= 'view_help';
			$this->load->view('template',$data);	
			}
			else
			{
				
			$row = $query->row();
			if($guide->num_rows()!=0)
			{
			$row_guide=$guide->row();
			
			$data['guide_question']								= $row_guide->question;
			$data['guide_status']                               = $row_guide->status;
			$data['id']                                     	=$row_guide->id;
			}
			$data['question'] 								    = $row->question;
			$data['description'] 								= $row->description;
			$data['page_refer'] 								= $row->page_refer;
			$data['result'] 								= $result;
			$data['guide'] 								= $guide;
			$data['title']               = get_meta_details('Help','title');
			$data["meta_keyword"]        = get_meta_details('Help','meta_keyword');
			$data["meta_description"]    = get_meta_details('Help','meta_description');
			$data['message_element'] 					= 'view_help';
			$this->load->view('template',$data);	
			}
}
function verify()
{
	 if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()))
		{
			$data['users'] = $this->db->where('id',$this->dx_auth->get_user_id())->from('users')->get()->row();
			$data['profiles'] = $this->db->where('id',$this->dx_auth->get_user_id())->from('profiles')->get()->row();
			$data['phone_number'] = substr($data['profiles']->phnum,-2);
			
		 $data['country'] = $this->Common_model->getTableData('country');
		 $data['user_id']             = $this->dx_auth->get_user_id();
		 $data['profile']             = $this->Common_model->getTableData('profiles', array('id' => $data['user_id']))->row();
			
			$data['fb_app_id'] = fb_api;
			$data['fb_app_secret'] = fb_secret;
			$data['google_app_id'] = google_client_id;
			$data['title']               = get_meta_details('Verify','title');
			$data["meta_keyword"]        = get_meta_details('Verify','meta_keyword');
			$data["meta_description"]    = get_meta_details('Verify','meta_description');
			$data['message_element'] 					= 'home/verify';
			$this->load->view('template',$data);		
		}	
	 else {
		 redirect('users/signin');
	 }
           
}
function help_autocomplete()
{
	    $val = $this->input->get('val');
		$result = $this->db->where('status',0)->like('question',$val)->get('help');
		foreach($result->result() as $row)
		{
			$question[] = $row->question;
		}
		echo json_encode($question);
}
function help_id()
{
	$val = $this->input->get('val');
		$result = $this->db->where('question',$val)->get('help');
		$question_id = '';	
		foreach($result->result() as $row)
		{
			$question_id = $row->id;
		}
		echo $question_id;
}

public function logout()
{
	$data["title"]               = get_meta_details('Logout_Shortly','title');
				$data["meta_keyword"]        = get_meta_details('Logout_Shortly','meta_keyword');
				$data["meta_description"]    = get_meta_details('Logout_Shortly','meta_description');
				
				$is_banned = $this->db->where('id',$this->dx_auth->get_user_id())->where('banned',1)->get('users')->num_rows();

			$this->dx_auth->logout();  
			$user = array(					
			'DX_user_id'						       => '',
			'DX_username'						      => '',
			'DX_emailId'						       => '',
			'DX_refId'						         => '',
			'DX_role_id'						       => '',			
			'DX_role_name'					      => '',
			'DX_parent_roles_id'		   => '',	// Array of parent role_id
			'DX_parent_roles_name'	  => '', // Array of parent role_name
			'DX_permission'					     => '',
			'DX_parent_permissions'	 => '',			
			'DX_logged_in'					      => TRUE
		);
			$this->session->unset_userdata($user);
			$this->session->unset_userdata('image_url');
						
				if( $this->facebook_lib->logged_in() )
				{
					$facebook->destroySession();       
                     $this->session->sess_destroy();
				}
	redirect('');
}


function get_notifycount(){
	
set_time_limit(0);

while ( true )
{
	$current_count = isset ( $_GET [ 'count' ] ) ? ((int)$_GET [ 'count' ]>0 ? (int)$_GET [ 'count' ]:'null' ) : null;
	
	// o PHP faz cache de operações "stat" do filesystem. Por isso, devemos limpar esse cache
	clearstatcache();
	$count = $this->Message_model->get_messages(array('messages.userto'=>$this->dx_auth->get_user_id(),'messages.is_read'=>0))->num_rows();
	
	if ( $current_count === null || $count > $current_count )
	{
		
		$arrData = array(
			'count' => $count
		);		

		$json = json_encode( $arrData );

		echo $json;

		break;
	}
	else
	{
		sleep( 1 );
		continue;
	}
}
}
public function payment($param = "", $env="")
	{
		    
			 if($this->input->post('payment_method') == 'braintree')
			{
			   $this->submission_cc($param);
			}
			else if($this->input->post('payment_method') == 'paypal')
			{
			  
			   $this->submission($param,$contact_key);
			
			}
			else if($this->input->post('payment_method') == 'stripe')
			{
				$this->submission_stripe_payment($param);	
				
			}
			else if($this->input->post('payment_method') == '2c')
			{
						//$this->submissionTwoc($param);	
			}
			else
			{
			   redirect('info');	
			}
	
	}
	
	
	function submission_stripe_payment($param)
	{
				$checkin          = $this->input->post('checkin');
				$checkout         = $this->input->post('checkout');
				$checkin_time     = $this->input->post('checkin_time');
				$checkout_time    = $this->input->post('checkout_time');
				$email = $this->input->post('email');
				$id               = $this->uri->segment(3);
		
			if($this->session->userdata('mobile_user_id'))
			{
				$user_id = $this->session->userdata('mobile_user_id');
				$this->session->unset_userdata('mobile_user_id');
			}
			else
			{
				$user_id = $this->dx_auth->get_user_id();
			}	
					    	
		//change Seasonal price 		
		$conform_c = $this->input->post('house');
		if($conform_c == 'house clean')
		{
			$clean_zip = $this->session->userdata('clean-zipcode');
			$clean_bedroom = $this->session->userdata('clean-bedcount');
			$clean_bathroom = $this->session->userdata('clean-bathcount');
			$clean_hours = $this->session->userdata('clean-cleanhour');
			$clean_date = strtotime($this->session->userdata('clean-cleandate'));
			$clean_time = $this->session->userdata('clean-timecleanin');
			$clean_email = $this->session->userdata('clean-cleanemail');
			$clean_type = $this->session->userdata('clean-type');
			$delivery_time = $this->session->userdata('delivery-time');
			$delivery_date = strtotime($this->session->userdata('delivery-date'));
			$wash_fold = $this->session->userdata('wash-flod');
			$wash_press = $this->session->userdata('wash-press');
			$wash_dry = $this->session->userdata('wash-dry');
			$pickup_location = $this->session->userdata('pickup-location');
			$drop_location = $this->session->userdata('drop-location');
			$clean_firstname = $this->input->post('fstname');
			$clean_secondname = $this->input->post('lastname');
			$clean_streetadd = $this->input->post('stretaddress');
			$clean_phone = $this->input->post('phonenum');
			$clean_apt = $this->input->post('apt');		
			$clean_state = $this->input->post('state');
			$clean_city = $this->input->post('city');
			$total_amt = $this->session->userdata('clean-amount');
			$custom_ = $clean_zip.';'.$clean_bedroom.';'.$clean_bathroom.';'.$clean_hours.';'.$clean_date.';'.$clean_time.';'.$clean_email.';'.$clean_firstname.';'.$clean_secondname.';'.$clean_streetadd.';'.$clean_phone.';'.$clean_apt.';'.$clean_state.';'.$clean_city.';'.$total_amt.';'.$conform_c.';'.$clean_type.';'.$delivery_date.';'.$delivery_time.';'.$wash_fold.';'.$wash_press.';'.$wash_dry.';'.$pickup_location.';'.$drop_location;		
		}
		
		//$custom = $id.'@'.$user_id.'@'.get_gmt_time(strtotime($checkin)).'@'.get_gmt_time(strtotime($checkout)).'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids.'@'.$total_price.'@'.$admin_commission.'@'.$contact_key.'@'.$cleaning.'@'.$security.'@'.$extra_guest_price.'@'.$guests.'@'.$amt.'@'.$this->session->userdata('booking_currency_symbol').'@'.$per_night;
		$amt=$total_amt;
		// print_r($custom_);
		// exit;
		//won
		
		
		
		//$custom = $id.'@'.$user_id.'@'.get_gmt_time(strtotime($checkin)).'@'.get_gmt_time(strtotime($checkout)).'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids.'@'.$to_pay.'@'.$admin_commission.'@'.$contact_key.'@'.$cleaning.'@'.$security.'@'.$extra_guest_price.'@'.$guests.'@'.$amt.'@'.$this->session->userdata('booking_currency_symbol').'@'.$per_night;		
		//print_r($custom);
		//exit;
		//}
		//$this->session->set_userdata('custom',$custom);
		$this->session->set_userdata('custom_',$custom_);
		
		if(get_currency_code() != 'USD')
		{
			$currency_code = 'USD';
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$amt = get_currency_value_lys(get_currency_code(),$currency_code,$amt);
			
		}
		else
			{
				//$currency_code = $this->session->userdata('booking_currency_symbol');
				$currency_code = get_currency_code();
				$amt = $amt;
			}
			$this->session->set_userdata('currency_code_payment',$currency_code);
				
		
		error_reporting(E_ALL) ; 	
		
			$data['secret_key'] = $this->stripe_secret ;
			$data['publishable_key'] = $this->stripe_pub;
		
		  Stripe::setApiKey($data['secret_key']);
		  
		  
		$data['amount'] = $amt;
		
		$conform_clean = $this->input->post('house');
		if($conform_clean == 'house clean')
		{
			
			$data['amount'] = $total_amt;
		}
		
		        $data['title']                = "Payments";
				$data["meta_keyword"]         = "";
				$data["meta_description"]     = "";
				$data['message_element']      = "home/payment_form";
				$this->load->view('template',$data);		

	}

	function stripe_success()
	{
				
		$amt=$this->input->post("amount");
		
		$currency_code = $this->session->userdata('currency_code_payment');
		if($currency_code == 'INR' || $currency_code == 'MYR' || $currency_code == 'ARS' || 
		$currency_code == 'CNY' || $currency_code == 'IDR' || $currency_code == 'KRW' 
		|| $currency_code == 'VND' || $currency_code == 'ZAR')
		{
			$currency_code = 'USD';
			//$currency_code = $this->session->userdata('booking_currency_symbol');
			$amt = get_currency_value_lys($currency_code,$currency_code,$amt);
		}
		else
			{
				//$currency_code = $this->session->userdata('booking_currency_symbol');
				$currency_code = $currency_code;
				$amt = $amt;
			}
		
		
		$data['secret_key'] = $this->stripe_secret ;
			$data['publishable_key'] = $this->stripe_pub;
			
			  Stripe::setApiKey($data['secret_key']);
			  
			  if ($_POST) {
		    $error = NULL;
		    try {
		    	      if (isset($_POST['customer_id'])) {
		        $charge = Stripe_Charge::create(array(
		          'customer'    => $_POST['customer_id'],
		          'amount'      =>  $_POST['total_amount']*100,
		          'currency'    => 'usd',
		          'description' => 'Single quote purchase after login'));
		      }else if (isset($_POST['stripeToken']))
			  {
			  	 $charge = Stripe_Charge::create(array(
		        'card'     => $_POST['stripeToken'],
		        'amount'   =>  $_POST['total_amount'],
		        'currency' => 'usd'
		      ));
			  	
			  }else{
			  	 throw new Exception("The Stripe Token or customer was not generated correctly");
			  }
		       
		
		    }
		    catch (Exception $e) {
		      $error = $e->getMessage();
		    }
	
		$clean_brain = $this->session->userdata('custom_');
		$data_clean   = array();
		$clean_list   = array();
		$data_clean   = explode(';',$clean_brain);
		
		 if ($error == NULL || $error == "") {

				$clean_list['zip'] = $data_clean[0];
				$clean_list['bedroom'] = $data_clean[1];
				$clean_list['bathroom'] = $data_clean[2];
				$clean_list['hours'] = $data_clean[3];
				$clean_list['date'] = $data_clean[4];
				$clean_list['time'] = $data_clean[5];
				$clean_list['email'] = $data_clean[6];
				$clean_list['firstname'] = $data_clean[7];
				$clean_list['secondname'] = $data_clean[8];
				$clean_list['streetadd'] = $data_clean[9];
				$clean_list['phone'] = $data_clean[10];
				$clean_list['apt'] = $data_clean[11];
				$clean_list['state'] = $data_clean[12];
				$clean_list['city'] = $data_clean[13];
				$clean_list['amount'] = $data_clean[14];
				$clean_list['cleantype'] = $data_clean[16];
				$clean_list['deliverdate'] = $data_clean[17];
				$clean_list['delivertime'] = $data_clean[18];
				$clean_list['washfold'] = $data_clean[19];
				$clean_list['washpress'] = $data_clean[20];
				$clean_list['washdry'] = $data_clean[21];
				$clean_list['picuplocation'] = $data_clean[22];
				$clean_list['dropofflocation'] = $data_clean[23];
				$this->Common_model->insertData('cleaning', $clean_list);
					
					$from_email = $data_clean[6];
					$to_email = $this->Common_model->getTableData('users',array('id'=>1))->row()->email;
					$from_email_name = $data_clean[7];
					$servicetype = $data_clean[16];
					$charges = $data_clean[14];
					$admin_email_from = $this->dx_auth->get_site_sadmin();
					$admin_name  = $this->dx_auth->get_site_title();
					$email_name = 'house_notifaction';
					$splVars    = array("{payment_type}"=>'PayPal',"{site_name}" => $this->dx_auth->get_site_title(), "{traveler_email_id}" => $from_email, '{service_type}' => $servicetype, '{market_price}' => $charges, '{username}' => $from_email_name);
					$this->Email_model->sendMail($admin_email_from,$from_email,$admin_name,$email_name,$splVars);
					$session_lang = $this->session->userdata('locale');
					if($session_lang == "") {
					$email_name = 'traveller_reservation_notification';}
					else {$email_name = 'traveller_reservation_notification_'.$session_lang;}
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), '{traveler_name}' => $from_email_name);
					$this->Email_model->sendMail($from_email,$admin_email_from,$admin_name,$email_name,$splVars);
					
					$data['PagePopupContent'] 		= GetPagePopupContent('step4');
		            $data['title']= "Payment Success !";
					$data['message_element']      = 'payments/paypal_success';
					$this->load->view('template',$data);			
			}
		}
	 }

}
/* End of file home.php */
/* Location: ./app/controllers/home.php */
?>