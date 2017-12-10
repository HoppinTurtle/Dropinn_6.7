<div class="container">
<div class="inner_container_bg inner_pad_top col-md-12 padding-zero" id="View_Pages">
<div class="inner_Box">

	<div class="Box_Content padding-zero" style="border:0px!important;">
	
 		<?php echo translate($page_content); ?>
	</div>
	<script>
$(document).ready(function()
    {
        var f = $(".inner_header > h2").text();
            
    $.ajax({ url: base_url + "pages/err_lang",
             type: "POST",
             data: {
                    title: f
                        },
                success: function(e) {
                      $(".inner_header > h2").html(e); 
                                                   
                          
    }
   })
    });
    </script>


 
</div>
</div>
</div>