/**
 * memberlite-shortcodes.js
 */
jQuery( document ).ready( function() {

	//show accordion content when clicked
	jQuery('.memberlite_accordion-item h3').click(function(e) {
		
		var accordion_trigger, accordion, accordion_wrapper;

		accordion_trigger = jQuery(this);
		accordion = accordion_trigger.closest('.memberlite_accordion-item');
		accordion_wrapper = accordion.closest('.memberlite_accordion');

		if(accordion_wrapper.hasClass('memberlite_accordion-show')) {
			//hide all items
			jQuery.each(accordion_wrapper.find('.memberlite_accordion-item'), function(key, item) {
				if(jQuery(item).is(accordion)) {
					jQuery(item).find('.memberlite_accordion-item-content').slideToggle(350);
					if(jQuery(item).hasClass('memberlite_accordion-active')) {
						jQuery(item).removeClass('memberlite_accordion-active');
					} else {
						jQuery(item).addClass('memberlite_accordion-active');
					}
				}
			});
		} else {
			//hide all items
			jQuery.each(accordion_wrapper.find('.memberlite_accordion-item'), function(key, item) {
				if(jQuery(item).is(accordion)) {
					jQuery(item).find('.memberlite_accordion-item-content').slideToggle(350);
					if(jQuery(item).hasClass('memberlite_accordion-active')) {
						jQuery(item).removeClass('memberlite_accordion-active');
					} else {
						jQuery(item).addClass('memberlite_accordion-active');
					}
				} else {
					jQuery(item).find('.memberlite_accordion-item-content').slideUp(350);
					jQuery(item).removeClass('memberlite_accordion-active');
				}
			});
		}
	});	 


	jQuery("body").on("click", ".memberlite_active a", function(){

		if( typeof memberlite_postdata !== 'undefined' ){

			if( memberlite_postdata.tabs_cookie !== false ){

				var item_name = jQuery(this).html();
				var post_id = memberlite_postdata.post_id;
				var active_tabs = memberlite_postdata.active_tabs;

			  	Cookies.set('memberlite_active_tabs_'+post_id+'_'+active_tabs, Array( item_name ), { expires: 1, path: '' } );

		  	}

		}

	});

	if( jQuery(".memberlite_accordion-item").length > 0 ){
		//Accordion is on this page
		var accordion_id = location.hash;
		if( accordion_id !== "" ){
			//Open an accordion
			jQuery( accordion_id + ' h3' ).click();
		}

	}

});