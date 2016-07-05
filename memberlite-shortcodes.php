<?php
/*
Plugin Name: Memberlite Shortcodes
Plugin URI: http://www.memberlitetheme.com/plugins/memberlite-shortcodes/
Description: Shortcodes designed to work with the Memberlite Theme and Memberlite Child Themes.
Version: 1.0
Author: kimannwall, strangerstudios
Author URI: http://www.memberlitetheme.com
*/

define('MEMBERLITESC_DIR', dirname(__FILE__) );
define('MEMBERLITESC_URL', WP_PLUGIN_URL . "/memberlite-shortcodes");
define('MEMBERLITESC_VERSION', '1.0');

/*
	Enqueue Stylesheets and Javascript
*/
function memberlitesc_init_styles()
{	
	//need jquery
	wp_enqueue_script('jquery');
	
	wp_enqueue_style('memberlite_fontawesome', MEMBERLITESC_URL . "/font-awesome/css/font-awesome.min.css", array(), "4.6.1");
	wp_enqueue_script('memberlitesc_js', MEMBERLITESC_URL . "/js/memberlite-shortcodes.js", array( "jquery" ), MEMBERLITESC_VERSION, true);
	wp_enqueue_style("memberlitesc_frontend", MEMBERLITESC_URL . "/css/memberlite-shortcodes.css", array(), MEMBERLITESC_VERSION);	
}
add_action("wp_enqueue_scripts", "memberlitesc_init_styles");	

/*
	Load all Shortcodes
*/
require_once(MEMBERLITESC_DIR . "/shortcodes/banners.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/buttons.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/columns.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/font-awesome.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/messages.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/recent_posts.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/signup.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/subpagelist.php");
require_once(MEMBERLITESC_DIR . "/shortcodes/tabs.php");
