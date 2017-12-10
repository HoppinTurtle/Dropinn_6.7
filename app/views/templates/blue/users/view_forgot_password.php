<div id="forgot_password_container" class="Box col-md-12 col-sm-12 col-xs-12 no_padding ">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <div class="Box_Head1">
    <h2 class="pol_msgbg"> <?php echo translate("Reset Password"); ?> </h2>
  </div>
  <div class="Box_Content">
      <p> <?php echo translate("Enter your e-mail address to have the password associated with that account reset. A new password will be e-mailed to the address."); ?> </p>
      <form id="Forgot" name="Forgot" action="<?php echo site_url('users/forgot_password'); ?>" method="post">
        
        <p><input id="password" name="email" type="text" value="" class="required" /></p>
								<span style="color:#FF0000"><p id="message"></p></span>
        <p style="width:100%; text-align:center;">

        	<button type="submit" class="btn_sign" name="commit"><span><span><?php echo translate("Reset Password"); ?></span></span></button>

        	<!--<button type="submit" class="btn blue gotomsg forgot-pswd" name="commit"><span><span><?php echo translate("Reset Password"); ?></span></span></button>-->

           </p>
      </form>
  </div>
</div>
<style>
.modal-body{
	padding: 0px !important;
}
.Frm_Error_Msg{
color:#FF0000;}
.Box {
    background: #fff none repeat scroll 0 0;
    border-radius: 6px;
    border:0px;
    box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.15);}
  .Box_Head1 {
    background: #fafafa none repeat scroll 0 0;
    border-bottom: 1px solid #c3c3c3;
    border-top: 1px solid #c3c3c3;
    border-right:0px;
    border-left:0px;
    height: 50px;
    margin-top:0px;}
    .close{
    	   margin-right: 5px;
    margin-top: 10px;
    }
    .Box_Content {
    overflow: hidden;
    padding: 10px;
    word-wrap: break-word;}
    
    .btn_sign{
    	padding:12px 50px;
    	border-radius:3px;
    }
    @media (min-width:300px) and (max-width:500px) {
    .modal-body{
    	padding: 0px !important;
    }
    #fancybox-wrap {
    left: 0% !important;
    width: 100% !important;
}
    }
    .fancybox-wrap{
    	top: 200px !important;
    }
    .close {
    margin-right: 10px !important;
    }
</style>
<script type="text/javascript">
$('.forgot-pswd').click(function(){
	$('.forgot-pswd').css('margin-top','-20px');
});
$(document).ready(function(){
$("#Forgot").validate({
   errorElement:"p",
			errorClass:"Frm_Error_Msg",
			focusInvalid: false,
			submitHandler: function(form) 
			{
				  	$.post("<?php echo site_url('users/forgot_password'); ?>", $("#Forgot").serialize(),
							function(data)
							{
							$("#message").show();
							$("#message").html(data);
							$("#message").delay(3000).fadeOut('slow');
							
							}
						);
				}
			});
})
$(".close").click(function()
		{
			$("#fancybox-content").removeClass('in');
			$("#fancybox-content").css('display','none');
		})
</script>