<link rel="stylesheet" type="text/css" href="<?php echo css_url().'/jquery.fancybox-1.3.4.css' ?>" media="screen" />
<style>
	iframe[src^="https://apis.google.com"] 
	{
  		display: none;
	}
	 	.modal-body
	{
		padding:0px 0px;
	}
	#UsernamePasswordError
	{
	 color: #484848;
	  width: 100%;
	  padding: 5px 10px 5px;
	  font-size: 16px;
	  text-align: center;
	  display:none;
	  background-color: #F7C0C0;
	  position: relative;
	}
	#BanUsernamePasswordError
	{
		color: #484848;
	  width: 100%;
	  padding: 5px 10px 5px;
	  font-size: 16px;
	  text-align: center;
	  display:none;
	  background-color: #F7C0C0;
	  position: relative;
	}
	.modal-dialog.modal-md
	{
		max-width:370px;
	}
	.close
	{
		  position: absolute;
 		  right: 15px;
	}
	@media screen and (max-width:480px)
	{.modal-body{
		padding:15px;
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
           jQuery.ajax({
            url: "<?php echo base_url()?>users/google_signin",           
            type: "POST",                       
            data:PostData,
            success: function (result) { 
            	//alert(result);return false;
              window.location.href = '<?php echo base_url();?>'+result;                  
            },
            error: function (thrownError)
            {
            	 //alert(thrownError);
            	//alert('error');
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
jQuery(document).ready(function(){

jQuery("#signup #password1").focus(function(){
jQuery(".hidden").show();
})

})
</script> 
<script type="text/javascript">
	window.onbeforeunload = function(e)
	{
		gapi.auth.signOut();
	};
    var profile, email;
	function loginFinishedCallback(authResult) 
	{
	    if (authResult) 
	    {
	    	if (authResult['status']['signed_in'])
	    	{
	          	if(authResult['status']['method'] == 'AUTO')
	    	  	{
	      			return false;
	      		}
	            gapi.client.load('plus','v1', loadProfile);  // Trigger request to get the email address.
	      	}
	      	else 
	      	{
	        	console.log('An error occurred');
	      	}
	    }
	    else 
	    {
	      console.log('Empty authResult');  // Something went wrong
	    }
  	}
	function loadProfile()
	{
    	var request = gapi.client.plus.people.get( {'userId' : 'me'} );
    	request.execute(loadProfileCallback);
 	}
	function loadProfileCallback(obj) 
	{
    	profile = obj;
    	email = obj['emails'].filter(function(v) 
    	{
    		return v.type === 'account'; // Filter out the primary email
    	})[0].value; // get the email from the filtered results, should always be defined.
    	displayProfile(profile);
  	}
	function displayProfile(profile)
	{
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
 		toggleElement('profile');
 		var PostData = 'name='+name+'&first_name='+first_name+'&last_name='+last_name+'&id='+profile['id']+'&url='+profile['url']+'&imageurl='+profile['image']['url']+'&email='+email;
        jQuery.ajax({
            url: "<?php echo base_url()?>users/google_signin",            
            type: "POST",                       
            data:PostData,
            success: function (result) 
            { 
    	        window.location.href = '<?php echo base_url();?>'+result;                  
            },
            error: function (thrownError)
            {      },
           
            });
   	}
	function toggleElement(id) 
	{
	   /* var el = document.getElementById(id);
	    if (el.getAttribute('class') == 'hide') {
	      el.setAttribute('class', 'show');
	    } else {
	      el.setAttribute('class', 'hide');
	    }*/
  	}
  	(function() 
  	{
	    var po = document.createElement('script');
	    po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(po, s);
  	})();
	function render()
	{
    	gapi.signin.render('customBtn', 
    	{
	     	'callback': 'loginFinishedCallback',
	     	'clientid': '<?php echo $google_app_id;?>',
	      	'cookiepolicy': 'single_host_origin',
	      	'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
    	});
  	}
	jQuery(document).ready(function()
	{
		jQuery("#signup #password1").focus(function()
		{
			jQuery(".hidden").show();
		})

	})
</script>
<!--<script src="<?php echo base_url().'js/facebook_invite.js'; ?>"></script>-->
<!-- <script src="<?php echo base_url().'js/jquery.fancybox-1.3.4.pack.js'; ?>"></script> -->
<script type="text/javascript">

	function forgot_password()
    {
      	jQuery('#modal_body').html('Loading....');
	 	jQuery('#modal_footer').html('');
	 	
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url().'users/forgot_password'; ?>",
			format: "HTML",
			success: function(data){
				jQuery('#modal_body').html(data);
				jQuery("#modal_body2").html(data);
			}
			});
	 	
    }
	FB.init
	({ 
       appId:'<?php echo $fb_app_id; ?>', 
       frictionlessRequests: true
    });
    function login()
    {
	    FB.login(function(response) 
	    {
	    	if (response.authResponse) 
	    	{
        		FB.api("/me?fields=name,email,first_name,last_name,hometown", function(me)
        		{
        			if (me.id) 
        			{
            		   	var id = me.id; 
            			var email = me.email;
            			var first_name = me.first_name;
            			var last_name = me.last_name;
            			var live ='';
            	 		if (me.hometown!= null)
        				{
        					var live = me.hometown.name;
        				}
            			var picture = 'https://graph.facebook.com/'+id+'/picture?type=square';
            			var username = me.name;
            			jQuery.ajax({
            				cache: false	,
							type: "POST",
							dataType : 'text',
							url: '<?php echo base_url()."facebook/success?";?>'+new Date().getTime(),
							data: { id: id, email: email, name: first_name, Lname: last_name, live: live, src: picture, username: username },
							success: function(data)
							{ 
							   	//alert(data);return false;
							   	if(data)
							   	{							   		
									window.location.href = '<?php echo base_url();?>'+data;
								}  
					        },
					        error: function (req, text, error) 
					        {    		}
							});
            	  		}
        			});
    			}
			}, {scope: 'email'});
		}
	/*	jQuery("#signin").validate({
	 	rules: 
	 	{ 
			username: 
			{	
				required: true,
			}, 
			password:
			{
			    required:true,
			},	      	 	    
      	},
		messages: 
   		{ 
			username:
			{ 
				 required:	"Email ID Required",
			},
   	 		password:
   			{ 
			   	required:"Password Required",
   	 		}
   	  	},
   	    submitHandler: function(form) 
   	    {
           
        } });	*/
	
 </script>
 <script type="text/javascript">
 
	jQuery(document).ready(function(){
		
	jQuery('#password , #username').keypress(function (e) 
	{
		var key = e.which;
 		if(key == 13)  
 		{
  			jQuery("#SignInButton").click();
  		}
	});


jQuery('#signin').validate({
			 rules: {
username: { required: true,
		  },
password : { required: true, 
           }
},
messages:{
    username: { required: "User name Required" },
    password: { required: "Password Required" }
		}
		})
		
		jQuery(".close").click(function()
		{
			jQuery("#signin_popup").removeClass('in');
			jQuery("#signin_popup").css('display','none');
		})
		
	});
</script>
<script>
		jQuery("#SignInButton").click(function(){
		jQuery("#UsernamePasswordError").hide();
						
		if(jQuery("#signin").valid()){
			
			var Username = jQuery("#username").val();
			var Passwd = jQuery("#password").val();
			var ParamData = "Username="+Username+"&Password="+Passwd;
			//alert(ParamData)
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url().'users/CheckUserDetails'; ?>",
			format: "JSON",
			data: ParamData,
			success: function(status){
				if(jQuery.trim(status) == "success") {
				jQuery("#signin").submit();
				return true;
				} else {
					if(jQuery.trim(status) == "band"){
				jQuery("#BanUsernamePasswordError").show();
				jQuery("#BanUsernamePasswordError").delay(2000).fadeOut('slow');		
					} else {
				jQuery("#UsernamePasswordError").show();
				jQuery("#UsernamePasswordError").delay(2000).fadeOut('slow');
				}			 
				return false;
				
				}
			}
			});
		}
});
</script>




<div class="signup_head">
	

	
    <div id="section_signin" style="" class="signup_h1">
        <div class="clsSign_Top">
        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="sign-fb-my-account">
            	 
                <?php if ( !$this->facebook_lib->logged_in() ): ?>
                	 <p class="signform_head">Sign In</p> 
                <a href="javascript:void(0)" onclick="login();" class="col-md-12 col-sm-12 col-xs-12 login_fb">
                	<span class="icon-container">
                	<i class="fa fa-facebook signin" aria-hidden="true"></i>
                	<p class="fb_login">Log in With Facebook</p>
                	</span>
                	<!--Log in With Facebook-->
                	<!--<img src="<?php echo base_url();?>Cloud_data/images/follow-us-facebook-plus.png" class="img_hover_contrast">-->																																		
                </a>
                  <a href="<?php echo base_url().'users/redirect';?>" class="col-md-12 col-sm-12 col-xs-12 login_twitter">
                  	
                  	<i class="fa fa-twitter signin" aria-hidden="true"></i>
                  	<p class="fb_login">Log in With Twitter</p>
                  	<!--<img src="<?php echo css_url();?>/images/twitter.png" class="img_hover_contrast">-->
                  </a>
                <fb:facepile></fb:facepile>
                <?php else:?>
                <?php redirect('facebook/login'); ?>
                <?php endif;?>
                <!-- sign_up_google_bg -->
				
						
						<div id="customBtn" class="customGPlusSignIn col-xs-12 col-sm-12 col-md-12 no-padding">
							<img class="fa fa-googleplus" src="<?php echo base_url();?>images/Google-plus.png"/>
							<p class="fb_login">Log in With Google</p>
							</div>
							<!--<img src="<?php echo css_url();?>/images/google_in.png" class="img_hover_contrast">-->
						
					
					         
                
            </div>
            <div class="sign_in_or">
              <p class="Sign_Or_Row col-md-12 col-sm-12 col-xs-12"><span>Or</span></p>    
             
            </div>
            <div class="clsSign_Email">
                <?php echo form_open("users/signin", array('name' => 'signin', 'id' => 'signin')); ?>
                  <div id="Input_Mail" class="Txt_input Txt_signin">
                  	<i class="fa fa-envelope-o" aria-hidden="true"></i>
                  	<input class="user_ico" type="text" name="username" id="username" placeholder="Email Address or User Name" value="<?php echo set_value('username'); ?>" />
                  	
                  </div>
                  <?php echo form_error('username'); ?>
                  <div id="Input_Password" class="Txt_input Txt_signin">
                  	<i class="fa fa-lock" aria-hidden="true"></i>
                  	<input id="password" name="password" type="password" value="" placeholder="Password"/>
                  </div>
                  <?php echo form_error('password'); ?>
                  
                  <div class="rem_forgot" style="margin: 15px 0px !important;">
		        	
		          		<input name="remember_me" class="large_checkbox" type="checkbox" value="1">
		          		<span class="signinremainme_span">Remember me</span>		
		    
		        	<label class="forget_pass"><a href="#" onclick="forgot_password()" class="forgot_anchor">Forgot Password?</a></label>
		        	</div>
		        	
                  <center>
               	<button name="SignIn" class="sign_gotomsg blue_home sign_in_btn col-md-12 col-sm-12 col-xs-12" type="button" id="SignInButton">
                  		<?php echo translate("Sign in"); ?>
                  </button>
                  
                  					<label id="UsernamePasswordError">The username and password you entered don't match.</label>
		        	<label id="BanUsernamePasswordError">Your account was banned by Admin.</label> 
                 <!-- <div class="rem_forgot" style="margin: 15px 0px !important;">
		        	
		          		
		          		<span class="" style="margin-right: 10px">Don't have an account?</span>		
		    
		        	<label class="forget_pass"><a href="#" onclick="signup_popup_in()"  class="forgot_anchor">Sign up here</a></label>
		        	</div> -->
		        	</center>
          		<?php echo form_close(); ?>
            </div>
            
            <div class="rem_forgot col-md-12 col-sm-12 col-xs-12" style="margin: 15px 0px !important;">
		        	<hr>
		          		
		          		<span class="col-md-8 col-sm-6 col-xs-8" style="float: left; font-size: 16px;">Don't have an account?</span>		
		    
		        	
      <li class="home-help_1 col-md-4 col-sm-6 col-xs-4" onclick="signup_popup()" data-dismiss="modal" data-toggle="modal" data-target="#signup_popup">
     	 <a class="close" href="javascript:void(0);"><?php echo translate("Sign Up");?></a>
		</li>
		        	</div>
        </div>
       <!-- End of form for the sign in feature -->
     
  </div>
  
  
  
</div>
<!-- <script>
	function signup_popup_in()
	 {
	 var img = '<?php echo base_url()."images/ajax-loader.gif";?>'	
	 var loading = '<img style="width:100%;padding-bottom:15px;" src="'+img+'" />';
	
 	jQuery('#modal_body').html(loading);
 	jQuery('#modal_body2').html(loading);
 	jQuery.ajax(
 	{
 		url: '<?php echo base_url().'users/signup_popup'; ?>',
 		type: "post",
 		Format:"HTML",
 		success: function(data)
 		{
 			jQuery('#modal_body').html('');
 			jQuery('#modal_body').html(data);
 			jQuery('#modal_body2').html('');
 			jQuery('#modal_body2').html(data);
  		}
 	})
 }
</script> -->