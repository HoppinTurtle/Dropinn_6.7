<style>
.st-only {
    border: 0 none;
    clip: rect(0px, 0px, 0px, 0px);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    width: 100%;
}
.drpdwnlist .navbar-toggle{
	background-image: none;
    border: medium none;
    border-radius: 0;
    float: none;
    margin-bottom: 0;
    margin-right: 0;
    margin-top: 0;
    padding: 0;
    position: relative;}
    
	body{
		background:#f5f5f5;
	}
.drpdwnlist button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
}
.dropdown_div .navbar-collapse {
    border-top: medium none;
    box-shadow: none;
    }	
  #click_msg{
  	font-size:16px;
  	color:#FFFFFF;
  }
  .mainhead{
  	color: #BBBBBB;;
  }
  ul.subnav li a {
    color: rgb(118, 118, 118);
    display: inline-block;
    line-height: normal;
}ul.subnav li a {
    display: inline-block;
    line-height: normal;
}ul.subnav li.active a {
    color: rgb(57, 60, 61);
}ul.subnav li{
	display: block;  
	font-size:14px;
	line-height:35px;
}
</style>

<div id="dashboard_page" class="">

<div class="main_dash_hdr clearfix">
	<div class="container">
<script>

$(document).ready(function(){


var tempi = $('.Search_Active').html();
	//$('.st-only').html(tempi);


$('#dropdown_msg').hide();
 $("#click_msg").click(function(){
    $("#dropdown_msg").slideToggle("fast");
  });

$('#dropdown_msg li').click(function() {
   msgtype = $(this).text();
   $('#dropdown_msg').hide();
   //window.location.href='<?php echo base_url();?>listings/sort_by_status?f='+(this.id);
   $("#click_msg").text(msgtype);
});
});



	$(document).ready(function(){
//	$(".subnav").css("display","none");
		$(".subnav1").css("display","none");
		//$(".mainhead ").click(function(){
			//$(this).next('ul').css("display","block");
		//})
	 //For referral tab	 
/*
	 $(".reference_link").click(function() {
	 	$(".reference_link")addclass("Search_Active");
        $(".subnav1").show();
       }
*/

	 reference = $('#reference a');
		  if(reference.hasClass('Search_Active')){
			  $(reference).next('ul').css("display","block");
		  }
	 
	  //For your listings tabs
	 yourlistings = $('#yourlistings a');
	 if(yourlistings.hasClass('Search_Active')){
	 	$(yourlistings).next('ul').css("display","block");
	 }
	 //For travelling tabs
	 travelling = $('#travelling a');
	 if(travelling.hasClass('Search_Active')){
	 	$(travelling).next('ul').css("display","block");
	 }
	 //For account tabs
	 account = $('#account a');
	 if(account.hasClass('Search_Active')){
	 	$(account).next('ul').css("display","block");
	 }
	 //For profile tabs
	 profile = $('#profile a');
	 if(profile.hasClass('Search_Active')){
	 	$(profile).next('.pofsub').css("display","block");
	 }
	})
</script>


<div class="dropdown_whole visible-xs">
<div class="dropdown_div">
<div class="navdash-wrapper">
<div class="navbar-header">
<h5 id="click_msg" class="drpdwnlist">
	<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bt-navbar-collapse">
	<span class="st-only"></span>	
	<div style="display:inline-block;">
	<?php 
	if($this->uri->segment(2) == 'dashboard'){ echo translate("Dashboard"); }
	else if($this->uri->segment(1) == 'message'  && $this->uri->segment(2) == 'inbox') { echo translate("Inbox"); }
	else if($this->uri->segment(1) == 'listings' || $this->uri->segment(2) == 'myReservation' || $this->uri->segment(2) == 'policies' || $this->uri->segment(1) == 'statistics') { echo translate("Your Listings"); }
	else if($this->uri->segment(1) == 'travelling') { echo translate("Your Trips"); }
	else if($this->uri->segment(1) == 'account' || $this->uri->segment(1) == 'referrals') { echo translate("Account"); }
	else echo translate("Profile");
	?></div><div style="display:inline-block;text-align:right;padding: 0px 0px 0px 5px;"><span><i class="fa fa-sort-desc" aria-hidden="true"></i></span></div>
	</h6>
	</button>
	</div>
<nav class="collapse navbar-collapse bt-navbar-collapse padding-zero" role="navigation">
<ul id="dropdown_msg" class="drpdwnlist_li">
<li><a href="<?php echo base_url().'home/dashboard/'; ?>" class=" mainhead"><?php echo translate("Dashboard"); ?></a></li>
<li><a href="<?php echo base_url().'message/inbox'; ?>" class=" mainhead"><?php echo translate("Inbox"); ?></a></li>
<li><a href="<?php echo base_url().'listings'; ?>" class=" mainhead"><?php echo translate("Your Listings"); ?></a></li>
<li><a href="<?php echo base_url().'travelling/your_trips'; ?>" class="mainhead"><?php echo translate("Your Trips"); ?></a></li>
<li><a href="<?php echo base_url().'account'; ?>" class="mainhead"><?php echo translate("Account"); ?></a></li>
<li><a href="<?php echo site_url('users/edit'); ?>" class="mainhead"><?php echo translate("Profile"); ?></a></li>
</ul>
</nav>
</div>
</div>
</div>   	

<div class="container dashboard_page" id="">
<ul id="nav" class="col-md-12 col-sm-12 col-xs-12 hidden-xs" style="padding: 0px;">
	<li id="dashboard" class="">
	<?php
	 if($this->uri->segment(2) == 'dashboard')
	 echo anchor('home/dashboard/',translate("Dashboard"),array("class" => "mainhead Search_Active med_12 pe_12 mal_12")); 
		else
		echo anchor('home/dashboard/',translate("Dashboard"),array("class" => "mainhead med_12 pe_12 mal_12")); 
		?>
	</li>
	
		<li id="rooms" class="">
	<?php
	 if($this->uri->segment(1) == 'message'  && $this->uri->segment(2) == 'inbox')
	 echo anchor('message/inbox',translate("Inbox"),array("class" => "mainhead Search_Active med_12 pe_12 mal_12")); 
		else
		echo anchor('message/inbox',translate("Inbox"),array("class" => "mainhead med_12 pe_12 mal_12")); 
		?>
	</li>
	
	<li id="yourlistings" class="">
	<?php
	 if($this->uri->segment(1) == 'listings' || $this->uri->segment(2) == 'myReservation' || $this->uri->segment(2) == 'policies' || $this->uri->segment(1) == 'statistics') {?>
	 <a href="<?php echo base_url().'listings'; ?>" class="Search_Active mainhead"><?php echo translate("Your Listings"); ?></a> 
		<?php }else { ?>
		<a href="<?php echo base_url().'listings'; ?>" class=" mainhead"><?php echo translate("Your Listings"); ?></a> 
		<?php }?>
	</li>
	
	<li id="travelling" class=" mainhead">
	<?php
	 if($this->uri->segment(1) == 'travelling') { ?>
	 	<a href="<?php echo base_url().'travelling/your_trips'; ?>" class="mainhead Search_Active"><?php echo translate("Your Trips"); ?></a>
	 <?php } else {?>
		<a href="<?php echo base_url().'travelling/your_trips'; ?>" class="mainhead"><?php echo translate("Your Trips"); ?></a>
		 <?php } ?>
		 
	</li>
	
 <li id="account" class=" mainhead">
	<?php
	 if($this->uri->segment(1) == 'account' || $this->uri->segment(1) == 'referrals') { ?>
	 	<a href="<?php echo base_url().'account'; ?>" class="mainhead Search_Active"><?php echo translate("Account"); ?></a>
	 <?php	} else { ?>
	 	<a href="<?php echo base_url().'account'; ?>" class="mainhead"><?php echo translate("Account"); ?></a>
	 	<?php } ?>
				
	</li>
	
 <li id="profile" class="clsBg_None  mainhead">
	<?php
	 if($this->uri->segment(1) == 'users') {?>
	 <a href="<?php echo site_url('users/edit'); ?>" class="mainhead Search_Active"><?php echo translate("Profile"); ?></a>
	 <?php } else{ ?>
	 	<a href="<?php echo site_url('users/edit'); ?>" class="mainhead"><?php echo translate("Profile"); ?></a>
	 <?php } ?>
	 	
		
	</li>
	
</ul>
</div>



</div>
</div>
<div class="container">