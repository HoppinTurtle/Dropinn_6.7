<!-- Required css stylesheets -->
<!--<link href="<?php echo base_url().'Cloud_data/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />-->

<!-- End of stylesheet inclusion -->

<!-- datatable functions script for search -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/datatable/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/datatable/dataTables.bootstrap.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>js/datatable/jquery.dataTables.js"></script>		
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>js/datatable/dataTables.bootstrap.js"></script>

<script>
	$(document).ready(function(){
    $('#ftable_id').DataTable({
    	
    	 stateSave: true
    });
	});
</script>

<!-- datatable functions script for search -->

   <?php
		 $this->load->view(THEME_FOLDER.'/includes/dash_header'); 
			$this->load->view(THEME_FOLDER.'/includes/hosting_header'); 
			?>


		<style>
		#listings_filter
		{
			padding-bottom: 5px !important;
   			padding-left: 0 !important;
  			padding-right: 20px;
    		padding-top: 7px;
			background-color: #ffffff;
		}
		</style>
<div id="dashboard_container" class="col-sm-10 col-md-9 col-xs-12">
    <div class="Box" id="Mange_Lisiting">
        <div class="Box_Content no_padding clearfix">
            <!-- sort-header dropdown-->
            <div class="msgbg">

              <select class="" id="listings_filter" style="width: auto;">
                <option value="<?php echo base_url();?>listings/sort_by_status?f=all" class=""><?php echo translate("Show all listings "); ?></option>
             	 <option value="<?php echo base_url();?>listings/sort_by_status?f=active" class="" <?php if(!empty($sort)) { if($sort=="active") { echo 'selected'; } }?>><?php echo translate("Show active"); ?></option>
                <option value="<?php echo base_url();?>listings/sort_by_status?f=hide" class="" <?php if(!empty($sort)) { if($sort=="hide") { echo 'selected'; } }?>><?php echo translate("Show hidden"); ?></option>  
              </select>
          <!--</span>-->
            </div>  

<div class="clsFloatLeft">    
</div>	
          
            <!-- sort-header dropdown-->

            <div id="listings-container" class="col-md-12 col-xs-12 col-sm-12">

          <!--  <div id="listings-container">
            <ul class="listings">-->

                <?php 
                
               
	
                if($this->dx_auth->is_logged_in()): ?>
                <?php
                    $id = $this->dx_auth->get_user_id();
                    $query='';
        $query = $this->db->select('list.*,lys_status.calendar as calendar_status,lys_status.overview as overview_status,lys_status.price as price_status,lys_status.photo as photo_status,lys_status.address as address_status,lys_status.listing as listing_status')->join('lys_status',"lys_status.id=list.id")->where("list.user_id",$id)->get('list');
		
		            if(!empty($sort))
                    {
          
                       if($sort=="active")
                        {
                        	//echo 'Result >> Active Listings';		    
                            $this->db->where('is_enable', 1);
                          //  $query = $this->db->distinct()->select('list.*,lys_status.calendar as calendar_status,lys_status.overview as overview_status,lys_status.price as price_status,lys_status.photo as photo_status,lys_status.address as address_status,lys_status.listing as listing_status')->join('lys_status',"lys_status.id=list.id")->where("list.user_id",$id)->get('list',$row_count,$offset);
                    $query = $this->db->distinct()->select('list.*,lys_status.calendar as calendar_status,lys_status.overview as overview_status,lys_status.price as price_status,lys_status.photo as photo_status,lys_status.address as address_status,lys_status.listing as listing_status')->join('lys_status',"lys_status.id=list.id")->where("list.user_id",$id)->where("list.list_pay",1)->where("lys_status.calendar",1)->where("lys_status.price",1)->where("lys_status.overview",1)->where("lys_status.title",1)->where("lys_status.summary",1)->where("lys_status.bedscount",1)->where("lys_status.bedtype",1)->where("lys_status.photo",1)->where("lys_status.amenities",1)->where("lys_status.address",1)->where("lys_status.listing",1)->where("lys_status.beds",1)->where("lys_status.bathrooms",1)->get('list',$row_count,$offset);
                          					
                        } 	
                        
                        if($sort=="hide")
                        {
                        	//echo 'Result >> Hidden Listings';				    
                            $this->db->where('is_enable', 0);
             		       $query = $this->db->distinct()->select('list.*,lys_status.calendar as calendar_status,lys_status.overview as overview_status,lys_status.price as price_status,lys_status.photo as photo_status,lys_status.address as address_status,lys_status.listing as listing_status')->join('lys_status',"lys_status.id=list.id")->where("list.user_id",$id)->where("list.list_pay",1)->where("lys_status.calendar",1)->where("lys_status.price",1)->where("lys_status.overview",1)->where("lys_status.title",1)->where("lys_status.summary",1)->where("lys_status.bedscount",1)->where("lys_status.bedtype",1)->where("lys_status.photo",1)->where("lys_status.amenities",1)->where("lys_status.address",1)->where("lys_status.listing",1)->where("lys_status.beds",1)->where("lys_status.bathrooms",1)->get('list',$row_count,$offset);
                        }	
                    }
                   					 
                   // $query = $this->db->distinct()->select('list.*,lys_status.calendar as calendar_status,lys_status.overview as overview_status,lys_status.price as price_status,lys_status.photo as photo_status,lys_status.address as address_status,lys_status.listing as listing_status')->join('lys_status',"lys_status.id=list.id")->where("list.user_id",$id)->get('list',$row_count,$offset);

                    if( $query->num_rows > 0){
                    	?>
                    	            	<table id="ftable_id" class="display table1 res_table" cellpadding="2" cellspacing="0">
		 								<thead>
											<th><?php echo translate_admin('List Image'); ?></th>
											<th><?php echo translate_admin('LIst Title'); ?></th>
											<th><?php echo translate_admin('List Status'); ?></th>
										</thead>
										<tbody>
                    	<?php
                
                    foreach($query->result() as $row)
                    {
                		
                        $url = getListImage($row->id);
               			if($row->title == ''){
							$title = "No Title";
						}else{
							$title = $row->title;
						}
						if($title == '')
						{
							$title="No Title";
						}
						     
						$noimage ="'".base_url()."images/no_image.jpg"."'";
                        echo '<tr><td class="col-md-3 col-sm-3 col-xs-4"><div class="thumbnail listing_img fullwidthxs">';
                        echo '<a class="image_link" href="'.base_url().'rooms/'.$row->id.'" linkindex="98"><img title="'.$row->title.'" src="'.$url.'" onerror="this.src='.$noimage.'" class="search_thumbnail"></a> </div></td>';
                       echo '<td class="listing-size"><div class="listing-info fullwidthxs"><h3>';
                        echo anchor('rooms/'.$row->id,$title);
                        echo '</h3>';
                        echo '<span class="actions"><span class="action_button">';
						 echo'<i class="fa fa-edit edit_fa"></i>';


                        echo anchor('rooms/lys_next/edit/'.$row->id,translate("Manage Listing & Calendar"),array('class' => 'icon edit'));
						echo '</span>';

						echo '<span class="actions"><span class="action_button">';
						echo'<i class="fa fa-trash-o edit_fa"></i>';
						echo anchor('rooms/deletelisting/'.$row->id,translate("Delete Listing"),array('class' => 'icon delete','onclick'=>'return delete_list();' ));
						
						
						echo '</span><span class="action_button">';
						echo'<i class="fa fa-edit edit_fa"></i>';
                        echo anchor('statistics/view_statistics_graph/'.$row->id,translate("View statistics"),array('class' => 'icon edit'));
																								
                        echo '</span><span class="clearfix"></span></div></td>';

						$total_status = $row->address_status+$row->overview_status+$row->price_status+$row->photo_status+$row->calendar_status+$row->listing_status;
						
               if($row->list_pay == 0) {
			   }
			   else {
					?>
               <td><div class="Chang_To"> <?php echo translate("Change To"); ?> : 
               	<?php }
			    if($row->list_pay == 0) 
			    {
					$final_status = 6-$total_status;
					
					if($final_status != 0)
					{

					echo '<td><a class="btn_dash_green btn_dash_list1" style="float:right" href="'.base_url().'rooms/lys_next/edit/'.$row->id.'">'.$final_status.translate('steps to list').'>></a></td>';
				    }
                   else {
	                echo '<td><a class="btn_dash_green btn_dash_list1" style="float:right" href="'.base_url().'rooms/lys_next/edit/'.$row->id.'">List now</a></td>';

                      }
				}
				elseif($row->is_enable == 0){
				 ?>
                  <a href="<?php echo base_url().'listings/change_status?stat=1&rid='.$row->id; ?>"><?php echo translate("Active"); ?></a>
               <?php }
               else { ?> 
               <a href="<?php echo base_url().'listings/change_status?stat=0&rid='.$row->id; ?>"><?php echo translate("Hide"); ?></a>
               <?php } 
			    if($row->is_enable == 0) 
			    {
               	if($total_status != 6 || $total_status == 6)
				{
					
				} 
				else {
					echo '</div></td>';
				}
				}
				else
				{
				echo '</div></td>';
				}
                 echo '<div class="clear"></div></tr>';
                 }
                 
?>
           </td>  </tbody>
</table>
<?php                 
}

					else
                 {
                 	echo"<div class='donthave-listing'>";
                      echo "<p style='font-size:18px'>".translate("You don't have any listings!")."</p>
                            <br/> ".translate("Listing your space on")." ".$this->dx_auth->get_site_title()." ".translate("is an easy way to  monetize any extra space you have.")."
                            <br/>".translate("You'll also get to meet interesting travelers from around the world!")."
                            <br/>
                            <br>";
                      echo anchor('rooms/new', translate("Post a new listing"), array('class' => 'clsLink2_Bg'));
                     echo"</div>";
                }
                
                  endif; ?>

              <div class="clearfix"></div>

          <!--    <div style="clear:both"></div>-->

            </div>
            
        </div>
</div>
</div>
<!-- Footer Scripts -->
 <script>
				 $(".active_list").click(function ( event ) {
        		 event.preventDefault();
		 		 $(this).hide();
					$(".hide_list").show();
				
       			 });	
				 $(".hide_list").click(function ( event ) {
        		 event.preventDefault();
		 		 $(this).hide();
				 $(".active_list").show();
       			 });
</script>


<script type="text/x-jqote-template" id="availability_button_template">
<![CDATA[
  <span class="clearfix current-availability icon <*= this.status *>">
    <span class="label"><*= this.label *></span>
    <span class="expand"></span>
  </span>
  <div class="toggle-info" style="display: none;">
    <div class="instructions"><*= this.instructions *></div>
    <div class="toggle-action-container">
      <a href="<*= this.url *>" class="toggle-action icon <*= this.next_status *>"><*= this.toggle_label *></a>
    </div>
  </div>
]]>
</script>

		
		<script type="text/javascript">
		  //
  // We can probably toss all of this code into a plugin at some point
  //

  var spinnerImage = new Image(); 
  spinnerImage.src = "images/spinner.gif";
  
  VisibilityFilter = function(el, options){
    if(el)
      this.init(el, options);
  }

  jQuery.extend(VisibilityFilter.prototype, {
    name: 'visibilityFilter',

    init: function(el, options){
      this.element = $(el);
      $.data(el, this.name, this);

      var $this = this.element;
      var _ref = this;

      jQuery('#listings-filter .display-filter').click(function(){
        _ref.togglePanel();
      });

      jQuery('#listings-filter .toggle-filter a').click(function(){
        var $link = jQuery(this);

        if($link.hasClass('active'))
          _ref.setPanelState('active');
        else if($link.hasClass('inactive'))
          _ref.setPanelState('inactive');
        else
          _ref.setPanelState();

        _ref.showSpinner();
        _ref.hidePanel();
      });

      var outsideClickHandler = function(eventObject){
        eventObject.data.hidePanel();
      };

      // attach and detach handlers to make it possible to close the widget by clicking
      // outside of the element
      this.element.hover(
        function(){ jQuery(document).unbind('click', outsideClickHandler); },
        function(){ jQuery(document).bind('click', _ref, outsideClickHandler); }
      );
    },


    hidePanel: function(){
      this.element.removeClass('expand');
    },

    togglePanel: function(){
      this.element.toggleClass('expand');
    },

    showPanel: function(){
      this.element.addClass('expand');
    },

    setPanelState: function(state, showSpinner){
      if(!!showSpinner)
        this.showSpinner(); 

      this.element.removeClass('none inactive active');
      this.element.addClass(state);
    },

    showSpinner: function(){
      this.element.find('.display-filter span.icon:visible').not('.always').addClass('widget-spinner');
    },

    hideSpinner: function(){
      this.element.find('.display-filter span.widget-spinner').not('.always').removeClass('widget-spinner');
    }


  });

  jQuery.fn.visibilityFilter = function(options){
    // get the arguments 
    var args = $.makeArray(arguments),
        after = args.slice(1);

    return this.each(function() {
      // see if we have an instance
      var instance = $.data(this, 'visibilityFilter');

      if (instance) {
        // call a method on the instance
        if (typeof options === "string") {
          instance[options].apply(instance, after);
        } 
        else if (instance.update) {
          // call update on the instance
          instance.update.apply(instance, args);
        }
      } 
      else {
        // create the plugin
        new VisibilityFilter(this, options);
      }
    });
  }

  jQuery(document).ready(function(){
    jQuery('#post-listing-new').click(function(){
      document.location = "http://www.cogzidel.com/rooms/new";
    });

    jQuery('#listings-filter').visibilityFilter();
  });
  var buttonContent = {
    active: {
      label: "Active",
      instructions: "Hide your listing to remove it from search results:",
      toggle_label: "Hide"
    },
    inactive: {
      label: "Hidden",
      instructions: "Activate your listing to have it show up in search results:",
      toggle_label: "Activate"
    }
  };

/*  jQuery(document).ready(function(){

    jQuery('div.set-availability').availabilityWidget(buttonContent);    

//    jQuery('div.set-availability').availabilityWidget(buttonContent);    

  });*/
  
  jQuery('#listings_filter').change(function()
    {
    	window.location.href= $(this).val();
    })
  
		function delete_list()
		{
    	var answer = confirm("Are you sure to delete?")
    		if (answer){
        	document.messages.submit();
    		}
    	return false;  
		} 

		</script>
</div>
<style>
td.listing-size {
    width: 50%!important;
}
#ftable_id_filter {
    padding-right: 10px;
}
#ftable_id_info {
    padding-left: 16px;
}
#listings-container .donthave-listing {
    padding: 20px 22px!important;
}
		.thumbnail
		{
			width: 100%;
		}
		.dataTables_length {
    display: none;
}
@media(max-width: 360px)
{
	.res_table td, .res_table1 td 
	{ 
		padding-left: 0% !important;
	}
}
@media(min-width: 760px and max-width:1024px)
{
.action_button {
   display: inline-flex;}
   .action_button a {
   width:880px !important;	
}
</style>