<div id="View_Login">
	<?php
	//Show Flash Message
	if($msg = $this->session->flashdata('flash_message'))
	{
		$validation_msg = $msg;
		//redirect_admin('backend');
	}
	?>

<!--CONTENT-->
<div class="container-fluid top-sp body-color login-page">
	<div class="">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<h1 class="login-header"><?php  echo translate_admin("Member Area"); ?> - <?php echo translate_admin("Login"); ?> </h1>

        	<form method="post" action="<?php echo site_url('administrator/login'); ?>">
			<table class="col-md-offset-3 col-xs-8 col-sm-offset-3" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 20px 0px 0px 0px; text-align: center">
						<?php echo translate_admin("Username"); ?><span style="color: #FFFFFF;">*</span>
					</td>
					<td style="padding: 20px 0px 0px 0px;">
						<input class="focus" type="text" name="usernameli" value="<?php echo set_value('usernameli'); ?>"/>
						<?php echo form_error('usernameli'); ?>
					</td>
					
				</tr>
						
                <tr>
                	<td style="padding: 20px 0px 0px 0px; text-align: center">
                		<?php echo translate_admin("Password"); ?><span style="color: #FFFFFF;">*</span>
                	</td>
                	<td style="padding: 20px 0px 0px 0px;">
                		<input class="focus" type="password" name="passwordli" value=""/>
                		<?php echo form_error('passwordli'); ?>
                	</td>
                	
                </tr>
						
                <tr>
                	<td>&#160;</td>
                	<td style="padding: 20px 0px 0px 0px;">
                		<input type="submit" name="loginAdmin" value="<?php echo translate_admin("Submit"); ?>">
                        <input class="can-but" type="reset"name="reset" value="<?php echo translate_admin("Reset"); ?>">
                	</td>
                </tr>
				 
        
        
				</table>
				
				</div>             		
		</form>
		
		<tr><?php 
        if(isset($validation_msg))
        echo "<p class='login_msg'>".translate_admin("Use a valid username and password to gain access to the Administrator Back-end").'.'."<p>"; 
        ?></tr>
       
        <div class="clsLog_Bg"></div>
        <div class="clear"></div>
</div>
<!--END OF CONTENT-->
</div>
</div>
<style>
	.error_msg {
    color: white;
}
.login_msg
{
	text-align: center;
}

.page-header,.text_box_text{
	color: white;
}
header{
	        background: linear-gradient(to right, #2F9CF4 0%, #002E42 100%);
}
.top-sp{
	        background: linear-gradient(to right, #2F9CF4 0%, #002E42 100%);
	        color: white;
}
 .foot-bg{
 	        background: linear-gradient(to right, #2F9CF4 0%, #002E42 100%);
 	     border-top: 0px;
 	     color: white;
 }
.login-hg
{
	height:800px;
}
.navbar-static-top {
    background-color: none;
    border-bottom: none;
   }
   .container{
   	    overflow-x: hidden;
   }
   #View_Login .focus
   {
   		width: auto !important;
   }
</style>