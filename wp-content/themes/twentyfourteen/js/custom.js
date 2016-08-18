( function( $ ) {
	jQuery('.page_numbers:first-child').fadeIn();
	jQuery('.page_numbers:first-child').addClass('show_pages');
	jQuery('.page_numbers').nextAll().slice(0,9).fadeIn();

   
    // Event page
    jQuery(".sorting_holder").on("change",function() { 
    	jQuery(".ajax_loading_section" ).show();
	 	if(jQuery(this).val()=="prize" || jQuery(this).val()=="free" || jQuery(this).val()=="paid") {
			jQuery("#prize_soting_value").fadeIn();
		}
		else {
			jQuery("#prize_soting_value option:first-child").attr("selected", "selected");
			jQuery("#prize_soting_value").fadeOut();
		}
	});
	jQuery(document).on("click",".page_numbers",function() { 
		jQuery(".ajax_loading_section" ).show();
	});

	// Event page - sidebar
	jQuery('.site-info').html('<span> copyright©2016.<a href="http://etekchnoservices.com/" target="_blank"> Etekchnoservices Pvt.Ltd </a> </span>');
	jQuery(document).on("click",".dropdown_link",function() {
    	var list_section = jQuery(".dropdown_holder").find("li");
		var this_data_id = jQuery(this).data("panel");
		var find_active = jQuery(".dropdown_holder").find(".active");
		jQuery("." + this_data_id).slideDown().addClass("active");
		find_active.slideUp().removeClass("active");
		jQuery('#cutom_date_form_event').hide();
	});
	jQuery('#custom_date_event').on('click',function() {
		jQuery('#cutom_date_form_event').show();
	});
	

})( jQuery );

  
