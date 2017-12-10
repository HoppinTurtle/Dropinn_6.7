var o = 0 ;
jQuery(document).ready(function(){	
	var dropbox;  

var oprand = {
	dragClass : "active",
    on: {
        load: function(e, file) {
			// check file type
			var imageType = /image.*/;
			if (!file.type.match(imageType)) {  
			  alert("File \""+file.name+"\" is not a valid image file");
			  return false;	
			} 
			
			// check file size
			// if (parseInt(file.size / 1024) > 2050) {  
			  // alert("File \""+file.name+"\" is too big.Max allowed size is 2 MB.");
			  // return false;	
			// } 

			create_box(e,file);
	//		alert("oprand")
	//		window.location.reload(); 
	
    	},
    }
};

	FileReaderJS.setupDrop(document.getElementById('dropbox'), oprand);
	//window.location.reload(); 
	
});

create_box = function(e,file){
	var rand = Math.floor((Math.random()*100000)+3);
	var imgName = file.name; // not used, Irand just in case if user wanrand to print it.
	var src		= e.target.result;
// jQuery('#dropbox').html('');
	var template = '<div class="eachImage" id="'+rand+'">';
	template += '<span class="preview" id="'+rand+'"><img src="'+src+'"><span class="overlay"><span class="updone"></span></span>';
	template += '</span>';
	template += '<div class="progress" id="'+rand+'"><span></span></div>';

	if(jQuery("#dropbox .eachImage").html() == null)
		jQuery("#dropbox").html(template);
	else
		jQuery("#dropbox").append(template);
	
	var formData = new FormData();
		formData.append('upload_file[]', file); 
	
	// upload image
	upload(formData,rand);

	
}

upload = function(file,rand){
//	alert("Test")

	// now upload the file
	var xhr = new Array();
	xhr[rand] = new XMLHttpRequest();
	xhr[rand].open("post", base_url+"rooms/add_photo/"+ room_id, true);

	xhr[rand].upload.addEventListener("progress", function (event) {
	//	window.location.reload();
		//console.log(event);
		if (event.lengthComputable) {
			jQuery(".progress[id='"+rand+"'] span").css("width",(event.loaded / event.total) * 100 + "%");
			jQuery(".preview[id='"+rand+"'] .updone").html(((event.loaded / event.total) * 100).toFixed(2)+"%");
		}
		else {
			alert("Failed to compute file upload length");
		}
	}, false);

	xhr[rand].onreadystatechange = function (oEvent) { 
		// window.location.reload();
	  if (xhr[rand].readyState === 4) {  
		if (xhr[rand].status === 200) {  
			
				   if (xhr[rand].responseText == "users/signin") {
                        window.location.href = base_url + xhr[rand].responseText
                    } else if (xhr[rand].responseText != "no") {
                        jQuery("#container_photo").hide();
                        jQuery(".container_add_photo").show();
                        jQuery("#photos_count").hide();
                        jQuery("#content").show();
                        for (var n = 0; n < 50; n++) {
                            jQuery(".expand").css("width", n + "%")
                        }
                        jQuery("#upload_file_btn1").show();
                        jQuery("#upload_file_btn1_dis").hide();
                        setTimeout(function() {
                            jQuery("#container_photo").hide();
                            jQuery(".container_add_photo").show();
                            jQuery("#photo_ul").show();
                            jQuery("#photo_ul").replaceWith(xhr[rand].responseText);
                            for (var n = 50; n < 100; n++) {
                                jQuery(".expand").css("width", n + "%")
                            }
                            photo_status = 1;
                            photos_count = photos_count + 1;
                            //alert(photos_count);
                            jQuery("#content").hide();
                            jQuery("#photos_count").show();
                            if (photos_count < 0) {
                                jQuery("#photos_count").replaceWith('<p id="photos_count">0 Photos</p>')
                            } else {
                                jQuery("#photos_count").replaceWith('<p id="photos_count">' + photos_count + " Photos</p>")
                            }
                            jQuery("#photo_plus_white").hide();
                            jQuery("#photo_grn_white").show();
                            jQuery("#photo_ul").replaceWith(xhr[rand].responseText);
                            jQuery("#photo_plus_white").hide();
                            jQuery("#upload_file1").removeAttr("disabled");
                            jQuery("#upload_file1").show();
                            var r = 0;
                            r = o + price_status + address_status + listing_status + photo_status + overview_status;
                            var i = 6 - r;
                                        setTimeout(function() {  
   										sort();
                      			 }, 200);
                            jQuery("#steps").replaceWith('<span id="steps">' + i + " steps</span>");
                            if (i == 0) {
                                jQuery.ajax({
                                    url: base_url + "rooms/final_step",
                                    type: "POST",
                                    data: {
                                        room_id: room_id
                                    },
                                    success: function(e) {
                                        jQuery("#steps_count").hide();
                                        jQuery("#list_space").show();
                                        if (photos_count == 1) {
                                            jQuery("#list-button").rotate3Di(720, 750)
                                        }
                                    }
                                })
                            }
                        }, 2e3)
                    } else {
                        alert("Please choose the correct file");
                        return false
                    }
                    var r = false;
                    jQuery("#upload_file").removeAttr("disabled")
                    
                    
                    	if (photo_status == 1) {
        jQuery("#photo_plus").hide();
        jQuery("#photo_grn").show();
        var S = 0;
        S = o + price_status + address_status + listing_status + photo_status + overview_status;
        var x = 6 - S;
        jQuery("#steps").replaceWith('<span id="steps">' + x + " steps</span>");
        if (x == 0) {
            jQuery.ajax({
                url: base_url + "rooms/final_step",
                type: "POST",
                data: {
                    room_id: room_id
                },
                success: function(e) {
                    jQuery("#steps_count").hide();
                    jQuery("#list_space").show()
                }
            })
        }
    }
    
		  jQuery(".progress[id='"+rand+"'] span").css("width","100%");
		  jQuery(".preview[id='"+rand+"']").find(".updone").html("100%");
		  jQuery(".preview[id='"+rand+"'] .overlay").css("display","none");
		  
		  
		} else {  
		  //alert("Error : Unexpected error while uploading file");  
		}  
	  }  
	};  
	
	// Set headers
	
	// Send the file (doh)
	xhr[rand].send(file);
	// window.location.reload();
	//jQuery('#dropbox').html('');
}