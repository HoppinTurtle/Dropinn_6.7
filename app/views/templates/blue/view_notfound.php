<style>
#mediaplayer_wrapper {
margin:0 auto;
padding:10px;
}
#notfound{
	margin-left: -10px;
}
a{
	text-decoration:  none;
	
}
a:hover{
	color:white;
	text-decoration:  none;
}

.btn:hover{
	color:white;
}

@media only screen and (max-width:480px){
	.mob-font {
    	font-size: 136px !important;
	}
}
</style>
<div id="book_it" class="container_bg container">
<div class="Box" id="View_notfound">
			
			
			<div class="Box_Head">
			<h2><?php echo translate("404 page not found"); ?></h2>
			</div>
			
<div class="Box_Content">
<div align="center" style="padding:0 0 10px 0;">
	
	
        
        
      <span style="font-size: 200px;" class="mob-font">4</span><i class="fa fa-frown-o mob-font" id="access" aria-hidden="true" style="font-size:210px;" ></i><span  style="font-size: 200px" class="mob-font">4</span>          

      <p style="font-weight: bold;">OOPS! requested page does not exist.</p>
      <a href="<?php echo site_url('home');?>"  class="btn blue_home" role="button">Go to Home</a>
        
      
	
	  


<!--<img src="css/templates/blue/images/search_icon1.png" />-->


	<!--
<img style="width:100%;" src="<?php echo base_url().'iages/access-denied.png'; ?>" />-->
</div>

</div>
</div>
</div>