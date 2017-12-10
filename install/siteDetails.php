<?php
    session_start();
    
 error_reporting(0); 
    
    include "db.php";
    
    if( isset($_POST['submit']) && $_POST['submit'] == 'Submit' &&
        trim($_POST['site_title']) != '' &&
        /*trim($_POST['fb_api_id']) != '' &&
        trim($_POST['fb_api_secret']) != '' &&
        trim($_POST['twitter_api_id']) != '' &&
        trim($_POST['twitter_api_secret']) != '' &&
        trim($_POST['gmap_api_key']) != '' &&*/
        trim($_POST['site_admin_mail']) != '' &&
        trim($_POST['admin_name']) != '' &&
        trim($_POST['admin_password']) != ''){
    
  osc_db_connect($_SESSION['mysql_host'], $_SESSION['mysql_uname'], $_SESSION['mysql_password']);
  osc_db_select_db($_SESSION['mysql_db']);
  
  $majorsalt = '';
  $password = $_POST['admin_password'];
    // if PHP5
    if (function_exists('str_split'))
    {
        $_pass = str_split($password);
    }
    // if PHP4
    else
    {
        $_pass = array();
        if (is_string($password))
        {
            for ($i = 0; $i < strlen($password); $i++)
            {
                array_push($_pass, $password[$i]);
            }
        }
    }
    foreach ($_pass as $_hashpass)
    {
        $majorsalt .= md5($_hashpass);
    }
    $final_pass = crypt(md5($majorsalt));

    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['site_title']).'",created = "'.time().'" WHERE code = "SITE_TITLE"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['fb_api_id']).'",created = "'.time().'" WHERE code = "SITE_FB_API_ID"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['fb_api_secret']).'",created = "'.time().'" WHERE code = "SITE_FB_API_SECRET"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['twitter_api_id']).'",created = "'.time().'" WHERE code = "SITE_TWITTER_API_ID"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['twitter_api_secret']).'",created = "'.time().'" WHERE code = "SITE_TWITTER_API_SECRET"');
    
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['cloud_name']).'",created = "'.time().'" WHERE code = "cloud_name"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['cloud_api_id']).'",created = "'.time().'" WHERE code = "cloud_api_key"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['cloud_api_secret']).'",created = "'.time().'" WHERE code = "cloud_api_secret"');
	osc_db_query('UPDATE settings set string_value = "'.trim($_POST['sinch_name']).'",created = "'.time().'" WHERE code = "sinch_name"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['sinch_api_id']).'",created = "'.time().'" WHERE code = "sinch_api_key"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['sinch_api_secret']).'",created = "'.time().'" WHERE code = "sinch_api_secret"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['gmap_api_key']).'",created = "'.time().'" WHERE code = "SITE_GOOGLE_API_ID"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['gmap_client_key']).'",created = "'.time().'" WHERE code = "SITE_GOOGLE_CLIENT_ID"');
    osc_db_query('UPDATE settings set string_value = "'.trim($_POST['site_admin_mail']).'",created = "'.time().'" WHERE code = "SITE_ADMIN_MAIL"');
    
    srand ((double) microtime() * 1000000);
 $coupon_code = rand(10000,99999);
    
    $time = time();
    
    osc_db_query('INSERT into users set  shortlist="1,2", role_id  = "2", ref_id = "'.md5(trim($_POST['admin_name'])).'", coupon_code = "'.$coupon_code.'", username    = "'. trim($_POST['admin_name']) .'", password = "'.$final_pass .'", email = "'. $_POST['site_admin_mail'] .'", last_ip  = "'. $_SERVER['REMOTE_ADDR'] .'", created  = "'. mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time)) .'"');
    
    osc_db_query('INSERT into profiles set id = 1, email = "'. $_POST['site_admin_mail'] .'"');
    
    osc_db_query('INSERT into user_notification set user_id = 1');
  
  header('Location: complete.php');
  }
  elseif(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
    {
        $site_title         = trim($_POST['site_title']);
        $fb_api_id          = trim($_POST['fb_api_id']);
        $fb_api_secret      = trim($_POST['fb_api_secret']);
        $twitter_api_id     = trim($_POST['twitter_api_id']);
        $twitter_api_secret = trim($_POST['twitter_api_secret']);
        $cloud_name     = trim($_POST['cloud_name']);
        $cloud_api_id     = trim($_POST['cloud_api_key']);
        $cloud_api_secret = trim($_POST['cloud_api_secret']);
        $sinch_name     = trim($_POST['sinch_name']);
        $sinch_api_id     = trim($_POST['sinch_api_key']);
        $sinch_api_secret = trim($_POST['sinch_api_secret']);
        $gmap_api_key       = trim($_POST['gmap_api_key']);
		 $gmap_client_key       = trim($_POST['gmap_client_key']);
        $site_admin_mail    = trim($_POST['site_admin_mail']);
        $admin_name         = trim($_POST['admin_name']);
        $admin_password     = trim($_POST['admin_password']);
        
        $error = 'All the fields are required';
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>DropInn Installation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700'>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="css/common.css" />

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>


      <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
  
  <!-- jQuery Form Validation code -->
  <script>
  
  // When the browser is ready...
  $(function() {

    // Setup form validation on the #register-form element
    $("#settings").validate({
    
        // Specify the validation rules
        rules: {
            site_title: "required",
            site_admin_mail: 
            {
                required:true,
                 email: true
            },
            
            
             admin_name: "required",
         //   mysql_password: "required",
             admin_password: "required",
             cloud_name: "required",
             cloud_api_id: "required",
             cloud_api_secret: "required",
             sinch_name: "required",
             sinch_api_id: "required",
             sinch_api_secret: "required",
             gmap_api_key: "required",
             confirm_password:
             {
                required: true,
                equalTo: "#admin_password"
             }
             
          
      
        },
        
        // Specify the validation error messages
        messages: {
            site_title: "Please enter your Site title",
            
             
                    site_admin_mail:
         {
            required:"Please enter your Site Admin Mail ID ",
            email : "Please enter Valid Email ID"
            
         },
         
              
               
              admin_name: "Please enter your Site Admin Name",
          //     mysql_password: "Please enter your Database Password",
                admin_password: "Please enter your Admin Password",
         confirm_password:
         {
            required:"Please enter your Admin Confirm Password",
            equalTo : "Please enter Same Password"
            
         } 
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
  </script>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span4" style="margin-top: 8px">
                        
                            <a class="blog" href="http://www.cogzidel.com/" > <img src="assets/img/logo.png" alt=""></a>
                     
                    </div>
                    <div class="links span8">
                       <!-- <a class="home" href="http://www.cogzidel.com/" rel="tooltip" data-placement="bottom" data-original-title="Home"></a> -->
                        <a class="blog" href="http://www.cogzidel.com/" rel="tooltip" data-placement="bottom" data-original-title="Help"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <div class="iphone span5">
                  <!--  <img src="assets/img/iphone.png" alt="">-->
                </div>
             
                <div class="register">
                    
                         <?php
    // PHP5?
    if(!version_compare(phpversion(), '5.0', '>=')) {
        echo 'OOps!! <strong>Installation error:</strong> in order to run DROPinn you need PHP5. Your current PHP version is: ' . phpversion();
    } 
    else
    {
        if(isset($error))
        echo '<div id="error" class="error">' . $error . '</div><BR>';
    ?>

                    <form action="" name="settings" id="settings" method="post">
                        <h2>Installation<span class="red"><strong> Step (3 Of 4)</strong></span></h2>
                                            
                                            <div class="clsDbServer clearfix">
                                          
                                            <?php
                                            if(isset($error))
                                            echo '<div id="error" class="error">' . $error . '</div><BR>';
                                            ?>
             <br />
                                              <p><label>Site Title:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="site_title" value="<?php if( isset($site_title)) echo $site_title; ?>"/></p>
                                              
                                              <p><label>Site Admin Email:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="site_admin_mail" value="<?php if(isset($site_admin_mail)) echo $site_admin_mail; ?>"/></p>
                                                                                          
                                              <p><label>Admin Username:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="admin_name" value="<?php if( isset($admin_name)) echo $admin_name; ?>"/></p>
                                              
                                              <p><label>Admin Password:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="admin_password" id="admin_password" value="<?php if( isset($admin_password)) echo $admin_password; ?>"/></p>
                                                
                                                <p><label>Admin Confirm Password:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="confirm_password" value="<?php if(   isset($confirm_password)) echo $confirm_password; ?>"/></p>

                                            <h1 style=" font-size: 23px;">Third party APIs </h1></br>
                                            <h1 class="red">(if you are not giving proper details,your site will not connect to the APIs)</h1>

                                              <p><label>FB Application ID: <span> <a href="https://developers.facebook.com/" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="fb_api_id" value="<?php if(  isset($fb_api_id)) echo $fb_api_id; ?>"/><span></span></p>
                                                    
                                              <p><label>FB Application Secret:</label></p>
                                              <p><input type="text" class="clsTextLarge" name="fb_api_secret" value="<?php if(  isset($fb_api_secret)) echo $fb_api_secret; ?>"/><span></span></p>                  

                                              <p><label>Twitter Application ID: <span> <a href="https://apps.twitter.com/app/new" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="twitter_api_id" value="<?php if( isset($twitter_api_id)) echo $twitter_api_id; ?>"/><span></span></p>
                                                    
                                              <p><label>Twitter Application Secret:</label></p>
                                              <p><input type="text" class="clsTextLarge" name="twitter_api_secret" value="<?php if( isset($twitter_api_secret)) echo $twitter_api_secret; ?>"/><span></span></p>                                          
                                                    
                                              <p><label>Cloudinary Name: <span class="red">*</span><span><a href="http://cloudinary.com/documentation/api_and_access_identifiers" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="cloud_name" value="<?php if( isset($cloud_name)) echo $cloud_name; ?>"/><span></span></p>
                                                    
                                              <p><label>Cloudinary Application Key:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="cloud_api_id" value="<?php if( isset($cloud_api_id)) echo $cloud_api_id; ?>"/><span></span></p>                                          
                                                <p><label>Cloudinary Secret Key:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="cloud_api_secret" value="<?php if( isset($cloud_api_secret)) echo $cloud_api_secret; ?>"/><span></span></p>
                                                    
                                               <p><label>Sinch Name: <span class="red">*</span><span><a href="https://www.sinch.com/docs/voice/android/#registeranapplication" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="sinch_name" value="<?php if( isset($sinch_name)) echo $sinch_name; ?>"/><span></span></p>
                                                    
                                              <p><label>Sinch Application Key:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="sinch_api_id" value="<?php if( isset($sinch_api_id)) echo $sinch_api_id; ?>"/><span></span></p>                                          
                                                <p><label>Sinch Secret Key:<span class="red">*</span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="sinch_api_secret" value="<?php if( isset($sinch_api_secret)) echo $sinch_api_secret; ?>"/><span></span></p>
                                             
                                                    
                                                    
                                                    
                                              <p><label>Google API Key: <span class="red">*</span><span> <a href="https://developers.google.com/+/web/api/rest/oauth" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="gmap_api_key" value="<?php if(   isset($gmap_api_key)) echo $gmap_api_key; ?>"/><span></span></p>
                                                                                     
                                              <p><label>Google Client Id: <span> <a href="https://developers.google.com/identity/sign-in/web/devconsole-project" target="_blank">(Help)</a></span></label></p>
                                              <p><input type="text" class="clsTextLarge" name="gmap_client_key" value="<?php if(   isset($gmap_client_key)) echo $gmap_client_key; ?>"/><span></span></p>
                                                                                                                                                                                                                
                                                                                                                                                                                                  
                                                                                         
                                                                  
                                              <p><span class="red"><strong> * Require</strong></span></h2></p>
                                          
                                     
                          </div>
                         
             <input type="submit"  value="Submit" name="submit"  style=" background: none repeat scroll 0 0 #eb4141;
    border-radius: 25px;
    border-top-width: 0;
    color: ghostwhite;
    cursor: pointer;
    font-size: 23px;
    height: 33px;
    margin-left: 20px;
    margin-top: 6px;
    padding: 8px;
    width: 142px;"/>
         
             </form>
                                    <?php
    } // End of else
    ?>
                </div>
                
            </div>
        </div>

        <!-- Javascript -->
     
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

    </body>

</html>
