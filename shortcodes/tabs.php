<?php
// Tabs Content Wrapper
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
		$result .= '<li';
		$memberlite_active_tabs = memberlitesc_check_active_tab( array( $item ) );
		if( in_array( $item, $memberlite_active_tabs ) )
			$result .= ' class="memberlite_active"';
		$result .= '><a href="#tab-' . $item_id . '" data-toggle="tab" data-value="#' . $item_id . '">' . $item . '</a></li>';
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

function memberlitesc_check_active_tab( $items = array() ){

	global $post;

	$memberlite_active_tabs = array();

	$cookie_name = 'memberlite_active_tabs_' . $post->ID . '_' . count($items);

	if(!empty($_COOKIE[$cookie_name])){
		$cookie_value = $_COOKIE[$cookie_name];
	} else {
		$cookie_value = $cookie_name;
	}
	if(!empty($cookie_value) || empty( $items ) ){
		$memberlite_active_tabs[] = $cookie_value;
	} else {
		$memberlite_active_tabs[] = $items[0];
	}

	return $memberlite_active_tabs;

}

function memberlitesc_tab_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_tab class="text-center" item="Tab 1"]
    extract(shortcode_atts(array(
		'class' => '',
		'item' => '',
    ), $atts));
	$memberlite_active_tabs = memberlitesc_check_active_tab( array( $item ) );
	
	$item_id = sanitize_title_with_dashes( $item );
    $result = '<div class="memberlite_tab_pane ' . $class;
	if( in_array( $item, $memberlite_active_tabs ) )
		$result .= ' memberlite_active';
	$result .= '" id="tab-' . $item_id . '" >';
    $result .= do_shortcode($content);
    $result .= '</div>';
    return force_balance_tags($result);
}
add_shortcode('memberlite_tab', 'memberlitesc_tab_shortcode');