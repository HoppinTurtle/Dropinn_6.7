<script src="<?php echo base_url(); ?>js/pops.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery_lib.js"></script>
<link href="<?php echo css_url(); ?>/popup_carousel.css" media="screen" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url(); ?>js/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/popup_responsive.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.ui.touch-punch.min.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>js/jquery-ui-sliderAccess.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>js/swfobject.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jwplayer.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&language=en"></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<script src="<?php echo base_url(); ?>/jquery.city-autocomplete.js" type="text/javascript"></script>-->
<!--
<script>
$('input#location').cityAutocomplete();
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//
</script>-->

<script>
	var jayguery = jQuery.noConflict( true );

	
		jayguery(document).ready (function () {
		//load_map_wrapper('load_google_map');
        jayguery("#slider5").owlCarousel({
            autoPlay: false, //Set AutoPlay to 3 seconds
 			navigation :true,
    	  items : 3,
      	 itemsCustom : [
        [0, 1],
        [450, 1],
        [600, 2],
        [700, 2],
        [980, 2],
        [1000, 3],
        [1200, 3],
        [1400, 3],
        [1600, 3]
      ],
        });

    });
</script>
<script>
	 $(document).ready(function(){
	 	$(".owl-prev").css('background-image',"url(<?php echo base_url();?>images/leftarrow.png)");
	 	$(".owl-next").css('background-image',"url(<?php echo base_url();?>images/rightarrow.png)");
	 });
</script>
<style>


@media only screen and (max-width:767px){

.owl-next, .owl-prev{
    background: rgba(255, 255, 255, 0.7) none repeat scroll 0 0 !important;
    border-radius: 100%;
    height: 50px;
    width: 50px;
    background-position: 9px 9px !important;
    background-repeat: no-repeat !important;
}
.owl-next{
	right: -3%;
}
.owl-prev{
	left: -3%;
}
}
@media(min-width:280px)and (max-width:480px){
.callbacks_container{
	overflow: hidden;
}
}

@media(min-width:280px)and (max-width:750px){
.callbacks_arrow{
	display: none !important;
}
.next{
	display: none;
}
.prev{
	display: none;
}
}
.owl-prev{
	background-image: url("Cloud_data/images/leftarrow.png") !important;
}
.owl-next{
	background-image: url("Cloud_data/images/rightarrow.png") !important;
}
	.site{
		text-align:center !important; 
		position:absolute; 
		top:150px;
	}
	.site_title{
		display:block;
		font-family: Circular,"Helvetica Neue",Helvetica,Arial,sans-serif;
		font-size:60px;
		text-transform:uppercase;
		font-weight:700;
		color:#fff;
	}
	.site_slogan{
		display:block;
		font-family: Circular,"Helvetica Neue",Helvetica,Arial,sans-serif;
		color:#fff;
		font-size:20px;
	}
	#header{
		background-color: transparent !important;
	}
	.navbar-brand{
		border-right: 0px solid !important;
	}
	.home-help{
		border-left: 0px solid !important;
	}
	#view_help{
		border-left: 0px solid !important;
	}
	#inbox_icon{
		border-left: 0px solid !important;
	}
	#user_dropdown{
		border-left: 0px solid !important;
	}
	.lisyourspace{
		border-left: 0px solid !important;
	}
	.lisyourspace:hover {
    background-color: transparent !important;
}
#user_dropdown_1{
	border-left: 0px solid !important;
}
#user_dropdown_2{
	border-left: 0px solid !important;
}
.search {
	/*float:left;
	padding:13px 0 0 20px;*/
	padding:11px 15px;
	    line-height: 30px;
}
.heaericon {
    position: absolute;
    margin-left: 6px;
    margin-top: 8px;
    color: #fff;
    font-size: 20px !important;
} 
.navbar-brand:hover {
    background-color: transparent !important;
}
.searchbox {
	border: 1px solid #DFE2DB !important;
box-shadow: 0 1px 1px rgba(0,0,0,.075) inset,0 0 0 #000;
color: #fff;
font-family: Helvetica Neue;
font-size: 14px !important;
padding: 4px 0 4px 35px !important;
width: 240px;
background: transparent;
border-radius: 0px;
}
	#searchTextField{
		border: 0px solid #DFE2DB !important;
	}
.playpause {
    background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0 !important;
    bottom: 0;
    cursor: pointer;
    height: 120%;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    text-align: center;
    vertical-align: middle !important;
    width: 100%;
    z-index: 2;
}	
.fa.fa-play-circle {
 	color: rgb(255, 255, 255);
    font-size: 92px;
    padding: 4px 12px;
    position: absolute;
    text-shadow: 3px 2px rgba(0, 0, 0, 0.5);
    top: 40%;
    vertical-align: middle !important;
    left: 46%;
}
.playpause .fa.fa-play-circle:hover {
    text-shadow: 4px 3px rgba(0, 0, 0, 0.5) !important;
}

/*.playpause .fa.fa-play-circle:hover {
    text-shadow: 4px 3px rgba(0, 0, 0, 0.5) !important;
}*/

.search-area{
	z-index: 5 !important;
}
.padding_zero{
	padding-right: 0px !important;
	padding-left: 0px !important;
}
</style>
<?php $this->load->library('Twconnect'); ?>
<!--aircont-->
<div class="app_view">
	<!-- video start-->
	<div class="videoContainer hidden-xs">
<div class="wrapper">	
<video loop="loop" class="video">
 <source src="<?php echo base_url(); ?>uploads/home/<?php echo $media;?>" type='video/webm'>
  <source src="<?php echo base_url(); ?>uploads/home/<?php echo $media;?>" type='video/mp4'>
  Your browser does not support the video tag.
</video>
<div class="playpause"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
</div>
<!-- <video autoplay loop="loop">
 <source src="<?php echo base_url(); ?>uploads/home/<?php echo $media;?>" type='video/webm'>
  <source src="<?php echo base_url(); ?>uploads/home/<?php echo $media;?>" type='video/mp4'>
  Your browser does not support the video tag.
</video> -->
 <div  class="col-md-12 col-sm-12 col-xs-12 site no_padding" style=" " >
        <div class="overlay site_title"><?php echo $site_title; ?> </div>
       	<div class="overlay site_slogan"><?php echo $site_slogan; ?> </div>
   </div>
</div>
<!-- video loop end -->

<div class="clearfix visible-xs">
<div class="col-md-12 col-sm-12 col-xs-12 no_padding">
<div id="hero" class="search_intro search_int" data-native-currency="USD" style="display: block;">
<div class="callbacks_container arrow_ban">
<ul class="rslides" id="slider4">
<?php foreach($lists->result() as $row) { $url = base_url().'images/'.$row->list_id.'/'.$row->name.'_home.jpg_watermark.jpg'; 
$profile_pic = $this->Gallery->profilepic($row->user_id, 3); 
$city=explode(',', $row->address);
$shortlist=$this->Common_model->getTableData('user_wishlist',array('user_id' => $this->dx_auth->get_user_id(),"list_id"=>$row->list_id));
if($shortlist->num_rows() != 0)
{
			$src = 'images/heart_but_pink.png';
			$src = '<a class="heart_but" href="#">
<img width="40" height="40" src="'.$src.'" alt="no heart image" class="wishlist_pink_'.$row->list_id.'" onclick="add_shortlist('.$row->list_id.',this);">
</a>';
}
else
{
	$src = 'images/heart_but.png';	
    $src = '<a class="heart_but" href="#">
<img width="40" height="40" src="'.$src.'" alt="no heart image"  class="wishlist_normal_'.$row->list_id.'" onclick="add_shortlist('.$row->list_id.',this);">
</a>';
}		
?>
<li>
<!--<img class="mainbanner" src="<?php echo $url; ?>" alt="">-->
<!--<div class="caption">
	<?php echo $src; ?>
<div class="room_head">
<strong>
<span> <a href="<?php echo base_url().'rooms/'.$row->list_id; ?>"><?php echo $row->title; ?></a> </span>
</strong>
<br>
<!--<a href="<?php echo base_url().'rooms/'.$row->list_id; ?>"><?php echo $city[2]." - ".get_currency_symbol()."".$row->price; ?></a>--
<a href="<?php echo base_url().'rooms/'.$row->list_id; ?>"><?php echo $city[2]." - ".get_currency_symbol($row->list_id).get_currency_value1($row->list_id,"".$row->price); ?></a>
</div>


<!-- wishlist count 1 start-->

<!-- wishlist count 1 end-->


<!--<span class="thumb_img"> 
<img src="<?php echo $profile_pic; ?>" height="40" width="40" />
</span>-->
</li>
<?php } ?>
</ul>


</div> 
</div>
</div>
</div>
<div class="search-area">
<!--<div id="blob-bg" class="searcharea" style="display: block;">
<!--<img width="600" height="180" src="css/templates/blue/images/search_bg.png" alt="">--
<!--<div class="search-area">-->
<!--<div id="blob-bg" style="display: block; opacity: 0.5;">
<!--<img width="600" height="180" src="css/templates/blue/images/search_bg.png" alt="">

</div>-->
<?php
$result = $this->db->where('status',0)->limit(1)->get('admin_key');
$key = '';
if($result->num_rows() != 0)
{
foreach($result->result() as $row)
{
	
   $key = $row->page_key;
	
}
}
?>
<script>
$(document).ready(function()
{
	$('.video').parent().click(function () {
    if($(this).children(".video").get(0).paused){
        $(this).children(".video").get(0).play();
        $(this).children(".playpause").fadeOut();
    }else{
       $(this).children(".video").get(0).pause();
        $(this).children(".playpause").fadeIn();
    }
});

	localStorage.setItem('data',"");
	localStorage.setItem('data1',"");
	localStorage.setItem('instant',"");
	sessionStorage.setItem('guest',"");
	sessionStorage.setItem('cin',"");
	sessionStorage.setItem('cout',"");
	sessionStorage.setItem('location',"");
	sessionStorage.setItem('keywords',"");
	sessionStorage.setItem('sort',"");
	sessionStorage.setItem('min_bedrooms',"");
	sessionStorage.setItem('min_bathrooms',"");
	sessionStorage.setItem('min_beds',"");
	
		$('#search_form').submit(function(){
            if(!$.trim($('#location').val()) || ('<?php echo translate("Where_do_you_want_to_go") ;?>' == $('#location').val()) )
            {
               var errorEl = $('#enter_location_error_message');
            if(errorEl.css('display') == 'none'){
                $('#enter_location_error_message').show();
                return false;
            }
            else{
               // $("#enter_location_error_message").effect('pulsate', { times:1 }, 300);
                 $('#enter_location_error_message').show();
                return false;
            }

            return false;
            } 
            else{
                return true;
            }
        });
});
jQuery(document).ready(function() {
		Cogzidel.init({userLoggedIn: false});
		//My Wish List Button-Add to My Wish List & Remove from My Wish List
		add_shortlist = function(item_id,that) {
			$.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin?home=1");
      				}
      				});
		
		// $('#header').css({'z-index':'0'});
		 
		 $('body').css({'overflow':'hidden'});
		// disable_scroll();
		var value = $(that).val();
		$.ajax({
  				url: "<?php echo site_url('rooms/get_data'); ?>",
  				type: "POST",
  				dataType: 'json',
  				data: "list_id="+item_id,
  				success: function(data) {
  				//alert(data.images)
  				$('.dynamic-listing-photo').attr('src',data.images);
  				$('.hosting_description').text(data.title);
  				$('.hosting_address').text(data.address);  				
  				}
   				});
		$('#hidden_room_id').val(item_id);
		//$('.modal_save_to_wishlist').show();
		
		$.ajax({
  				url: "<?php echo site_url('rooms/wishlist_popup'); ?>",
  				type: "GET",
  				data: "list_id="+item_id+"&status=home",
  				success: function(data) {
  					$('.modal_save_to_wishlist').replaceWith(data);	
  					setTimeout(function() {
  						$('.modal_save_to_wishlist').show();
  						}, 200);
  				}
   				});
		
		if(value == "Save To Wish List" || value == '')	
		{	
			//$('.modal_save_to_wishlist').show();
   		}
   		else
   		{
   			//$('.modal_save_to_wishlist').show();  			
   		}			
    	};
    	//My Wish List Menu-Check whether the user is login or not 
    	view_shortlist =  function(that){
    			var value = $('#short').val();
    			if(value=="short")
    			{
    				$.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin");
      				else
      				{
      				$('#search_type_short').attr('id','search_type_photo');
      				$('#short').attr('value', 'photo');
      				$("#search_type_photo").trigger("click");
      				}
      				}
      				});
      			}
    	};	
    			
		});
	</script>
<div class="container search_bg search_pad" >
	<div class="search_col">
<!--<h1><?php echo translate($key); ?></h1>-->
<!--<h2>Rent from people in 38,368 cities and 192 countries.</h2>-->
<form id="search_form" class="custom show-search-options position-left col-md-12 col-sm-12 col-xs-12 " action="<?php echo site_url('search'); ?>" method ="post">
<div class="input-wrapper col-md-4 col-sm-4 col-xs-12 search-lang">
<input style="border-right: none !important;" id="location" class="location main_local" type="text" value="<?php echo translate("Where_do_you_want_to_go"); ?>" name="location" autocomplete="off" data-country="us" onblur="if (this.value == ''){this.value = '<?php echo translate("Where_do_you_want_to_go"); ?>'; }"
   onfocus="if (this.value == '<?php echo translate("Where_do_you_want_to_go"); ?>') {this.value = ''; }" placeholder="<?php echo translate("Where_do_you_want_to_go"); ?>">
<p id="enter_location_error_message" class="bad" style="display:none;">&#10;<?php echo translate("Please set location"); ?>&#10; </p>
<input type="hidden" id="lat1" name="lat" value="">
<input type="hidden" id="lng1" name="lng" value="">
</div>

<div id="checkinWrapper" class="input-wrapper col-md-2 col-sm-2 col-xs-12 search-lang">
<input id="checkin" class="checkin search-option ui-datepicker-target" type="text" value="Check in" name="checkin" onblur="if (this.value == ''){this.value = 'Check in'; }"
   onfocus="if (this.value == 'Check in') {this.value = ''; }" readonly>
<span class="search-area-icon"></span>
</div>

<div id="checkoutWrapper" class="input-wrapper col-md-2 col-sm-2 col-xs-12 search-lang">
<input id="checkout" class="checkout search-option ui-datepicker-target" type="text" value="Check out" name="checkout" onblur="if (this.value == ''){this.value = 'Check out'; }"
   onfocus="if (this.value == 'Check out') {this.value = ''; }" readonly>
<span class="search-area-icon search-area-icon-checkout"></span>
</div>
<div class="input-wrapper col-md-2 col-sm-2 col-xs-12 search-lang">
<div class="custom-select-container">
<div id="guests_caption" class="custom dropdown small current dropdown_guest" aria-hidden="true">1 <?php echo translate("Guest"); ?></div>
<div class="custom selector"></div>
<select id="guests" class="search-option small" name="number_of_guests">
<option value="1">1 <?php echo translate("Guest"); ?></option>
<option value="2">2 <?php echo translate("Guests"); ?></option>
<option value="3">3 <?php echo translate("Guests"); ?></option>
<option value="4">4 <?php echo translate("Guests"); ?></option>
<option value="5">5 <?php echo translate("Guests"); ?></option>
<option value="6">6 <?php echo translate("Guests"); ?></option>
<option value="7">7 <?php echo translate("Guests"); ?></option>
<option value="8">8 <?php echo translate("Guests"); ?></option>
<option value="9">9 <?php echo translate("Guests"); ?></option>
<option value="10">10 <?php echo translate("Guests"); ?></option>
<option value="11">11 <?php echo translate("Guests"); ?></option>
<option value="12">12 <?php echo translate("Guests"); ?></option>
<option value="13">13 <?php echo translate("Guests"); ?></option>
<option value="14">14 <?php echo translate("Guests"); ?></option>
<option value="15">15 <?php echo translate("Guests"); ?></option>
<option value="16">16+ <?php echo translate("Guests"); ?></option>
</select>
</div>
</div>
<button id="submit_location" class="blue_home col-md-2 col-sm-2 col-xs-12 search-lang-btn" type="submit" value="Search" name="Submit">
<i class="icon icon-search"></i>
<!--<img src="css/templates/blue/images/search_icon1.png" />-->
<?php echo translate("Search"); ?>&#10;
</button>
</form>
</div>
</div>
 </div>
</div>
<div class="mid_banner_cont">
<div id="mid_cont" class="midpos container-fluid section new_centcont">
	<!--<div class="title-section">
<h1 class="col-md-12 col-sm-12 col-xs-12"> <?php echo translate("Neighborhood Guides") ; ?> </h1>
<p class="col-md-12 col-sm-12 col-xs-12"> <?php echo translate("Not_sure") ; ?> </p>
</div>-->

<div class="padd_zer container">
<ul class="recent_view rec_view_1 col-md-12">
 
<li class="col-lg-8 col-md-8 col-sm-8 col-xs-12 rec_view_rec img_padd_2">
<div class="newbut_1">

<img class="country_img3" width="100%" height="344" src="<?php echo base_url()."images/restroom.jpg"; ?>" />
<img class="country_img3" width="100%" height="344" src="<?php echo base_url()."images/green-doors.jpg"; ?>" />
<img class="country_img3" width="100%" height="344" src="<?php echo base_url()."images/hostroom.jpg"; ?>" />

</div>


</li>


<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("country_img3");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, 4000); // Change image every 2 seconds
}
</script>


<li class="rec_view1 rec_view_txt col-md-4 col-sm-4 col-xs-12 img_padd_2">
	<h4 class="host_txt"><?php echo translate("Hosting opens up a world of opportunity"); ?></h4>
	<p class="host_prh_txt"><?php echo translate("Earn money sharing your extra space with travelers."); ?></p>
	<a href="<?php echo site_url('info/how_it_works');?>" class="btn_prmry" id="earn" style="list-style-type: none;" type="btn btn-defauld"><?php echo translate("See what you can earn"); ?></a>
			<!-- <a href="javascript:login();"  class="btn btn-info btn-sm" id="social" role="button">facebook</a>-->
</li>
</ul>
</div>
 <div class="title-section1">
<h3 class="col-md-12 col-sm-12 col-xs-12"> <?php echo translate("Explore") ; ?> </h3>
<p class="col-md-12 col-sm-12 col-xs-12"> <?php echo translate("traveling") ; ?> </p>
</div>


</div>
    

<div class="padd_zer container">
<ul class="rec_view_1 col-md-12" style="  text-align: center; color: #eb3c44; font-size: 29px;">
<?php

if(isset($cities))
{
if($cities->num_rows() != 0)
{
	$neigh_count = 1 ;
	
foreach($cities->result() as $city)
{
	$image_name = $this->db->where('city_name',$city->city_name)->from('neigh_city')->get()->row()->image_name; 
	$city_id = $this->db->where('city_name',$city->city_name)->from('neigh_city')->get()->row()->id; 
	
	if($neigh_count == 1 || $neigh_count == 7  ){
		$class_neigh = "marg_li col-lg-8 col-md-8 col-sm-12 col-xs-12 rec_view_rec img_padd_2" ; 
		$class_neigh_div = "newbut_1";
		$class_neigh_img = "country_img1";
   		$image_Url = cdn_url_images().'/images/neighbourhoods/'.$city_id.'/'.$image_name;
	}else{
		$class_neigh = "marg_li col-lg-4 col-md-4 col-sm-6 col-xs-12 img_padd_2" ;
		$class_neigh_div = "newbut_2";
		$class_neigh_img = "country_img2";
		$image_Url = cdn_url_images().'/images/neighbourhoods/'.$city_id.'/'.$image_name;
	}

	

?>


<li class="<?php echo $class_neigh; ?>">
<div class="<?php echo $class_neigh_div; ?>">
<!--<img src="css/templates/blue/images/new_but.png" style="opacity:1;"/>-->
<?php 
$city_created = $this->db->where('city_name',$city->city_name)->get('neigh_city')->row()->created;
 $month = 60 * 60 * 24 * 30; // month in seconds
if (time() - $city_created < $month) {
  // within the last 30 days ...
  //echo translate("new");
} 
 ?> 
<!--<span> new </span>-->

<a href='<?php echo site_url()."search?location=".$city->city_name; ?>' class="home">
	<?php $image_name = $this->db->where('city_name',$city->city_name)->from('neigh_city')->get()->row()->image_name; 
	$city_id = $this->db->where('city_name',$city->city_name)->from('neigh_city')->get()->row()->id; 
	?>
	<p class="coun-para"> <?php echo $city->city_name; ?> </p>
<img width="100%" height="344" class="<?php echo $class_neigh_img; ?>" src="<?php echo $image_Url; ?>" />

</div>
<!--<a href="<?php echo site_url()."rooms/".$row->id; ?>"></a>-->

<!--<div class="room_n">
<label class="room_name"><?php echo $city->city_name; ?></label>
<?php
$this->db->distinct()->select('neigh_city_place.place_name')->where('neigh_city_place.is_featured',1)->where('neigh_city_place.city_name',$city->city_name);
$this->db->join('neigh_post', 'neigh_post.place = neigh_city_place.place_name')->where('neigh_post.is_featured',1); 
$this->db->from('neigh_city_place');
$place_ = $this->db->get();
?>
<label class="neigh_count"><?php echo $place_->num_rows().' '.translate('Neighbourhoods'); ?></label>
</div>-->
<!--
<label class="shop_hover">
	<p class="Topdestination_city"><?php echo $city->city_name; ?></p>
	<i class="view_dtails fa fa-arrow-circle-right"></i>
</label>-->

</a>
</li>

<!--
<li class="rec_view1 rec_view_txt col-md-4 col-sm-4 col-xs-12 img_padd_2">
	<h4 class="host_txt">Hosting opens up a world of opportunity</h4>
	<p class="host_prh_txt">Earn money sharing your extra space with travelers.</p>
	<button class="btn_prmry" type="btn btn-defauld">see what can earn</button>
</li>-->


<?php $neigh_count++; } ?>
</ul>
<p class="neighbour_flo">
	<a href='<?php echo base_url().'home/neighborhoods'; ?>'><?php echo translate('All neighborhood guides');?></a>
 </p>
 <?php }
else
	{ ?>
		<?php echo translate("No Neighborhoods"); ?>
	<?php }
	} 
else
	{
		echo translate("No Neighborhood Places");
	}?>
</li>

  </ul>
 </div>
    
    
   
     </div>
    
    
    
    
    <div class="col-md-12 col-sm-12 col-xs-12 no_padding">
   
<!-- video start -->
<!-- <video width="100%" height="100%" controls>
  <source src="<?php echo base_url(); ?>uploads/home/Belong_p1_v2.mp4" type='video/mp4'>
        <source src="<?php echo base_url(); ?>uploads/home/Belong_p1_v2.webm" type='video/webm'>
  Your browser does not support the video tag.
</video> -->
<div class="container padding_zero">
<div id="hero" class="search_intro" data-native-currency="USD" style="display: block;">
	<h2 class="feature_list_head"><?php echo translate("Featured List"); ?></h2>
<div class="callbacks_container">
	<?php 
if($lists->num_rows() > 0)
{?>
<ul class="rslides col-md-12 owl-carousel owl-theme" id="slider5">
<?php 
foreach($lists->result() as $row) { $url = base_url().'images/'.$row->list_id.'/'.$row->name; 
$profile_pic = $this->Gallery->profilepic($row->user_id, 3); 
$city=explode(',', $row->address);
$shortlist=$this->Common_model->getTableData('users',array('id' => $this->dx_auth->get_user_id()));
if($shortlist->num_rows() != 0)
{
	$shortlist = $shortlist->row()->shortlist;
		//Remove the selected list from the All short lists
		$result="";
		$my=explode(',',$shortlist);
		if(in_array($row->list_id, $my))
		{
			$src = 'images/heart_but_pink.png';
			$src = '<a class="heart_but" href="'.base_url()."rooms/remove_my_shortlist/".$row->list_id.'">
<img width="40" height="40" src="'.$src.'" alt="no heart image">
</a>';
		}
		else
			{
			$src = 'images/heart_but.png';	
		    $src = '<a class="heart_but" href="'.base_url()."rooms/add_my_shortlist/".$row->list_id.'">
<img width="40" height="40" src="'.$src.'" alt="no heart image">
</a>';
			}
}
else
{
	$src = 'images/heart_but.png';	
    $src = '<a class="heart_but" href="'.base_url()."rooms/add_my_shortlist/".$row->list_id.'">
<img width="40" height="40" src="'.$src.'" alt="no heart image">

</a>';
}		
?>
<li class="items">
	
<a href="<?php echo base_url()."rooms/".$row->list_id; ?>"> 
	
	<?php 
			$date_new = strtotime(date("Y-m-d", strtotime("-3 days")));
			$created = $row->created;
	?>
	
	<?php if($created > $date_new ){ ?>
	<div class="map_number">New </div>
	<?php  }  ?>
    <img  src="<?php echo $url; ?>"  alt="" onerror="this.src='<?php echo base_url().'images/no_image.jpg';  ?>'"></a>
    <div class="map_num_list">
    	<?php
    	echo '<div class="subtitle">'.get_currency_symbol($row->list_id).get_currency_value1($row->list_id,"".$row->price).'</div>';
    	echo '<span class="related_listing_right col-xs-12">';
		echo anchor('rooms/'.$row->list_id , $row->title).'/'. '<span>'.$row->room_type.'</span>'.'</span>';
		  if($row->review_count != 0) { 
                echo 	'<div class="Sat_Star_Nor" title="">';
                echo'<div class="Sat_Star_Act" style="width: = this.review_rating %"> </div>';
                if($row->review_count != 0) { 
                echo'<span class="review"><*= this.review_count *></span>';  
                 } 
                echo'</div>';                                  	
                
                   } 
		?>
		</div>

</li>
<?php } ?>
</ul>
<?php 	
}else{
	echo "<p style='text-align:center' >There is no featured list!!</p>";
} ?>
</div> </div>

</div>

    </div> 
<div id="list_home" class="container">

<div class="travel col-md-4 col-sm-4 col-xs-12">
<h3> <?php echo translate("Travel"); ?> </h3>
<p> <?php echo translate("From_apartments"); ?></p>
<a href="<?php echo site_url('pages/view/travel'); ?>"> <?php echo translate("See most booked"); ?> <span> >> </span> </a>
</div>

<div class="host  col-md-4 col-sm-4 col-xs-12">
<h3> <?php echo translate("Host"); ?>  </h3>
<p>  <?php echo translate("Renting_out"); ?> </p> <br/>
<a href="<?php echo site_url('pages/view/why_host'); ?>"> <?php echo translate("Learn_more"); ?> >> </a>
</div>

<div class="work  col-md-4 col-sm-4 col-xs-12">
<h3> <?php echo translate("How It Works"); ?> </h3>
<p> <?php echo translate("From_our"); ?></p>
<a href="<?php echo site_url('info/how_it_works'); ?>"> <?php echo translate("Visit the trust & safety center"); ?> >> </a>
</div>
</div>
</div>
<!--end air-->
 <script>

    // You can also use "$(window).load(function() {"
    
    /*
    $(function () {
              // Slideshow 4
              $("#sler4").responsiveSlides({
                auto: true,
                pager: false,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                  $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                  $('.events').append("<li>after event fired.</li>");
                }
              });
        
            });*/
    
    /*
    
            $(function () {
          // Slideshow 4
          $("#slid").responsiveSlides({
            auto: false,
            pager: false,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            before: function () {
              $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
              $('.events').append("<li>after event fired.</li>");
            }
          });
    
        });*/
    
$(document).ready(function(){
preloader();
$("#guests").change(function(){
	var guest=$("#guests").val();
	var temp_guest="";
	if(guest=="1")
	{
		temp_guest=guest+" "+"<?php echo translate("Guest");?>";
	}
	else if(guest=="16")
	{
		temp_guest=guest+"+ "+"<?php echo translate("Guests");?>";
	}
	else
	{
		temp_guest=guest+" "+"<?php echo translate("Guests");?>";
	}
	$("#guests_caption").html(temp_guest);
});
})
// Home Page Checkin Checkout date function below lines jQuery
jQuery(document).ready(function() {
Translations.review = "review";
Translations.reviews = "reviews";
Translations.night = "night";
var opts = {};
CogzidelHomePage.init(opts);
CogzidelHomePage.defaultSearchValue = "Where are you going?";
});
	jQuery(document).ready(function() {
		Cogzidel.init({userLoggedIn: false});
	});

	Cogzidel.FACEBOOK_PERMS = "email,user_birthday,user_likes,user_education_history,user_hometown,user_interests,user_activities,user_location";	

function preloader() 
{
     // counter
     var i = 0;
     // create object
     imageObj = new Image();
     // set image list
     images = new Array();
	 <?php $i = 0; foreach($lists->result() as $row)	{ $url = base_url().'images/'.$row->list_id.'/'.$row->name; ?>
     images[<?php echo $i; ?>]="<?php echo $url; ?>"
	 <?php $i++; } $num_rows = $lists->num_rows(); $total_rows = $num_rows-1; ?>
     // start preloading
     for(i=0; i<=<?php echo $total_rows; ?>; i++) 
     {
          imageObj.src=images[i];
     }
} 

$(document).ready(function(){
$("#view_most").html('<img src="<?php echo base_url()."images/loader.gif"; ?>">');
	$('#location').keypress(function()
	{
      var input = document.getElementById('location');
    var autocomplete = new google.maps.places.Autocomplete(input);    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
      
      var r = place.formatted_address; 
              if(r!= undefined)
        {
      
	      var lat = place.geometry.location.lat();
	      var lng = place.geometry.location.lng();
	      $('#lat1').val(lat);
	      $('#lng1').val(lng);
		 $('#enter_location_error_message').hide();
	 	}else{
	 		var street_address = jQuery("#location").val();
        	var strfy = JSON.stringify(street_address);
        	var parsfy =JSON.parse(strfy);
        	var str_array = parsfy.split(',');
        	var str_array_len = str_array.length-1;
        	var change_country = str_array[str_array_len]; 
        	
        	//location geocoder starts here
        	
		        	var geocoder =  new google.maps.Geocoder();
		    		geocoder.geocode( { 'address': change_country}, function(results, status) {
		          if (status == google.maps.GeocoderStatus.OK) {
		          	//alert("okkkk")
		          	var latitude = results[0].geometry.location.lat();
		          	var langtitude = results[0].geometry.location.lng();
				      $('#lat1').val(latitude);
				      $('#lng1').val(langtitude);
					 $('#enter_location_error_message').hide();
		            //alert("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng()); 
		          } else {
		          	latitude = "0.4095680485690845";
		          	langtitude = "0.546840567898947568";
		            $('#lat1').val(latitude);
				    $('#lng1').val(langtitude);
		          }
		        });
        	
	 	}
    });	
	})
	
	
// clear the rooms/new session values
sessionStorage.setItem("accomedval","");
sessionStorage.setItem("otherstrimed","");
sessionStorage.setItem("room_typee", "");
sessionStorage.setItem("accomedval", "");



 jQuery("#location").keydown(function(e){
        if(e.keyCode==13)
        {
            e.preventDefault();
        }
    
        
    })

	
});
</script>
<input type="hidden" value="" id="hidden_room_id">
<div class="modal_save_to_wishlist" style="display: none;">
</div>
<style>
*
{
    box-sizing: border-box;
}
.map_num_list{
	display: inline-flex ;
	 color: #616161 !important;
    padding: 8px 0 !important
}
.map_num_list .subtitle{
	color: #00a699 !important;
    font-size: 15px !important;
    font-weight: bold !important;
    letter-spacing: 0.2px !important;
    line-height: 18px !important;
    word-wrap: break-word !important;
}
.map_num_list .related_listing_right{
	color: #484848 !important;
    font-size: 14px !important;
    font-weight: 100 !important;
    letter-spacing: 0.2px !important;
    line-height: 18px !important;
    word-wrap: break-word !important;
   }
   .related_listing_right a{
   	text-transform: capitalize;
   	color: #616161 !important;
   	} 
 .map_num_list .related_listing_right {
	color: #616161 !important;
}
.feature_list_head{
	 color: #484848;
    font-size: 26px;
    font-weight: bold;
    letter-spacing: 0.8px;
    padding-top: 25px;
    text-align: center;
    } 
.modal_save_to_wishlist {
    opacity: 1;
}
.map_number{
	margin-left: 7px !important;
}
.subtitle {
display: inline-table;
}
.modal_save_to_wishlist {
    background-color: rgba(0, 0, 0, 0.75);
   bottom: 0;
    left: 0;
    opacity: 1;
    overflow-y: auto;
    position: fixed;
    right: 0;
    top: 0;
    transition: opacity 0.2s ease 0s;
    z-index: 2000;
}
.modal-table {
    display: table;
    height: 100%;
    table-layout: fixed;
    width: 75%;
}
.modal-cell {
    display: table-cell;
    height: 100%;
    padding: 50px;
    vertical-align: middle;
    width: 100%;
}
.wishlist-modal {
    max-width: 700px;
    overflow: visible;
    width: 700px;
}

.modal-content {
    background-color: #fff;
    border-radius: 2px;
    margin-left: auto;
    margin-right: auto;
    max-width: 700px;
    overflow: hidden;
    position: relative;
}
.panel-dark, .panel-header {
    background-color: #edefed;
}
.panel-header {
    border-bottom: 1px solid #dce0e0;
    color: #565a5c;
    font-size: 16px;
    padding-bottom: 14px;
    padding-top: 14px;
}
.panel-header, .panel-body, ul.panel-body > li, ol.panel-body > li, .panel-footer {
    border-top: 1px solid #dce0e0;
    margin: 0;
    padding: 20px;
    position: relative;
}
.panel-footer {
    text-align: right;
}
.panel-footer {
    border-top: 1px solid #dce0e0;
    margin: 0;
    padding: 20px;
    position: relative;
}
.wishlist-modal .dynamic-listing-photo-container {
    height: 64px;
}
.panel-close, .alert-close, .modal-close {
    color: #cacccd;
    cursor: pointer;
    float: right;
    font-size: 2em;
    font-style: normal;
    font-weight: normal;
    line-height: 0.7;
    vertical-align: middle;
}
.row > .col-1, .row > .col-2, .row > .col-3, .row > .col-4, .row > .col-5, .row > .col-6, .row > .col-7, .row > .col-8, .row > .col-9, .row > .col-10, .row > .col-11, .row > .col-12 {
    padding-left: 12.5px;
    padding-right: 12.5px;
}
.col-2 {
    width: 16.6667%;
}
.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
    float: left;
    min-height: 1px;
    position: inherit;
}
.img-responsive-height {
    height: 100%;
    width: auto;
}
.media-cover, .media-cover-dark:after {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}
.wishlist-modal .dynamic-listing-photo-container {
    height: 64px;
}
.media-photo-block {
    display: block;
}
.row > .col-1, .row > .col-2, .row > .col-3, .row > .col-4, .row > .col-5, .row > .col-6, .row > .col-7, .row > .col-8, .row > .col-9, .row > .col-10, .row > .col-11, .row > .col-12 {
    padding-left: 12.5px;
    padding-right: 12.5px;
}
.col-10 {
    width: 83.3333%;
    text-align: left;
}
.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
    float: left;
    min-height: 1px;
    position: inherit;
}
.text-lead {
    font-size: 16px;
}
.row-space-2 {
    margin-bottom: 12.5px;
}
.row {
    margin-left: -12.5px !important;
    margin-right: -12.5px !important
}
#panel-body {
    margin-left: -12.5px !important;
    margin-right: -12.5px !important
}
#panel-body
{
    padding-left: 12.5px;
    padding-right: 12.5px;
}
#panel-body:before, #panel-body:after {
    content: "";
    display: table;
    line-height: 0;
}
#panel-body:after {
    clear: both;
}
.wishlist-modal .selectContainer {
    overflow: inherit;
}
.wishlist-modal .selectContainer {
    border: 1px solid #dce0e0;
}
.select-block {
    display: block;
    width: 100%;
}
.select {
    display: inline-block;
    position: relative;
    vertical-align: bottom;
}
.wishlist-modal #selected {
    display: block;
    height: 43px;
    line-height: 43px;
    margin-left: 20px;
    overflow: hidden;
    width: 252px;
}
.col-12 {
    width: 100%;
}
.noteContainer label {
    display: block;
    padding-bottom: 8px;
    padding-top: 9px;
}
.wishlist-note {
    line-height: inherit;
    padding-bottom: 10px;
    padding-top: 10px;
    resize: vertical;
      display: block;
    padding: 8px 10px;
    width: 100%;
}
.wishlist-modal .selectWidget {
    background-color: white;
    border: 1px solid #dce0e0;
    margin: -1px 0 0 -1px;
    position: absolute;
    width: 100%;
    z-index: 99999;
}
.wishlist-modal .selectList {
    margin: 0;
    max-height: 180px;
    overflow: auto;
    padding: 0;
}
.wishlist-modal .selectList li {
    border-bottom: 1px solid #dce0e0;
}
.wishlist-modal .selectContainer .checkbox.text-truncate {
    white-space: normal;
}
.wishlist-modal .selectList label {
    padding: 10px 15px;
}
.checkbox {
    cursor: pointer;
}
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.wishlist-modal .selectList input {
    display: inline-block;
    margin-top: 0px;
}
input[type="radio"], input[type="checkbox"] {
    height: 1.25em;
    margin-bottom: -0.25em;
    margin-right: 5px;
    position: relative;
    vertical-align: top;
    width: 1.25em;
}
.wishlist-modal .selectList label span {
    margin-left: 25px;
    width: 245px;
}
.wishlist-modal .newWLContainer {
    border-top: 1px solid #dce0e0;
    padding: 8px;
}
.wishlist-modal .newWLContainer .doneContainer {
    overflow: hidden;
}
.tooltip-bottom-left:before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: rgba(0, 0, 0, 0.1) transparent -moz-use-text-color;
    border-image: none;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-style: solid solid none;
    border-width: 10px 10px 0;
    bottom: -10px;
    content: "";
    display: inline-block;
    left: 50%;
    position: absolute;
    top: auto;
}
.tooltip-bottom-left:after {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #fff transparent -moz-use-text-color;
    border-image: none;
    border-left: 9px solid transparent;
    border-right: 9px solid transparent;
    border-style: solid solid none;
    border-width: 9px 9px 0;
    bottom: -9px;
    content: "";
    display: inline-block;
    left: 50%;
    position: absolute;
    top: auto;
}
  .tooltip{
     background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
    left: -2px !important;
    top: -196px;
    max-width: 280px;
    display:none;
    position: absolute;
    transition: opacity 0.2s ease 0s;
    z-index: 3000;
}
#privacy-tooltip-trigger:hover + .tooltip{
    display:block !important;
    z-index:3000;
    float:left;
    display:block;
    margin:190px 0px 0px 250px;
}
.hosting_address {
    margin-bottom: 15px;
}
.wishlist-modal .hide {
    border: 0 none;
    clip: rect(0px, 0px, 0px, 0px);
    height: 1px;
    margin: -1px;
    opacity: 0;
    overflow: hidden;
    padding: 0;
    pointer-events: none;
    position: absolute;
    width: 1px;
}
.wishlist-modal .selectWidget {
    background-color: white;
    border: 1px solid #dce0e0;
    margin: -1px 0 0 -1px;
    position: absolute;
    width: 100%;
    z-index: 99999;
}
.selectList li
{
	padding: 10px;
}
#new_wishlist {
    overflow:hidden;
}
#slider5{
	margin-top: 25px ;
	display: block;
    opacity: 1;
    overflow: visible;
}
p.Topdestination_city {
    top: 0;
    position: absolute;
    left: 0;
    right: 0;
    color: #fff;
    padding: 15px 0px;
}

}

.prev
{		margin-left:20px!important;
		}
.next{
}
@media(min-width:360px)and (max-width:768px){
.next{margin-right:250px;}
}
	@media(max-width:360px){
.next{margin-right:none;}
}

</style>
