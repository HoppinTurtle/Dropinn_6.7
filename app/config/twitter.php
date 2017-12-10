<?php
/**
 * twconnect library configuration
 */

$active_group = "default";
$active_record = TRUE;
$CI =& get_instance();

$db['default']['hostname'] = $CI->config->item('hostname');
$host = $db['default']['hostname'];
$db['default']['username'] = $CI->config->item('db_username');
$user = $db['default']['username'];
$db['default']['password'] = $CI->config->item('db_password');
$pass = $db['default']['password'];
$db['default']['database'] = $CI->config->item('db');
$dbb = $db['default']['database'];

/* Access tokens */


   $consumer_key = twiiter_api;

   $consumer_secret = twiiter_secret;

 $config = array(
  'consumer_key'    => $consumer_key,
  'consumer_secret' => $consumer_secret,
   'oauth_callback'      => 'oob' // Default callback application path
);

?>