<!--<script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>-->
<style>
iframe[src^="https://apis.google.com"] {
  display: none;
}
.modal-body
	{
		padding:0 !important;
	}
	.sign_up_pop{
		margin: 0px;
	}
	.term_popup
	{
		padding:0px 15px;
	}
	.close_signin_up
	{
	position: absolute;
    right: 8px;
    top: -5px;
    z-index: 1;
	}
	.buttonText, .buttonText:hover
	{
		margin:10px auto;
	}
	@media screen and (max-width:480px)
	{.term_popup{
		padding:0px;
	}
	}
	@media screen and (max-width:980px)
	{.modal-body{
		padding:15px 0px;
	}
	.popupsignin
{
	margin:0 auto 18px !important;
	padding-left: 10px !important;
    padding-right: 10px !important;
}
	}
	 @media (min-width:300px) and (max-width:500px) {
 	.signup_frm{
	width: 89% !important;
}
</style>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.js"> </script>-->
<!--<script src="http://connect.facebook.net/en_US/all.js"></script>-->
  <script type="text/javascript">  
	window.onbeforeunload = function(e){
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
        		//toggleElement('signin-button'); // Hide the sign-in button after successfully signing in the user.
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
 	/*   document.getElementById('name').innerHTML = profile['displayName'];
    document.getElementById('pic').innerHTML = '<img src="' + profile['image']['url'] + '" />';
    document.getElementById('email').innerHTML = email; */
     toggleElement('profile');
   	var PostData = 'name='+name+'&first_name='+first_name+'&last_name='+last_name+'&id='+profile['id']+'&url='+profile['url']+'&imageurl='+profile['image']['url']+'&email='+email;
           jQuery.ajax(
           	{
	            url: "<?php echo base_url()?>users/google_signin",            
	            type: "POST",                       
	            data:PostData,
	            success: function (result) { 
	            window.location.href = '<?php echo base_url();?>'+result;                  
            },
            error: function (thrownError)
            {           },
           
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
	jQuery(function() {
    jQuery(".labelBlur + input").change(function() {
        if(jQuery(this).val().length) {
            jQuery(this).prev('.labelBlur').hide();
        } else {
            jQuery(this).prev('.labelBlur').show();
        }
    });
     jQuery(".labelBlur + input").keyup(function() {
        if(jQuery(this).val().length) {
            jQuery(this).prev('.labelBlur').hide();
        } else {
            jQuery(this).prev('.labelBlur').show();
        }
    });
    jQuery(".labelBlur").click(function() {
        jQuery(this).next().focus();
    });
});
jQuery(".Txt_input label").focus(function(){
jQuery(".hidden").show();
});	

jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please"); 

jQuery("#signup").validate({
	 	rules: 
	 	{ 
			 first_name: 
			 {	lettersonly: true,
			 	required:true,},
			 last_name: 
  		 	{	lettersonly: true, 
  		 		required:true,},
  		 	
			   
			   username:
			 {	required:true,
				 remote: 
			   {
				   url: "<?php echo  base_url();?>users/user_name_check",
				   type: "post",
				   data: 
				   {
					   email: function() {return jQuery( "#username" ).val();}
				  }
				}
			},
			   
			   
  		 	email:
  		 	{	
  		 		required: true,
			     email: true,
			     remote: 
			     {
                 	url: "<?php echo  base_url();?>users/emailcheck",
                 	type: "post",
                 	data: 
                 	{
                 		email: function() {return jQuery( "#email" ).val();}
            		}
          		}
          	},
  		 	password:
    	    {	required:true,
    	    	minlength: 5,
		    	maxlength:16
		    },
		    remember_me:
		    {
		    	required:true
		    },
    	    confirmpassword:
    	    {  	required:true,	equalTo: "#password1"	},
		},
		messages: 
   		{ 
			 first_name:
			{ 
				  required:"First Name Required",
				  lettersonly: "First Name Must Contain Letters"
			},
			 last_name: 
			 {  
				   required:"Last Name Required",
				   lettersonly: "Last Name Must Contain Letters"
			 },
			email:
			{
				required:"Email is Required",
				 email: "Enter a Valid Email ID ",
				   remote: "Email ID Already Taken"
			},
			
			username: 
			{  
				   required:"User Name Required",
					remote: "User Name Already Taken"
			},
			password:
   			{ 
			 	required:"Password Required",
			 	minlength: "Password Needs Minimum 5 Characters",
			 	maxlength: "Password Needs Maximum 16 Characters" 
   	 		},
   	 		remember_me: 
			{  
				   required:"Reqiured",
			},
   	  		 confirmpassword:
   			 {
			 	required: "Confirm Password Required",
			 	 equalTo: "Password Does Not Match"
   	 		 },
   	 		
   	  	}   });	


});

jQuery(".close").click(function()
		{
			jQuery("#signup_popup").removeClass('in');
			jQuery("#signup_popup").css('display','none');
		})
//News Letter

FB.init({ 
       appId:'<?php echo $fb_app_id; ?>', 
       frictionlessRequests: true
     });
     function login()
     { 
  //  document.getElementById('light').style.display='block'; 
            FB.login(function(response) {
    if (response.authResponse) {
        FB.api("/me?fields=name,email,first_name,last_name", function(me){
            if (me.id) {
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
            	//alert(me.hometown.name);
            	//alert('https://graph.facebook.com/'+id+'/picture?type=square'); return false;	
            	jQuery.ajax({
  type: "POST",
  dataType: "text",
  url: '<?php echo base_url()."facebook/success";?>',
  data: { id: id, email: email, name: first_name, Lname: last_name, live: live, src: picture, username: username },
   success: function(data)
        {
        	//alert(data);
			  // jQuery('#category'+value).checked;
			  if(data)
        	{
		window.location.href = '<?php echo base_url();?>'+data;
			}  
			 //alert(value);
			  
              
        	
       // jQuery('#overlay_form_fb').html(data);
        }
});
            	  }
        });
    }
}, {scope: 'email'});
}
</script>
    
<div class="signup_head">
<div id="section_signup" class="signup_h1">
   <!-- Facebook Login is under here -->
    <div class="clsSign_Top  col-xs-12">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <div class="" style="">
	       	<div class="signin-heading"><p class="signform_head text-center">Sign Up</p> </div>
	       </div>
	       
	     <div class="sign_up_pop clearfix">
	       
        <div class="sign-fb-my-account col-xs-12"  style="padding:0 15px !important">
            
            <?php if ( !$this->facebook_lib->logged_in() ): ?>
            	
            <a href="javascript:void(0)" onclick="login();" class="google_login_1 log_fb login_fb Sign_Fb_Bg_1 col-md-12 col-sm-12 col-xs-12">
            	
            	<i class="fa fa-facebook signin" aria-hidden="true"></i>
                	<p class="fb_login">Sign up With Facebook</p>
            	
            </a>
            <fb:facepile></fb:facepile>
            <?php else:?>
            <?php redirect('facebook/login'); ?>
            <?php endif;?>
            
           <!-- Twitter sign up -->
           
           <a href="<?php echo base_url().'users/redirect';?>" class="google_login_1 login_twitter sign_up_tw_bg col-md-12 col-sm-12 col-xs-12">
           	
           	<i class="fa fa-twitter signin" aria-hidden="true"></i>
            <p class="fb_login">Sign up With Twitter</p>
           	
           </a>
           <!-- Twitter sign up -->
           
          <!-- <p class="Sign_Or_Row"><span><?php echo translate("Or"); ?></span></p> sign_up_google_bg -->
          
        
     <!-- <span class="buttonText_up"></span>-->
  
    	<div id="customBtn" class="google_login_1 customGPlusSignIn col-md-12 col-sm-12 col-xs-12">
							<img class="fa fa-googleplus" src="<?php echo base_url();?>images/Google-plus.png"/>
							<p class="fb_login">Sign up With Google</p>
							</div>
							</div>
   	
	<p class="Sign_Or_Row signup_frm col-xs-12 col-sm-12 col-md-12"><span><?php echo translate("Or"); ?></span></p>
  
        <div class="clsSign_Email">
            <?php echo form_open("users/signup", array('name' => 'signup', 'id' => 'signup' , 'class' => 'popupsignin')); ?>
             <div id="Input_First" class="Txt_input signup_frm col-sm-12">
             	<!--<label for="first_name" class="labelBlur required"><?php echo translate("First Name"); ?><span class="red">*</span></label>-->
             	<i class="fa fa-user" aria-hidden="true"></i>
		    	<input type="text" name="first_name" id="first_name" placeholder="First Name" class="inputname" value="<?php echo set_value('first_name'); ?>" />
		    	
            </div>
            <?php echo form_error('first_name'); ?>
			<div id="Input_Last" class="Txt_input signup_frm col-sm-12">
				<!--<label for="last_name" class="labelBlur required"><?php echo translate("Last Name"); ?><span class="red">*</span></label> -->
               <i class="fa fa-user" aria-hidden="true"></i>
               <input type="text" name="last_name" id="last_name" class="inputname" placeholder="Last Name" value="<?php echo set_value('last_name'); ?>" />
            </div>
            <?php echo form_error('last_name'); ?>
		
			<div id="Input_User" class="Txt_input signup_frm col-sm-12">
				<!--<label for="username1" class="labelBlur required"><?php echo translate("User Name"); ?><span class="red">*</span></label>--> 		   
				<i class="fa fa-user" aria-hidden="true"></i>
				<input type="text" name="username" id="username1" placeholder="User Name" class="inputname" value="<?php echo set_value('username'); ?>" />
			</div>
			<?php echo form_error('username'); ?>
            <div id="Input_Mail" class="Txt_input signup_frm col-sm-12">
            	<!--<label for="email" class="labelBlur required"><?php echo translate("Email Address"); ?><span class="red">*</span></label>-->
            	<i class="fa fa-envelope-o" aria-hidden="true"></i>
            	<input type="text" name="email" id="email" placeholder="Email Address" class="inputname" class="Sign_Inp_Bg" value="<?php echo set_value('email'); ?>" />
            </div>
            <?php echo form_error('email'); ?>
			<div id="Input_Password" class="Txt_input signup_frm col-sm-12">
				<!--<label for="password1" class="labelBlur required"><?php echo translate("Password"); ?><span class="red">*</span></label>-->   
            	<i class="fa fa-lock" aria-hidden="true"></i>
            	<input id="password1" name="password" size="30" placeholder="Password" class="inputpass" type="password" value="" />
            </div>
            <?php echo form_error('password'); ?>
            <div id="Input_Password" class="Txt_input signup_frm col-sm-12">
            	<!--<label for="re_password" class="labelBlur required"><?php echo translate("Confirm Password"); ?><span class="red">*</span></label>--> 
              	<i class="fa fa-lock" aria-hidden="true"></i>
              	<input id="re_password" name="confirmpassword" size="30" placeholder="Confirm Password" class="inputpass" type="password" value="" />
            </div>
            <?php echo form_error('confirmpassword'); ?>
			<p class="col-xs-12">
            <label class="forgot_pass">
				<span class="signemailcolor">*</span><?php echo translate("Required fields"); ?>
			</label>
			<span class="clearfix"></span>
			</p>
			<center>
			<div class="col-xs-12 col-sm-12 col-md-12">
			<button name="SignUp fontopen" class="blue_home sign_in_btn_1 col-md-12 col-sm-12 col-xs-12" type="submit"><span><span><?php echo translate("Sign up"); ?></span></span></button>
			</div>
			</center>
			<?php echo form_close(); ?>
        <!--  End of form for sign up -->
        </div>
        
        </div>
        <div class="create_acc col-md-12">
           <span class="col-md-8 col-sm-8 col-xs-8"> <?php echo translate("Already a member?"); ?></span>
           
           <li style="float: right" class="col-md-4 col-sm-4 col-xs-4 home-help_1" onclick="signin_popup()" data-dismiss="modal" data-toggle="modal" data-target="#signin_popup">
      	<a class="close" href="javascript:void(0);"><?php echo translate("Sign In");?></a>
      </li>
           <!-- <a href="<?php echo base_url().'users/signin';?>"><?php echo translate("Sign in"); ?></a>-->
            </div>
        
    </div>
</div>
</div>
