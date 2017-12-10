<?php 


$active_group = "default";
$active_record = TRUE;
$CI =& get_instance();

$CI->load->database();
$query_cloud = $CI->db->get('settings');
$theme_color = $CI->db->get_where("theme_select",array("status"=>1))->row()->color;  

foreach($query_cloud->result() as $row)
{
	if($row->code == "cloud_name")
	{
	$cdn_name = $row->string_value;	
	$cloud_version = $row->created + 1234;
	}
		if($row->code == "cloud_api_key")
	{
	$cdn_api = $row->string_value;	
	}
		if($row->code == "cloud_api_secret")
	{
	$cloud_s_key = $row->string_value;	
	}
		if($row->code == "SITE_FB_API_ID")
	{
	$fb_api = $row->string_value;	
	}
		if($row->code == "SITE_FB_API_SECRET")
	{
	$fb_secret = $row->string_value;	
	}
		if($row->code == "SITE_TWITTER_API_ID")
	{
	$twiiter_api = $row->string_value;	
	}
	
			if($row->code == "SITE_TWITTER_API_SECRET")
	{
	$twiiter_secret = $row->string_value;	
	}
	
		if($row->code == "SITE_GOOGLE_API_ID")
	{
	$google_api = $row->string_value;	
	}
			if($row->code == "FRONTEND_LANGUAGE")
	{
	$front_end_lang = $row->string_value;	
	$front_end_lang_ini = $row->int_value;	
	}
				if($row->code == "SITE_TITLE")
	{
	$site_title = $row->string_value;	
	}
			if($row->code == "SITE_GOOGLE_CLIENT_ID")
	{
	$google_client_id = $row->string_value;	
	}
	
}

// $cdn_name = $CI->db->get_where('settings', array('code' => 'cloud_name'))->row()->string_value;
// $cdn_api = $CI->db->get_where('settings', array('code' => 'cloud_api_key'))->row()->string_value;
// $cloud_s_key = $CI->db->get_where('settings', array('code' => 'cloud_api_secret'))->row()->string_value;
// $cloud_version = $query_cloud->created + 1234;

define('theme_color', $theme_color);
define('cdn_name', $cdn_name);
define('cdn_api', $cdn_api);
define('cloud_s_key', $cloud_s_key);
define('cloud_version', 'v'.$cloud_version);
 
define('fb_api', $fb_api);
define('fb_secret', $fb_secret);
define('twiiter_api', $twiiter_api);
define('twiiter_secret', $twiiter_secret);
define('google_api', $google_api);
define('front_end_lang', $front_end_lang);
define('front_end_lang_ini', $front_end_lang_ini);
define('site_title', $site_title );
define('google_client_id', $google_client_id);

 $config = array(
 'theme_color' => $theme_color,
  'cdn_name'    => $cdn_name,
  'cdn_api' => $cdn_api,
   'cloud_s_key'      => $cloud_s_key ,
   'cloud_version'      => 'v'.$cloud_version, 
    'fb_api' => $fb_api,
  'fb_secret'    => $fb_secret,
  'twiiter_api' => $twiiter_api,
   'twiiter_secret' => $twiiter_secret,
   'google_api'      => $google_api ,
   'front_end_lang'      => $front_end_lang,
   'front_end_lang_ini'      => $front_end_lang_ini,
   'site_title' => $site_title,
   'google_client_id'  => $google_client_id
    ) ;

?>