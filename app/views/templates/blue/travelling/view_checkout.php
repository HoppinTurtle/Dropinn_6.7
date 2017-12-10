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
<h2 class="chck_head_box"> <?php echo translate("Are you sure You want to Check-Out?"); ?> </h2>
</div>
<div class="Box_Content">
<form id="checkin" name="checkin-trips" action="<?php echo site_url('travelling/checkout'); ?>" method="post">
<p style="display: none;"> <?php echo translate("Are you sure to Check-Out?"); ?> </p>
<p> 
<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" >
<button name="checkout" type="submit" class="btn_dash"><span><span><?php echo translate("Check-Out"); ?></span></span></button>
</p>
</form>
</div>
</div>
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
}
#fancybox-close {
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