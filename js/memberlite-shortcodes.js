/**
 * memberlite-shortcodes.js
 */
jQuery( document ).ready( function() {

	//show accordion content when clicked
	jQuery('.memberlite_accordion-item h3').click(function(e) {
		
		var accordion_trigger, accordion, accordion_wrapper;

		accordion_trigger = jQuery(this);
		accordion = accordion_trigger.parent();
		accordion_wrapper = accordion.parent();

		accordion_trigger.next().slideToggle(350);
		accordion_wrapper.addClass('memberlite-active');

		if(accordion_wrapper.hasClass('memberlite_accordion-collapse')) {
			accordion_wrapper.addClass('kim');
		}
	});	 

});