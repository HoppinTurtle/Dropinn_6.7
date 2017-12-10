<?php error_reporting(E_ERROR | E_PARSE); ?>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="<?php echo css_url().'/jquery_colorbox.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url().'/search_result.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!--<link href="<?php echo css_url().'/bootstrap-responsive.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
-->
 <style type="text/css">
 .Sat_Star_Act{
  	height: 14px !important;
    margin-top: 0 !important;
 }
 .review {
    margin-left: 85px;
    position: absolute;
    bottom: -2px;
}
 #sort_by_rev div {
color: #FF5A5F;
}
li#review_container {
margin: 0 13px;
}
 .gm-style-iw {
  	width: 222px !important;
  	overflow: visible !important;
}
.panel-image.listing-img.img-large{
    padding-bottom: 76% !importnat;
}
.listing-map-popover ul li img{
    /*max-height: 159px;*/
}
.instant{
    border: 0 none;
     height: 30px;
    position: relative;
    vertical-align: middle;
    width: 16px;
    padding:2px;
    top: -6px;
    margin:0px 0px -12px 0px;
   float: right !important;
   
}
.panel-body.panel-card-section {
    border-top: medium none !important;
    padding-top: 30px !important;
}

/*

.gm-style-iw + div {
	display: none;
	}*/
.close_but{
	margin-right: -8px;
    font-size: 15px;
    margin-top: -10px;
}
 body { font: normal 10pt Helvetica, Arial; }
 #map { width: 350px; height: 300px; border: 0px; padding: 0px; 
  }
  .message{
display: none;
text-align: left;
color: #565a5c;
position: absolute;
top: 30px;
/*right: -15px;*/
background: #fff;
padding: 5px;
line-height: 22px;
width: 280px;
box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
 left: 52px;
}
.anchor:hover + .message{
    display:block !important;
    /*z-index:10;*/
   z-index:99;
    float:left;
    margin:5px 0px 0px 5px;
   
}
#results
{
	/*margin-left: -24px;*/
}
.price_options::after{
	display: none;
}
@media screen and (-webkit-min-device-pixel-ratio:0) {
#results
{
	/*margin-left: -39px;*/
}
}

}*/
#location:focus, #location:hover, #checkin:hover, #checkin:focus, #checkout:hover, #checkout:focus {
    border: 1px solid #bbb !important;
}
.navbar.navbar-static-top{
	position: fixed !important;
left: 0;
right: 0;
}
.guests_section select {
font-size: 13px !important;
}
@media (min-width:320px) and (max-width:567px) {
	.input[type="radio"], input[type="checkbox"]{
		width: 18px !important;
		height: 18px !important;
	}
	input[type="checkbox"]:checked:before{
		margin-left: 3px !important;
		font-size: 14px !important;
	}
	#location {
    width: 98% !important;
}
	}
	@media (min-width:768px) and (max-width:1028px) {
	#location {
    width: 96% !important;
	}
}
#list_view_loading{
height: 100px;
width: 100px;
border: none;
box-shadow: none;
}	
#location {
    width: 93%;
}
#search_body{
	margin-bottom: 30px;
}


/*CUSTOM UL DESIGN*/


#review_container ul{
  list-style: none;
  height: 100%;
  width: 100%;
  margin: 0;
  padding: 0;
}


#review_container ul li{
    color: rgb(170, 170, 170);
    display: block;
    float: left;
    position: relative;
    width: 100%;
}

#review_container ul li input[type=radio]{
  position: absolute;
  visibility: hidden;
}

#review_container ul li label{
	cursor: pointer;
    display: block;
    font-size: 1.35em;
    font-weight: 300;
    height: 30px;
    margin: 0;
    padding: 7px 25px 25px 36px;
    position: relative;
    z-index: 9;
}

#review_container ul li:hover label{
	color: rgb(255, 189, 0);
}

#review_container ul li .check{
 	border: 5px solid rgb(170, 170, 170);
    border-radius: 100%;
    display: block;
    height: 25px;
    left: 0;
    position: absolute;
    top: 3px;
    width: 25px;
    z-index: 5;
	transition: border .25s linear;
	-webkit-transition: border .25s linear;
}

/*#review_container ul li:hover .check {
  border: 5px solid #FFFFFF;
}*/

#review_container ul li .check::before {
 	border-radius: 100%;
    content: "";
    display: block;
    height: 11px;
    left: 2.1px;
    margin: auto;
    position: absolute;
    top: 1.5px;
    transition: background 0.25s linear 0s;
    width: 11px;
}

#review_container input[type=radio]:checked ~ .check {
  border: 5px solid rgb(255, 189, 0);
}

#review_container input[type=radio]:checked ~ .check::before{
  background: rgb(255, 189, 0);
}

#review_container input[type=radio]:checked ~ label{
  color: rgb(255, 189, 0);
}

.search_filter.sort.clearfix1 {
    margin: 0 0px 0 20px!important;
    padding-right: 10px;
}
</style>


<script>

	
$( ".gm-style-iw" ).parent().css( "background-color", "red" );


$(document).ready(function() {
	      $('#list_view_loading').css('background-image',"url(<?php echo base_url();?>images/ajax_spin.gif)");
       // $('#header').css({'position':'fixed'});
   $(window).scroll(function() {
  
       var headerH = $('#header').outerHeight(true);
   
       var scrollTopVal = $(this).scrollTop();
        if ( $(this).scrollTop()) {
            $('#search_map').css({'position':'fixed','top' :'49px' , 'bottom' : '0px'});
            $('#Search_Main').css({'position':''});
            $('#header').css({'z-index':'9999'});
        } else {
            $('#search_map').css({'position':'fixed','top':'49px'});
            $('#Search_Main').css({'position':''});
            $('#header').css({'z-index':'9999'});
        }
              
       var headerH = $('#header').outerHeight(true);
	   var headerH = $('.price_options').outerHeight(true);
	
      	 var scrollTopVal = $(this).scrollTop();
       	 var winsize = $(window).width();	 
      	 if(winsize <= 480)
	    	{
	    		
	    		if ( scrollTopVal > 282 ) {
		          $('.more_filters1').html("Filters");
		          $('.price_options').html("");
		          $('#filters_lightbox_nav').css({'position':'fixed', 'margin-top': '0px', 'top' :'61px','min-width':'58.4%','z-index' :'16','padding-right':'10px','margin-left':'15px !important'});
				  $('#search_body').css({'position':'relative', 'top' : '22px'});
		  		} 
		        else {
		        	$('.more_filters1').html("More Filters");
				 	$('.price_options').html("Enter dates to see full pricing. Additional fees apply. Taxes may be added.");
		            $('#filters_lightbox_nav').css({'position':'static', 'margin-top': '0',  'top':'0px','width':'auto','margin-left':'0'});
		            $('#search_body').css({'top' : '0px'});
				
		      	 }
	    		
	    		
	    	}else{
	    		
	    		 if ( scrollTopVal > 282 ) {
		          $('.more_filters1').html("Filters");
		          $('.price_options').html("");
		          $('#filters_lightbox_nav').css({'position':'fixed', 'margin-top': '0px', 'top' :'61px','min-width':'58.4%','z-index' :'16','padding-right':'10px','margin-left':'15px !important'});
				  $('#search_body').css({'position':'relative', 'top' : '80px'});
		  		} 
		        else {
		        	$('.more_filters1').html("More Filters");
				 	$('.price_options').html("Enter dates to see full pricing. Additional fees apply. Taxes may be added.");
		            $('#filters_lightbox_nav').css({'position':'static', 'margin-top': '0',  'top':'0px','width':'auto','margin-left':'0'});
		            $('#search_body').css({'top' : '0px'});
				
		      	 }
	    		
	    		
	    	}
        
     
    });


    /*room type */
  

 $("#roomType").hide();

$(".room_0").click(function() 
{
 
     if($(".rroom").is(":checked")  ) 
    {
       $("#roomType").show();
  
    } 
    else 
    {
    $("#roomType").hide();
 
    }

});



  
$("#roomType").hide();
if($("#roomType").click(function(){
	//alert('success');
	 $(".rroom").attr("checked", false)
	 $("#roomType").hide();
})) 
 
 /*   
 $("#roomType").hide();
if($("#roomType").click(function(){
	 $(".room_1").attr("checked", false)
	 $("#roomType").hide();
}))

$("#roomType").hide();
if($("#roomType").click(function(){
	 $(".room_2").attr("checked", false)
	 $("#roomType").hide();
}))*/ 
    
   
   
    
    /* room type */
    
    /* size */
   


$("#roomType4").hide();
 $( ".size1" ).click(function() {
 	
 	 //alert('success');
 	 if ( $('#min_bedrooms').value == '' && $('#min_bathrooms').value == '' && $('#min_beds').value == '' )	 
     {
     	 $("#roomType4").hide();
     }
 	 else
 	 {
 	 	 $("#roomType4").show();
 	 }
 
 });
  
 
 
 $("#roomType4").hide();
if($("#roomType4").click(function(){
	
	 
	$(".size1").prop('selectedIndex', 0);
	  	 
	 $("#roomType4").hide();
})) 

 
 
 
   /* size */
    
    
    
    
    
    
    
    /* property type  */
   
   
   $("#roomType2").hide();

$(".property_type1").click(function() 
{
	
	//alert('super');
 
 
     if($(".property_type1").is(":checked")  ) 
    {
      //  alert('success1');
       $("#roomType2").show();
  
    } 
    else 
    {
    $("#roomType2").hide();
 
    }

});

$("#roomType2").hide();
if($("#roomType2").click(function(){
	
	 $(".property_type1").attr("checked", false)
	 $("#roomType2").hide();
})) 




    
   /* property type */ 
    
   /* Amenities */ 
    
    $("#roomType3").hide();

$(".amenities1").click(function() 
{
	
	//alert('super');
 
 
     if($(".amenities1").is(":checked")  ) 
    {
      //  alert('success1');
       $("#roomType3").show();
    } 
    else 
    {
    $("#roomType3").hide();
 
    }

});

$("#roomType3").hide();
if($("#roomType3").click(function(){
	
	 $(".amenities1").attr("checked", false)
	 $("#roomType3").hide();
})) 

 
    /* Amenities */  
    
 
  
    

 

    $('#footer_search').hide();
$.ajax({
		url: '<?php echo base_url().'search/footer'; ?>',
		type: 'POST',
        success: function(data)
        {
        	$('#clientsCTA').html(data);
        }
     });
     
//moblie footer script start//

//mobile footer script end//

      $('#lang').click(function () {
      	$('#clientsCTA').show();
    $('#clientsDropDown #clientsDashboard').slideToggle({
      direction: "up",
    }, 300);
    $(this).toggleClass('clientsClose');
	});
  var cancel = false;
  $('.selectContainer').click(function()
  {
  	$('.selectWidget').show();
  	if(i == 1 || i == 2)
  	{
  		$('#new_wishlist').show();
  		$('.doneContainer').hide();
  	}
  	else if(done == 1)
  	{
  		done = 0;
  		$('.selectWidget').hide();
  	}
  	else if(i == 3)
  	{
  		$('.doneContainer').show();
  		$('#new_wishlist').hide();
  	}
  	else
  	{
  	$('.doneContainer').show();
  	$('#new_wishlist').hide();
  	 $.ajax({
		   type: "GET",
		   url: '<?php echo base_url()."rooms/get_wishlist_category";?>',
		   data: 'list_id='+$('#hidden_room_id').val(),
		   success: function(data){
		   		$('.selectList').replaceWith(data);
		   		i = 3;
				   }
		 }); 
  	}
  	
  	if($('#new_wishlist').css('display') == 'none' && i != 3)
  	{
  		i = 0;
  	}
  	else if(i == 3)
  	{
  		i = 3;
  	}
  	else {
  		i = 1;
  	}
  	cancel = true;
  	 	
  })
 var i = 0;
 $('#create_new').click(function()
 {
 	i++;
 	$('.doneContainer').hide();
 	$('#wishlist_category_name').val('');
 	$('#new_wishlist').show();
 })
 
 $('#wishlist_close').click(function()
			{
				$('body').css({'overflow':'scroll'});
				$('.modal_save_to_wishlist').hide();
			})
			
$(".panel-header").hover(function(){
   // $("div.description").show();
   $('#new_wishlist').hide();
   i = 0;
   $(".selectWidget").hide();
});

$(".panel-footer").hover(function(){
   // $("div.description").show();
   $('#new_wishlist').hide();
   i = 0;
   $(".selectWidget").hide();
});

$('.wishlist-note').focus(function()
{
	$('#new_wishlist').hide();
	i = 0;
	 $(".selectWidget").hide();
})

$('#add_note').click(function()
{
	$('#new_wishlist').hide();
	i = 0;
	$(".selectWidget").hide();
})

$('#wishlist_category').click(function()
{
	var dataString = 'name='+$('#wishlist_category_name').val()+'&privacy='+$('#privacy').val()+'&list_id='+$('#hidden_room_id').val();
	 $.ajax({
		   type: "GET",
		   url: '<?php echo base_url()."rooms/wishlist_category";?>',
		   data: dataString,
		   success: function(data){
		   	
		   		 $.ajax({
		   type: "GET",
		   url: '<?php echo base_url()."rooms/get_wishlist_category";?>',
		   data: 'list_id='+$('#hidden_room_id').val(),
		   success: function(data){
		   	    $('.selectWidget').hide();
		   		$('.selectList').replaceWith(data);
				   }
		 });
		   		
				   }
		 });
})

var done = 0;

$('#wishlist_done').click(function()
{
	var wishlist_count = 0;
	var name = '';
	done = 1;
	$("input[type=checkbox]:checked").each ( function() 
	{
   wishlist_count++;
   name = $('#'+$(this).val()).text();
});

if(wishlist_count == 1)
{
$('#selected span').text(name);
}
else
{
$('#selected span').text(wishlist_count+' Wish Lists');
}

$('.selectWidget').css({'display':'none'});

})

$('#wishlist_save').click(function()
{
	var wishlist_count = 0;
	
	$("input[type=checkbox]:checked").each ( function() 
	{
		wishlist_count++;
		
   		 $.ajax({
		   type: "GET",
		   url: '<?php echo base_url()."rooms/add_user_wishlist";?>',
		   data: 'wishlist_id='+$(this).val()+'&list_id='+$('#hidden_room_id').val()+'&note='+$('.wishlist-note').val()+'&i='+wishlist_count,
		   success: function(data){
		   	   
		   	   $.ajax({
  				url: "<?php echo site_url('search/add_my_shortlist'); ?>",
  				async: true,
  				type: "POST",
  				data: "list_id="+$('#hidden_room_id').val(),
  				success: function(data) {
  				if(data == "error")
  				window.location.replace("<?php echo base_url(); ?>users/signin");
  				else
  				{
    			$('.'+$('#hidden_room_id').val()).attr('value', '<?php echo translate("Saved to Wish List"); ?>'); 
    		    $('.'+$('#hidden_room_id').val()).attr('src', '<?php echo base_url().'images/heart_rose.png'; ?>'); 
    		    $('.modal_save_to_wishlist').hide();
    		    $('body').css({'overflow':'scroll'});
    		    }
  				}
   				});
		   	   
				   }
		 });
});

if(wishlist_count == 0)
{	
	 $.ajax({
		   type: "GET",
		   url: '<?php echo base_url()."rooms/remove_user_wishlist";?>',
		   data: 'wishlist_id='+$(this).val()+'&list_id='+$('#hidden_room_id').val()+'&note='+$('.wishlist-note').val(),
		   success: function(data){
		   			   	 
    			$('.'+$('#hidden_room_id').val()).attr('value', '<?php echo translate("Save To Wish List"); ?>'); 
    			$('.'+$('#hidden_room_id').val()).attr('src', '<?php echo base_url().'images/search_heart_hover.png'; ?>'); 
    			$('.modal_save_to_wishlist').hide();
    			$('body').css({'overflow':'scroll'});
    		    
		   	   
				   }
		 });
	
   		 
}
})
 });
</script>
<script type="text/javascript">
		    		
    // Run on page load
    window.onload = function() {
		
        // If values are not blank, restore them to the fields
        var guest = sessionStorage.getItem('guest');
        if (guest !== null && guest != 0) $('#number_of_guests').val(guest);
        
        
        var cin = sessionStorage.getItem('cin');
        if (cin !== null && cin !== "") $('#checkin').val(cin);
        
        
        var cout = sessionStorage.getItem('cout');
        if (cout !== null && cout !== "") $('#checkout').val(cout);
        
        
        var keywords = sessionStorage.getItem('keywords');
        if (keywords !== null && keywords !== "") $('#keywords').val(keywords);
        
        
        //var location = sessionStorage.getItem('location');
        //if (location !== null && location !== "") $('#location').val(location);
        
        var sort = sessionStorage.getItem('sort');
        if (sort !== null && sort !== "") $('#sort').val(sort);
                
        var min_bedrooms = sessionStorage.getItem('min_bedrooms');
        if(min_bedrooms !== null && min_bedrooms != "") $('#min_bedrooms').val(min_bedrooms);
        
        var min_bathrooms = sessionStorage.getItem('min_bathrooms');
        if(min_bathrooms !== null && min_bathrooms !== "") $('#min_bathrooms').val(min_bathrooms);
        
        var min_beds = sessionStorage.getItem('min_beds');
        if(min_beds !== null && min_beds !== "") $('#min_beds').val(min_beds);
  
     /*	var price_min = sessionStorage.getItem('min');
     	if(price_min !== null && price_min !== "") $('#slider_user_min').val(price_min);
     	
     	var price_max = sessionStorage.getItem('max');
     	if(price_max !== null && price_max !== "") $('#slider_user_max').val(price_max);   */
    }

    // Before refreshing the page, save the form data to sessionStorage
    window.onbeforeunload = function() {
        sessionStorage.setItem("guest", $('#number_of_guests').val());
        sessionStorage.setItem("cin", $('#checkin').val());
        sessionStorage.setItem("cout", $('#checkout').val());
        sessionStorage.setItem("location", $('#location').val());
        sessionStorage.setItem("keywords", $('#keywords').val());
        sessionStorage.setItem("sort", $('#sort').val());
        sessionStorage.setItem("min_bedrooms", $('#min_bedrooms').val());
        sessionStorage.setItem("min_bathrooms", $('#min_bathrooms').val());
        sessionStorage.setItem("min_beds", $('#min_beds').val());
       /* sessionStorage.setItem("min", $('#slider_user_min').val());
        sessionStorage.setItem("max", $('#slider_user_max').val());*/
        
		var data = $('input[name=property_type_id]:checked').map(function(){
	        return this.value;
	    }).get();
	    localStorage['data']=JSON.stringify(data);
	    
	    var data1 = $('input[name=room_types]:checked').map(function(){
	        return this.value;
	    }).get();
	    localStorage['data1']=JSON.stringify(data1);
	    
	    var instant = $('input[name=amenities]:checked').map(function(){
	        return this.value;
	    }).get();
	    localStorage['instant']=JSON.stringify(instant);
		
    }
    		
	</script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
<!--<script>
	function translate_today(today) 
	{
		alert('success');
	}
</script>

<!-- //clientsDropDown -->
<script>

function myFunction() {
    jQuery('.clearfix_type').toggle('show');
}
function myFunctionamenities()
{

	//alert('welcome');

	jQuery('.lightbox_filter_container').toggle('show');
}

</script>
<script>

	function myfunctionmore() {
   	var $elem = $('#search_main_left_top'); 
		jQuery('html, body').animate({scrollTop: $elem.height()+50}, 800);
    jQuery('.more_filter_tab').hide();
    jQuery('#search_body').hide();
    
    jQuery('#results').hide();
    jQuery('#results_footer').hide();
    jQuery('.property_type_search').show();
    jQuery('.amenities_search').show();
    jQuery('.keywords_search').show();
    jQuery('#show_listing').show();
    jQuery('.size_search').show();
    jQuery('.sort').show();
    jQuery('#results_footer').hide();
}	

</script>
<script>
	function myfunctionshowlist()
	{
		var $elem = $('#Search_Main'); 
			jQuery('html, body').animate({scrollTop: '0px'}, 800);
	jQuery('#results').toggle('show');
	jQuery('#search_body').toggle('show');
	jQuery('.lightbox_filters_class').hide();
	jQuery('.more_filter_tab').show();
	jQuery('#results_footer').show();
	jQuery('.sort').hide();
	jQuery('.property_type_search').hide();
	jQuery('.size_search').hide();
    jQuery('.amenities_search').hide();
    jQuery('.keywords_search').hide();
    jQuery('#show_listing').hide();
	
	}
</script>
<?php
$this->session->set_userdata('checkin','');
$this->session->set_userdata('checkout','');
$this->session->set_userdata('no_of_guest','');

?>

<?php $zz=0; ?>

<script type="text/javascript">


function show()
{

var location =  document.getElementById('location').value;
		var dataString = "&location=" +location;
			
	
	 b_url = "<?php echo base_url().'search/sample'?>";
		 $.ajax({
		   type: "GET",
		   url: b_url,
		   data: dataString,
		   success: function(data){
		   		$('#neighbor').html(data);
				   }
		 });
	
}
/*$('#show_listings').live('click',function() {
	$('input[type=checkbox]:checked').each(function() {
			$.ajax {
				type: 'post',
				url: "search" ?>',
				async: true,
				success : function() {
					$('input[type=checkbox]:checked').show();		
				} 
			}
			
	});
});*/

</script>


 <!---Include Validation for the Book it button----->
          <script type="text/javascript">
          
          
          
 $('#book_it_button').live('click',function()
  {
  	
  	var hid = $(this).attr("name");
var ratepernight=$(this).attr("alt");
var checkin = $("#checkin").val();

	var checkout = $("#checkout").val();
	var guest = $("#number_of_guests").val();
			
	//var dataString = "checkin=" +checkin +"&checkout="+checkout + "&guest="+guest+"&ratepernight=" +ratepernight; 
	
	var dataString = "checkin=" +checkin +"&checkout="+checkout + "&guest="+guest+"&ratepernight=" +ratepernight; 
	var c1= encodeURIComponent(checkin);
var c2=encodeURIComponent(checkout);
if($('#checkin').val()=='mm/dd/yy' && $('#checkout').val()=='mm/dd/yy')
{
	alert("Please choose the dates");

	return false;
}   
else
{  
  window.location.href="<?php echo base_url(); ?>payments/index/"+hid+"?"+dataString;
      }
     
    });
    
 
 
</script>
<style>

/*#clientsDropDown {
  position:fixed;
  bottom:0;
  width: 100%;
 /* padding-bottom:2%;
margin-bottom: 30px;
  z-index: 100;
}*/
.sch_fot_pop{
	height:150px !important;
}
#clientsOpen {
  color: #ececec;
  cursor: pointer;
  margin: -2px 0 0 10%;
  padding: 0 15px 2px;
  text-decoration: none;
}
/*#clientsCTA {
  width: 100%;
text-align: center;
padding: 0px 0;
text-decoration: none;
  /*background:#eb3c44;
  width:100%;
  color: #CCCCCC;
  text-align:center;
  margin-top: -80px;
  padding: 0px 0;
  text-decoration: none;
  padding:0 118px 0 40px;
  position: fixed;
}*/
/*#lang{
	border: 1px solid #dce0e0;
background: white;
color: #565a5c;
padding-bottom: 0%;
position: fixed;
background: none repeat scroll 0 0 #FFFFFF;
border-color: #DCE0E0;
color: #565A5C;
height: 45px;
padding: 12px;
left: 10px;
bottom: -1px;
font-weight: bold;
}
#lang:hover
{
	border:1px solid #b1b1b1; 
}
#clientsDropDown .clientsClose {
  background-image: url(images/close.png);
}
#clientsDropDown #clientsDashboard {
 display: none;
position: fixed;
width: 100%;
bottom: 0;
  /*float:bottom;
}*/
.pac-container {
   /* width: 450px !important;*/
  z-index: 9999;
}
.down_arrow
{
position: absolute;
right: 40px;
top: 15px;
opacity: 0.5;
}
.navbar-fixed-top, .navbar-fixed-bottom, .navbar-static-top{
margin-left:0px;
margin-right:0px;
}
body{
padding-left:0px;
padding-right:0px;
}

 /* #keywords
   {
   	margin: -10px 0px 0px 177px;
   	width:60%;
   }  */
 /* @media screen and (min-width:320px) and (max-width:767px){
	#clientsDropDown #clientsDashboard {
position: static;
}
#clientsDropDown {
  position:static;
  margin-bottom:0px;
}
#lang{
	/*display:none;
}
	}*/
	@media (min-width: 320px) and (max-width: 640px){
	.res_footer_container{
		margin:0px !important;
	}
	#clientsDropDown {
  position:relative !important;
  z-index: 100 !important;
}
#clientsCTA {
	 position:relative !important;
 }
 
 
}
@media screen and (max-width: 767px) and (min-width: 320px){
.fixes {
    width: 100% !important;
    padding-left: 8px !important;
}
}
@media (min-width: 320px) and (max-width: 640px)
{
	#lang , #close_search_footer
	{
		 display: none !important;
	}
	#clientsCTA
	{
		display: block !important;
	}
	#search_map
	{
	position: relative !important;
top: 0 !important;
width: 100% !important;
height: 300px !important;
}
#map_options
{
	position: absolute !important;
}
#filters_lightbox_nav
{
/*	width:100%;*/
}
#Search_Main
{
	margin-top:0px !important;
}
}
@media (min-width: 760px)
{
	#search_map
	{
	position: fixed !important;
}
#map_options
{
	position: relative;
}
}
#clientsOpen {
  color: #ececec;
  cursor: pointer;
  margin: -2px 0 0 10%;
  padding: 0 15px 2px;
  text-decoration: none;
}
/*@media (min-width: 759px)
{
/*#clientsCTA {
  margin-top: -231px;
  position: fixed;
	width:100%;
  /*background:#414142;
  color: #CCCCCC;
  text-align:center;
  padding: 0px 0;
  text-decoration: none;
  padding:0 118px 0 40px;
  
}*/
/*#clientsDropDown {
  position:absolute;
  bottom:0;
  width: 100%;
 /* padding-bottom:2%;
margin-bottom: 30px;
  z-index: 100;
}*/
/*#clientsDropDown #clientsDashboard {
  display: none;
  position:absolute;
  margin-top: -134px;
  float:bottom;
}*/
		
.dates_section.sch_da {
    margin-top: 30px;
}
#main_content {
overflow: hidden;
}
</style>
	
	
	<div class="search_main_right_tool col-md-7 col-sm-7 col-xs-12">
<div id="Search_Main" class="list_view condensed_header_view searchmain1">
<!-- search_header -->
<div id="search_main_left_top">
<div id="Selsearch_params"> 
  <form onsubmit="clean_up_and_submit_search_request(); return false;" action="<?php echo base_url();?>search" id="search_form" method="get" class="bordernone">
       
    <div id="SelSer_Par_Inps">
		
		<div class="dates_section loction_original col-md-12 col-xs-12 col-sm-12 sch_dat">
    		<div class="heading_1 col-md-2 col-sm-12">Location
    			</div>
    	      <div class="col-md-10 col-sm-8" style="padding: 0px;">
       			<input id="location" class="location date" type="text" value="<?php echo $location; ?>" name="location" autocomplete="off" placeholder="<?php echo translate("Location");?>">
      		<input type="hidden" value="<?php echo $lat; ?>" name="latti" id="latti" />
      		<input type="hidden" value="<?php echo $lng; ?>" name="longi" id="longi" />
      		
      		<input type="hidden" value="<?php echo $lat; ?>" name="lat1" id="lat1" />
      		<input type="hidden" value="<?php echo $lng; ?>" name="lng1" id="lng1" />
      			</div>
      		</div>


    	<div class="dates_section col-md-12 col-xs-12 col-sm-12 sch_da">
    		<div class="heading_1 col-md-2 col-sm-12"><?php echo translate("Dates"); ?>
    			</div>
  			
      <div class="dates_section box_1 col-md-3 col-sm-4">


        <input id="checkin" value="" class="checkin date active" name="checkin" autocomplete="off" placeholder="<?php echo translate('Check In'); ?>" readonly/><!--readonly placeholder="<?php echo translate('Check in'); ?>"-->
      </div>
      <div class="dates_section box_1 col-md-3 col-sm-4">
        <input id="checkout" value=""  class="checkout date active" name="checkout" autocomplete="off" placeholder="<?php echo translate('Check out'); ?>" readonly/>
      </div>
      <div class="guests_section box_1 col-md-3 col-sm-4">

      <!--  <input  id="checkin" value="" class="checkin date active" name="checkin" autocomplete="off"  readonly placeholder="Check In"/>
      </div>
     <!-- <div class="dates_section datesect2">
       <input id="checkout" value=""  class="checkout date active" name="checkout" autocomplete="off" placeholder="Check Out" readonly/>
     
     
     </div>-->
     
     
     
    <!-- <div class="dates_section datesect2">
       <input id="checkout" value=""  class="checkout date active" name="checkout" autocomplete="off"  placeholder="Check Out" readonly />
     
     
     </div>-->
     
     
     
     <!-- <div class="guests_section datesect3">-->

        <select id="number_of_guests" name="number_of_guests" value="Guests">
		 
          <option value="1">1  <?php echo translate('Guest'); ?></option>
          <option value="2">2 <?php echo translate('Guests'); ?></option>
          <option value="3">3 <?php echo translate('Guests'); ?></option>
          <option value="4">4 <?php echo translate('Guests'); ?></option>
          <option value="5">5 <?php echo translate('Guests'); ?></option>
          <option value="6">6 <?php echo translate('Guests'); ?></option>
          <option value="7">7 <?php echo translate('Guests'); ?></option>
          <option value="8">8 <?php echo translate('Guests'); ?></option>
          <option value="9">9 <?php echo translate('Guests'); ?></option>
          <option value="10">10 <?php echo translate('Guests'); ?></option>
          <option value="11">11 <?php echo translate('Guests'); ?></option>
          <option value="12">12 <?php echo translate('Guests'); ?></option>
          <option value="13">13 <?php echo translate('Guests'); ?></option>
          <option value="14">14 <?php echo translate('Guests'); ?></option>
          <option value="15">15 <?php echo translate('Guests'); ?></option>
          <option value="16">16+ <?php echo translate('Guests'); ?></option>
        </select>
      
      </div>
      </div>
    </div>
  

<input type="hidden" name="page" id="page" value="<?php echo $page; ?>" />
    <div class="clearfix"></div>
  </form>
</div>
<div class="panel_border"></div>
<!--Filters -->
<ul class="collapsable_filters">  
            <li class="search_filter clearfix1 room-type" id="room_type_container">   
            	<div class="dates_section1 col-md-12 col-xs-12 col-sm-12">
        <div class="heading_1 col-md-2" style="margin-top: px;">                                          
                         <?php echo translate("Room Type"); ?>
                         
	        	<img height="15" width="15" src="<?php echo base_url().'images/question_mark_2.png'; ?>" class="anchor">
	        	<p class="message">
	        		<b>Public</b><br>
	        		 Listing where you have the whole place to yourself.<br>
	        		 <b>Private</b><br>
	        		 Listings where you have your own room but share some common spaces.<br>
	        		 <b>House</b><br>
	        		 Listings where you'll share your room or your room may be a common space.
	        	</p>
	        
                        </div>
                        
                       
                  	
                    <!-- Search filter content is below this -->

                  <div class="clearfix1 col-md-3 col-sm-4 col-xs-12 rooms-sub room_type room_type_mob room_ser panel-heading">

            <img width="15" src="<?php echo base_url().'images/home.png'; ?>" class="set_img">
            <?php $room1 = $this->db->limit(1)->order_by('id','asc')->get('room_type')->row()->type;?>
			<label class="room_models" for="room_type_0"> <?php echo $room1; ?><input type="checkbox" id="room_type_0" class="room_0 room_2" <?php if(isset($room_type11)){ echo "checked"; } ?> name="room_types" value="<?php echo translate($room1); ?>">  </label>
			</div>
           
            
					<div class="clearfix1 col-md-3 col-sm-4 col-xs-12 room-sub room_type room_type_mob room_type_mob1 panel-heading">
            
			<img width="12" height="16" src="<?php echo base_url().'images/real-estate-03-512.png'; ?>" class="set_img">    <?php $room2 = $this->db->limit(1,1)->order_by('id','asc')->get('room_type')->row()->type;?>
            <label class="room_models rooms_models" for="room_type_1"><?php echo $room2; ?><input type="checkbox" id="room_type_1" class="room_2" <?php if(isset($room_type22)){ echo "checked"; } ?> name="room_types" value="<?php echo translate($room2); ?>"> </label>
            
            </div>
                       <div class="clearfix1 col-md-3 col-sm-4 col-xs-12 room-subs room_type room_type_mob room_shar panel-heading">
            
			<img width="18" height="13" class="sch_shar sch_shar_mob set_img sets_imgs" src="<?php echo base_url().'images/Bitmap.png'; ?>" >
			
			    <?php $room3 = $this->db->limit(1,2)->order_by('id','asc')->get('room_type')->row()->type;?>
			
			
			<label class="room_models shared_room rooms_model_1" for="room_type_2"><?php echo $room3 ; ?><input type="checkbox" id="room_type_2" class="room_2" <?php if(isset($room_type33)){ echo "checked"; } ?> name="room_types" value="<?php echo translate($room3);?>"> </label>
			
            </div>
              <!-- End of search filter content -->
             </div>
            </li>

                    

            
            <li id="price_container" class="search_filter clearfix1 clear_fix">
                <div class="dates_section data_line col-md-12 col-xs-12 col-sm-12">
        <div class="heading_1 col-md-2 price_size">                                          
                         <?php echo translate("Price Range"); ?>
                        </div>
                  	                
                    <div class="search_filter_content select_boxs col-md-9">
                      	<div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                        <div id="slide1" class="ui-slider-range ui-widget-header searchslider"></div>
                        <a href="#" class="ui-slider-handle ui-state-default price_min_ran ui-corner-all leftzero ui-slider-handle-state" style="left:0%"></a>
                        <a href="#" class="ui-slider-handle ui-state-default price_max_ran ui-corner-all fullleft ui-slider-handle-state" style="left:100%"></a>
                        <div class="ui-slider-range ui-widget-header texts" style="left: 0%; width: 100%;"></div>

                  	<!--	<div class="search_filter_content">
                        <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div id="slide1" class="ui-slider-range ui-widget-header searchslider"></div>
                        <a href="#" class="ui-slider-handle ui-state-default ui-corner-all leftzero"></a><a href="#" class="ui-slider-handle ui-state-default ui-corner-all fullleft "></a></div>-->

                        <ul id="slider_values">
                            <li id="slider_user_min">$10</li>
                            <li id="slider_user_max">$10000+ </li>
                        </ul>
                      
                    </div>
               </div>
            </li>
			<li class="search_filter sort clearfix1" id="instance_book_con" style="display: none;">
			<div class="dates_section col-md-12 col-xs-12 col-sm-12">
        	<div class="heading_1 col-md-2 instant-search">                                          
                         <?php echo translate("Options"); ?>
                        </div>
                        
		 		<div class="clearfix1 col-md-4 col-sm-4 col-xs-12 room_type room_type_mob room_ser ">
            		<input type="checkbox" id="instance_book" class="instance_book" name="instance_book" >
            			<img src="<?php echo base_url() ?>images/svg_7.png" class="instance-img">
						<label for="instance_book" class="instance-label">&nbsp;&nbsp; <?php echo translate('Instant Booking'); ?>  </label>
						<p class="instance-p">You can book the list without waiting for host approval</p>
            	</div>
			</li>
            <li id="price_container" class="search_filter sort clearfix1" style="display: none">
            	<div class="heading_1 col-md-2 col-sm-12"><?php echo translate("Sort by Category"); ?> </div>
           <div id="sort_by_filter" class="guests_section col-md-3 col-xs-12 col-sm-12" style="padding: 0">
              <select name="sort" id="sort">
			   <option value="1"><?php echo translate("Recommended"); ?></option>
               <option value="2"><?php echo translate("Price: low to high");?></option>
               <option value="3"><?php echo translate("Price: high to low"); ?> </option>
               <option value="4"><?php echo translate("Newest"); ?></option>
			   </select>
			   <input type="hidden" id="sort_val" name="sort" class="input_product" value=""></input>

        </div>
	</li>
	
	<li id="review_container" class="search_filter sort clearfix1" style="display: none">
       <div class="heading_1 col-md-2 col-sm-12"><?php echo translate("Sort by Review"); ?> </div>
       <div id="sort_by_rev" class="guests_section col-md-3 col-xs-12 col-sm-12" style="padding: 0">
		<form id="reviews_stars">
		<ul>
		  <li>
		    <input type="radio" id="no_option" name="review_selector" value="0" CHECKED>
		    <label for="no_option">No Preferences</label>
		    <div class="check"></div>
		  </li>
		  <li>
		    <input type="radio" id="ones" name="review_selector" value="1">
		    <label for="ones"><i class="fa fa-star" aria-hidden="true"></i></label>
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  <li>
		    <input type="radio" id="twos" name="review_selector" value="2">
		    <label for="twos"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></label>
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  
		  <li>
		    <input type="radio" id="threes" name="review_selector" value="3">
		    <label for="threes"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></label>
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  <li>
		    <input type="radio" id="fours" name="review_selector" value="4">
		    <label for="fours"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></label>
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  <li>
		    <input type="radio" id="fives" name="review_selector" value="5">
		    <label for="fives"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></label>
		    <div class="check"><div class="inside"></div></div>
		  </li>
		</ul>
		</form>
		</div>
	</li>	

	
	
			<!-- <li id="review_container" class="search_filter sort clearfix1" style="display: none">
            	<div class="heading_1 col-md-2 col-sm-12"><?php echo translate("Sort by Review"); ?> </div>
            	<div id="sort_by_rev" class="guests_section col-md-3 col-xs-12 col-sm-12" style="padding: 0">
            		<div><input type="radio" name="rev" value="1" checked><i class="fa fa-star" aria-hidden="true"></i></div>
            		<div><input type="radio" name="rev" value="2"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></div>
            		<div><input type="radio" name="rev" value="3"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></div>
            		<div><input type="radio" name="rev" value="4"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></div>
            		<div><input type="radio" name="rev" value="5"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></div>
            	</div>
		</li> -->
            <!--<div class="size_end_form">-->
            	<li id="price_container" class="search_filter size_search clearfix1" style="display: none">
            <div class="dates_section col-md-12 col-xs-12 col-sm-12">
        <div class="heading_1 col-md-2 col-sm-12" style="margin-left: -12px;">                                          

            
            <!--	<li id="price_container" class="search_filter size_search" style="display: none">
            <div class="dates_section">
        <div class="heading_1">                                          -->

                         <?php echo translate("Size"); ?>
                        </div>
                  <div class="col-md-3 col-sm-4 room_size room_size_1">
                          <select id="min_bedrooms" name="min_bedrooms"><option value=""><?php echo translate("Bedrooms"); ?></option>
						<?php for($i = 1; $i <= 16; $i++) { ?>
									<option value="<?php echo $i." " .Bedrooms; ?>"><?php echo $i." " .Bedrooms; ?> </option>
							<?php } ?>
						</select>
  					</div>
  					   <div class="col-md-3 col-sm-4 room_sizes room_size_1">
                        <select id="min_bathrooms" name="min_bathrooms"><option value=""><?php echo translate("Bathrooms"); ?></option>
                        	
						<option>0 Bathrooms</option>
                        <option>0.5 Bathrooms</option>
                        <option>1 Bathrooms</option>
                        <option>1.5 Bathrooms</option>
                        <option>2 Bathrooms</option>
                        <option>2.5 Bathrooms</option>
                        <option>3 Bathrooms</option>
                        <option>3.5 Bathrooms</option>
                        <option>4 Bathrooms</option>
                        <option>4.5 Bathrooms</option>
                        <option>5 Bathrooms</option>
                        <option>5.5 Bathrooms</option>
                        <option>6 Bathrooms</option>
                        <option>6.5 Bathrooms</option>
                        <option>7 Bathrooms</option>
                        <option>7.5 Bathrooms</option>
                        <option>8+ Bathrooms</option>
						</select>
                      </div>
                       <div class="col-md-3 col-sm-4 room_siz room_size_1">
                          <select  id="min_beds" name="min_beds">
							<option value=""><?php echo translate("Beds"); ?></option>
							<?php for($i = 1; $i <= 16; $i++) { ?>

													<option value="<?php echo $i." ".Beds; ?>"><?php echo $i." " .Beds; if($i == 16) echo '+'; ?> </option>

								<?php } ?>
							</select>
                      </div>
                      </div>
                      </li>
                      

                        <li id="room_type_container" class="search_filter property_type_search clearfix  private_rooms" style="display: none">
           
            <div class="dates_section col-md-12 col-xs-12 col-sm-12  heading_botm">
        <div class="heading_1 col-md-2">                                          

                         <?php echo translate("Property Type"); ?>
                        </div>
                        
                        <ul class="search_filter_content" id="lightbox_filter_content_property_type_id">
                        	
                        		                    <?php
                   $property = $this->db->limit(3)->from('property_type')->get();
				$i = 1;
					 foreach($property->result() as $value) 
					 {

					   echo '<li class="clearfix1 col-md-3 col-sm-6" style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">';

					 //  echo '<li class="clearfix" style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; ">';

					   if($i == 1)
					   {
					   	 $label_style = 'margin:0px 0px 0px 0px;';
						 $check_style = 'margin-top:0;';
					   }
					    if($i == 2)
					   {
					   	 $label_style = 'margin:0;';
						 $check_style = 'margin:0 0px 0px 0px;';
					   }
					    if($i == 3)
					   {
					   	 $label_style = 'margin:0;';
						 $check_style = 'margin:0 0px 0px 0px;';
					   }
					   $i++;
					  ?>
					<input type="checkbox" style="<?php echo $check_style;?>" value="<?php echo $value->id;?>" name="property_type_id" id="lightbox_property_type_id_<?php echo $value->type;?>">

				<!--	<label for="lightbox_property_type_id_<?php echo $value->type;?>"><?php echo $value->type; ?></label>-->

					
					<label title="<?php echo $value->type; ?>" for="lightbox_property_type_id_<?php echo $value->type;?>"><?php echo $value->type.'<br>'; ?></label>

					<?php 
					  echo '</li>';
					 }
					 ?>
					
					
				 </ul> 
				
					 <img class="down_arrow" onclick="myFunction()" src="<?php echo base_url(); ?>images/dropdown.jpg" />
				
					<div class="spacings">
						
				<ul class="search_filter_content col-md-offset-2" id="lightbox_filter_content_property_type_id" >
					
						<div class="hovers"><hr class="propertys_hr"></div>
					 <?php 
					 $property_count = $this->db->from('property_type')->get()->num_rows();
					$property = $this->db->limit($property_count,3)->from('property_type')->get();
					
					foreach($property->result() as $value) 
					{

					 echo '<li class="clearfix_type col-md-4 col-sm-6 fixes" style="display:none;">'; ?>
					<input type="checkbox" value="<?php echo $value->id;?>" name="property_type_id" id="lightbox_property_type_id_<?php echo $value->type;?>">
					<label title="<?php echo $value->type; ?>" for="lightbox_property_type_id_<?php echo $value->type;?>"><?php echo $value->type; ?></label>

					<!--echo '<li class="clearfix_type" style="display:none; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; ">'; ?>
				<!--	<input type="checkbox" value="<?php echo $value->id;?>" name="property_type_id" id="lightbox_property_type_id_<?php echo $value->type;?>">
					<label title="<?php echo $value->type; ?>" for="lightbox_property_type_id_<?php echo $value->type;?>"><?php echo $value->type.'<br>'; ?></label>-->

					<?php } echo '</li>';?>
			
				</ul> 
			</div>
					 <div style="clear:both;"></div>
					</div>
                      </li>
                <hr>      
                       <li id="room_type_container" class="search_filter amenities_search clearfix1 ptns" style="display: none">
           
            <div class="dates_section col-md-12 col-xs-12 col-sm-12  heading_botm">
        <div class="heading_1 col-md-2">                                          
                         <?php echo translate("Amenities"); ?>
                        </div>
                        
                        <ul class="search_filter_content" id="lightbox_container_amenities" style="padding:0px !important;">
                
                    <?php
                   $amenities = $this->db->limit(3)->from('amnities')->get();
				$i = 1;
					 foreach($amenities->result() as $value) 
					 {

					   echo '<li class="clearfix1 col-md-3 col-sm-6" style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">';

					  // echo '<li class="clearfix" style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; ">';

					   if($i == 1)
					   {
					   	 $label_style = 'margin:0px 0px 0px 0px;';
						 $check_style = 'margin-top:0;';
					   }
					    if($i == 2)
					   {

					   	 $label_style = 'margin: 5px 0px 0px 0px;';
						 $check_style = 'margin:0 0px 0px 0px;';
					   }
					    if($i == 3)
					   {
					   	 $label_style = 'margin:7px 0px 0px 0px;';
						 $check_style = 'margin:0 0px 0px 0px;';

					  /* 	 $label_style = 'margin: 5px 0px 0px 15px;';
						 $check_style = 'margin:0 0px 0px 17px;';
					   }
					    if($i == 3)
					   {
					   	 $label_style = 'margin:7px 0px 0px 15px;';
						 $check_style = 'margin:0 0px 0px 31px;';*/

					   }
					   $i++;
					  ?>
					<input type="checkbox" style="<?php echo $check_style;?>" value="<?php echo $value->id;?>" name="amenities" id="lightbox_amenity_<?php echo $value->name;?>">

				<!--	<label style="" for="lightbox_amenity_<?php echo $value->name;?>"><?php echo $value->name; ?></label>-->

					<label style="" title="<?php echo $value->name; ?>" for="lightbox_amenity_<?php echo $value->name;?>"><?php echo $value->name.'<br>'; ?></label>

					<?php 
					  echo '</li>';
					 }
					 ?>
					 
					 </ul> 

				<img class="down_arrow" onclick="myFunctionamenities()" src="<?php echo base_url(); ?>images/dropdown.jpg" />
				<div class="hovers"><hr class="property_hr"></div>
				<ul class="search_filter_content col-md-offset-2" id="lightbox_container_amenities" >

					<!-- <img class="down_arrow downarrowsearch" onclick="myFunctionamenities()" src="<?php echo base_url(); ?>images/dropdown.jpg" />
				<div class="searchfilter1_ami">
				<ul class="search_filter_content" id="lightbox_container_amenities" >-->
<div class="pnts">
					 <?php 
					 $amnities_count = $this->db->from('amnities')->get()->num_rows();
					$amnities_total = $this->db->limit($amnities_count,3)->from('amnities')->get();
					$i = 0;
					foreach($amnities_total->result() as $value) 
					{
						echo '<li class="clearfix_amenities lightbox_filter_container col-md-4 col-sm-6 fixes" style="'.$style.'display:none; /*width: 23%; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;*/ ">'; ?>
			<input type="checkbox" value="<?php echo $value->id;?>" name="amenities" id="lightbox_amenity_<?php echo $value->name;?>">
					<label class="label-check" title="<?php echo $value->name; ?>" for="lightbox_amenity_<?php echo $value->name;?>"><?php echo $value->name.'<br>'; ?> </label>
					<?php } echo '</li>';?>

					<!--echo '<li class="clearfix_amenities lightbox_filter_container col-md-4 col-sm-6" style="display:none;">'; ?>-->
					<!--<input type="checkbox" value="<?php echo $value->id;?>" name="amenities" id="lightbox_amenity_<?php echo $value->name;?>">
					<label for="lightbox_amenity_<?php echo $value->name;?>"><?php echo $value->name; ?></label>

					<!--	if($i == 0)
						{
							$style = "clear: both;";
						}
						else {
							$style = '';
						}
                     $i++;-->
                    </div>
				</ul> 
				</div>
					 <div style="clear:both"></div>
				
                      </li>
                     <hr>
                      <li id="room_type_container" class="search_filter keywords_search clearfix ptnes" style="display: none">
            <div class="dates_section col-md-12 col-xs-12 col-sm-12">
        <div class="heading_1 col-md-2" style="margin-top: 0px; padding-top: 10px;">                                          
                         <?php echo translate("Keywords"); ?>
                        </div>
                        <ul id="lightbox_container_amenities" class="search_filter_content">

                        	<li class="clearfix1 searchfilter3 ser_key col-md-10">

                        <!--	<li class="clearfix searchfilter3 ser_key">-->

                    <input type="text" placeholder="Ocean side, transit, relaxing..." id="keywords" />
                    </li>
                    </ul>
                    </div>
					 									
					 <div style="clear:both"></div>
                      </li>
<hr>
                     <div class="show_listing_div">
                      <!--<a href="javascript:void(0);" id="show_listing" style="display: none">
                      <input type="button" value="Show listing" class="show_listing_show_1" onclick="myfunctionshowlist()" />
                      -->
                      <button class="show_listing_show_1 cursorpoint finish" id="show_listing" style="display: none;" onclick="myfunctionshowlist()">Show Listings</button>
                      </div>

                      <div class="">
                      
                  <!--    <button class="show_listing_show_1 cursorpoint" id="show_listing" style="display: none;" onclick="myfunctionshowlist()">Show Listings</button>-->
                      

                      </div>
                      </div>
<div>

    <li id="more_filters" class="search_filter" style="padding:0px;">    
                     <div id="filters_lightbox Box_head" class="more_filter_tab" style="display: block;">
      <ul id="filters_lightbox_nav" class="sch_filt" style="position: static; margin-top: 0px; top: 0px;  margin-left: 0px; z-index: 16;">

          <li class="filters_lightbox_nav1_element" id="lightbox_nav_room_type" >
          	<a href="javascript:void(0);" class="more_filters1" onclick="myfunctionmore()"><?php echo translate("More Filters"); ?></a> 
          	
<p class="price_options">Enter dates to see full pricing. Additional fees apply. Taxes may be added.</p>
          	
         	<ul class="collapsable">
          		<li>
         <!---- 	<input class="more_filters1" type="button" id="roomType"  value="RoomType X">
          		----->          		
          		
           </li></ul> 
          	<!-- price option -->
          <!--<ul class="collapsable">
          		<li>
          	<input class="more_filters1" type="button" id="roomType1"  value="PriceType X">
          		          		
           </li></ul>
          	
          <!-- property type -->
         	<!--<ul class="collapsable">
          		<li>
          	<input class="more_filters1" type="button" id="roomType2"  value="PropertyType X">
          		          		
           </li></ul> 
          	
          	<ul class="collapsable">
          		<li>
          	<input class="more_filters1" type="button" id="roomType3"  value="Amenities X">
          		          		
           </li></ul> 
           <ul class="collapsable">
          		<li>
          	<input class="more_filters1" type="button" id="roomType4"  value="Size X">
          		          		
           </li></ul> -->
          	
          	
          	

          	<div class="results_count clsFloatLeft morefilter1"></div>
          </li>
          
      </ul>
      </div>
 </li>
</div>
<!--<div>
    <li id="more_filters" class="search_filter" style="padding:0;">    
                     <div id="filters_lightbox Box_head" class="more_filter_tab">
      <ul id="filters_lightbox_nav" class="sch_filt" style="position: static; margin-top: 0px; top: 0px; width: 100%; margin-left: 0px; z-index: 16;" >

          <li class="filters_lightbox_nav1_element" id="lightbox_nav_room_type" >
          	<a href="javascript:void(0);" class="more_filters1" onclick="myfunctionmore()"><?php echo translate("More Filters"); ?></a>  
          	<div class="results_count clsFloatLeft" style="float: right; padding: 10px; margin-top: 15px;"></div>
          </li>
      </ul>
      </div>
 </li>
</div> -->
										 
            	
     
<!--Filters End-->	
<!-- search_params -->
<div id="standby_action_area" style="display:none;">
  <div> <b><a id="standby_link" href="/messaging/standby" target="_blank">
    <?php echo translate("Do you need a place <i>pronto</i>? Join our Standby list!"); ?>
    </a></b> </div>
</div>
    	<!-- End of Left -->
        <!-- Right -->
        <!-- End of Right 
        	
    <!-- Results header was here initially -->
    <!--  End of results header -->
     <div id="list_view_loading" class="rounded_more" style="display: none;" ><!-- <img class="listview1" src="<?php echo base_url(); ?>images/page2_spinner.gif" height="42" width="42" alt="" />--> </div>
       <div id="search_body" style=" min-height: 590px; " >
    <div id="results_filters">
        <div id="filters_text"><?php echo translate("Filters:"); ?></div>
        
        <ul id="applied_filters">
        </ul>
      </div>
    <ul id="results" class="col-md-12">
    	 
      </ul>
      <div id="footer_search" class="footsearch"></div>
 
    <!-- results -->
    <div id="results_footer" class="clearfix">
    	<div class="results_count" id="results_count_html"></div>
        <div id="results_pagination" class="clsFloatRight"></div>
        <span class="country_name" id="currency_mname">
        <span class="country_name">
        <?php
        if(isset($location))
		{
        $address_pieces = explode(',', $location);
		if(count($address_pieces) > 0)
		{
			$address_pieces = array_reverse($address_pieces);
			$i = 1;
			foreach($address_pieces as $row)
			{
				$row = trim($row);
				if(count($address_pieces) != $i)
				{
					echo '<a href="'.base_url().'search?location='.$row.'" > '.$row.'</a> > ';	
					//echo '<a href="'.base_url().'search?location='.$row.'" > '.$row.'</a>>';
				}
				else
				{
					echo $row;
				}
				$i++;
			}
		}
		else {
			echo $location;
		}
		}
        ?>	   
        </span>
      </div>
    <!-- results_footer -->
   
  </div>
    
<!--End Of search_body -->
<!-- Contents below this is for the search filters -->

</div>
</div>
<!-- v3_search -->


<!-- this partial is wrapped in a div class='search_filters' -->
	<!-- Map Container Hidden-->         
    
      <div id="search_filters_wrapper" class="search-main-right col-md-5 col-sm-5 col-xs-12">
		<div id="search_filters">
		
		<div id="map_op_parent" >
	<div id="map_options" class="postfixed" style="position: fixed; left:58%;top:0%;"><input style= "float: left;display: inline" type="checkbox" name="redo_search_in_map" id="redo_search_in_map" />
	<label style= "float: left;padding-top: 3px;" for="redo_search_in_map" id="for_redo_search_in_map"><?php echo translate('Search as I move the map');?>	</label>
	<i for="redo_search_in_map" id="redo_img" style="display:none;" class="fa fa-repeat"></i> 
	</div>
	</div>
		
		
		<div id="map_wrapper">       
    		<div id="search_map" class="searchmap1"></div>           
	</div>
	</div>
	</div>
  



<ul id="blank_state_content" style="display:none;">
  <li id="blank_state">
    
    <div id="blank_state_text">
       <p>
        <?php echo translate("We couldn’t find any results that matched your criteria, but tweaking your search may help. Here are some ideas:"); ?>
     </p>
      <p>
        <?php echo translate("but tweaking your search may help. Here are some ideas:"); ?>
      <ul>
      	<li class="content1">Remove some filters.</li>
      	<li class="content1">Expand the area of your search.</li>
      	<li class="content1">Search for a city, address, or landmark.</li>
      </ul>
        </p>
    </div>
  </li>
</ul>

							

<style type="text/css">
.ac_results { border-color:#a8a8a8; border-style:solid; border-width:1px 2px 2px; margin-left:1px; }
.clearfix:before, .clearfix:after {
    content: "";
}
</style>
<script type="text/x-jqote-template" id="badge_template">
    <![CDATA[
        <li class="badge badge_type_<*= this.badge_type *>">
            <span class="badge_image">
                <span class="badge_text"><*= this.badge_text *></span>
            </span>
            <span class="badge_name"><*= this.badge_name *></span>
        </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_item_template">
    <![CDATA[
        <li id="room_<*= this.hosting_id *>" class="search_result col-md-6 ">
            <div class="pop_image_small">
                
                
               <!--Discount label 1 start -->
                           
<* if(this.discount!=0){ *><div style="position: absolute;" class="list_new_room_left_search"><*= this.discount *></div><* } *>                 
 
  <!--Discount label 1 end -->
                
                
                
                
                <ul class="enlarge"> 
                <a href="<?php echo base_url(); ?>rooms/<*= this.hosting_id *>" class="image_link" title="<*= this.hosting_name *>">
                	<li class="img_wid">
                		<?php 
                		$date_new = strtotime(date("Y-m-d", strtotime("-3 days")));
						
                		?>
                		<* if(this.created >= <?php echo $date_new ?>){ *>
                		<div class="map_number">New</div>
                		<* }  *>
                	<img alt="<*= this.hosting_name *>" class="search_thumbnail searchthumb" src="<*= this.hosting_thumbnail_url *>" onerror="this.src='<?php echo base_url().'images/no_image.jpg';  ?>'" title="<*= this.hosting_name *>"/><br />
			
</li>

				</a>
				</ul>
            <div class="price">
            	 
                <div class="price_data">
                    <sup class="currency_if_required"><*= CogzidelSearch.currencySymbolRight *></sup>
       
                    <div class='currency_with_sup'><*= this.symbol *><*= this.price *> <*if(this.instant_book==1) { *>
                  
            <img class="instant" src= "<?php echo base_url() ?>images/svg_7.png" title="Instant Book &#xA;Book with out waiting for your &#xA;reservation to be accepted">
                <* } *>
              
                    </div>
                 
                </div>
                 
                <div class="price_modifier" style="display: none;">
                    Per night
                </div>
                </div>

                

              

                 <* if(this.short_listed == 1) { *>
				<img class="search_heart_hover searchheart_hover1"src="<?php echo base_url() ?>images/heart_rose.png" value="Saved to Wish List" id="my_shortlist"  onclick="add_shortlist(<*= this.hosting_id *>,this);">
				<* } else { *>
				<img class="search_heart_normal searchheart_hover1"src="<?php echo base_url() ?>images/search_heart_hover.png" value="Save To Wish List" id="my_shortlist" onclick="add_shortlist(<*= this.hosting_id *>,this);">
				<* } *>
				
            

            <ul class="reputation reputation_user"> <a class="" href="<?php echo base_url(); ?>users/profile/<*= this.user_id *>">
            	<img alt="<*= this.user_name *>" height="45" src="<*= this.user_thumbnail_url *>" title="<*= this.user_name *>" width="45" class="img_user media-photo media-round" /></a> </ul>
               </div>
                </div>

          <!--  <ul class="reputation reputation_user"> <a class="" href="<?php echo base_url(); ?>users/profile/<*= this.user_id *>"><img alt="<*= this.user_name *>" height="45" src="<*= this.user_thumbnail_url *>" title="<*= this.user_name *>" width="45" class="img_user media-photo media-round" /></a> </ul>-->
               


            <div class="room_details">
                <div class="room_title">
                  <a class="name" title="<*= this.hosting_name *>" href="<?php echo base_url(); ?>rooms/<*= this.hosting_id *>"><*= this.hosting_name *> 
                 
                 <a href="#" id="star_<*= this.hosting_id *>" title="Add this listing as a 'favorite'" class="star_icon_container"><div class="star_icon"></div></a>

                </h6>

                <* if(this.distance) { *>
                    <p class="address_max_width"><*= this.address *></p>
                    <p class="distance"><*= this.distance *> <*= Translations.distance_away *></p>
                <* } else { *>
                    <p class="address img_text"><*= this.address *></p>
                <* } *>
                
                 <* if(this.review_count != 0) { *> 
                 	<div class="Sat_Star_Nor" title="">
                  <div class="Sat_Star_Act" style="width:<*= this.review_rating *>%"> </div>
                   <* if(this.review_count != 0) { *> 
                	<span class="review"><*= this.review_count *></span>  
                	<* } *>
                </div>                                  	
                
                  <* } *>
                 </a>
                  </div> 
               
                	
                   <!--wishlist count 1 start-->
                     <!--wishlist count 1 end-->
               
               
               
               

                
				
            </div>
            
			<div class="user_thumb">
          </div>
					<table width="76%" cellspacing="0" cellpadding="0" border="0" class="marginzero">
  <tbody><tr>
    <td width="25%" valign="middle" align="right" style="display: none;">
		<div class="count_badge countview">
			<*= this.views*></div>
			<div class="countview1"><?php echo translate('Views');?></div></td>
		
    	
   
    <td width="10%" valign="middle" align="center" style="display: none;">
		<a class="btn green bookit_button buttonsearch" href="#" alt="<*=this.price*>" name="<*= this.hosting_id *>" id="book_it_button" oncontextmenu="return false" style="display: inline-block;"><?php echo translate('Book it');?></a>
	</td>
  </tr>
</tbody>
</table>
        
			<* if (this.connections.length > 0) { *>

			<div class="room-connections-wrapper">
				<span class="room-connections-arrow"></span>
				<div class="room-connections">
					<ul>
						<* for (var k = 0; k < Math.min(this.connections.length, 3); k++) { *>
						<li>
							<img height="28" width="28" alt="" src="<*= this.connections[k].pic_url_small *>" />
							<div class="room-connections-title">
								<div class="room-connections-title-outer">
									<div class="room-connections-title-inner">
										<*= this.connections[k].caption *>
									</div>
								</div>
							</div>
						</li>
						<* } *>
					</ul>
				</div>
			</div>
			<* } *>

        </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="applied_filters_template">
    <![CDATA[
        <li id="applied_filter_<*= this.filter_id *>"><span class="af_text"><*= this.filter_display_name *></span><a class="filter_x_container"><span class="filter_x"></span></a></li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_airtv_template">
    <![CDATA[
        <div id="airtv_promo">
            <img src="/images/page2/v3/airtv_promo_pic.jpg" />
            <h6><*= this.airtv_headline *></h6>
            <h6><*= this.airtv_description *> <b><?php echo translate("Watch Now!");?></b></h6>
        </div>
    ]]>
</script>
</div>


	
	


<script type="text/javascript">

var srch_map_txt = 'Search as I move the map' ;
var redo_txt =  'Redo search here' ;

    jQuery(document).ready(function(){
        Cogzidel.Bookmarks.starredIds = [];

        CogzidelSearch.$.bind('finishedrendering', function(){ 
        	
        	var queries = {};
$.each(document.location.search.substr(1).split('&'), function(c,q){
    var i = q.split('=');
    if(i != ""){
    queries[i[0].toString()] = i[1].toString();
     var plch = decodeURI((i[1].toString()) )!=""?decodeURI((i[1].toString()) ):"Where do you want to going ?";
     //alert(plch)
 jQuery("#location").attr("placeholder", plch) ;
 }
});
        	
          Cogzidel.Bookmarks.initializeStarIcons(function(e, isStarred){ 
            // hide the listing result from the set of search results when the result is unstarred
            if(!isStarred && CogzidelSearch.isViewingStarred){
              if(CogzidelSearch.currentViewType == 'list')
                $('#room_' + $(e).data('hosting_id')).slideUp(500);
              else if(CogzidelSearch.currentViewType == 'photo')
                $('#room_' + $(e).data('hosting_id')).fadeOut(500);
            }
          }) 
        });

            SearchFilters.amenities.a_11 = ["Smoking Allowed", false];
            SearchFilters.amenities.a_12 = ["Pets Allowed", false];
            SearchFilters.amenities.a_1 = ["TV", false];
            SearchFilters.amenities.a_2 = ["Cable TV", false];
            SearchFilters.amenities.a_3 = ["Internet", false];
            SearchFilters.amenities.a_4 = ["Wireless Internet", false];
            SearchFilters.amenities.a_5 = ["Air Conditioning", false];
            SearchFilters.amenities.a_30 = ["Heating", false];
            SearchFilters.amenities.a_21 = ["Elevator in Building", false];


            SearchFilters.amenities.a_6 = ["Handicap Accessible", false];
            SearchFilters.amenities.a_7 = ["Pool", false];
            SearchFilters.amenities.a_8 = ["Kitchen", false];
            SearchFilters.amenities.a_9 = ["Parking Included", false];
            SearchFilters.amenities.a_13 = ["Washer / Dryer", false];
            SearchFilters.amenities.a_14 = ["Doorman", false];
            SearchFilters.amenities.a_15 = ["Gym", false];
            SearchFilters.amenities.a_25 = ["Hot Tub", false];
            SearchFilters.amenities.a_27 = ["Indoor Fireplace", false];
            SearchFilters.amenities.a_28 = ["Buzzer/Wireless Intercom", false];
            SearchFilters.amenities.a_16 = ["Breakfast", false];
            SearchFilters.amenities.a_31 = ["Family/Kid Friendly", false];
            SearchFilters.amenities.a_32 = ["Suitable for Events", false];

        //CogzidelSearch.currencySymbolLeft = '<?php //echo get_currency_symbol(1); ?>';
        CogzidelSearch.currencySymbolRight = "";
        SearchFilters.minPrice = 10;
        SearchFilters.maxPrice = 10000;
        SearchFilters.minPriceMonthly = 150;
        SearchFilters.maxPriceMonthly = 5000;

        var options = {};

        //Some More Testing needs to be done with this logic - there are still edge cases
        //here, we add ability to hit the back button when the user goes from (page2 saved search)->page3->(browser back button)
        if(CogzidelSearch.searchHasBeenModified()){
            options = {"lat":"<?php echo $lat; ?>","location":"<?php echo $location; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"ajax_get_results","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        } else {
            options = {"lat":"<?php echo $lat; ?>","location":"<?php echo $location; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"ajax_get_results","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        }

          CogzidelSearch.isViewingStarred = false;
       

        if(options.search_view) {
            CogzidelSearch.forcedViewType = options.search_view;
        }

        //keep translations first
        Translations.clear_dates = "Clear Dates";
        Translations.entire_place = "Entire Place";
        Translations.friend = "friend";
        Translations.friends = "friends";
        Translations.loading = "Loading";
        Translations.neighborhoods = "Neighborhoods";
        Translations.private_room = "Private Room";
        Translations.review = "review";
        Translations.reviews = "reviews";
        Translations.superhost = "superhost";
        Translations.shared_room = "Shared Room";
        Translations.today = "Today";
        Translations.you_are_here = "You are Here";
        Translations.a_friend = "a friend";
        Translations.distance_away = "away";
        Translations.instant_book = "Instant Book";
        Translations.show_more = "Show More...";
        Translations.learn_more = "Learn More";
        Translations.social_connections = "Social Connections";

        //these are generally for applied filter labels
        Translations.amenities = "Amenities";
        Translations.room_type = "Room Type";
        Translations.price = "Price";
        Translations.keywords = "Keywords";
        Translations.property_type = "Property Type";
        Translations.bedrooms = "Bedrooms";
        Translations.bathrooms = "Bathrooms";
        Translations.beds = "Beds";
        Translations.languages = "Languages";
        Translations.collection = "Collection";

        //zoom in to see more properties message in map view
        Translations.redo_search_in_map_tip = "\"Redo search in map\" must be checked to see new results as you move the map";
        Translations.zoom_in_to_see_more_properties = "Zoom in to see more properties";

        //when map is zoomed in too far
        Translations.your_search_was_too_specific = "Your search was a little too specific.";
        Translations.we_suggest_unchecking_a_couple_filters = "We suggest unchecking a couple filters, zooming out, or searching for a different city.";

        //Tracking Pixel
        //run after localization
        TrackingPixel.params.uuid = "yq0m0k6hjg";
        TrackingPixel.params.user = "";
        TrackingPixel.params.af = "";
        TrackingPixel.params.c = "";
        TrackingPixel.params.pg = '2';

        CogzidelSearch.init(options);



// clear the rooms/new session values

sessionStorage.setItem("accomedval","");
sessionStorage.setItem("otherstrimed","");
sessionStorage.setItem("room_typee", "");
sessionStorage.setItem("accomedval", "");



    });
    
    function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

    function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  if (window.addEventListener) {
      window.addEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = wheel;
}

	jQuery(document).ready(function() {
		Cogzidel.init({userLoggedIn: false});
		//My Wish List Button-Add to My Wish List & Remove from My Wish List
		add_shortlist = function(item_id,that) {
			
			$.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin?search=1");
      				}
      				});
		
		 $('#header').css({'z-index':'0'});
		 
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
  				type: "get",
  				data: "list_id="+item_id,
  				success: function(data) {
  					//alert(data);
  					$('.modal_save_to_wishlist').replaceWith(data);	
  					$('.modal_save_to_wishlist').show();
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
    		

// clear the rooms/new session values
sessionStorage.setItem("accomedval","");
sessionStorage.setItem("otherstrimed","");
sessionStorage.setItem("room_typee", "");
sessionStorage.setItem("accomedval", "");    		
    		
    			
		});
	</script>
	<script type="text/javascript">
/*		    		
    // Run on page load
   window.onload = function() {
var sum = $('#slider_user_min').val();
var sumi = $('#slider_user_max').val();
//var stxt = $('#searchTextField').val();

        // // If sessionStorage is storing default values (ex. name), exit the function and do not restore data
        // if (sessionStorage.getItem('guest') == "guest") {
            // return;
        // }

        // If values are not blank, restore them to the fields
        
        var min = sessionStorage.getItem('min');
        if (min !== null) $('#slider_user_min').val(min);
//         
        var max = sessionStorage.getItem('max');
        if (max !== null) $('#slider_user_max').val(max);
//     
        // if(ng!="" || cn!="" || ng!="" || rta!="" || rtb!="" || rtc!=""|| sum!=""|| sumi!=""|| stxt!=""){
        	
//         	
        	// setTimeout(function(){
			  // alert("Boom!");
			  CogzidelSearch.loadNewResults();
			// }, 5000);
        	
        // }

    }

    // Before refreshing the page, save the form data to sessionStorage
    window.onbeforeunload = function() {
        
        sessionStorage.setItem("min", $('#slider_user_min').val());
        sessionStorage.setItem("max", $('#slider_user_max').val());
       
    }
    		*/
	</script>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  <div id="clientsDropDown" class="col-md-12 col-sm-12 col-xs-12 search-main-right">
  <div id="clientsDashboard">
    <div id="clientsCTA" style="bottom:0px;"></div>
  </div>
  
</div>
<input type="hidden" value="" id="hidden_room_id">
<button id="lang"><img src="<?php echo base_url() ?>images/globe-icon.png" />&nbsp;&nbsp;&nbsp;Language and Currency</button>

<div class="modal_save_to_wishlist" style="display: none;">
</div>
<input type="hidden" name="location" id="slocation" value="" />
              <input type="hidden" name="startdate" id="sstartdate" value="" />
              <input type="hidden" name="enddate" id="senddate" value="" />
              <input type="hidden" name="participants" id="sparticipants" value="" />
              <input type="hidden" name="instantbooking" id="sinstantbooking" value="" />
              <input type="hidden" name="minprice" id="sminprice" value="" />
              <input type="hidden" name="maxprice" id="smaxprice" value="" />
              <input type="hidden" name="activitytype" id="sactivitytype" value="" />
              <input type="hidden" name="objectivestype" id="sobjectivestype" value="" />
              <input type="hidden" name="keywords" id="skeywords" value="" />
              
<!--<div  class="loader" style="display: none;"><span>dropinn</span></div>
<style>
	#list_view_loading {
/*border: 16px solid #f3f3f3;
border-radius: 100%;
border-top: 16px solid #ccc;
border-right: 16px solid #c8c6;
border-left: 16px solid #c8c6;
border-bottom: 16px solid #ccc;
width: 100px;
height: 100px;
-webkit-animation: spin 2s linear infinite;
animation: spin 2s linear infinite;
box-shadow: 1px 1px 17px 7px #888888;
background: #a11f1a;*/
animation: 2s linear 0s normal none infinite running spin;
    background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
    border: 11px inset #e3dbd8;
    border-radius: 100%;
    box-shadow: 0 0 0 7px rgba(0, 0, 0, 0.5);
    height: 90px;
    width: 90px;
}
#list_view_loading > span {
   color: rgba(255, 255, 255, 0.47);
    font-size: 17px;
    font-weight: bolder;
    left: 10px;
    padding: 0;
    position: absolute;
    text-align: center;
    text-transform: capitalize;
    top: 38%
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>-->
<?php 
			
			// $room_id = $this->db->where('review !=', 0)->get('list');
			// foreach ($room_id -> result() as $valroom_id) {
// 				
				// $valroom_id = $valroom_id->id; 
				// $overall = review_star_rating($valroom_id);
				// echo "<pre>";
				// print_r($valroom_id."/".$overall);
			// }			

?>