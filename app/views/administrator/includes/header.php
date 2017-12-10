<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transition
al//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=10">
<meta name="title" content="<?php if(isset($title)) echo $title; else echo ""; ?>" />
<meta name="keywords" content="<?php if(isset($meta_keyword)) echo $meta_keyword; else echo ""; ?>" />
<meta name="description" content="<?php if(isset($meta_description)) echo $meta_description; else echo ""; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="google-translate-customization" content="376d9d52f1776ee3-46f58b508c85587c-ged0a34236ce0763e-1e"></meta>

	<!-- Latest compiled and minified CSS 

<!-- Latest compiled and minified JavaScript -->
<!-- favicon image 1 start -->
<?php 
	        $query  = $this->db->get_where('settings', array('code' => 'FAVICON_IMAGE'));
			$favicon  		 = base_url().'logo/'.$query->row()->string_value; ?>
			
<link rel="icon" href="<?php echo $favicon ?>" type="image">

<!-- favicon image 1 end -->

<title><?php echo translate_admin("DropInn Admin Section"); ?></title>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>Cloud_data/js/bootstrap-admin.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>Cloud_data/js/bootstrap-admin.min.js"></script>
-->

<script type="text/javascript" src="<?php echo base_url() ?>js/common.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/webtoolkit.aim.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/script.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>Cloud_data/js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery_lib.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery_lib.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/affix.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/alert.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/button.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/carousel.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/dropdown.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/popover.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/scrollspy.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tab.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/transition.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url() ?>Cloud_data/js/datetimepicker.js"></script>
<script type="text/javascript" src="http://jqueryui.com/ui/i18n/jquery.ui.datepicker-fr.js">-->
<script type="text/javascript" src="<?php echo base_url() ?>js/countries-2.0-min.js"></script>

 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>



<link rel="stylesheet" type="text/css" href="<?php echo cdn_url_raw();?>css/templates/blue/admin.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href="<?php echo cdn_url_raw(); ?>uploads/font/font.css" media="screen" rel='stylesheet' type='text/css'>
</head>
<style>
	html * :not(i)
{
     font-family: 'CircularStd-Book',"Helvetica Neue",Helvetica,Arial,sans-serif !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
     
}
.navbar{
	margin-bottom: 0px !important;
}
#sort_list
{
	
	border-bottom: 0px solid;
	
}
table.dataTable thead th{
	border-bottom:0;
	
	
}

      .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: white !important;
        border: 0px solid black;
        background-color: #002e42;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #0092d1), color-stop(100%, #002e42));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #002e42 0%, #002e42 100%);
        /* Chrome10+,Safari5.1+ */
        background: -moz-linear-gradient(top, #002e42 0%, #002e42 100%);
        /* FF3.6+ */
        background: -ms-linear-gradient(top, #002e42 0%, #002e42 100%);
        /* IE10+ */
        background: -o-linear-gradient(top, #002e42 0%, #002e42 100%);
        /* Opera 11.10+ */
        background: linear-gradient(to bottom, #002e42 0%, #002e42 100%);
        /* W3C */ }
      
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 0px solid #374773;
        background-color: #2F9CF4;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7a8cbf), color-stop(100%, #374773));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #2F9CF4 0%, #2F9CF4 100%);
        /* Chrome10+,Safari5.1+ */
        background: -moz-linear-gradient(top, #2F9CF4 0%, #2F9CF4 100%);
        /* FF3.6+ */
        background: -ms-linear-gradient(top, #2F9CF4 0%, #2F9CF4 100%);
        /* IE10+ */
        background: -o-linear-gradient(top, #2F9CF4 0%, #2F9CF4 100%);
        /* Opera 11.10+ */
        background: linear-gradient(to bottom, #2F9CF4 0%, #2F9CF4 100%);
        /* W3C */ }
    
</style>
<script>
$(document).ready(function()
{

	$("#sort_list").DataTable({
			         	
    "bPaginate": true,
    "order":[]
    
    
   
    });
 });
</script>
<body>
<!--LAYOUT-->
<!--HEADER-->
<?php
if($this->uri->segment(2) == 'login')
{
if($this->dx_auth->get_user_id() == 1)
{
	//redirect_admin('');
}
}
?>
<header id="top" class="navbar navbar-static-top bs-docs-nav head-bg" role="banner">
	<div class="container-fluid">
		<div class="navbar-header">
		<button class="navbar-toggle collapsed" data-target=".bs-navbar-collapse" data-toggle="collapse" type="button">
			<span class="sr-only">Toggle Navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		 <?php 
					$logo         = $this->db->get_where('settings',array('code' => 'SITE_LOGO'))->row()->string_value; 
					$query        = $this->Common_model->getTableData('settings', array('code' => 'BACKEND_LANGUAGE'))->row();
					?>
					
		<a class="logo" href="<?php echo admin_url('backend');?>"><img width="137" height="45" src="<?php echo base_url().'logo/'.$logo; ?>" title="<?php echo $this->dx_auth->get_site_title(); ?>"/></a>
	<!--	<h1><a class="logo" href="<?php echo admin_url('backend');?>">DropInn</a></h1>-->		
		</div>
		
		
			 
	   
		<nav class="navbar-collapse bs-navbar-collapse collapse" role="navigation" style="height:1px;">
			 <ul class="nav navbar-nav navbar-right">
			 <li class="timer" id="show_date_time">
				<?php if($query->int_value == 2) { ?>		 	
			 </li>
			 <?php } ?>
			 <li>
				<a style="text-align: center;" href="<?php echo site_url('administrator'); ?>"><?php echo translate_admin("Admin Home"); ?></a> 	
			 </li>	
			 <li>
				<a style="text-align: center;" href="<?php echo base_url();?>"><?php echo translate_admin("Site Home"); ?></a> 	
			 </li>
			<?php if($this->dx_auth->is_admin()) { ?> 
			<li><a style="text-align: center;" href="<?php echo site_url('users/logout');?>"> <?php  echo translate_admin("Logout"); ?> </a></li> 
			<?php  } ?>
			</ul>
			</nav>
	  </div>
   </header>
   
<!--END OF HEADER-->