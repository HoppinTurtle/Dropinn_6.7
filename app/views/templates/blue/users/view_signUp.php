<style>
iframe[src^="https://apis.google.com"] {
  display: none;
}
 @media (min-width:300px) and (max-width:500px) {
 	.signup_frm{
	width: 89% !important;
}

@media only screen and (min-width:320px) and (max-width:359px) {
	.one-google {
    float: left;
}.wrapper {
    max-width: 287px !important;
    min-height: 100%;
    position: relative;
}
}
</style>
  <script type="text/javascript">
  
window.onbeforeunload = function(e){
  gapi.auth.signOut();
};
   var profile, email;

  function loginFinishedCallback(authResult) {
    if (authResult) {
      if (authResult['status']['signed_in']){
      	
      	if(authResult['status']['method'] == 'AUTO')
      	{
      	 return false;
      	}
        //toggleElement('signin-button'); // Hide the sign-in button after successfully signing in the user.
        gapi.client.load('plus','v1', loadProfile);  // Trigger request to get the email address.
      } else {
        console.log('An error occurred');
      }
    } else {
      console.log('Empty authResult');  // Something went wrong
    }
  }

  function loadProfile(){
    var request = gapi.client.plus.people.get( {'userId' : 'me'} );
    request.execute(loadProfileCallback);
  }

 
  function loadProfileCallback(obj) {
    profile = obj;
    email = obj['emails'].filter(function(v) {
        return v.type === 'account'; // Filter out the primary email
    })[0].value; // get the email from the filtered results, should always be defined.
    displayProfile(profile);
  }


  function displayProfile(profile){
  	var name;
  	if(profile['displayName'] == '')
  	{
  		name = email.split('@');
  		name = name[0];
  	}
  	else
  	{
  		name = profile['displayName'];
  	}
  	var last_name = profile['name']['familyName'];
  	var first_name = profile['name']['givenName'];
 /*   document.getElementById('name').innerHTML = profile['displayName'];
    document.getElementById('pic').innerHTML = '<img src="' + profile['image']['url'] + '" />';
    document.getElementById('email').innerHTML = email; */
     toggleElement('profile');
   var PostData = 'name='+name+'&first_name='+first_name+'&last_name='+last_name+'&id='+profile['id']+'&url='+profile['url']+'&imageurl='+profile['image']['url']+'&email='+email;
           $.ajax({
            url: "<?php echo base_url()?>users/google_signin",            
            type: "POST",                       
            data:PostData,
            success: function (result) { 
              window.location.href = '<?php echo base_url();?>'+result;                  
            },
            error: function (thrownError)
            {
            },
           
            });
   
  }

 
  function toggleElement(id) {
   /* var el = document.getElementById(id);
    if (el.getAttribute('class') == 'hide') {
      el.setAttribute('class', 'show');
    } else {
      el.setAttribute('class', 'hide');
    }*/
  }

  (function() {
    var po = document.createElement('script');
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
  })();

  function render() {
    gapi.signin.render('customBtn', {
      'callback': 'loginFinishedCallback',
      'clientid': '<?php echo $google_app_id;?>',
      'cookiepolicy': 'single_host_origin',
      'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
    });

  }

$(document).ready(function(){

$("#signup #password1").focus(function(){
$(".hidden").show();
});

//News Letter

$('#news_letter').change(function(){
 if($(this).is(':checked')){
    $(this).val(1);
  }else{
   $(this).val(0);
  }
});

$("#forgot_password").fancybox({	});

});

FB.init({ 
       appId:'<?php echo $fb_app_id; ?>', 
       frictionlessRequests: true
     });
     function login()
     { 
  //  document.getElementById('light').style.display='block'; 
            FB.login(function(response) {
    if (response.authResponse) {
        FB.api("/me?fields=email,name", function(me){
            if (me.id) {
            	var id = me.id; 
            	var email = me.email;
            	var name = me.name;
            	var last_name = "";
            	var live ='';
            	 if (me.hometown!= null)
        {
        	var live = me.hometown.name;
        }
        
        
        
            	var picture = 'https://graph.facebook.com/'+id+'/picture?type=square';
            	var username = me.name;
            	//alert(me.hometown.name);
            	//alert('https://graph.facebook.com/'+id+'/picture?type=square'); return false;	
            	$.ajax({
  type: "POST",
  dataType: "text",
  url: '<?php echo base_url()."facebook/success";?>',
  data: { id: id, email: email, name: name, Lname: last_name, live: live, src: picture, username: username },
   success: function(data)
        {
        	//alert(data);
			  // $('#category'+value).checked;
			  if(data)
        	{
		window.location.href = '<?php echo base_url();?>'+data;
			}  
			 //alert(value);
			  
              
        	
       // $('#overlay_form_fb').html(data);
        }
});
            	  }
        });
    }
}, {scope: 'email,user_friends'});
}
 //var j = jQuery.noConflict();
  //j("input").focus(function () {
    //    j(this).prev(".labelBlur").hide();
     //});
       //j('input').blur(function() {
      //if (j(this).val())
       //j(this).prev(".labelBlur").hide();
      
    //else
      // j(this).prev(".labelBlur").show();
  //});
</script>
<div class="container">
<div class="container_bg1 signup_head">
<div id="section_signup" class="signup_h1">
    <h1>
    <?php echo translate("Sign up for ".$this->dx_auth->get_site_title()); ?>
    </h1>
<!-- Facebook Login is under here -->
    <div class="clsSign_Top col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="sign-fb-my-account">
            <p class="align_left"><?php echo translate("Find the best places to stay recommended by your friends."); ?></p>
            
            <?php if ( !$this->facebook_lib->logged_in() ): ?>
            <a href="javascript:void(0)" onclick="login();" class="log_fb login_fb Sign_Fb_Bg col-md-12 col-sm-12 col-xs-12">
            
            <i class="fa fa-facebook signin" aria-hidden="true"></i>
            <p class="fb_login">Sign up With Facebook</p>	
            	
            </a>
            <fb:facepile></fb:facepile>
            <?php else:?>
            <?php redirect('facebook/login'); ?>
            <?php endif;?>
            
           <!-- Twitter sign up -->
           
           <a href="<?php echo base_url().'users/redirect';?>" class="login_twitter sign_up_tw_bg col-md-12 col-sm-12 col-xs-12">
           	
           	<i class="fa fa-twitter signin" aria-hidden="true"></i>
            <p class="fb_login">Sign up With Twitter</p>
           	
           </a>
           <!-- Twitter sign up -->
           
          <!-- sign_up_google_bg -->
          
         
    <div id="customBtn" class="google_login_1 customGPlusSignIn col-md-12 col-sm-12 col-xs-12">
							<img class="fa fa-googleplus" src="<?php echo base_url();?>images/Google-plus.png"/>
							<p class="fb_login">Sign up With Google</p>
							</div>
 
        </div>
        
        <p class="Sign_Or_Row signup_frm col-xs-12 col-sm-12 col-md-12"><span><?php echo translate("Or"); ?></span></p>
        
        <div class="clsSign_Email">
            <?php echo form_open("users/signup", array('name' => 'signup', 'id' => 'signup')); ?>
          
		    <div id="Input_First" class="Txt_input signup_frm col-sm-12">
		    	<i class="fa fa-user fa-2x inputmail"></i>
                <label for="first_name" class="labelBlur"><?php echo translate("First name"); ?><span class="signemailcolor">*</span></label>
                <input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>" />
            <?php echo form_error('first_name'); ?>
            </div>
            
			
            <div id="Input_Last" class="Txt_input signup_frm col-sm-12">
            	<i class="fa fa-user fa-2x inputmail"></i>
                <label for="last_name" class="labelBlur"><?php echo translate("Last name"); ?><span class="signemailcolor">*</span></label>
                <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" />
          		<?php echo form_error('last_name'); ?>
            </div>
            
           
		    <div id="Input_User" class="Txt_input signup_frm col-sm-12">
		    	<i class="fa fa-user fa-2x inputmail"></i>
                <label for="username1" class="labelBlur"><?php echo translate("Username"); ?><span class="signemailcolor">*</span></label>
                <input type="text" name="username" id="username1" value="<?php echo set_value('username'); ?>" />
            	<?php echo form_error('username'); ?>
            </div>
            
			
            <div id="Input_Mail" class="Txt_input signup_frm col-sm-12">
            	<i class="fa fa-envelope-o" aria-hidden="true"></i>
            	<label for="email" class="labelBlur"><?php echo translate("Email Address"); ?><span class="signemailcolor">*</span></label>
            	<input type="text" name="email" id="email" class="Sign_Inp_Bg" value="<?php echo set_value('email'); ?>" />
            	<?php echo form_error('email'); ?>
            </div>
            
		
            <div id="Input_Password" class="Txt_input signup_frm col-sm-12">
            	<i class="fa fa-lock fa-2x inputmail"></i>
                <label for="password1" class="labelBlur"><?php echo translate("Password"); ?><span class="signemailcolor">*</span></label>
            	<input id="password1" name="password" size="30" type="password" value="" />
            	<?php echo form_error('password'); ?>
            </div>
            
            
            <div id="Input_Password" class="Txt_input signup_frm col-sm-12" >
            	<i class="fa fa-lock fa-2x inputmail"></i>
            	<label for="re_password" class="labelBlur"><?php echo translate("Confirm Password"); ?><span class="signemailcolor">*</span></label>
            	<input id="re_password" name="confirmpassword" size="30" type="password" value="" />
            	<?php echo form_error('confirmpassword'); ?>
            </div>
            
                   
                    <p>
                    <span class="signemailcolor">*</span><?php echo translate("Required fields"); ?> 
                    </p> 
                   
                    <center>
			<div class="col-xs-12 col-sm-12 col-md-12">
                    <button name="SignUp" class="blue_home sign_in_btn_1 col-md-12 col-sm-12 col-xs-12" type="submit"><span><span><?php echo translate("Sign up"); ?></span></span></button>

                   </div>
                   </center>
                    
                              
            <?php echo form_close(); ?>
        <!--  End of form for sign up -->
        </div>
        
         <p class="create_acc">
            <?php echo translate("Already a member"); ?>?&nbsp;
           
           <!-- <a href="javascript:void(0);" onclick="$('#section_signup').hide();$('#section_signin').show();return false;"><?php echo translate("Sign in"); ?></a>-->
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo base_url().'users/signin';?>"><?php echo translate("Sign in"); ?></a>
            </p>
        
        
    </div>
    <div class="clsSign_Bottom">&nbsp;</div>
</div>
</div>
</div>