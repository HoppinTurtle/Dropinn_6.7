<link rel="stylesheet" href="<?php echo  css_url();?>/dashboard.css" type="text/css">
<script>
jQuery.noConflict();
jQuery(document).ready(function(){  
    jQuery(".closeLink").click(function () {
        jQuery.fancybox.close();
    });
});
</script>
<div id="View_Checkin" class="Box">
	<a id="fancybox-close" class="closeLink" style="display: inline;"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
<div class="Box_Head1">
<h2 class="chck_head_box"> <?php echo translate("Are you sure You want to Check-In?"); ?> </h2>
</div>
<div class="Box_Content">
<form id="checkin" name="checkin-trips" action="<?php echo site_url('travelling/checkin'); ?>" method="post">
<p style="display: none;"> <?php echo translate("Are you sure to Check-In?"); ?> </p>
<p> 
<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" >

<button name="checkin" type="submit" class="btn_dash"><span><span><?php echo translate("Check-In"); ?></span></span></button>
<!--<button name="checkin" id="button1" type="submit" class="button1"><span><span><?php echo translate("Checkin"); ?></span></span></button>-->

</p>
</form>
</div>
</div>
<script>
/*$("#button1").click(function(){
       // alert('success');
        var count = 0;
        count++;
     //   alert(count);
        if(count>1)
      	
          $('#button1').prop('disabled', true);
});*/                                                
    
 /*$('#checkin').on('submit', function () {
    $('#button1').prop('disabled', true);
});*/

 var count = 0; 
$("#button1").click(function(){

     count++;
  
     if(count>1)
         $('#button1').prop('disabled', true);
});


	
</script>
<style>
	#fancybox-wrap #checkin:hover {
    border: medium none!important;
}
#fancybox-overlay{
	height: 1783px !important;
	background: rgba(0, 0, 0, 0.7) !important;
	opacity: 1!important;
}
#View_Checkin {
    margin: 0;
    padding: 10px 30px;
    text-align: center;
}
#View_Checkin h2{
    margin:1px 0!important;
    padding: 6px 0;
}	
#fancybox-outer{
	background: none!important;
}#fancybox-close {
    cursor: pointer;
    float: right;
    color: rgb(0, 0, 0)!important;
    font-size: 16px;
    position: static !important;
    z-index: 1103;
}#View_Checkin .Box_Head1 {
    margin: 30px 10px 0;
}
.fa.fa-times-circle-o {
    font-size: 19px;
}
#checkin span span {
text-transform: capitalize !important;
}
</style>


