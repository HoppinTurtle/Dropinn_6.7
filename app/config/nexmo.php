<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = & get_instance();

$nexmo_api_key     = $CI->db->get_where('settings', array('code' => 'NEXMO_API_KEY'))->row()->string_value;
$nexmo_api_secret  = $CI->db->get_where('settings', array('code' => 'NEXMO_API_SECRET'))->row()->string_value;

// please get the following api on Nexmo Dashboard.
$config['api_key']    = $nexmo_api_key;
$config['api_secret'] = $nexmo_api_secret;

/* End of file nexmo.php */
/* Location: ./application/config/nexmo.php */
