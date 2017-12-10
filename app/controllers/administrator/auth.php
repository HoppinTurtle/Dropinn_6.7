<?php
class Auth extends CI_Controller
{
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	function Auth()
	{
		parent::__construct();
		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');			
		
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->library('session');
		
		$this->load->model('Users_model');
		$this->load->model('dx_auth/user_temp', 'user_temp');
		$this->load->model('dx_auth/login_attempts', 'login_attempts');
	}
	
	function index()
	{
		$this->login();
	}
	
	/* Callback function */
	
	function username_check($username)
	{
		$result = $this->dx_auth->is_username_available($username);
		if ( ! $result)
		{
			$this->form_validation->set_message('username_check', 'Username already exist. Please choose another username.');
		}
				
		return $result;
	}

	function email_check($email)
	{
		$result = $this->dx_auth->is_email_available($email);
		if ( ! $result)
		{
			$this->form_validation->set_message('email_check', 'Email is already used by another user. Please choose another email address.');
		}
				
		return $result;
	}

	function captcha_check($code)
	{
		$result = TRUE;
		
		if ($this->dx_auth->is_captcha_expired())
		{
			// Will replace this error msg with $lang
			$this->form_validation->set_message('captcha_check', 'Your confirmation code has expired. Please try again.');			
			$result = FALSE;
		}
		elseif ( ! $this->dx_auth->is_captcha_match($code))
		{
			$this->form_validation->set_message('captcha_check', 'Your confirmation code does not match the one in the image. Try again.');			
			$result = FALSE;
		}

		return $result;
	}
	
	function recaptcha_check()
	{
		$result = $this->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->form_validation->set_message('recaptcha_check', 'Your confirmation code does not match the one in the image. Try again.');
		}
		
		return $result;
	}
	
	/* End of Callback function */
	
function login()

{

// Check if user logged in or not

if (!$this->dx_auth->is_logged_in())

{

$val = $this->form_validation;


if($this->input->post())

{	

//Set rules

$val->set_rules('usernameli', 'Username', 'strtolower|trim|required|xss_clean');

$val->set_rules('passwordli', 'Password', 'trim|required|xss_clean');

if($this->form_validation->run())

{

$login    = $val->set_value('usernameli');

$password = $val->set_value('passwordli');

// Get which function to use based on config

if ($this->config->item('DX_login_using_username') AND $this->config->item('DX_login_using_email'))

{

$get_user_function = 'get_login';

}

else if ($this->config->item('DX_login_using_email'))

{

$get_user_function = 'get_user_by_email';

}	

else

{

$get_user_function = 'get_user_by_username';

}

// Get user query

if ($query = $this->Users_model->$get_user_function($login) AND $query->num_rows() == 1)

{

// Get user record

$row = $query->row();

// Check if user is banned or not

if ($row->banned > 0)

{

$this->session->set_flashdata('flash_message', "Login failed! you are banned");

redirect_admin('login','refresh');

}

// If it's not a banned user then try to login

else

{	

$password = $this->dx_auth->_encode($password);

$stored_hash = $row->password;

// Is password matched with hash in database ?

if (crypt($password, $stored_hash) === $stored_hash)

{

// Log in user 

$this->dx_auth->_set_session($row); 	

if ($row->newpass)

{

// Clear any Reset Passwords

$this->users->clear_newpass($row->id); 

}

/*if ($remember)

{

// Create auto login if user want to be remembered

$this->dx_auth->_create_autologin($row->id);

}	*/	

// Set last ip and last login

$this->dx_auth->_set_last_ip_and_last_login($row->id);

// Clear login attempts

$this->dx_auth->_clear_login_attempts();

// Trigger event

$this->dx_auth_event->user_logged_in($row->id);

redirect_admin('','refresh');

}

else	

{

$this->session->set_flashdata('flash_message', "Login failed! Incorrect username or password");

redirect_admin('login','refresh');

}

}	

}

else

{

$this->session->set_flashdata('flash_message', "Login failed! Incorrect username or password");

redirect_admin('login','refresh');

}

}//If End - Check For Form Validation

} //IF End- Check For Form Submission	

$data['message_element'] = "administrator/view_login";

$data['auth_message'] = 'You are already logged in.';

$this->load->view('administrator/admin_template', $data);	

}else{

redirect('administrator');

}

}




	function logout()
	{
		$this->dx_auth->logout();
		
		$data['auth_message'] = 'You have been logged out.';		
		$this->load->view($this->dx_auth->logout_view, $data);
	}
	
	
	function cancel_account()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('password', 'Password', "trim|required|xss_clean");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				redirect_admin('', 'location');
			}
			else
			{
				$this->load->view($this->dx_auth->cancel_account_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	// Example how to get permissions you set permission in /backend/custom_permissions/
	function custom_permissions()
	{
		if ($this->dx_auth->is_logged_in())
		{
			echo 'My role: '.$this->dx_auth->get_role_name().'<br/>';
			echo 'My permission: <br/>';
			
			if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit'))
			{
				echo 'Edit is allowed';
			}
			else
			{
				echo 'Edit is not allowed';
			}
			
			echo '<br/>';
			
			if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
			{
				echo 'Delete is allowed';
			}
			else
			{
				echo 'Delete is not allowed';
			}
		}
	}
	
}
?>