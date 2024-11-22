<?php
/*
	Based on the pmpro_signup shortcode bundled in the PMPro Register Helper plugin.
	
	This shortcode will show a signup form. It will only show user account fields.
	If the level is not free, the user will have to enter the billing information on the checkout page.	
*/
function memberlitesc_signup_shortcode($atts, $content=null, $code="")
{
	_doing_it_wrong( __FUNCTION__, __( 'The [memberlite_signup] shortcode is now deprecated. Please use the Signup Shortcode Add On for Paid Memberships Pro instead.', 'memberlite-shortcodes' ), '1.4' );

	// Show a message to admins that the shortcode is deprecated.
	if ( current_user_can ( 'manage_options' ) ) {
		return '<div class="pmpro_message pmpro_error">' . esc_html__( 'Admin only message: The Memberlite Signup shortcode is deprecated. Please update your content.', 'memberlite-shortcodes' ) . '</div>';
	}
}
remove_shortcode('memberlite_signup');	//replace shortcode bundled with Memberlite 2.0 and prior or anywhere else
add_shortcode("memberlite_signup", "memberlitesc_signup_shortcode");
