<script language="Javascript" type="text/javascript" src="<?php echo base_url().'js/jquery-ui.min.js';?>"></script>

  <style>
  .list_btn
  {
  	background-color: hsl(198, 100%, 13%);
    border-color: hsl(198, 100%, 13%);
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: hsl(0, 0%, 100%);
    cursor: pointer;
    float: left;
    font-weight: bold;
    margin: 0 0 0 5px;
    padding: 5px 10px;
  }
ul.ui-widget-content
{
background: #e8e8e8 none repeat scroll 0 0;
width: 265px !important;
text-align:left;
z-index:1003;
max-height: 150px;
overflow-x:hidden;
overflow: auto;
}
li.ui-menu-item {
	text-transform:capitalize;
	/*border-bottom:1px solid #fff;*/
	font-size: 14px;
	line-height:0px;
	text-indent: 2px;
	cursor: pointer;
	padding:3px 0px;
		
}
li.ui-menu-item:hover
{
	background-color:#f09fc5;
}
li.ui-menu-item a  >span{
	margin-left:10px;
	font-weight: bold;
}
li.ui-menu-item:hover a  >span{
color:#FFFFFF;
}
li.ui-menu-item a{
text-decoration: none !important;
cursor: pointer;	
}
</style>
<style>

	.black_overlay{
	display: none;
	position: fixed;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;

	background-color: black;
	z-index:1001;
	-moz-opacity: 0.7;
	opacity:.80;
	filter: alpha(opacity=80);
}

.white_content {
	display: none;
	position: absolute;
	top: 25%;
	  left: 10%;
  width: 70%;
	border-radius:10px;
	min-height:250px;
	padding: 16px;
	background-color: white;
	z-index:1002;
	overflow: visible;
}
.pop_but_list_new
{
	 background-color: #E1117D;
    background-image: -moz-linear-gradient(center top, #F52691 0, #E1117D 100%);
    border-color: #EA1282 #CB1272 #BB0E68;
    border-image: none;
    border-style: solid;
    border-width: 1px;
    cursor: pointer;
    color: #fff;
    padding:5px;
    font-weight: 700;
    border-radius: 5px
}
.form_admin_list input
{
	margin-right:8px;
}
.close_admin > img
{
	  width: 35px;
  height: 35px;
  margin-right: -30px;
  margin-top: -94px;
  float: right;
}
.form_admin_list h3
{
	padding:13px 0 11px;
	text-transform:capitalize;
	font-size:16px;
	  font-weight: 700;
}
.down_link
{
	padding:3px 0px 0px;
	font-size:15px;
	line-height:20px;
	color:#e33085;
	width:200px;
	float:left;
	font-weight:bold;
}
.white_content h2
{
	font-size: 18px;
	padding-bottom:11px;

	capitalize:capitalize;
	border-bottom:2px solid #BDBDBD;
}
.down_admin h3{
	padding:13px 0 11px;
 font-size:16px;

}
div.container {
        width: 80%;
    }
</style>
<style>
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
	.res_table td:nth-of-type(1):before { content: "List Id"; }
	.res_table td:nth-of-type(2):before { content: "User Name" ; }
	.res_table td:nth-of-type(3):before { content: "Address"; }
	.res_table td:nth-of-type(4):before { content: "Title"; }
	.res_table td:nth-of-type(5):before { content: "Status"; }
	.res_table td:nth-of-type(6):before { content: "Capacity"; }
	.res_table td:nth-of-type(7):before { content: "Price"; }
	.res_table td:nth-of-type(8):before { content: "Featured"; }
	.res_table td:nth-of-type(9):before { content: "Action"; }
}  
</style>


<script>
$(document).ready(function(){
					$("#fade").delay(800).fadeOut('slow');

          		});
</script> 

<?php //echo form_open('administrator/lists/managelist'); ?>

<?php  				
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
		
		// Show error
		echo validation_errors();
		
				$tmpl = array (
                    'table_open'          => '<div class="col-md-12 col-sm-12 col-xs-12"><table  class="table1 res_table" id="sort_list" border="0" cellpadding="4" cellspacing="0">',
                    
					 'thead_open'            => '<thead>',
     			   'thead_close'           => '</thead>',
     			   
                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',
                  
				  'tbody_open'            => '<tbody>',
       			 'tbody_close'           => '</tbody>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

		$this->table->set_template($tmpl); 

		$this->table->set_heading(translate_admin('LIST_ID'), translate_admin('USER NAME'), translate_admin('ADDRESS'), translate_admin('TITLE'), translate_admin('STATUS'), translate_admin('CAPACITY'), translate_admin('PRICE'),translate_admin('Create Date'),  translate_admin('Featured'),translate_admin('ACTION'));
		$num_rows1 = 0;
		foreach ($users as $user) 
		{
		if(isset($user->user_id))
		{
				$query = $this->Users_model->get_user_by_id($user->user_id);
				$username = $this->db->where('id',$user->user_id)->get('users');
				if($username->num_rows()!=0)
				{
					$num_rows1 = 1;
					$username = $username->row()->username;
				}
				else {
					$username = 'No Data';
				}
				$lys_status = $this->db->where('id',$user->id)->get('lys_status');
				
				foreach($lys_status->result() as $row)
				{
				$total_status = $row->address+$row->overview+$row->price+$row->photo+$row->calendar+$row->listing;
				$total_status = 6 - $total_status;
				}
				
				if($total_status == 0)
				{
					$total_status = 'Listed';
				}
				else {
					if($total_status != 1) $s = 's'; else $s='';
					$total_status = 'Pending ('.$total_status.' Step'.$s.')';
				}
									// Get user record
					if($query)
					{
				      
					    $user_name = $query->row()->username;
					    $this->table->add_row(
						form_checkbox('check[]', $user->id).' '.
						$user->id, 
						$username, 
						character_limiter($user->address, 20), 			
						character_limiter($user->title, 20),
						$total_status,
						$user->capacity, 
						$user->price,
						date("d M Y",$user->created),
						$user->is_featured==1?"Yes":"No",
						'<a href="'.admin_url("lists/managelist/?id=".$user->id).'"><img src="'.base_url().'images/edit-new.png" alt="Edit" title="Edit" /></a>
						<a href="'.admin_url("lists/managelist/delete/?id=".$user->id).'" onClick="return confirm(Are you sure want to delete??);"><img src="'.base_url().'images/Delete.png" alt="Delete" title="Delete" /></a>');
			       }
			}
		}
		
		//echo form_open($this->uri->uri_string());
			echo '<div class="container-fluid top-sp body-color"><div class=""><div class="col-xs-12 col-md-12 col-sm-12"><h1 class="page-header2">'.translate_admin('User Listing Management').'</h1></div>';
		echo '<div class="col-xs-12 col-md-12 col-sm-12">';
		
		echo '<span2a>';
		echo form_open('administrator/lists/addlist');
		echo form_submit('add', translate_admin('Add List'));
		echo form_close();
		echo '</span2a><span2>';
		echo form_open('administrator/lists/managelist');
		echo form_submit('delete', translate_admin('Delete List'));
		echo '</span2><span2>';
		echo form_submit('featured', translate_admin('Featured List'),'class=feat_list');
		echo '</span2><span2>';
		echo form_submit('unfeatured', translate_admin('Unfeatured List'),'class=reset_pass');
		?>
	
		<?php echo $this->table->generate(); 

		echo form_close();

			
	?>
	<a class="list_btn" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Import</a>
	 <br>
    <div id="light" class="white_content"><h2>Import the lists from external file - XLSX</h2>
    <a class="close_admin" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="<?php echo base_url(); ?>images/fancy_close.png" alt="close" width="30" height="30" /></a>
	<div>
	<div class="form_admin_list">
	<h3>Select user</h3>	
	<div>
	<input type="text" autocomplete="off" name="user_list" id="user_list" placeholder="Enter a username or email address" style="width: 268px !important;"  />
	<span id="error_msg" style="color: red;"></span>
	</div>
	<h3>Select a file type to import</h3>
	<div>
	<form>
	<!--<input type="radio" value ="tsv" name ="import" />TSV -->
	<input type="radio" value ="xls" name ="import" />XLSX	
	</form>
	</div>
	</div>
	<div class="down_admin" >
		<h3>Download Sample file</h3>
		<p>
		<!--<p><a class="down_link" href="<?php echo base_url()."administrator/lists/sample_download/sample.tsv";?>" >Sample.tsv</a></p>
		<p><a class="down_link" href="<?php echo base_url()."administrator/lists/generate_Excel/xls";?>" >Sample.xls</a></p>-->
		<p><a class="down_link" href="<?php echo base_url()."administrator/lists/generate_Excel/xlsx";?>" >Sample.xlsx</a></p>
		</p>
	  </div>
	  </div>
	  <div  style="float:left;">
	  <form id="tsv" style="display:none;" method="post" action="<?php echo base_url() ?>administrator/lists/import_tsv" enctype="multipart/form-data">
                    <input type="file" name="userfile"  style="width:220px;" ><br>
                    <input type="hidden" name="user_id_list_1" id="user_id_list_1" value="" />
                    <input type="submit" name="submit" value="Import TSV file" class="btn btn-primary">
               </form>
      <form id="xls" style="display:none;" method="post" action="<?php echo base_url() ?>administrator/lists/import_xls" enctype="multipart/form-data">
                    <input type="file" name="userfile"  style="width:220px;" ><br>
                    <input type="hidden" name="user_id_list_2" id="user_id_list_2" value="" />
                    <input type="submit" name="submit" value="Import XLSX file" class="btn btn-primary">
      </form>
      </div>
      </div>
      <div id="fade" class="black_overlay"></div>     
<script>

$(document).ready(function(){
jQuery(".ui-helper-hidden-accessible").remove();
	$("input[type='radio']").change(function(){
		$("#tsv,#xls").hide();
		$("#"+$(this).val()).show();
	});
	 $(".black_overlay").click(function(){
  	$("#light").hide();
  	$("#fade").hide();


  });
    	
  	$("#tsv,#xls").submit(function()
  	{
  	$txt_user = $('#user_list').val();	
  	$suges_user_1 =  $("#user_id_list_1").val();
  	$suges_user_2 =  $("#user_id_list_2").val();
  	if($txt_user == "" || $suges_user_1 == "" || $suges_user_2 == "")
  	{
  		jQuery("#error_msg").html('You should need to select a username to import');
  		return false;
  	}else{
  			jQuery("#error_msg").html('');
  		return true;
  	}	
  	});
              jQuery('#user_list').autocomplete({
                source:  function (request, response) { 
                	$(".ui-widget-content").html('Loading...');
                	$(".ui-widget-content").show();
                	//alert('dfdfd');return false;
			 	jQuery.ajax({ 
			 		url: "<?php echo base_url(); ?>users/get_userlist", 
			 		dataType: "json", 
			 		type: 'post',		
			 		data: { user_name_or_email : jQuery("#user_list").val()}, 
			 		success: function (data) {
			 			if(data == "")
			 			{
			 			$(".ui-widget-content").hide();
			 			}else{
			 			response(data);	
			 			}
			 			} 
			 		});			
				},
                scroll: true,
                minLength: 1,
      select: function( event, ui ) {
        $( "#user_list" ).val(ui.item.user_name);
        $("#user_id_list_1").val(ui.item.user_id);
         $("#user_id_list_2").val(ui.item.user_id);
        return false;
      }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a><img src='" + item.user_image + "' width='50' height='50' /><span>" + item.user_name + "</span></a>" )
        .appendTo( ul );
    };
            
            jQuery('#user_list').focusout(function()
            {
            	$id_user_1 = $("#user_id_list_1").val();
            	$id_user_2 = $("#user_id_list_2").val();
            	$id_user_ = $("#user_list").val();
            	if($id_user_ == "")
            	{
            		$("#user_id_list_1").val('');
            		$("#user_id_list_2").val('');
            	}
            	if($id_user_1 == "" || $id_user_ == "" || $id_user_2 == "")
            	{
            		jQuery("#error_msg").html('You should need to select a username to import');
            	}else{
					jQuery("#error_msg").html('');
            	}
			
			 			
            });
});

</script>