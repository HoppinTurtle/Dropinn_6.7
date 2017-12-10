<script src="<?php echo base_url(); ?>js/swfobject.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jwplayer.js" type="text/javascript"></script>
<div class="container container_bg_non" id="View_HowIt" style="padding:0!important;">
<div class="How_It_VideoBg col-md-12 col-xs-12 col-sm-12">
	<!--<?php if($display_type == 0) { ?>
    <div id="mediaplayer"><?php echo translate("JW Player goes here") ; ?></div>
    <?php } else { 
    echo html_entity_decode($embed_code);
    } ?>-->
    <style>
	.How_It_VideoBg.col-md-12 > a {
    width: 100% !important;
}
#mediaplayer_jwplayer_display_iconBackground{left:45% !important;}
/*@media (min-width:300px) and (max-width:767px){
	.verify-dash{float: none !important; padding:10px 20px !important; margin-top:15px !important;}}*/
</style>
    <?php if($display_type == 0) { ?>
    <div id="mediaplayer"><?php echo translate("JW Player goes here") ; ?></div> 
    <?php } else { 
    echo $embed_code;
    } ?>
</div>
<div id="How_It_Blk" class="clearfix col-md-10 col-md-offset-1 col-sm-12">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="How_It1 how_over">
    	<h2><?php echo translate("Find a place"); ?></h2>
        <div class="Howit_Img"><img src="<?php echo css_url(); ?>/images/find_places.png" /></div>
        <p class="col-md-12 col-sm-12 col-xs-12"><a href="<?php echo site_url('search'); ?>" class="btn_sta finish btn_how col-md-12 col-sm-12"><?php echo translate("Search"); ?></a></p>
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-12">
    	<div class="How_It2 how_over">
    	<h2><?php echo translate("Add your Place"); ?></h2>
        <div class="Howit_Img"><img src="<?php echo css_url(); ?>/images/add_place.png" /></div>
        <p class="col-md-12 col-sm-12 col-xs-12"><a href="<?php echo site_url('rooms/new'); ?>" class="btn_sta finish btn_how col-md-12 col-sm-12"><?php echo translate("List Your Space"); ?></a></p>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
    	<div class="How_It3 how_over">
    	<h2><?php echo translate("Why Host"); ?></h2>
        <div class="Howit_Img"><img class="why" src="<?php echo css_url(); ?>/images/why_hosts.png" /></div>
        <p class="col-md-12 col-sm-12 col-xs-12"><a href="<?php echo site_url('pages/view').'/why_host'; ?>" class="btn_sta finish btn_how col-md-12 col-sm-12"><?php echo translate("Learn More_how"); ?></a></p>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
jwplayer("mediaplayer").setup({
flashplayer: "<?php echo site_url('Cloud_data/uploads/howit/player.swf'); ?>",
file: "<?php echo base_url(); ?>uploads/howit/<?php echo $media; ?>",
height:429,
width:885
});
</script>
