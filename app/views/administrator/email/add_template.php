<div id="Add_Email_Template">
<div class="container-fluid top-sp body-color">
	<div class="">
	<div class="col-xs-12 col-md-12 col-sm-12">
				<h1 class="page-header1"><?php echo translate_admin("Add E-mail Template"); ?></h1>
				</div> 	
				  
<form method="post" action="<?php echo admin_url('email/addemailTemplate')?>">					
<div class="col-xs-12 col-md-12 col-sm-12">
<table class="table" cellpadding="2" cellspacing="0">
		
<tr>
		<td><?php echo translate_admin('Email code'); ?><span style="color: #e4285b;">*</span></td>
		<td>
						<input type="text" size="55" name="email_type" value="<?php echo set_value('email_type'); ?>"/>
						<p><?php echo form_error('email_type'); ?></p>
		</td>
</tr>
<tr>
  <td><?php echo translate_admin('Email Title'); ?><span style="color: #e4285b;">*</span></td>
		<td>
				<input type="text" size="55" name="email_title" value="<?php echo set_value('email_title'); ?>"/>
				<p><?php echo form_error('email_title'); ?></p>
	 </td>
</tr>

<tr>
  <td><?php echo translate_admin('Email Subject'); ?><span style="color: #e4285b;">*</span></td>
		<td>
				<input size="55" type="text" name="email_subject" value="<?php echo set_value('email_subject'); ?>"/>
				<p><?php echo form_error('email_subject'); ?></p>
		</td>
</tr>

<tr>
   <td><?php echo translate_admin("Plain Text Body"); ?><span style="color: #e4285b;">*</span></td>
			<td>
				<textarea style="width:400px; height:150px" rows="10" cols="60" class="mceNoEditor" name="email_body_text"><?php echo set_value('email_body_text'); ?></textarea>
				<p><?php echo form_error('email_body_text'); ?></p>
			 </td>
</tr>

<tr>
   <td><?php echo translate_admin("Html Body"); ?><span style="color: #e4285b;">*</span></td>
			<td>
				<textarea class="" name="email_body_html"><?php echo set_value('email_body_html'); ?></textarea>
				<span style="position: relative; left: 455px; top: -15px;"><?php echo form_error('email_body_html'); ?></span>
			 </td>
</tr>

<tr>
	<td colspan="2" style="text-align: center;">
	<input value="<?php echo translate_admin('Submit'); ?>" name="addemailTemplate" type="submit">
	</td>
</tr>
		
</table>
</form>	

</div>
	

<!-- TinyMCE inclusion -->
<script type="text/javascript" src="<?php echo base_url()?>Cloud_data/css/tiny_mce/tiny_mce.js" ></script>

<script language="Javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
								editor_deselector : "mceNoEditor",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
style_formats: [
    {title: 'Bold text', inline: 'b'},
    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
    {title: 'Example 1', inline: 'span', classes: 'example1'},
    {title: 'Example 2', inline: 'span', classes: 'example2'},
    {title: 'Table styles'},
    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
  ],
        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
});

</script > 
<!-- End of inclusion of files -->