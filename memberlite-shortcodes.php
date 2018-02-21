<?php
/*
Plugin Name: Memberlite Shortcodes
Plugin URI: https://memberlitetheme.com/plugins/memberlite-shortcodes/
Description: Shortcodes designed to work with the Memberlite Theme and Memberlite Child Themes.
Version: 1.2
Author: kimannwall, strangerstudios
Author URI: https://memberlitetheme.com
*/

define( 'MEMBERLITESC_DIR', dirname( __FILE__ ) );
define( 'MEMBERLITESC_URL', plugins_url( '', __FILE__ ) );
define( 'MEMBERLITESC_VERSION', '1.2' );

/**
 * Enqueue Stylesheets and Javascript
 */
function memberlitesc_init_styles() {
	global $post, $page;
	$shortcodes = array(
		'memberlite_accordion',
		'memberlite_banner',
		'memberlite_btn',
		'row',
		'row_row',
		'row_row_row',
		'row_row_row_your_boat',
		'fa',
		'memberlite_msg',
		'memberlite_recent_posts',
		'memberlite_signup',
		'memberlite_subpagelist',
		'memberlite_tab',
	);

	$should_exit = true;

	foreach ( $shortcodes as $sc ) {
		if ( ( isset( $post->post_content ) && has_shortcode( $post->post_content, $sc ) ) || ( isset( $page->post_content ) && has_shortcode( $page->post_content, $sc ) ) ) {
			$should_exit = false;
		}
	}

	// Only load / enqueue resources if a shortcode is present on the post/page.
	if ( false === $should_exit ) {
		wp_enqueue_style( 'font-awesome', MEMBERLITESC_URL . '/font-awesome/css/font-awesome.min.css', array(), '4.7' );
		wp_enqueue_script( 'memberlitesc_js', MEMBERLITESC_URL . '/js/memberlite-shortcodes.js', array( 'jquery' ), MEMBERLITESC_VERSION, true );
		wp_enqueue_style( 'memberlitesc_frontend', MEMBERLITESC_URL . '/css/memberlite-shortcodes.css', array(), MEMBERLITESC_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'memberlitesc_init_styles' );

/**
 * Load all Shortcodes
 * Note we load on init with priority 20 here so we load after shortcodes that might still be around from Memberlite 2.0 and prior.
 */
function memberlitesc_init_shortcodes() {
	require_once( MEMBERLITESC_DIR . '/shortcodes/accordion.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/banners.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/buttons.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/columns.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/font-awesome.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/messages.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/recent_posts.php' );
	if ( defined( 'PMPRO_VERSION' ) ) {
		require_once( MEMBERLITESC_DIR . '/shortcodes/signup.php' );
	}
	require_once( MEMBERLITESC_DIR . '/shortcodes/subpagelist.php' );
	require_once( MEMBERLITESC_DIR . '/shortcodes/tabs.php' );
}
add_action( 'init', 'memberlitesc_init_shortcodes', 20 );

/**
 * Sometimes if two shortcodes bump up against one another, WP will autop it and we don't want that.
 *
 * @param  string $content The return content of the memberlite banner shortcode output.
 */
function memberlitesc_the_content_unautop( $content ) {
	$shortcodes = array(
		'memberlite_banner',
	);
	foreach ( $shortcodes as $shortcode ) {
		$content = preg_replace( '/<br \/>\s*\[' . $shortcode . '/ms', '[' . $shortcode, $content );
		$content = preg_replace( '/<p\>\[' . $shortcode . '/ms', '[' . $shortcode, $content );
		$content = preg_replace( '/\[\/' . $shortcode . '\]<\/p>/ms', '[/' . $shortcode . ']', $content );
	}
	return $content;
}
add_action( 'the_content', 'memberlitesc_the_content_unautop' );
