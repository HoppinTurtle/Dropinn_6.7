<?php
            $logo         = $this->Common_model->getTableData('settings',array('code' => 'SITE_LOGO'))->row()->string_value;
			$default_lang = front_end_lang;
			$user_lang    = $this->session->userdata('locale');
			
			if($user_lang == '')
			{
			  $locale = $default_lang;
			}
			else
			{
			  $locale = $user_lang;
			}

			$currency_code = get_currency_code();

			$currency_symbol   = $this->Common_model->getTableData('currency', array('currency_code' => $currency_code))->row()->currency_symbol;
									
			if($this->dx_auth->is_logged_in())
			{
				if($this->dx_auth->get_username() == "")
				{
				$query          = $this->Common_model->getTableData( 'profiles',array('id' => $this->dx_auth->get_user_id()) )->row();
				$name           = $query->Fname.' '.$query->Lname;
				}
				else
				{
				$name           = $this->dx_auth->get_username();
				}
			}
			else
			{
			$name = '';
			}
  ?>
  <style>
  #currency_drop {
background-color: #FFFFFF;
}
#currency > select {
margin-left: 10px;
margin-top: 10px;

}
#language > select
{

	margin-top: 0px;
}
#lang_drop
{
	top:2px;
}
.modal
{
	background: rgba(0,0,0,0.5);
}
.modal-dialog
{
	max-width:450px;
	margin:10px auto;
}
.sign-fb-my-account > a > img, #gSignInWrapper img {
    margin: 22px 0 0 4px !important;
}
.blue_home
{
	padding:12px !important;
}
@media only screen and (max-width:640px)
{
.sign-fb-my-account > a > img, #gSignInWrapper img
{
	width:230px;
}
.modal-dialog
{
	margin:10px auto;
}
}
.popupsignin {
    float: left;
    margin: 0px 0;
    overflow: hidden;
    width: 100%;
}
.modal-open, .modal {
    overflow-x: hidden;
    overflow-y: auto;
}
/*
#language:before{
	background-image: url('images/arrow.png') no-repeat right 1px center transparent !important;
}*/
  </style>
  <script>
  
  jQuery('document').ready(function(){
  	
  //	$("#language_drop").datepicker($.datepicker.regional["fr"]);
  	
  	
  	
  	jQuery('#currency_drop').change(function()
  	{
  		/*var prop="";
  		if($("input[id='lightbox_property_type_id_House']").is(':checked')) 
  		{
  			prop+=$('#lightbox_property_type_id_House').val()+'@';
  		}
  		if($("input[id='lightbox_property_type_id_Apartment']").is(':checked')) 
  		{
  			prop+=$('#lightbox_property_type_id_Apartment').val()+'@';
  		}
  		if($("input[id='lightbox_property_type_id_Bed & Break Fast']").is(':checked')) 
  		{
  			prop+=$('#lightbox_property_type_id_Bed & Break Fast').val()+'@';
  		}*/
  		jQuery.ajax(
  		{
  			url: '<?php echo base_url().'users/change_currency'; ?>',
  			type: "post",
  			data: 'currency_code='+jQuery(this).val()/*+'&property_id='+$('#lightbox_property_type_id_House').val()+'&property_id='+$('#lightbox_property_type_id_Apartment').val()+'&property_id='+$('#lightbox_property_type_id_Bed & Break Fast').val()*/,
  			
  			success: function(data)
  			{		
  				
  					location.reload();
  				
  					//$('#clientsCTA').hide();	
    	    		$('#clientsDropDown #clientsDashboard').slideToggle({
      					direction: "down"
    					}, 300);
    				//window.location.reload();
    	    }
  		})
  	})
  	
  jQuery('#language_drop').change(function()
  	{
  		jQuery.ajax(
  		{
  			url: '<?php echo base_url().'users/change_language'; ?>',
  			type: "post",
  			data: 'lang_code='+jQuery(this).val(),
  			success: function()
  			{
  				location.reload();
  			}
  		})
  	})	
  })
 </script>
  <script type="text/javascript">	
jQuery("#close_search_footer").live("click",function()
{
    	$('#clientsCTA').hide();	
    	    $('#clientsDropDown #clientsDashboard').slideToggle({
      direction: "down"
    }, 300);
});

$(function() {
   $('.ui-datepicker').addClass('notranslate');
});
  function signin_popup()
 {
 	var t= "Don't have an Account";
 	jQuery('#modal_footer').html('<center><div class="checkbox rem_forgot" style="margin: 10px 0px 15px 0px!important;"><p class="Sign_Reminder_Me dont_account">'+t+'</p><p class="forget_pass signin_foot"><a href="javascript:void(0);" onclick="signup_popup()" class="forgot_anchor">Sign up now</a></p></div></center>');
 	jQuery.ajax(
 	{
 		url: '<?php echo base_url().'users/signin_popup'; ?>',
 		type: "post",
 		Format:"HTML",
 		success: function(data)
 		{
 			jQuery('#modal_body').html('');
 			jQuery('#modal_body').html(data);
 			jQuery('#signin_popup').css('display','block');
  		}
 	})
 }
 function signup_popup()
 {
 	 	jQuery('#modal_footer').html('<center><div class="checkbox rem_forgot" style="margin: 9px 0px 11px 0px!important;"><p class="Sign_Reminder_Me dont_account">Already an Yatching member?</p><p class="forget_pass signin_foot"><a href="javascript:void(0);" onclick="signin_popup()" class="forgot_anchor">Log in now</a></p></div></center>');
 	 	
 	jQuery.ajax(
 	{
 		url: '<?php echo base_url().'users/signup_popup'; ?>',
 		type: "post",
 		Format:"HTML",
 		success: function(data)
 		{
 			jQuery('#modal_body2').html('');
 			jQuery('#modal_body2').html(data);
 			jQuery('#signup_popup').css('display','block');
  		}
 	})
 }

</script>
<div id="Footer">

		<div id="footer" class="container">
<div class="col-md-4 col-sm-4 col-xs-12">
<!--<div id="footer" class="row">
<div class="span3 clearfix">
<h5><?php echo translate("Language Settings"); ?> </h5>-->
<div class="clsFloatLeft" style="margin-top: 10px;">
<div id="language">
<div class="football_img"> 
	<!--<img class="img_lang" src="<?php echo css_url(); ?>/images/football.png" /> 
	<!--<i class="fa fa-soccer-ball-o img_lang" style="color: #616161; margin-left: -4.9px;"></i>-->
		<i class="fa fa-globe img_lang"></i>

	</div>
<!--<div class="football_img" style="top:-9px; "> 
  <!--	<img class="img_lang" src="<?php echo css_url(); ?>/images/football.png" /> 
	<i class="fa fa-soccer-ball-o img_lang" style="color: #616161; margin-left: -4.9px;"></i>
</div>-->

<?php

$default_language = front_end_lang_ini;
if($default_language == 2)
{
?>
<!-- Begin TranslateThis Button -->

<!--<div id="translate-this"><a style="width:180px;height:18px;display:block;" class="translate-this-button" href="//www.translatecompany.com/translate-this/">Translate This</a></div>

<script type="text/javascript" src="//x.translateth.is/translate-this.js"></script><script type="text/javascript">TranslateThis();</script>

<!-- End TranslateThis Button -->
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'de,en,es,fr,it,pt', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        
<?php
}
else 
{
?>

<!--<div class="football_img"> 
<i class="fa fa-soccer-ball-o img_lang" style="color: #616161; margin-left: -3.9px; top: 9px"></i>
</div>-->
	

<?php
$default_language = front_end_lang;
$default_lang_name = $this->db->where('code',$default_language)->get('language')->row()->name;
?>
<?php if($this->session->userdata('language')=="") $default_lang_name = $default_lang_name; else $default_lang_name = $this->session->userdata('language'); ?>
<div class="arrow_sym">  </div>

<select id="language_drop" onchange="this.className = this.options[this.selectedIndex].className"  style="background-color: #FFFFFF;">
<?php 
$languages_core = $this->Common_model->getTableData( 'language',array('id <='=>6))->result();
foreach($languages_core as $language) { 
	if($language->name == $default_lang_name)
	{
		echo $s = 'selected';
	}
	else {
		echo $s = '';
	}
	?>

<option class="language option" value="<?php echo $language->code; ?>" id="language_selector_<?php echo $language->code; ?>" name="<?php echo $language->code; ?>" <?php echo $s;?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $language->name; ?></option> 

  	<?php } ?>						
</select>
<?php
}
?>																				
</div>
</div>

<div class="clsFloatLeft">
<div id="currency" class="notranslate">
<select id="currency_drop" onchange="this.className = this.options[this.selectedIndex].className">
<?php 
$currencies = $this->Common_model->getTableData('currency',array('status'=>1))->result();
foreach($currencies as $currency) {
	if($currency->currency_code == $currency_code) echo $s = 'selected';
	else echo $s = '';
	  ?>		
<option value="<?php echo $currency->currency_code; ?>" name="<?php echo $currency->currency_code; ?>" id="currency_selector_<?php echo $currency->currency_code; ?>" class="currency option" <?php echo $s;?>><?php echo $currency->currency_symbol.' '.$currency->currency_code; ?> </option>
<?php } ?>					
</select>																							
</div>		
</div>

</div>
<div class="col-md-4 col-sm-4 col-xs-12">
<h5><?php echo translate("Discover"); ?> </h5>
<ul class="unstyled js-footer-links">

<li>
<a href="<?php echo site_url('info/how_it_works'); ?>"><?php echo translate("How it works"); ?></a>
</li>

<?php 
$result = $this->db->where('is_footer',1)->where('is_under','discover')->from('page')->get();
if($result->num_rows()!=0)
{
	foreach($result->result() as $row)
	{
	echo '<li>
<a href="'.site_url("pages/view/".$row->page_url).'">'.$row->page_name.'</a>
</li>';
}
}
?>
</ul>
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
<h5><?php echo translate("Company"); ?></h5>
<ul class="unstyled js-footer-links">
<li>
<a href="<?php echo site_url('pages/contact'); ?>"><?php echo translate("Contact us");?></a>
</li>
<li>
<a href="<?php echo site_url('pages/faq'); ?>"><?php echo translate("FAQ"); ?></a>
</li>

<?php 
$result = $this->db->where('is_footer',1)->where('is_under','company')->from('page')->get();
if($result->num_rows()!=0)
{
	foreach($result->result() as $row)
	{
	echo '<li>
<a href="'.site_url("pages/view/".$row->page_url).'">'.$row->page_name.'</a>
</li>';
}
}
?>
</ul>
</div>
<?php
$sql="select url from joinus";$query=$this->db->query($sql);$result=$query->result_array();
$site=array();$i=1;
foreach($result as $res) { $site[$i]=$res['url']; $i=$i+1; }
	 $twitter  = $this->db->get_where('joinus', array('id' => '1'))->row()->url;
	 $facebook = $this->db->get_where('joinus', array('id' => '2'))->row()->url;
	 $google   = $this->db->get_where('joinus', array('id' => '3'))->row()->url;
	 $youtube  = $this->db->get_where('joinus', array('id' => '4'))->row()->url;
?>
<div class="col-md-offset-0 col-sm-offset-0 col-xs-12">
	<div class="joinus footer2">
<h5 style="text-align: center; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 21px; border-bottom: medium none ! important;"><?php echo translate("Join us on"); ?></h5>
<ul class="unstyled js-external-links">
<li>
<a target="_blank" href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
</li>
<li>
<a target="_blank" href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
</li>
<li> 
<a target="_blank" href="<?php echo $google; ?>"><i class="fa fa-google-plus"></i></a>
</li>
<li>
<a target="_blank" href="<?php echo $youtube; ?>"><i class="fa fa-youtube-play"></i></a>
</li>
</ul>
<div id="copyright footer_copy"><a style="color:white;" href="http://www.cogzidel.com/" target="_blank">Cogzidel Technologies</a><a style="color:white;" href="http://www.cogzidel.com/airbnb-clone/" target="_blank"> DropInn Software </a> is licensed under the <a style="color:white;" href="https://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a> </div>

</div>
</div>

</div>
<a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>

<!-- Advertisement popup 1 start -->
	<?php if(isset($PagePopupContent)) {
	$i = 1;
	?>
	
	<div>
	<ul class="pop_pos_foot">	
	<?php
	foreach($PagePopupContent as $Row) { ?> 

<li class="pop_footer" id="Notification_Popup_<?php echo $i; ?>" style="display:none;">
	<a href="javascript:void(0);" id="Notification_close_<?php echo $i; ?>"><img src="<?php echo css_url('image'); ?>/images/sin_cal_close.gif" /> </a>
	<h1 class="pop_footer_head"><?php echo $Row->content; ?></h1>
	<p></p>
</li>

<?php $i++; } ?>
</ul>
</div>

 <?php } ?>
	
	
<script type="text/javascript">	
<?php if(isset($PagePopupContent)) {
	$i = 1;
foreach($PagePopupContent as $Row)	{ 
	$FadeIn = ($i * 1000) + 1000;
	$FadeOut = ($i * 1000) + 5000;
	
	?>
setTimeout(function() { 
 jQuery("#Notification_Popup_<?php echo $i ?>").fadeIn(100, function() {
});
},<?php echo $FadeIn; ?>);
setTimeout(function() { 	
jQuery("#Notification_Popup_<?php echo $i ?>").fadeOut(18000, function() {
});
},<?php echo $FadeOut; ?>);
jQuery("#Notification_close_<?php echo $i ?>").click(function(){
jQuery("#Notification_Popup_<?php echo $i ?>").hide();
});
<?php $i++; } } ?>
</script>

<!-- Advertisement popup 1 end -->



<?php
if($this->uri->segment(1) == 'search')
{
	echo '<button id="close_search_footer"><img src="'.base_url().'images/close.png" height="15" width="15">&nbsp;Close</button>';
}
?>
<style>
#close_search_footer
{
		bottom: 0;
position: fixed;
right: 0px;
padding-bottom: 0%;
background: #FFFFFF;
border: 1px solid #DCE0E0;
color: #565A5C;
float: left;
height: 39px;
width: 95px;
font-weight: bold;
}
.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }

#scroll {
    position:fixed;
    right:10px;
    cursor:pointer;
    width:40px;
    height:40px;
    background-color:rgb(86, 90, 92);
    text-indent:-9999px;
    display:none;
    -webkit-border-radius:60px;
    -moz-border-radius:60px;
     border-radius: 100%;
    outline:none;
    -webkit-box-shadow: 4px 4px 8px 0px rgba(0,0,0,0.4);
     -moz-box-shadow: 4px 4px 8px 0px rgba(0,0,0,0.4);
     box-shadow: 4px 4px 8px 0px rgba(0,0,0,0.4);
     bottom: 15%;
    position: fixed;
    right: 25px;
    z-index: 99999999999;      
}
#scroll span {
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-8px;
    margin-top:-12px;
    height:0;
    width:0;
    border:8px solid transparent;
    border-bottom-color:#ffffff;
    outline:none;
}
#scroll:hover {
    /*background-color:#e74c3c;*/
    opacity:1;filter:"alpha(opacity=100)";
    -ms-filter:"alpha(opacity=100)";
    outline:none;
}
    
</style>
</body>
</html>

<script type="text/javascript" src="<?php echo base_url().'js/jquery.validate.min.js'; ?>"></script>

<?php
if($this->uri->segment(1) != 'search')
{
?>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
<?php
if($this->uri->segment(2) == 'editConfirm' || $this->uri->segment(1) == 'rooms') 
{
?>
<script>
	var places_API = "<?php echo $places_API;?>";
</script>
<script src="<?php echo base_url().'js/page3.js'; ?>"></script>
<?php
} 
else if($this->uri->segment(1) != 'users') 
{
	 
if($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '' || $this->uri->segment(2) == 'wishlists') 
{  
$js = array(
     array(cdn_url_raw().'/js/jquery.easing.1.3.min.js'),
    array(cdn_url_raw().'/js/jquery.sliderkit.1.8.min.js'),
    array(cdn_url_raw().'/js/sliderkit.delaycaptions.min.js'),
    array(cdn_url_raw().'/js/jquery.leanModal.min.js'),
    array(cdn_url_raw().'/js/responsiveslides.min.js'),
    array(cdn_url_raw().'/js/home_new.js')
);

$this->carabiner->group('slider',array('js'=>$js));
$this->carabiner->display('slider');
}
} 
  
}
if($this->uri->segment(2) == 'help')
{
	$help_js = array(
    array('jquery_help.min.js'),
    array('jquery-ui_help.min.js')
);

$this->carabiner->group('help',array('js'=>$help_js));
$this->carabiner->display('help');

}
if($this->uri->segment(2) == 'signin' || $this->uri->segment(2) == 'signup')
{
	?>
<script src="<?php echo base_url().'js/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
	<?php
} 
?>
<script>
jQuery(document).ready(function(){ 
    jQuery(window).scroll(function(){ 
        if (jQuery(this).scrollTop() > 100) { 
            jQuery('#scroll').fadeIn(); 
        } else { 
            jQuery('#scroll').fadeOut(); 
        } 
    }); 
    jQuery('#scroll').click(function(){ 
        jQuery("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});
</script>
