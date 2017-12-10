<style>
	.subnav{overflow: hidden;}
.msg_txt{
	font-size: 16px;
}
.clow{
	  opacity: .2;
  font-size: 280px; 
      padding-bottom: 20px;
}
.map_number{
	margin-left: 0px !important;
}
</style>



<?php 
		$count = 0 ;
	  echo '<div class="image-placeholder-popular container">
	  <ul class="popular_whole" style="margin-top:30px !important;"> <li> <ul class="popular_whole_img">';
	  
	  foreach($shortlist->result() as $row) 
	  {
	  		
    $step_completed=$this->db->where('id',$row->list_id)->where(array('calendar'=>1,'overview'=>1,'listing'=>1,'photo'=>1,'address'=>1,'price'=>1))->get('lys_status')->num_rows(); 
	if($step_completed == 1) 
	{ 	
		
			 
	  	$query['id'] = $row->id;		 //get list table data's
	  	$query['address'] = $row->address;
		$query['title'] = $row->title;
		$query['country'] = $row->country;
		$query['price'] = $row->price;
		$query['city'] = $row->city;
	 
	  $list_create = $this->db->select('created')->where('id',$row->list_id)->get('list')->row();	
	  $created = $list_create->created;

		$city=explode(',', $query['address']);

		$photo=$this->Users_model->get_list_by_id('list_photo','list_id',$row->list_id); //get photo name from list_photo table
	
				 if(count($photo) > 0) //condition for if empty photo
				 {
				 	 $url = cdn_url_images().'images/'.$query['id'].'/'.$photo['name']; 
					 
				 	 $handle = curl_init($url);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($handle);
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			curl_close($handle);
			
				 	?>
				 	<li class="row wishlists-list-item">
				 	 	<?php
				 	 	 if(intval($httpCode) < 400)
						{ ?>
		   <?php echo '<li class="col-md-6 col-xs-12 col-sm-6" style="margin-bottom:20px;"><a href="'.site_url().'rooms/'.$query['id'].'">';?> <div style="position:relative;">
		   		<?php 
			$date_new = strtotime(date("Y-m-d", strtotime("-3 days")));
			
			?>
			
			<?php if($created >= $date_new ){ ?>
				<div class="map_number">New</div>
				<?php } ?>
		   	<img src="<?php echo $url; ?>" height=280 width=275  alt=<?php echo $query["title"];?> onerror="this.src='<?php echo base_url().'images/no_image.jpg';  ?>'" >
		 
						<?php }		
				 else { 
					 echo '<li class="col-md-6 col-xs-12 col-sm-6" style="margin-bottom:20px;"><a href="'.site_url().'rooms/'.$query['id'].'">';?> <div style="position:relative;"><img src="<?php echo base_url().'images/no_image.jpg'; ?>" height=280 width=275 alt=<?php echo $query["title"];?> >
					<?php 				 }
		?>
	<!--<a href="'.site_url().'rooms/'.$query['profile'].'"><img height="50" width="50" alt="" src="<?php echo $this->Gallery->profilepic($row->profile,2); ?>" /></a>-->
		  
		  
		  
		   	<div style="position:relative; bottom:0; left:0;" class="col-md-12 col-xs-12 col-sm-12 padd-zero">
		   		
<ul>
  
    <li class="pop_wid" style="width: 74%;">
    	
    	
		  
      
    	
    	<?php 

    	echo '<div class="pop_img_h col-xs-7 padd-zero col-md-10 col-sm-7">'.$query['title'].'</div>';

    	

    	echo '<div class="pop_img_h_place col-xs-8 col-md-10 col-sm-7" style="padding-left:0px !important;padding-right:5px !important;">'.$query['city'].','.$query['country'].'</div>';?>

    	</li>
    	
    	
    	 <div>   <?php
    	  $user_id = $this->db->where('id',$query['id'])->from('list')->get()->row()->user_id;
            ?>
            <img class="img-circle" id="trigger_id_1" width="18" height="18" alt="" src="<?php    
		  	 echo $this->Gallery->profilepic($user_id,2);
            ?>" title=""/>
               </div>
   
    	
             <div class="pop_img_h_dollar price" style="position:absolute: right:0; bottom:0;">
             	<div class="pop_doll">
                <?php echo '<p class="dollor_symbol doller_symbol_2">'.get_currency_symbol($query['id']).'</p><p class="dollor_price dollor_price_2">'.get_currency_value1($query['id'],$query['price']); ?>
               <!-- <p class="per_night"><?php echo translate('per night');?></p>-->
               
           
               
                </div>
                
              </div>
          
          

 </ul>
 
		   </div></div></a>
							</li>							 
					
	  
		   
		  <?php
		  } 
		     else 
		     {
		     	 		 	 	?><li class="row wishlists-list-item">
		   <?php echo '<li class="col-md-6 col-xs-12 col-sm-6" style="margin-bottom:20px;" ><a href="'.site_url().'rooms/'.$query['id'].'">';?> <div style="position:relative;"><img src="<?php echo base_url().'images/no_image.jpg'; ?> height=280    alt=<?php echo $query["title"];?> >
		   	<div style="position:absolute; bottom:0; left:0;" class="col-md-12 col-xs-12 col-sm-12 padd-zero">
		   		
    <li>
    	
    	
    	<?php 
    	echo '<div class="pop_img_h col-xs-9 padd-zero col-md-10 col-sm-10">'.$query['title'].'</div>';
    	echo '<div class="pop_img_h_place col-xs-12 col-md-10 col-sm-10">'.$query['city'].','.$query['country'].'</div>';?>
    	</li>
    	 <li>
         	<div class="pop_img_h_dollar price" style="position:relative: right:0; bottom:0;">
              <div class="pop_doll">
				<?php echo '<p class="dollor_symbol">'.get_currency_symbol($query['id']).'</p><p class="dollor_price">'.get_currency_value1($query['id'],$query['price']); ?>
					
              <!--  <p class="per_night"><?php echo translate('per night');?></p>-->
              
                <div>   <?php
            $user_id = $this->db->where('id',$query['id'])->from('list')->get()->row()->user_id;
            ?>
            <img class="img-circle text-right" id="trigger_id_1" width="18" height="18" alt="" src="<?php    
		  	 echo $this->Gallery->profilepic($user_id,2);
            ?>" title=""/>
               </div>
              
              </div>
            </div>
         </li>
 
 
		   </div></div></a>
							</li>							 
				<?php 
				 
			 }

	  $count++; }
	  }
	  if($count == 0){?>
	  	
<div class="msg_txt" style=" text-align: center;">
<i class="fa fa-frown-o clow"></i>	
</div>
	  	
	  <?php }
            echo '</ul>
			</li> 
	  		 
			<li style="clear:both;"></li>
	  </ul>';    
				 
	  ?>