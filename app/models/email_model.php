<?php
/**
 * Dropinn Email_model Class
 *
 * Email settings information in database.
 *
 * @package		Dropinn
 * @subpackage	Models
 * @category	Settings
 * @author		Cogzidel Product Team
 * @version		Version 1.5
 * @link		http://www.cogzidel.com

 */
class Email_model extends CI_Model {

	/**
	 * Constructor
	 *
	 */

	function Email_model() {
		parent::__construct();
	}//Controller End

	// --------------------------------------------------------------------

	/**
	 * Get Email settings from database
	 *
	 * @access	private
	 * @param	nil
	 * @return	array	payment settings informations in array format
	 */
	function getEmailSettings($conditions = array()) {
		if (count($conditions) > 0)
			$this -> db -> where($conditions);

		$this -> db -> from('email_templates');
		$this -> db -> select('email_templates.id,email_templates.type,email_templates.title,email_templates.mail_subject,email_templates.email_body_text,email_templates.email_body_html');
		$result = $this -> db -> get();
		return $result;

	}//End of getEmailSettings Function

	/**
	 * Add Email Settings
	 *
	 * @access	private
	 * @param	array	an associative array of insert values
	 * @return	void
	 */
	function addEmailSettings($insertData = array()) {
		$this -> db -> insert('email_templates', $insertData);
		return;
	}//End of getGroups Function

	// --------------------------------------------------------------------

	/**
	 * delete Email Settings
	 *
	 * @access	private
	 * @param	array	an associative array of insert values
	 * @return	void
	 */
	function deleteEmailSettings($condition = array()) {
		if (isset($condition) and count($condition) > 0)
			$this -> db -> where($condition);

		$this -> db -> delete('email_templates');
		return;
	}//End of getGroups Function

	//------------------------------------------------------------------------

	/**
	 * Send Mail
	 *
	 * @access	private
	 * @param	array
	 * @return	array	site settings informations in array format
	 */
	function send_mail2($to = '', $from_email = '', $from_name = '', $subject = '', $message = '') {
		// load Email Library

		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this -> load -> library('email', $config);
		$this -> email -> initialize($config);

		$this -> email -> to($to);
		//print_r($to);exit;
		$this -> email -> from($from_email, $from_name);
		$this -> email -> subject($subject);
		$this -> email -> message($message);

		if (!$this -> email -> send()) {
			//echo $this->email->print_debugger();
		}

	}//

	function sendMail1($to = '', $from_email = '', $from_name = '', $email_name = '', $splvars = array(), $cc = '', $bcc = '', $type = 'html') {
		// load Email Library
		$this -> load -> library('email');

		$mailer_type = $this -> db -> get_where('email_settings', array('code' => 'MAILER_TYPE')) -> row() -> value;

		$smtp_port = $this -> db -> get_where('email_settings', array('code' => 'SMTP_PORT')) -> row() -> value;

		$smtp_user = $this -> db -> get_where('email_settings', array('code' => 'SMTP_USER')) -> row() -> value;

		$smtp_pass = $this -> db -> get_where('email_settings', array('code' => 'SMTP_PASS')) -> row() -> value;

		$mailer_mode = $this -> db -> get_where('email_settings', array('code' => 'MAILER_MODE')) -> row() -> value;

		$logo = $this -> db -> get_where('settings', array('code' => 'SITE_LOGO')) -> row() -> string_value;
		$slogan = $this -> db -> get_where('settings', array('code' => 'SITE_SLOGAN')) -> row() -> string_value;

		if ($mailer_type == 2) {
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'shawmail.vc.shawcable.net';
			$config['smtp_port'] = $smtp_port;
			$config['smtp_user'] = $smtp_user;
			$config['smtp_pass'] = $smtp_pass;
		} else if ($mailer_type == 3) {
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['smtp_port'] = $smtp_port;
			$config['smtp_user'] = $smtp_user;
			$config['smtp_pass'] = $smtp_pass;
		}

		$subject = '';
		$message = '';

		if ($email_name != '') {
			$conditionUserMail = array('email_templates.type' => $email_name);
			$result = $this -> getEmailSettings($conditionUserMail);
			$rowUserMailConent = $result -> row();

			$subject = strtr($rowUserMailConent -> mail_subject, $splvars);

			if ($mailer_mode == 'html') {
				$config['mailtype'] = 'html';

				$message = '<table cellspacing="0" cellpadding="0" width="678" style="border:1px solid #e6e6e6; background:#fff;  font-family:Arial, Helvetica, sans-serif; -moz-border-radius: 16px; -webkit-border-radius:16px; -khtml-border-radius: 16px; border-radius: 16px; -moz-box-shadow: 0 0 4px #888888; -webkit-box-shadow:0 0 4px #888888; box-shadow:0 0 4px #888888;">
	            <tr>
																	<td>
																					<table background="' . base_url() . 'images/email/head_bg.png" width="676" height="156" cellspacing="0" cellpadding="0">
																									<tr>
																													<td style="vertical-align:top;">
																																	<img src="' . base_url() . 'Cloud_data/logo/' . $logo . '" alt="' . $this -> dx_auth -> get_site_title() . '" style=" margin:10px 0 0 20px;" />
																																</td>
																																<td style="text-transform:uppercase; font-weight:bold; color:#0271b8; width:290px; padding:0 10px 0 0; line-height:28px;">
																																				<p style="margin:0 0 10px 0; color:#0271b8;">' . $slogan . '</p>
																																</td>
																												</tr>
																								</table>
																				</td>
																</tr>
																<tr>
																	<td style="padding:0 10px; font-size:14px;">';

				$message .= strtr($rowUserMailConent -> email_body_html, $splvars);
				$message .= '</td>
                  </tr>
																			<tr>
																			<td>
																			<table cellpadding="0" cellspacing="0" background="' . base_url() . 'images/email/footer.png" width="676" height="58" style="text-align:center;">
																			<tr>
																			<td style="font-size:13px; padding:6px 0 0 0; color:#333333;">Copyright 2013 - 2014 <span style="color:#0271b8;">' . $this -> dx_auth -> get_site_title() . '.</span> All Rights Reserved.</td>
																			</tr>
																			</table>
																			</td>
																			</tr>
																			</table>';
			} else {
				$config['mailtype'] = 'text';
				$message = strtr($rowUserMailConent -> email_body_text, $splvars);
			}
		}

		$config['wordwrap'] = TRUE;

		$this -> email -> initialize($config);

		$this -> email -> to($to);
		$this -> email -> from($from_email, $from_name);
		$this -> email -> cc($cc);
		$this -> email -> bcc($bcc);
		$this -> email -> subject($subject);
		$this -> email -> message($message);

		if (!$this -> email -> send()) {
			//echo $this->email->print_debugger();
		}

	}// Function sendmail End

	function sendMail($to = '', $from_email = '', $from_name = '', $email_name = '', $splvars = array(), $cc = '', $bcc = '', $type = 'html', $invoice = '')
    {
        if($email_name == "users_signin" ){
        $toEmail = $splvars['{email}'];
        $link = base_url().'users/email_confirmation?passkey='.md5($toEmail);
        $this->db->where('email',"$toEmail")->update('users',array('email_verification_code'=>md5($toEmail)));
        $activate      = anchor($link,translate('Activate now'),"style='background:#227DBF;font-size:16px;font-weight:bold;padding:15px 15px;color:#ffffff;text-decoration:none;text-align:center;display:block' target='_blank'");
        $splvars['{email_verification_link}'] = $activate;
        }
        
        // load Email Library 
        //echo $this->session->userdata('locale');
        //$mail_Lang = $this->session->userdata('locale');
         
        // echo "hai";
        $this->load->library('email');
        
        $mailer_type = $this -> db -> get_where('email_settings', array('code' => 'MAILER_TYPE')) -> row() -> value;

		$smtp_port = $this -> db -> get_where('email_settings', array('code' => 'SMTP_PORT')) -> row() -> value;

		$smtp_user = $this -> db -> get_where('email_settings', array('code' => 'SMTP_USER')) -> row() -> value;

		$smtp_pass = $this -> db -> get_where('email_settings', array('code' => 'SMTP_PASS')) -> row() -> value;

		$mailer_mode = $this -> db -> get_where('email_settings', array('code' => 'MAILER_MODE')) -> row() -> value;

		// $mailer_domain          = $this->db->get_where('email_settings', array('code' => 'DOMAIN_NAME'));

		$mailer_in_ser = $this -> db -> get_where('email_settings', array('code' => 'IN_MAIL_SERVER'));

		$mailer_out_ser = $this -> db -> get_where('email_settings', array('code' => 'OUT_MAIL_SERVER'));

		$smtp_mail_user = $this -> db -> get_where('email_settings', array('code' => 'MAIL_USER'));

		$smtp_mail_pass = $this -> db -> get_where('email_settings', array('code' => 'MAIL_PASS'));

		$smtp_do_port = $this -> db -> get_where('email_settings', array('code' => 'MAIL_DOMAIN_PORT'));

		$logo = $this -> db -> get_where('settings', array('code' => 'SITE_LOGO')) -> row() -> string_value;
		
		$color = $this -> db -> get_where('theme_select', array('status' => '1')) -> row() -> color;
		
		$slogan = $this -> db -> get_where('settings', array('code' => 'SITE_SLOGAN')) -> row() -> string_value;
        if($color == "red"){
			
			$color = "#ea6b6f";
		}
		elseif($color == "green"){
			$color = "#1ED080";			
		}
		elseif($color == "yellow"){
			$color = "#FFB32A";
		}
		elseif($color == "orange"){
			$color = "#FF755F";
		}
		else{
			$color = "#EF6BB8";
		}
		;
        $main_img_ext = explode('.', $logo);
        $logo = $main_img_ext[0].".png";
          
		  
		  $config['charset'] = 'utf-8';
		$config['protocol'] = 'sendmail';
		  
        if ($mailer_type == 2) {
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://mail.ncr.airtelbroadband.in';
			$config['smtp_port'] = $smtp_port;
			$config['smtp_user'] = $smtp_user;
			$config['smtp_pass'] = $smtp_pass;
		} else if ($mailer_type == 3) {
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'tls://smtp.gmail.com';
			$config['smtp_port'] = $smtp_port;
			$config['smtp_user'] = $smtp_user;
			$config['smtp_pass'] = $smtp_pass;
		} else if ($mailer_type == 5) {
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $mailer_in_ser;
			$config['smtp_port'] = $smtp_do_port;
			$config['smtp_user'] = $smtp_mail_user;
			$config['smtp_pass'] = $smtp_mail_pass;
		}
        
        $subject = '';
        $message = '';
        
        if($email_name != '')
        {
        $conditionUserMail = array('email_templates.type' => $email_name);
        $result            = $this->getEmailSettings($conditionUserMail);
        $rowUserMailConent = $result->row();
        
        $subject     = strtr($rowUserMailConent->mail_subject, $splvars);
        
                    if($mailer_mode == 'html')
                    {
                        //echo "dfgfg";
                    $config['mailtype'] = 'html';
                    
                    $message = '
                    <head>
                    <link href="'.cdn_url_raw().' uploads/font/font.css"  media="screen" rel="stylesheet" type="text/css">
                    <style>
                    @font-face {
					    font-family: "PTSansCaptionRegular";
					    src: url("ptc55f.eot");
					    src: url("ptc55f.eot") format("embedded-opentype"),
					         /url("ptc55f.woff") format("woff"),
					         url("ptc55f.ttf") format("truetype"),
					         url("ptc55f.svg#PTSansCaptionRegular") format("svg");
					}
						html * :not(i)
					{
					     font-family: "Helvetica",Helvetica,Arial,sans-serif !important;
					    -webkit-font-smoothing: antialiased;
					    -moz-osx-font-smoothing: grayscale;
					     
					}
					body{
						font-family: "Helvetica",Helvetica,Arial,sans-serif !important;
					    -webkit-font-smoothing: antialiased;
					    -moz-osx-font-smoothing: grayscale;
					}
					
                    @media all only screen and (max-width: 768px) { .main_cnt {background-color: white;!important}}
					tbody{
						font-family: "CircularStd-Book","Helvetica Neue",Helvetica,Arial,sans-serif !important;
					}
					
					td{
						font-family: "Helvetica",Helvetica,Arial,sans-serif !important;
						-webkit-font-smoothing: antialiased;
						-moz-osx-font-smoothing: grayscale;
					}
					tbody, tr, td, a, input, select, textarea{
						font-size: 15px !important;
						font-weight: bolder !important;
						color: #515151 !important;
						font-family: "Helvetica",Helvetica,Arial,sans-serif !important;
						
						
					}
					
					
                    </style>
                   
                    
                    </head>
                    <body>
                    <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
    <tbody><tr>
        <td align="center" class="main_cnt" valign="top" bgcolor="#f4f4f4" style="border-radius:6px;background-color:#E2E1E1">
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:800px; margin-top: 54px; padding: 10px 20px;">
                <tr>
                                                                    <td>
                                                                                    <table  height="80" style=" width: 100%;" cellspacing="0" cellpadding="0">
                                                                                                    <tr>
                                                                                                                    <td align="center" style=" background-color:'.$color.'; " >
                                                                                                                    <a href ="'.base_url().'">
                                                                                                                                    <img src="'.cdn_url_images().'logo/'.$logo.'" alt="'.$this->dx_auth->get_site_title().'" />
                                                                                                                                    </a>
                                                                                                                                </td>
                                                                                                                                
                                                                                                                </tr>
                                                                                                </table>
                                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 20px 30px 20px 30px; background: #FFF; font-size: 16px; font-weight: 600; color: #484848; font-family: helvetica,arial,sans-serif;">';
                    
                    $message .= strtr($rowUserMailConent->email_body_html, $splvars);
                    $message .= '</td>
                  </tr>
                                          <tr>
                                           <td>
                                            <table cellpadding="0" cellspacing="0" style=" width: 100%; text-align:center;background: '.$color.' ;height: auto;padding-top: 15px;padding-bottom: 15px;">
                                              <tr>
                                               <td align="center" style=" padding-top: 2px; ">
                                                
												<a target="_blank" href="https://www.facebook.com/cogzidel"><img src="' . cdn_url_images() . 'images/email/facebook-logo.png" title="Facebook" style="border-radius: 50%; margin-right: 5px;" width="35" height="35"></a>
												<a target="_blank" href="https://plus.google.com/116955559424123283004/about"><img src="' . cdn_url_images() . 'images/email/google-plus-social-logotype.png" title="Google+" style="border-radius: 50%; margin-right: 5px;" width="35" height="35" ></a>
												<a target="_blank" href="http://twitter.com/cogzidel"><img src="' . cdn_url_images() . 'images/email/twitter-social-logotype.png" title="Twitter" style="border-radius: 50%; margin-right: 5px;" width="35" hight="35"></a>
												<a target="_blank" href="http://www.youtube.com/results?search_query=cogzidel"><img src="' . cdn_url_images() . 'images/email/youtube-symbol.png" title="you tube" style="border-radius: 50%; margin-right: 5px;" width="35" height="35"></a>
                                                </td>
                                                </tr>                                                    
                                               <tr>
                                               <td style="font-size:13px; color:white!important;">'.$sent_cmpny.'</td>
                                            </tr>
                                           </table>
                                           </td>
                                         </tr>
                                         <tr><td style="font-size: 12px; padding-top: 10px; padding-bottom: 3px;" align="center">'.$copy_resv.'</td></tr>
                                          <tr> <td style=" font-size: 12px;padding-bottom: 10px; "  align="center">Copyright 2016 - 2017  <a style=" color: #227DBF !important; text-decoration: none; " target="_blank" href="http://products.cogzidel.com/airbnb-clone/">' . $this -> dx_auth -> get_site_title() . '</a>  All Rights Reserved.</td></tr>
                                             </table>
                                                                            
                                        </td></tr></tbody></table> </body>';                                        
                    }
                    else
                    {
                    $config['mailtype'] = 'text';
                    $message = strtr($rowUserMailConent->email_body_text, $splvars);
                    }
            }
		//print_r($message);exit;
        $config['wordwrap'] = TRUE;

		$this -> email -> initialize($config);
		$this -> email -> set_newline("\r\n");
		// ID verification start
		if ($email_name == "passport_verification") {
			$view = $this -> db -> where('id', $this -> dx_auth -> get_user_id()) -> from('users') -> get() -> row() -> file1;
			$viewf = $this -> db -> where('id', $this -> dx_auth -> get_user_id()) -> from('users') -> get() -> row() -> file2;
			$this -> email -> attach(FCPATH . '/images/' . $view);
			$this -> email -> attach(FCPATH . '/images/' . $invoice);
		}
		// ID verification end

		$this -> email -> to($to);
		$this -> email -> from($from_email, $from_name);
		$this -> email -> cc($cc);
		$this -> email -> bcc($bcc);
		$this -> email -> subject($subject);
		$this -> email -> message($message);
		
		if($invoice != "" && $invoice != NULL)
		{
			$this -> email -> attach(FCPATH . 'invoice/' . $invoice . '.pdf');
		}
		 //print_r($message);exit;
		if (!$this -> email -> send()) {
			//echo $this->email->print_debugger();exit;
		}

	}// Function sendmail End

	/**
	 * Update Email Settings
	 *
	 * @access	private
	 * @param	array	an associative array of insert values
	 * @return	void
	 */
	function updateEmailSettings($id = 0, $updateData = array()) {
		$this -> db -> where('id', $id);
		$this -> db -> update('email_templates', $updateData);

	}//End of editGroup Function

	function sendHtmlMail($to = '', $from = '', $subject = '', $message = '', $cc = '') {
		// load Email Library
		$this -> load -> library('email');

		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this -> email -> initialize($config);

		$this -> email -> to($to);
		$this -> email -> from($from);
		$this -> email -> cc($cc);
		$this -> email -> subject($subject);
		$this -> email -> message($message);
		if (!$this -> email -> send()) {
			echo $this -> email -> print_debugger();
		}
	}

}

// End Email_model Class

/* End of file Email_model.php */
/* Location: ./app/models/Email_model.php */
