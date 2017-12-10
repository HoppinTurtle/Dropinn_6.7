
<div class="container-fluid top-sp body-color">
	<div class="">
		
		<?php
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
	  ?>
	<div class="col-xs-12 col-md-12 col-sm-12">
  <h1 class="page-header"><?php echo translate_admin('Dashboard'); ?> <span class="page-sub"><?php echo translate_admin('Latest Activity'); ?></span></h1>
 </div>
  <?php
  $ci = & get_instance();
  $ci->load->model('Trips_model');
  $ci->load->model('Users_model');
	$no_user          = $ci->Users_model->get_all()->num_rows();
	$no_list          = $this->db->get('list')->num_rows(); 
	$totalreservation =  $ci->Trips_model->get_reservation()->num_rows(); 
	?>
  
  <!--   <p><img src="<?php echo base_url().'images/chat.gif';?>" height="40" width="45" alt="img" /></p>-->
    <div class="col-xs-12 col-md-12 col-sm-12">
    <div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-green">
      	<div class="panel-body">
      	<?php if(isset($no_user))?><a href="<?php echo admin_url('members'); ?>"> <?php echo $no_user; ?></a>
        <a href="<?php echo admin_url('members'); ?>"><?php echo translate_admin('Members'); ?></a>
      	</div>
      <div class="panel-footer back-footer-green"><?php echo translate_admin('Total Users'); ?></div>
      </div>
       </div>       

	<div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-pink">
		<div class="panel-body">
		<?php if(isset($no_list))?><a href="<?php echo admin_url('lists'); ?>"> <?php echo $no_list; ?></a>
         <a href="<?php echo admin_url('lists'); ?>"> <?php echo translate_admin('Lists'); ?></a>
		</div>
		<div class="panel-footer back-footer-pink">
         <?php echo translate_admin('Total List'); ?>
         </div>
         </div> 
         </div>    
           

	<div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-violet">
		<div class="panel-body">
		<?php if(isset($totalreservation))?> <a href="<?php echo admin_url('payment/finance'); ?>"> <?php echo $totalreservation;  ?></a>
         <a href="<?php echo admin_url('payment/finance'); ?>"><?php echo translate_admin('Reservation'); ?></a>
		</div>
		<div class="panel-footer back-footer-violet">
         <?php echo translate_admin('Total Reservation'); ?>
         </div>
         </div> 
         </div>    
         </div>

		<div class="col-xs-12 col-md-12 col-sm-12">                
       <div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-green">
		<div class="panel-body">
               <?php if(isset($todayuser))
			   ?>
			   <a href="<?php echo admin_url('members?time=today'); ?>"> <?php echo $todayuser;  ?></a>
              </div>
              <div class="panel-footer back-footer-green">
              <?php echo translate_admin('Today Users'); ?></td>
             </div>
            </div>
           </div>

            <div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-pink">
		<div class="panel-body">
              <?php if(isset($today_userlist)) ?>
              			   <a href="<?php echo admin_url('lists?time=today'); ?>"> <?php echo $today_userlist;  ?></a>
           </div>
           <div class="panel-footer back-footer-pink">
              <?php echo translate_admin('Today Lists'); ?>
            </div>
           </div>
           </div>
              
              
              <div class="col-xs-12 col-md-4 col-sm-4">
      <div class="panel text-center bg-color-violet">
		<div class="panel-body">
                <?php if(isset($today_reservation))  ?>
          <a href="<?php echo admin_url('payment/finance?time=today'); ?>"> <?php echo $today_reservation;  ?></a>

               </div>
         <div class="panel-footer back-footer-violet">
                 <?php echo translate_admin('Today Reservation'); ?>
             </div>
            </div>
            </div>
            </div>   
              
<div class="col-xs-12 col-md-12 col-sm-12">       
  <h1 class="page-header"><?php echo translate_admin('Version'); ?></h1>
    <p class="ins-text"><a href="#"><?php echo translate_admin('Installed Version'); ?> - 6.7</a> 
    	<div id="container_pie" style="  position:fixed bottom:0 display:inline-block"></div>
  </ul>
</div>

</div>

</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<script>
	$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#container_pie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Latest Activity - Pie Chart'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
            	
            	  series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            window.open(this.options.href,'_blank');
                        }
                    }
                }
            },
            	
            
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
              credits: {
      enabled: false
  },
            series: [{
                name: 'Users',
                colorByPoint: true,
                data: [{
                    name: 'Total Users',
                    
                    y: <?php
  $ci = & get_instance();
  $ci->load->model('Trips_model');
  $ci->load->model('Users_model');
	$no_user          = $ci->Users_model->get_all()->num_rows();
	echo $no_user;
	?>,
	href :   "<?php echo admin_url('members'); ?>"
	
                }, {
                    name: 'Total List',
                    y: <?php
  $ci = & get_instance();
  $ci->load->model('Trips_model');
  $ci->load->model('Users_model');
	
	$no_list          = $this->db->get('list')->num_rows(); 
	echo $no_list;
	?>,
                    sliced: true,
                    selected: true,
                    href : "<?php echo admin_url('lists'); ?>"
                }, {
                    name: 'Total Reservation',
                    y: <?php
  $ci = & get_instance();
  $ci->load->model('Trips_model');
  $ci->load->model('Users_model');
	
	$totalreservation =  $ci->Trips_model->get_reservation()->num_rows(); 
	echo $totalreservation;
	?>,
	href : "<?php echo admin_url('payment/finance'); ?>"
                }, {
                    name: 'Today Users',
                    y: <?php echo $todayuser;?>


                }, {
                    name: 'Today Lists',
                    y: <?php echo $today_userlist;?>
                }, {
                    name: 'Today Reservation',
                    y:  <?php echo $today_reservation;?>
                }]
                
            }] 
        }); 
    });
});
</script>
<style>
	.message{
		margin-top:10px;
	}
	hr{
		margin:0px !important;
	}
</style>
