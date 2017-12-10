<!Doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Meta Content from user -->
<meta http-equiv="X-UA-Compatible" content="IE=10">
<meta name="title" content="<?php if(isset($title)) echo $title; else echo ""; ?>" />
<meta name="keywords" content="<?php if(isset($meta_keyword)) echo $meta_keyword; else echo ""; ?>" />
<meta name="description" content="<?php if(isset($meta_description)) echo $meta_description; else echo ""; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="google-translate-customization" content="376d9d52f1776ee3-46f58b508c85587c-ged0a34236ce0763e-1e"></meta>
<!-- favicon image 1 start -->
<?php

error_reporting(0);
?>
<?php

if($this->uri->segment(1)=="rooms" )
{
$this->session->set_userdata('redirect_to', url_with_query() );
}
if($this->uri->segment(2)=="help" )
{
$this->session->set_userdata('redirect_to','');
}

	        $query = $this->db->get_where('settings', array('code' => 'FAVICON_IMAGE'));
			$favicon  		 = base_url().'logo/'.$query->row()->string_value;
			
			 ?>
			
<link rel="icon" href="<?php echo $favicon ?>" type="image">

<!-- favicon image 1 end -->

<?php
if($this->uri->segment(1) == 'rooms')
{
	if(isset($images))
	{
	if($images->num_rows() > 0)
	{
	foreach ($images->result() as $image)
		{			
			$url_link[] = base_url().'images/'.$image->list_id.'/'.$image->name;
		}
	} 
else {
	$url_link[] = base_url().'images/no_image.jpg';
}
$check = $this->db->where('id' ,$list->property_id)->get('property_type');
		  if($check->num_rows()!=0)
		  {
			$fb_share_property_type = $check->row()->type;
		  }
		  else {
			  $fb_share_property_type = 'No Property Type';
		  }
		  
if($list->user_id == $this->dx_auth->get_user_id())
			{
				$fb_share_address = $city.', '.$state.', '.$country;
			}
		else {
				$fb_share_address = $city.', '.$state.', '.$country;
			}
	?>
     <meta property="og:url" content="<?php echo base_url().'rooms/'.$list->id; ?>" />
     <meta property="og:title" content="<?php echo $list->title; ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?php echo $this->dx_auth->get_site_title(); ?>" />
	<meta property="og:description" content="<?php echo $fb_share_property_type.' in '.$fb_share_address.'. '.$list->desc; ?>" />
	<meta property="og:image" content="<?php echo $url_link[0]; ?>" />
<?php }
}
else if($this->uri->segment(2) == 'wishlists')
{
	?>
<meta property="og:title" content="<?php echo $wishlist_name;?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo base_url().'account/wishlists/'.$this->uri->segment(3);?>" />
<meta property="og:site_name" content="<?php echo $this->dx_auth->get_site_title(); ?>" />
<meta property="og:description" content="<?php echo $og_desc; ?>" />
	<?php if(isset($images))
	{
	?>
	<meta property="og:image" content="<?php echo $images; ?>" />
<?php }
}
else {
	?>
	<meta property="og:title" content="<?php echo 'Log In / Sign Up to '.$this->dx_auth->get_site_title(); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo base_url().'users/signup';?>" />
	<meta property="og:site_name" content="<?php echo $this->dx_auth->get_site_title(); ?>" />
	<meta property="og:description" content="<?php echo "Browse and book, or list your space. It's easy!"; ?>" />
	<meta property="og:image" content="<?php echo base_url().'images/dropinn_send_dialog.png'; ?>" />
	<?php
}
 ?>
<link rel="image_src" href="<?php echo base_url().'images/icon.png'; ?>" /> 
<link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Cogzidel" />
<link href="<?php echo css_url(); ?>/combine.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/home.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/signin_signup.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/browse.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/static.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo cdn_url_raw(); ?>uploads/font/font.css" media="screen" rel='stylesheet' type='text/css'>
<link href="<?php echo css_url(); ?>/responsive.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url(); ?>/dashboard.css" media="screen" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery_lib.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/affix.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/alert.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/button.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/collapse.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dropdown.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker-pt.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker-de.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker-es.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker-fr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker-it.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/popover.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/scrollspy.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tab.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/transition.js"></script>
    	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>

<style>
	html * :not(i)
{
     font-family: 'CircularStd-Book',"Helvetica Neue",Helvetica,Arial,sans-serif !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
     
}

@media only screen and (max-width:767px)
{
	#advanced_search_rooms
	{
	 width: 320px!important;
	}
	.head_backclr{
		overflow: visible !important;
	}
}
@media only screen and (min-width:768px) and (max-width:1024px)
{
	#advanced_search_rooms
	{
	 width: 100%!important;
	}
}
</style>
<link href="<?php echo css_url().'/font-awesome/css/font-awesome.min.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!-- Advertisement popup 1 start 
	
<link href="<?php echo css_url(); ?>/common.css" media="screen" rel="stylesheet" type="text/css" />-->

<!-- Advertisement popup 1 end -->
<?php echo common();

if($this->uri->segment(1) == 'rooms')
{
	?>
	<link href="<?php echo css_url(); ?>/rooms.css" media="screen" rel="stylesheet" type="text/css" />
	<?php
}

if($this->uri->segment(1) != 'search')
{
$this->carabiner->js(cdn_url_raw().'/js/common.js');
$this->carabiner->display('js');
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$query5 = $this->db->get_where('settings', array('code' => 'GOOGLE_ANALYTICS_CODE'));
echo $query5->row()->text_value;

autologin();

$mainpath =  dirname($_SERVER['SCRIPT_FILENAME']);
$user_id = $this->session->userdata('DX_user_id');
$is_banned = $this->db->where('id',$user_id)->where('banned',1)->get('users')->num_rows();
if($is_banned == 1)
{
	$this->session->set_userdata('is_banned',1);
	redirect('users/logout');
}
$fb_app_id = fb_api;
?>
<script>

var NREUMQ=[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);(function(){var d=document;var e=d.createElement("script");e.type="text/javascript";e.async=true;e.src="<?php echo base_url(); ?>js/rum.js";var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(e,s);})()
var base_url = '<?php echo base_url(); ?>';var symbol = '<?php echo get_currency_symbol1(); ?>';var min_price = '<?php echo get_currency_value(10);?>';var max_price = '<?php echo get_currency_value(10000);?>'; var cdn_img_url = '<?php echo cdn_url_images();?>'; 
var default_value = '<?php echo "Where are you going?"; ?>';
var lat = '<?php echo $this->session->userdata('lat'); ?>'; var lng = '<?php echo $this->session->userdata('lng'); ?>'; var time = 1;
</script>

<script>
function translate_month(e){
 	
  // alert(e);
 	var current_ ="<?php echo $this->session->userdata('language') ?>" ;
 	
 	
 	var en=["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    
   //array['0']=''
    var	 fr=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    var it= ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
 	var sp= ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
 	 var gr= ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];
    var po= ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];	
 
 //	alert(current_);
 	switch(current_)
 	{
 	 case 'French':
 	      
 	      return fr[e];
 	     
 	      break;
 	 case 'Italian':
 	      return it[e] ;
 	      break;
 	  case 'Spanish':
 	      return sp[e];
 	      break;
 	 case 'German':
 	      return gr[e];
 	      break;  
 	 case 'Portuguese':
 	      return po[e];
 	      break; 
 	 default: 
 	    return en[e];
 	
 	      break;                       	
 		
 	}
 	
 	
 }

function translate_day(o)
{
	

 var current_ ="<?php echo $this->session->userdata('language') ?>" ;
 
  var fr=['Di','Lu','Ma','Me','Je','Ve','Sa'];
 
 var en=['Su','Mo','Tu','We','Th','Fr','S'];
 var it=['Do','Lu','Ma','Me','Gi','Ve','Sa'];
 var sp=['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'];
 var gr=['So','Mo','Di','Mi','Do','Fr','Sa'];
 var po=['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'];
 
 switch(current_)
 	{
 	 case 'French':
 	      
 	      return fr[o];
 	     
 	      break;
 	 case 'Italian':
 	      return it[o] ;
 	      break;
 	  case 'Spanish':
 	      return sp[o];
 	      break;
 	 case 'German':
 	      return gr[o];
 	      break;  
 	 case 'Portuguese':
 	      return po[o];
 	      break; 
 	 default: 
 	    return en[o];
 	
 	      break;                       	
 		
 	}
 
	
}

 function translate_today(to)
 {
 	
 	
 	var current_ ="<?php echo $this->session->userdata('language') ?>" ;
    var fr="aujourd'hui";
    var en="Today";
    var it="oggi";
    var gr="heute";
    var sp="hoy";
    var po="hoje";
  
    switch(current_)
 	{
 	 case 'French':
 	      
 	      return fr;
 	     
 	      break;
 	 case 'Italian':
 	      return it ;
 	      break;
 	  case 'Spanish':
 	      return sp;
 	      break;
 	 case 'German':
 	      return gr;
 	      break;  
 	 case 'Portuguese':
 	      return po;
 	      break; 
 	 default: 
 	    return en;
 	
 	      break;                       	
 		
 	}
   
    
    
 }
 function translate_cleardates(clear)
 {
 	
 	var current_ ="<?php echo $this->session->userdata('language') ?>" ;

 	var fr="Dates claires";
 	 var en="Clear Dates";
    var it="Cancella date";
    var gr="Klar Termine";
    var sp="Fechas claras";
    var po="Limpar datas";
  
    switch(current_)
 	{
 	 case 'French':
 	      
 	      return fr;
 	     
 	      break;
 	 case 'Italian':
 	      return it ;
 	      break;
 	  case 'Spanish':
 	      return sp;
 	      break;
 	 case 'German':
 	      return gr;
 	      break;  
 	 case 'Portuguese':
 	      return po;
 	      break; 
 	 default: 
 	    return en;
 	
 	      break;                       	
 		
 	}
   
 	
 }
 
 

</script>

<title><?php echo $title ?></title>
<?php
if($this->uri->segment(1) == 'search')
{
?>
<script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>

<?php
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
?>
<?php
if($this->uri->segment(2) != 'verify')
{
?>
<script src="<?php echo base_url().'js/jquery.validate.min.js'; ?>" type="text/javascript"></script>
<?php } ?>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.ui.touch-punch.min.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>js/jquery-ui-sliderAccess.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>js/page2.js" type="text/javascript"></script>
<?php
 } 
 ?>

<script>

$(document).ready(function($){

    $("#subnavigation").focusout(function(){	
    	$('#subnavigation').addClass("booking_head");
    });
    $("#user_dropdown").focusout(function(){	
    	$('#user_dropdown').addClass("booking_head");  
    });
     $(".help_book").focusout(function(){	
    	$('.help_book').addClass("booking_head");    
    }); 
});(jQuery);
</script>
  <?php if($this->uri->segment('1') != "rooms")

{

?>

<!--<script src="<?php echo base_url().'js/facebook_invite.js'; ?>" type="text/javascript"></script>-->
<script src="http://connect.facebook.net/en_US/all.js"></script>
<?php

}

?> <?php if(($this->uri->segment('2') == "lys_next")||($this->uri->segment('2') == "new"))

{

?>

<!--<script src="<?php echo base_url().'js/facebook_invite.js'; ?>" type="text/javascript"></script>-->
<script src="http://connect.facebook.net/en_US/all.js"></script>

<?php

}

?>

<script>
	

FB.init({ 
       appId:'<?php echo $fb_app_id; ?>', 
       frictionlessRequests: true
     });
     
function logout()
{
	FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
  	
  } else if (response.status === 'not_authorized') {
   
  } else {
   window.location.href = "<?php echo base_url().'users/logout';?>";
  }
 },true);
FB.logout(function(response) {
  window.location.href = "<?php echo base_url().'users/logout';?>";
});
}
</script>
</head>
<!--browse dropdown start-->
<script>
	//$(document).ready(function(){

   // jQuery('.browse-dropdown').hover(

    //    function(){
    //        $(this).children('.browse-submenu').slideDown(200);
    //    },
      //  function(){
       //     $(this).children('.browse-submenu').slideUp(200);
    //    }

  //  );
 //  }
  //  });
</script>



<!--browse dropdown end-->
<?php ob_flush(); ?>

<body>
<div id="fb-root"></div>
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
			
			$currency_code     = $this->session->userdata('locale_currency');
			$new_currency      = $this->Common_model->getTableData('currency', array('default' => 1,'status'=>1));
			
			if($new_currency->num_rows() == 0)
			{
				$new_currency = $this->Common_model->getTableData('currency', array('status'=>1));
				if($new_currency->num_rows() == 0)
				{
					$new_currency = $this->Common_model->getTableData('currency', array('id'=>1))->row();
				}
				else
					{
						$new_currency = $this->Common_model->getTableData('currency', array('status'=>1))->row();
					}
			}
			else {
				$new_currency      = $this->Common_model->getTableData('currency', array('default' => 1,'status'=>1))->row();
			}
			if($currency_code == '')
			{
			  $currency_code   = $new_currency->currency_code;
					$currency_symbol = $new_currency->currency_symbol;
			}
			else
			{
			$currency_code     = $this->session->userdata('locale_currency');
			$currency_symbol   = $this->Common_model->getTableData('currency', array('currency_code' => $currency_code,'status'=>1));
			if($currency_symbol->num_rows()!=0)
			{
				$currency_symbol = $currency_symbol->row()->currency_symbol;
			}
			else {
				$currency_symbol = $this->Common_model->getTableData('currency', array('status'=>1)); 
				if($currency_symbol->num_rows() == 0)
				{
					$currency_symbol = $this->Common_model->getTableData('currency', array('id'=>1))->row()->currency_symbol;
				}
				else
					{
						$currency_symbol = $this->Common_model->getTableData('currency', array('status'=>1))->row()->currency_symbol;
					}
			}
			}
			
				$places_API = "" ;
			$places_API = google_api;
			
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
  <?php if($this->uri->segment(1) != 'listpay')
  {
  	if($this->uri->segment(1)!='calendar')
	{
   ?>
  <script type="text/javascript">
 var base_url = '<?php echo base_url();?>';
 var cdn_img_url = '<?php echo cdn_url_images();?>'; 
function disableEnterKey(e){  
var key;
    if(window.event){
    key = window.event.keyCode;
    } else {
    key = e.which;     
    }
    if(key == 13){
    return false;
    } else {
        return true;
    }
  }
function getSelectedText() {
        if (window.getSelection) {
            return window.getSelection().toString();
        } else if (document.selection) {
            return document.selection.createRange().text;
        }
        return '';
    }
          jQuery(document).ready(function(){

				var Translations = {
    translate_button: {
      
      show_original_description : 'Show original description',
      translate_this_description : 'Translate this description to English'
    },
    per_month: "per month",
    long_term: "Long Term Policy",
    clear_dates: "Clear Dates"
  }
       var date = new Date();
var currentMonth = date.getMonth();
var currentDate = date.getDate();
var currentYear = date.getFullYear();
var checkin_status = 0;
	   jQuery( "#checkoutdate2" ).datepicker({
                minDate: 1,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                closeText: "Clear Dates",
                currentText: Translations.today,
                showButtonPanel: true,
                onClose: function(dateText, inst) { 
                	
	 	<?php if($this->uri->segment(1)=='0')
		{  ?>
	 	jQuery('.advanced_search').show();
          <?php } else { ?>
       jQuery('.advanced_search_rooms').show();   
       <?php } ?>           
     },
      onSelect: function(dateText, inst) { 

    	if(checkin_status != 1) {
       	
        d = jQuery('#checkindate2').datepicker('getDate');
         if(!d)
         {
         	var d = new Date();
         	 d.setDate(d.getDate()); // add int nights to int date
		jQuery("#checkindate2").datepicker("option", "minDate", d);
         }
         else
         {
         	d.setDate(d.getDate()); // add int nights to int date
		jQuery("#checkindate2").datepicker("option", "minDate", d);
         }
   
    	setTimeout(function () 
		{
			jQuery("#checkindate2").datepicker("show")
                                }, 0)   
                                
           k = (d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear();

         jQuery( "#checkindate2" ).val(k) ; 
        }
        }       
	    });
	   
          jQuery(document).ready(function(){
	     jQuery(".ui-datepicker-close").live("mouseup", function() {
               // $.datepicker._clearDate(this);
               jQuery('#checkindate2').val('');
               jQuery('#checkoutdate2').val('');
           });

	    jQuery( "#checkindate2" ).datepicker({
			    minDate: date,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                closeText: "Clear Dates",
                currentText: Translations.today,
                showButtonPanel: true,
	 onClose: function(dateText, inst) { 
	 	 
	 	<?php if($this->uri->segment(1)=='0')
		{  ?>
			
	 	jQuery('.advanced_search').show();
          <?php } else { ?>
          	
       jQuery('.advanced_search_rooms').show();   
       <?php } ?>  
    },
    onSelect: function(dateText, inst) {
    	checkin_status = 1;
          d = jQuery('#checkindate2').datepicker('getDate');
         if(!d)
         {
         	var d = new Date();
         	 d.setDate(d.getDate()+1); // add int nights to int date
		jQuery("#checkoutdate2").datepicker("option", "minDate", d);
         }
         else
         {
         	d.setDate(d.getDate()+1); // add int nights to int date
		jQuery("#checkoutdate2").datepicker("option", "minDate", d);
         }
    	setTimeout(function () 
		{
			jQuery("#checkoutdate2").datepicker("show")
                                }, 0)                      
           k = (d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear();
         jQuery( "#checkoutdate2" ).val(k) ;       
    }
	   });
    });
 
jQuery(document).ready(function(){

	jQuery('.navbar-nav .dropdown').click(function() {
    jQuery('.navbar-nav .dropdown').not(this).find('.dropdown-menu').slideUp();
    jQuery(this).find('.dropdown-menu').slideToggle();
    	//jQuery(this).toggleClass("open");
    }); 
    


	jQuery("#close_search1").click(function(){
		<?php if($this->uri->segment(1)=='')
		{  ?>
	 jQuery("#advanced_search").fadeOut();
          <?php } else { ?>
      jQuery("#advanced_search_rooms").fadeOut();  
       <?php } ?> 
	
});
jQuery("#close_search").click(function(){
		<?php if($this->uri->segment(1)=='')
		{  ?>
	 jQuery("#advanced_search").fadeOut();
          <?php } else { ?>
      jQuery("#advanced_search_rooms").fadeOut();  
       <?php } ?> 
	
});
});
});
</script>
<?php
} 
}?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo $places_API;?>&libraries=places"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
	
    jQuery('#searchTextField').keypress(function(event)
    {
      var input = document.getElementById('searchTextField');
   
var keycode = (event.keyCode ? event.keyCode : event.which);

	if(keycode == '13'){
   	  $s_trim = jQuery.trim($(this).val()); 
		if($s_trim == 'undefined' || $s_trim == '')
		{
$(this).val("");
	 return false;
		}else{
			return true;
		}	
	}
    var autocomplete = new google.maps.places.Autocomplete(input);   
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
      var lat = place.geometry.location.lat();
      var lng = place.geometry.location.lng();
      jQuery('#lat').val(lat);
      jQuery('#lng').val(lng);
       jQuery('#lat1').val(lat);
      jQuery('#lng1').val(lng);
       jQuery.ajax({
            url: "<?php echo base_url()?>search/lat_lng",           
            type: "POST",                      
            data:"lat="+lat+"&lng="+lng,
            success: function (result) {
                     <?php if($this->uri->segment(1)=='0')
        {  ?>
         jQuery('.advanced_search').show();
          <?php
        }
else if($this->uri->segment(1) == 'search')
        {
            ?>
            window.location.href = '<?php echo base_url()."search?location=";?>'+$s_trim;
            <?php }
else
     { ?>
          jQuery('.advanced_search_rooms').show(); 
    <?php } ?>
            }
            });
  
         jQuery('#checkindate2').trigger('click');
    });
    })

});

</script>
<style>
.inbox_icon{
      		position: relative;
      	}
.inbox_count{
position: absolute;
top: 11px;
left: 31px;
/*right: 2px;
display: inline-block;*/
min-width: 9px;
padding: 1px 3px;
border-radius: 10px;
font-style: normal;
font-weight: bold;
font-size: 10px;
line-height: 13px;
color: #FFF;
border: 1px solid #FF5A5F;
background: none repeat scroll 0% 0% #FF5A5F;
}

#cal_container.center_entire{
/*height:500px!important;*/
}
/*#price_container.center_entire{
width:700px!important;
}
#overview_entire.center_entire{
height:500px!important;
}*/
#amenities_entire.center_entire{
padding-bottom:104px!important;
}
#listing_entire.center_entire{
padding:40px 40px 100px!important;
}
.myentire{
padding-bottom:120px !important;
}
/*#photos_container.center_entire{
height:500px!important;
}*/
}

#listing_entire.center_entire{
height:468px;
}     	
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus{
    background: #fff;
	color: #EB3C44 ;
    text-decoration: none!important;
	text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.2)!important;
	border:none !important;
	border-radius:4px!important;
} 
.ui-menu .ui-menu-item a.ui-state-hover, .ui-menu .ui-menu-item a.ui-state-active  {
    background-color: rgb(0, 176, 255)!important;
	outline:0px none;
    text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.2)!important;
    color: rgb(255, 255, 255)!important;
    text-decoration: none!important;  
   
}
.ui-menu .ui-menu-item a {
    font-weight: normal!important;
	margin:-1.2px -1.8px 0px -1.8px !important;
    padding: 12px!important;
    font-size: 1.2em!important;
    display: block!important;
    clear: both!important;
    line-height: 18px!important;
    color: rgb(57, 60, 61)!important;
    white-space: nowrap!important;
	border-bottom: 1px solid rgb(238, 238, 238)!important;
	border-radius:0px!important;
}
.ui-menu li:first-child a{
border-top-width:0px!important;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
    border-radius: 4px!important;

}
.pac-item-query
{
	color:#eb3f44;
	cursor: pointer;
	font-size: 16px;
}
.pac-item
{
	color:#eb3f44;
	cursor: pointer;
	font-size: 16px;
	padding-left: 10px;
}

.pac-icon
{
	width:0px;
}
.pac-container
{
	/*border: black;*/
}
.Box_Head bookhead h2{
 	text-align:left;
 }
 .dashed_table .label {
 	/*width:132px !important;*/
 }
 .container_bg {
    text-align: left;
}
.dashed_table .data .inner {
/*    margin: -43px 0 0 125px;*/
}
.bookhead > h2 {
	text-align:left !important;
	}
.Box_Content
{
	
	<p> Please provide your billing details now and the 
place shall be booked for your purpose</p>

}

#property_details #hosting_details p{
    padding: 4px 0 -8px;
}
#hosting_details > p {
    display: block;
    position: relative;
    right: 5%;
}
#property_details .main_photo {
    border: 1px solid #CFCFCF;
    display: block;
    float: left;
    height: 140px;
    margin-right: 21px;
    padding: 2px;
    width: 160px !important;
}

  #currency_drop {
background-color: transparent;
    /*-webkit-appearance: none;*/
    -moz-appearance: none;
    background-image: url("images/down_arrow1.png");
    background-position: right 9px center;
    background-repeat: no-repeat;
    padding-left: 18px;
    text-indent: 0.01px;
    text-overflow: "";
    /*width:127px;*/
} 
#currency > select {
    
    margin-top: 9px;
    margin-left:0px !important;
    width:111px;
}
.rslides {
  position: relative;
  list-style: none;
  overflow: hidden;
  width: 100%;
  padding: 0;
  margin: 0;
  }

.rslides li {
  -webkit-backface-visibility: hidden;
  position: absolute;
  display: none;
  left: 0;
  top: 0;
  padding: 0 7px !important;
  }

.rslides li:first-child {
  position: relative;
  display: block;
  float: left;
  }

/*.rslides img {
  display: block;
  height: auto;
  float: left;
  width: 100%;
  border: 0;*/
  }
  </style>
<!-- End of meta content -->
<!--Header-->
<title><?php echo $title ?></title>

<header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
<div id="header" class=" container-fluid">
	<div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?php echo base_url(); ?>" class="navbar-brand"> <img title="<?php echo $this->dx_auth->get_site_title(); ?>"  src="<?php echo base_url().'logo/'.$logo; ?>" width="137" height="45"> </a>
    </div>
     <nav class="collapse navbar-collapse bs-navbar-collapse head_backclr" role="navigation">
     	
      <ul class="nav navbar-nav">
        <li>

    <div class="search search_head"<?php if($this->uri->segment(2) == 'new' || $this->uri->segment(2) == 'lys_next' || $this->uri->segment(1) == 'search') echo 'style="display:none;"' ; else echo 'style=""' ?>>
      <form id="search_form1" action="<?php echo site_url('search'); ?>" method ="post" class="searchform_head">
      	
      	
      	<i class="fa fa-search heaericon"></i>
      <input type="text" id="searchTextField" name="searchbox" class="searchbox" value="<?php echo translate("Where are you going?");?>" onblur="if (this.value == ''){this.value = '<?php echo translate("Where are you going?");?>'; }"
   onfocus="if (this.value == '<?php echo translate("Where are you going?");?>') {this.value = ''; }" onKeyPress="return (event)" placeholder="<?php echo translate("Where are you going?"); ?>"/>
 
<input type="hidden" id="searchAP">
  <div id="map-canvas"></div>
  <input type="hidden" id="lat" name="lat" value="">
<input type="hidden" id="lng" name="lng" value="">
   <?php  if($this->uri->segment(1) == '0')
		{ 	$img_path=base_url().'images/close_red.png';?>
        <div class='advanced_search' id="advanced_search" style='display: none; position: absolute;
        z-index: 2147483647; background:#FCFCFC; border: 1px solid #CCCCCC; padding: 10px; opacity: 1;width: 250px;top:60px;'>     
    <label class="checkin_search">
	<?php echo translate('Check in'); ?>  
		<div id="checkinWrapper" class="input-wrapper">
		<input id="checkindate2" class="check_wrap checkin search-option ui-datepicker-target" type="text" placeholder="<?php echo translate('Check in'); ?>"  name="checkin" autocomplete="off" readonly>
		</div>
	</label>
	<label class="checkout-detail_search">
		<?php echo translate('Check out'); ?>
		<div id="checkoutWrapper" class="input-wrapper">
		<input id="checkoutdate2" class="check_wrap checkout search-option ui-datepicker-target" type="text" placeholder="<?php echo translate('Check out'); ?>" name="checkout" autocomplete="off" readonly>
	</div>
    </label>
	<label class="guest-detail_search">
		<div class="guests_section">
        <div class="heading">
          <?php echo translate("Guests"); ?>
        </div>
        <select id="number_of_guests" name="number_of_guests" placeholder="<?php echo translate('Guests'); ?>" class="guest-detail-section headergust" >
          <option placeholder="1">1</option>
          <option placeholder="2">2</option>
          <option placeholder="3">3</option>
          <option placeholder="4">4</option>
          <option placeholder="5">5</option>
          <option placeholder="6">6</option>
          <option placeholder="7">7</option>
          <option placeholder="8">8</option>
          <option placeholder="9">9</option>
          <option placeholder="10">10</option>
          <option placeholder="11">11</option>
          <option placeholder="12">12</option>
          <option placeholder="13">13</option>
          <option placeholder="14">14</option>
          <option placeholder="15">15</option>
          <option placeholder="16">16+</option>
        </select>
		</div>
	</label>
                    <div class="clearfix"></div>
                         <p class="filter_header"><?php echo translate("Room type"); ?></p>
                  	 <!-- Search filter content is below this -->
                    <div class="clearfix"></div>
                    <ul class="search_filter_content">
                        <li class="clearfix checkbox">
                        	<?php $room1 = $this->db->limit(1)->order_by('id','asc')->get('room_type')->row()->type;?>
                            <input class="checkbox_filter" type="checkbox" value="Entire home/apt" name="room_types1" id="room_type_0">
	                        <label class="checkbox_list" for="room_type_0"> <?php echo $room1; ?></label>
                        </li>
                        <li class="clearfix checkbox">
                        	<?php $room2 = $this->db->limit(1,1)->order_by('id','asc')->get('room_type')->row()->type;?>
                            <input class="checkbox_filter" type="checkbox" value="Private room" name="room_types2" id="room_type_1">
	                        <label class="checkbox_list" for="room_type_1"> <?php echo $room2; ?></label>
                        </li>
                        <li class="clearfix checkbox">
                        	<?php $room3 = $this->db->limit(1,2)->order_by('id','asc')->get('room_type')->row()->type;?>
                            <input class="checkbox_filter" type="checkbox" value="Shared room" name="room_types3" id="room_type_2">
                            <label class="checkbox_list" for="room_type_2"><?php echo $room3; ?></label>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
	<!--	<button id="submit_location" class="btn_dash" style=" font-size: 12px;margin: 10px 0; padding: 5px 11px;" type="submit" value="Search" name="Submit" >-->
		<!--<i class="fa fa-search submitloc"></i>-->
		<!--<img src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />-->
		<button id="submit_location" class="btn_dash" type="submit" value="Search" name="Submit" >
		<i class="fa fa-search submitloc"></i>
		<!--<img src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />-->
		<?php echo translate("Find a place"); ?>
		</button>
		<label class="btn_dash" id="close_search">
			<?php echo translate("Close"); ?>
			</label>
	</div>
	</form>
	</div>
	</li>
<?php }

	
	else {  
	?>
		<div class='advanced_search_rooms' id='advanced_search_rooms' style='display: none; position: absolute;
     background:#FCFCFC; border: 1px solid #CCCCCC; padding: 10px; opacity: 1; z-index: 2147483647; '>
    <label class="checkin_search adcheckin">
	<?php echo translate('Check in'); ?>
		<div id="checkinWrapper" class="input-wrapper">
		<input id="checkindate2" class="check_wrap checkin search-option ui-datepicker-target" type="text" placeholder="<?php echo translate('Check in'); ?>" name="checkin" autocomplete="off" readonly>

		</div>
	</label>
	<label class="checkout-detail_search adcheckin">
		<?php echo translate('Check out'); ?>
		<div id="checkoutWrapper" class="input-wrapper">
		<input id="checkoutdate2" class="check_wrap checkout search-option ui-datepicker-target" type="text" placeholder="Check out" name="checkout" autocomplete="off" readonly>

	</div>
    </label>
		<label class="guest-detail_search" for="number_of_guests">
			<?php echo translate("Guests"); ?><br />
                <select id="number_of_guest" name="number_of_guests" class="guest-detail-section noguest">
                  		<?php for($i = 1; $i <= 16; $i++) { ?>
							<option placeholder="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> </option>
														       <?php } ?>
                </select>
		</label>
				<div class="clearfix"></div>
					<p class="filter_header"><?php echo translate("Room type"); ?></p>
				<div class="clearfix"></div>
                  	 <!-- Search filter content is below this -->
                    <ul class="search_filter_content">
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter check_filter" type="checkbox" value="Entire home/apt" name="room_types11" id="room_type_0">
	                        <label class="checkbox_list" for="room_type_0"> <?php echo translate("Entire home/apt"); ?> </label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter check_filter" type="checkbox" value="Private room" name="room_types22" id="room_type_1">
                        <label class="checkbox_list" for="room_type_1"> <?php echo translate("Private room"); ?> </label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter check_filter" type="checkbox" value="Shared room" name="room_types33" id="room_type_2">
                            <label class="checkbox_list" for="room_type_2"><?php echo translate("Shared room"); ?></label>
                        </li>
                    </ul>
                    <div class="clearfix"></div>

		<!--<button id="submit_location" class="btn_dash blue"  type="submit" value="Search" name="Submit" style=" font-size: 12px;margin: 10px 0; padding: 5px 11px;" >-->
		<!--<i class="fa fa-search submitloc"></i>-->
		<!--<img class="search_icon_checkinout" src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />-->

		<button id="submit_location" class="btn_dash" type="submit" value="Search" name="Submit" >
		<i class="fa fa-search submitloc"></i>
		<!--<img class="search_icon_checkinout" src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />-->
	<?php echo translate("Find A Place"); ?>
		</button>
        <label class='btn_dash blue' id="close_search1">
			<?php echo translate("Close"); ?>
			</label>
		</li>
	
	<?php } ?>
	</form>
    
    </li>

    <li id="subnavigation" class="dropdown browse-dropdown">
		<a class="dropdown-toggle header_link" href="#" data-toggle="dropdown"><?php echo translate("Browse")?> <span class="caret"></span></a>
	  	<ul class="dropdown-menu sub-menu browse-submenu">
	    <li><a href="<?php echo base_url().'home/popular/'?>"><!-- <i class="icon-popular"> </i>--> <i class="fa fa-heart"></i> <?php echo translate("Popular"); ?></a></li>
	    <li><a class="friends" href="<?php echo base_url().'home/friends/'?>"><i class="icon-friends"> </i> <?php echo translate("Friends"); ?></a></li>
	    <li><a class="map-neigh" href="<?php echo base_url().'home/neighborhoods/'?>"><!--<i class="icon-neighborhoods"> </i> --> <i class="fa fa-map-marker"></i><?php echo translate("Neighborhoods"); ?></a></li>
	    </ul>
	  </li>
      
    </ul>
    <!-- Self Timer Live Demo-

<span id="time_show" style="font-size: 14px; line-height:46px; color: white;"> </span> 

<span id="time_show" style="font-size: 20px; line-height:46px;  color: white;">
</span>

<!-- Self Timer Live Demo -->
 
    <ul class="nav navbar-nav navbar-right dropdown_list">
		      <?php if(0):  
		      /*	if($this->session->userdata('image_url') != '')
				   {
				      $src = $this->session->userdata('image_url');
				   }
				   else { */
					   
				  	 $src = $this->Gallery->profilepic($this->dx_auth->get_user_id(),1);
					   
				 //  }
		      	?>
		      	<?php 
		      	if($this->dx_auth->is_logged_in())
				{
		      	$via_login = $this->Common_model->getTableData('users',array('id'=>$this->dx_auth->get_user_id()))->row()->via_login;
				} ?>
			
			
			<li class="help"><a href="#"><?php echo /*translate("Hello").*/'&nbsp&nbsp'.    "<img src='".$src."'width='30' height='30'/>"
	      .'&nbsp&nbsp'.$name; ?></a>
			  <ul class="sub-help">
			      <li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>
			      <li><?php echo anchor('listings', translate("Your Listings")); ?></li>
			      <li><?php echo anchor('listings/my_reservation', translate("Your Reservations")); ?></li>
			      <li><?php echo anchor('travelling/your_trips', translate("Your Trips")); ?></li>
			       <li><?php echo anchor('account/mywishlist', translate("Wishlists")); ?></li>
			       <li><?php echo anchor('referrals', translate("Invite Friends")); ?></li>
			       <li><?php echo anchor('users/edit', translate("Edit Profile")); ?></li>
			       <li><?php echo anchor('account', translate("Account")); ?></li>
			       <?php if($this->dx_auth->is_admin()): ?>
			      <li><?php echo anchor('administrator', translate("Admin Panel"),array("target"=>"_blank")); ?></li>
			      <?php endif; ?>
			      <?php if($via_login != 'facebook')
				  {
				  	?>
				  	<li><?php echo anchor('users/logout', translate("Logout")); ?></li>
				  	<?php
				  }
                else {
				  ?>
			      <li><a id="logout" onclick="logout();"><?php echo translate("Logout");?></a></li>
			      <?php } ?>
			   </ul>
		
      </li>
    </ul>
   
      <?php elseif(!($this->dx_auth->is_logged_in())): ?>
      	
      <!--<li class="rightsign sign1"><?php echo anchor('users/signup', translate("Sign Up")); ?></li>
      <li class="rightsign sign1"><?php echo anchor('users/signin', translate("Sign In")); ?></li> -->
     
      <li class="home-help" onclick="signin_popup()" data-toggle="modal" data-target="#signin_popup">
      	<a href="javascript:void(0);"><?php echo translate("Sign In");?></a>
      </li>
       <li class="home-help" onclick="signup_popup()" data-toggle="modal" data-target="#signup_popup">
     	 <a href="javascript:void(0);"><?php echo translate("Sign Up");?></a>
		</li>
		<li class="lisyourspace" onclick="signin_popup()" data-toggle="modal" data-target="#signin_popup"> <a class="btn yellow" href="javascript:void(0);"><span><?php echo translate('List Your Space'); ?></span></a> </li>
      <?php else: 
      /*	if($this->session->userdata('image_url') != '')
		   {
		      $src = $this->session->userdata('image_url');
		   }
		   else {*/
			   
		  	 $src = $this->Gallery->profilepic($this->dx_auth->get_user_id(),1);
			   
		//   }
      	?>
<?php 
		      	if($this->dx_auth->is_logged_in())
				{
					$via_login = $this->Common_model->getTableData('users',array('id'=>$this->dx_auth->get_user_id()))->row()->via_login;
				} ?>
  <ul class="nav navbar-nav drop-lists drop-list_2">  
    <li class="dropdown browse-dropdown dropdown_home drop-down text-left" id="user_dropdown_1">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top:9px; padding-bottom: 15px;"><?php echo translate("Host");?>&nbsp&nbsp<i class="fa fa-home" aria-hidden="true"></i></a>
			<ul class="dropdown-menu sub-menu browse-submenu">
              <li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>
              
              <li><?php echo anchor('listings/my_reservation', translate("Your Reservations")); ?></li>
              <li class="lisyourspace_1"> <a class="btn_1" href="<?php echo site_url('rooms/new');?>"><span><?php echo translate('List Your Space'); ?></span></a> </li>
              <li><?php echo anchor('account/transaction', translate("Transaction History")); ?></li>
              <li><?php echo anchor('listings', translate("Manage Listings")); ?></li>
              <li><?php echo anchor('users/reviews', translate("Reviews")); ?></li>
             </ul>
            </li>
            
            <li class="dropdown browse-dropdown dropdown_home drop-down text-left" id="user_dropdown_2">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top:16px; padding-bottom: 15px;"><?php echo translate("Trips");?>&nbsp&nbsp<i class="fa fa-suitcase" aria-hidden="true"></i><span class="caret"></span></a>
			<ul class="dropdown-menu sub-menu browse-submenu">
            	<li><?php echo anchor('travelling/your_trips', translate("Your Trips")); ?></li>
            	<li><?php echo anchor('account/mywishlist', translate("Wish Lists")); ?></li>
            </ul>
            </li>
            
           </ul>
           
           
           
           
           
           
      <li class="dropdown browse-dropdown drop-list_2" id="user_dropdown">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top: 11px; padding-bottom: 15px;"><?php echo "<img src='".$src."'width='32' height='32'/>".'&nbsp&nbsp'.$name; ?><span class="caret"></span> </a>
			<ul class="dropdown-menu sub-menu browse-submenu">
              <!--<li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>-->
              <li><?php echo anchor('listings', translate("Your Listings")); ?></li>
              <li><?php echo anchor('referrals', translate("Invite Friends")); ?></li>
              
              
              <li><?php echo anchor('account', translate("Account")); ?></li>
              <li><?php echo anchor('users/edit', translate("Edit Profile")); ?></li>
              
              <?php if($this->dx_auth->is_admin()): ?>
              <li><?php echo anchor('administrator', translate("Admin Panel"),array("target"=>"_blank")); ?></li>
              <?php endif; ?>
             <?php if($via_login != 'facebook')
				  {
				  	?>
				  	<li><?php echo anchor('users/logout', translate("Logout")); ?></li>
				  	<?php
				  }
                else {
				  ?>
			      <li><a id="logout" onclick="logout();"><?php echo translate("Logout");?></a></li>
			      <?php } ?>
              
          </ul>
      </li>
      
      
      
        <!--responsive device open-->
      <ul class="nav navbar-nav dropdown_list head_lists">
      	
      	<li class="dropdown browse-dropdown" id="user_dropdown">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top: 11px; padding-bottom: 15px;"><?php echo "<img src='".$src."'width='32' height='32'/>".'&nbsp&nbsp'.$name; ?> <span class="caret"></span></a>
			<ul class="dropdown-menu sub-menu browse-submenu">
              <!--<li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>-->
              <li><?php echo anchor('listings', translate("Your Listings")); ?></li>
              <li><?php echo anchor('referrals', translate("Invite Friends")); ?></li>
              
              
              <li><?php echo anchor('account', translate("Account")); ?></li>
              <li><?php echo anchor('users/edit', translate("Edit Profile")); ?></li>
              
              <?php if($this->dx_auth->is_admin()): ?>
              <li><?php echo anchor('administrator', translate("Admin Panel"),array("target"=>"_blank")); ?></li>
              <?php endif; ?>
             <?php if($via_login != 'facebook')
				  {
				  	?>
				  	<li><?php echo anchor('users/logout', translate("Logout")); ?></li>
				  	<?php
				  }
                else {
				  ?>
			      <li><a id="logout" onclick="logout();"><?php echo translate("Logout");?></a></li>
			      <?php } ?>
              
          </ul>
      </li>
      
         <ul class="nav navbar-nav dropdown_list">
    <li class="dropdown browse-dropdown dropdown_home drop-down text-left" id="user_dropdown_1">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top:9px; padding-bottom: 15px;"><?php echo translate("Host");?>&nbsp&nbsp<!--<i class="fa fa-home" aria-hidden="true"></i>--><span class="caret"></span></a>
			<ul class="dropdown-menu sub-menu browse-submenu">
              <li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>
              
              <li><?php echo anchor('listings/my_reservation', translate("Your Reservations")); ?></li>
              <li class="lisyourspace_1"> <a class="btn_1 yellow" href="<?php echo site_url('rooms/new');?>"><span><?php echo translate('List Your Space'); ?></span></a> </li>
              <li><?php echo anchor('account/transaction', translate("Transaction History")); ?></li>
              <li><?php echo anchor('listings', translate("Manage Listings")); ?></li>
              <li><?php echo anchor('users/reviews', translate("Reviews")); ?></li>
             </ul>
            </li>
            </ul>
            <ul class="nav navbar-nav dropdown_list">
            <li class="dropdown browse-dropdown dropdown_home drop-down text-left" id="user_dropdown_2">
		 <a class="dropdown-toggle rightsign sign1" href="#" data-toggle="dropdown" style="padding-top:16px; padding-bottom: 15px;"><?php echo translate("Trips");?>&nbsp&nbsp<!--<i class="fa fa-suitcase" aria-hidden="true"></i>--><span class="caret"></span></a>
			<ul class="dropdown-menu sub-menu browse-submenu">
            	<li><?php echo anchor('travelling/your_trips', translate("Your Trips")); ?></li>
            	<li><?php echo anchor('account/mywishlist', translate("Wish Lists")); ?></li>
            </ul>
            </li>
            </ul>
          <ul class="nav navbar-nav dropdown_list">
           <li id="inbox_icon" class="inboxicon inbox-dp_2">
      	<a class="inbox_icon" href="<?php echo base_url(); ?>message/inbox">
      		<?php echo translate('Inbox'); ?>
      		<!--<img src="<?php echo base_url(); ?>/images/messageicon.fw.png" />-->
      		<!--<i class="fa fa-envelope-o fa-2x menudrop"></i>-->

      	<?php
      	if($this->dx_auth->get_user_id() != '')
		{ 
	$count = $this->Message_model->get_messages(array('messages.userto'=>$this->dx_auth->get_user_id(),'messages.is_read'=>0))->num_rows();		
			?>
			
		<script>// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe(count) {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification("<?php echo $this->dx_auth->get_site_title(); ?>", {
      icon: "<?php echo base_url().'logo/'.$logo; ?>",
      body: "Hey there! You've ("+count+") unread message",
    });

    notification.onclick = function () {
      window.location.href = "<?php echo base_url().'message/inbox';?>";      
    };
    setTimeout(function(){
notification.close();
},3000);

  }

}

function getContent( count )
{
	var queryString = { 'count' : '<?php echo $count; ?>' };
	
	jQuery.get ( "<?php echo base_url()?>home/get_notifycount", queryString , function ( data )
	{
		var obj = jQuery.parseJSON( data );
		//alert( obj.count);
		$( '.inbox_count' ).html( obj.count );
		notifyMe(obj.count);
		// reconecta ao receber uma resposta do servidor
		//getContent( obj.count );
	});
}

$( document ).ready ( function ()
{
	getContent();
});


</script>
<?php		}
		if($count != 0)
		{
		?>
      	<label class="inbox_count"><?php echo $count; ?></label>
      	<?php } ?>	
      	</a>
      	</li>
      	</ul>
      </ul>
      
      <!--responsive device close-->
      
      
      
      
      
    <!--  <li id="inbox_icon" class="inboxicon" style="padding: 13px 0px !important;">
      	<a class="inbox_icon" style="padding-top: 1px;padding-bottom: 1px !important;" href="<?php echo base_url(); ?>message/inbox">
      		<img src="<?php echo base_url(); ?>/images/messageicon.fw.png" />-->
      		<!--<i class="fa fa-envelope-o fa-2x menudrop"></i>-->

      <li id="inbox_icon" class="inboxicon inbox-dp">
      	<a class="inbox_icon" href="<?php echo base_url(); ?>message/inbox">
      		<!--<img src="<?php echo base_url(); ?>/images/messageicon.fw.png" />-->
      		<i class="fa fa-envelope-o fa-2x menudrop"></i>

      	<?php
      	if($this->dx_auth->get_user_id() != '')
		{ 
	$count = $this->Message_model->get_messages(array('messages.userto'=>$this->dx_auth->get_user_id(),'messages.is_read'=>0))->num_rows();		
			?>
			
		<script>// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe(count) {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification("<?php echo $this->dx_auth->get_site_title(); ?>", {
      icon: "<?php echo base_url().'logo/'.$logo; ?>",
      body: "Hey there! You've ("+count+") unread message",
    });

    notification.onclick = function () {
      window.location.href = "<?php echo base_url().'message/inbox';?>";      
    };
    setTimeout(function(){
notification.close();
},3000);

  }

}

function getContent( count )
{
	var queryString = { 'count' : '<?php echo $count; ?>' };
	
	jQuery.get ( "<?php echo base_url()?>home/get_notifycount", queryString , function ( data )
	{
		var obj = jQuery.parseJSON( data );
		//alert( obj.count);
		$( '.inbox_count' ).html( obj.count );
		notifyMe(obj.count);
		// reconecta ao receber uma resposta do servidor
		//getContent( obj.count );
	});
}

$( document ).ready ( function ()
{
	getContent();
});


</script>
<?php		}
		if($count != 0)
		{
		?>
      	<label class="inbox_count"><?php echo $count; ?></label>
      	<?php } ?>	
      	</a>
      	</li>

      <?php endif; ?>
<?php 
        	$segment =$this->uri->segment(2);
        	if($segment == 'help')
				  {  ?>
				  	<script>
				  	jQuery(document).ready(function(){
				  	jQuery('#view_help').hide();
				  	})
                   </script>	
				 <?php  }
				  ?>
                   <?php  
				 $u_agent = $_SERVER['HTTP_USER_AGENT']; 
				  if(preg_match('/MSIE/i',$u_agent))
{
       
      echo "<li id='view_help' style='float:left;width:85px;padding:0px;'>"; 
    }
	else
	{
	echo "<li id='view_help' style='float:left;'>";
	}
	
  ?>
            <li id='view_help' class="dropdown browse-dropdown help_book">
      	
      	<?php 
        	$segment =$this->uri->segment(2);
        	if($segment == 'help')
				  {
				  	
				  } else
				  {
				  	?>
	    <a class="dropdown-toggle view_help1" data-toggle="dropdown" href="#"><?php echo translate("Help") ?> <i class="fa fa-life-ring" aria-hidden="true"></i><span class="caret"></span></a> 
	    	<?php }?>
	     <ul class="dropdown-menu sub-menu browse-submenu">
	     	<?php	
			$static_que = $this->Common_model->getTableData('help',array('page_refer'=>'guide','status'=>0));
	     	if($static_que->num_rows()!=0)
			{ 
				foreach($static_que->result() as $row_status)
				{ $row_status->id;
					?>
					<li><a href="<?php echo base_url().'home/help/'.$row_status->id;?>"><?php echo $row_status->question.'</a>';?></li>
				<?php 
				
				} }
	     	?>
	     	<?php
	     	
					$id_segment =$this->uri->segment(1);
				    $segment =$this->uri->segment(2);
					if(!$id_segment)
					{
						 $sql = $this->Common_model->getTableData('help',array('id'=>1));
						 if($sql->num_rows()==0)
						 {
						 	
						 }
					}
					else {
						
					if($id_segment && !$segment)
					{
					 $sql = $this->Common_model->getTableData('help',array('page_refer'=>$id_segment));
					
					}
					else {
						$id_segment =$this->uri->segment(2,0);
						 $sql = $this->Common_model->getTableData('help',array('page_refer'=>$id_segment));
						
					}
					}
                  		  
					  
						foreach($sql->result() as $row)
						{
							 $my_id=$row->id;
						$segment=$row->page_refer;
						 $stat = $row->status;
							if($stat !=1)
							{ 
						 ?>
					 <?php echo '<li>';?><a href="<?php echo base_url().'home/help/'.$row->id; ?>"> <?php echo "$row->question";?> <?php } ?></a>
                       
					
				<?php echo'</li>';
				 } 
                ?>
 
          </ul>

       </li>
	    
      <?php  
				 $u_agent = $_SERVER['HTTP_USER_AGENT']; 
				  if(preg_match('/MSIE/i',$u_agent))
    {
       
      echo '</li>';
    }
	else
	{
	//echo '</div>';
	}
	if($this->uri->segment(1) == 'new' || $this->uri->segment(2) == 'lys_next')
	{
	}
	else {
	
  ?>


<!--<li class="listyourspace_menu"> <a class="yellow btn" href="<?php echo site_url('rooms/new');?>"><span><?php echo translate('List Your Space'); ?></span></a> </li>-->
    <?php
	}
	?>
	



    </nav>					

</div>
</header>

 <div class="modal fade" id="signin_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-width">
    <div class="modal-content">
      <div class="modal-body" id="modal_body">
      	<div class="text-center">
        <img src="<?php echo cdn_url_images(); ?>/images/loading.gif"/>
       </div>
      </div>
	  </div>
      <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="signup_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-width">
    <div class="modal-content">
      <div class="modal-body " id="modal_body2">
      	<div class="text-center">
        <img src="<?php echo cdn_url_images(); ?>/images/loading.gif"/>
       </div>
      </div>
	  </div>
      <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!--Header Ends-->
<?php if($this->uri->segment(2) == 'popular' || $this->uri->segment(2) == 'friends' || $this->uri->segment(2) == 'mywishlist' || $this->uri->segment(2) == 'wishlists')
{
?>
<div data-sticky="true" class="subnav wishlists-navbar">
    <div class="page-container-inner-header">
      <ul class="subnav-list">
        <li style="float:left;">
          <a href="<?php echo base_url().'home/popular';?>" data-route="popular" class="subnav-item" aria-selected="<?php if($this->uri->segment(2) == 'popular') echo 'true';?>">
             Popular
          </a>
        </li>
       <li style="float:left;">
          <a href="<?php echo base_url().'home/friends';?>" data-route="friends" class="subnav-item" aria-selected="<?php if($this->uri->segment(2) == 'friends') echo 'true';?>">
            Friends
          </a>
        </li>
      
         <li>
           <a href="<?php echo base_url().'account/mywishlist';?>" data-route="my" class="subnav-item" aria-selected="<?php if($this->uri->segment(2) == 'mywishlist' || $this->uri->segment(2) == 'wishlists') echo 'true';?>">
              My Wish Lists
           </a>
       
        </li>
    
      </ul>
    </div>
  </div>
  <?php
}
?>
<script>
	jQuery(".home-help").live('click', function(e) { 
   if( e.which == 2 ) {
      e.preventDefault();
   }
});
</script>
  <style>
 *, *:before, *:after, hr, hr:before, hr:after, input[type="search"], input[type="search"]:before, input[type="search"]:after {
   /* box-sizing: border-box;*/
}
  .subnav {
    -moz-user-select: none;
    /*background-color: #565a5c;*/
   background-color: #F5F5F5;
    position: relative;
    overflow:hidden;
}
	@media only screen and (min-width:270px) and (max-width:320px){
		.card.signin-card.pre-shift.no-name{
			width: 227px !important;
			padding: 10px 20px !important;
		}
		.google-header-bar.centered {
    height: 73px;
}
	}
	
	
.subnav-list > li
{
	line-height:40px;
}
.subnav-list {
    margin-left: -14px;
    margin-right: -14px;
}
.page-container-inner-header {
    width: 1045px;
}
.list-unstyled, .list-layout, .subnav-list, .sidenav-list {
    list-style: outside none none;
    padding-left: 0;
}
.list-layout, .subnav-list, .sidenav-list {
    margin-bottom: 0;
}
.page-container-inner-header, .page-container-responsive {
    margin-left: auto;
    margin-right: auto;
    padding-left: 25px;
    padding-right: 25px;
}
.subnav-item {
    color: #cacccd;
}
.subnav-text, .subnav-item {
   /* float: left;*/
    padding: 10px 14px;
    position: relative;
}
.subnav-item:hover
{
	color: #fff !important;
	text-decoration: none !important;
}
.check_filter{
	margin-top: 8px !important;
}
.subnav-item[aria-selected="true"]:before {
    background: none repeat scroll 0 0 #cacccd;
    bottom: 0;
    content: "";
    height: 4px;
    left: 14px;
    position: absolute;
    right: 14px;
}
.subnav-item[aria-selected="true"]
{
color: #fff !important;
}
.input[type="radio"], input[type="checkbox"] {
height: 16px !important;
width: 16px !important;
margin-right:3px !important;
margin-left:0px;
}
.fade .in{
	height: auto !important;
}
.guests_section::before{
	content: "" !important;
}
#checkindate2, #checkoutdate2 {
    padding-left: 4px !important;
}
.noguest {
    -moz-appearance: none;
    height: 48px !important;
    padding-bottom: 4px;
    padding-left: 4px;
    padding-right: 4px;
    padding-top: 0 !important;
    text-indent: 0.01px !important;
    text-overflow: "" !important;
    vertical-align: middle;
    width: 49px;
}
.headergust{
	 -moz-appearance: none;
    height: 48px !important;
    padding-bottom: 4px;
    padding-left: 4px;
    padding-right: 4px;
    padding-top: 0 !important;
    text-indent: 0.01px !important;
    text-overflow: "" !important;
    vertical-align: middle;
     border-radius: 0 !important;
    width: 49px;
}
#number_of_guest {
    border-radius: 0 !important;
    margin-top: 5px;
}
@media only screen and (min-width:768px) and (max-width:1024px){
	
	#user_dropdown_1, .navbar-right ul li, ul.dropdown_list li{
	    border: medium none !important;
	}
	
	#searchTextField {
	    border: 1px solid rgb(0, 204, 112) !important;
	}
}
</style>
