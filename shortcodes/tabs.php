<?php
/**
 * The memberlite_tabs shortcode.
 * This shortcode is a wrapper for each
 * individual membership_tab shortcode.
 *
 * Example:
 * [memberlite_tabs items="Item 1,Item 2"]
 * [memberlite_tab item="Item 1"]Item 1 tab content.[/memberlite_tab]
 * [memberlite_tab item="Item 2"]Item 2 tab content.[/memberlite_tab]
 * [/memberlite_tabs]
 *
 * Note: The JS for handling tabs is in the Memberlite theme.
 */
function memberlitesc_tabs_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_tabs class="text-center" items="Tab 1, Tab 2, Tab 3"][/tabs]
    extract(shortcode_atts(array(
		'class' => '',
		'items' => '',
    ), $atts));
	$items = explode(",",$items);
	//figure out the active tab and store in a global
	global $post;
	//build tab menu
	$count = '1';
    $result = '<div class="memberlite_tabbable ' . $class . '">';
    $result .= '<ul class="memberlite_tabs">';
	foreach($items as $item)
	{	
		$item_id = sanitize_title_with_dashes($item);
		$result .= '<li><a href="#tab-' . $item_id . '" data-toggle="tab" data-value="#' . $item_id . '">' . $item . '</a></li>';
	}
	$result .= '</ul><div class="memberlite_tab_content">';
    $content = str_replace("]<br />", ']', $content);
    $content = str_replace("<br />\n[", '[', $content);
    $result .= do_shortcode($content);
    $result .= '</div></div>';
    return force_balance_tags($result);
}
remove_shortcode('memberlite_tabs');	//replace shortcode bundled with Memberlite 2.0 and prior or anywhere else
add_shortcode('memberlite_tabs', 'memberlitesc_tabs_shortcode');

/**
 * The memberlite_tab shortcode.
 * These shortcodes should be inside of a memberlite_tabs shortcode.
 *
 * Example:
 * [memberlite_tab class="tab1" item="Tab 1"]Tab content.[/memberlite_tab]
 */
function memberlitesc_tab_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_tab class="text-center" item="Tab 1"]
    extract(shortcode_atts(array(
		'class' => '',
		'item' => '',
    ), $atts));
	$item_id = sanitize_title_with_dashes( $item );
    $result = '<div class="memberlite_tab_pane ' . $class;
	$result .= '" id="tab-' . $item_id . '" >';
    $result .= do_shortcode($content);
    $result .= '</div>';
    return force_balance_tags($result);
}
add_shortcode('memberlite_tab', 'memberlitesc_tab_shortcode');