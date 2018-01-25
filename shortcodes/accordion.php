<?php
// Tabs Content Wrapper
function memberlitesc_accordion_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_accordion action="hide" class="text-center" visibility=""][/memberlite_accordion]
    extract(shortcode_atts(array(
        'action' => 'hide',
		'class' => '',
        'visibility' => 'collapse'
    ), $atts));
		
	//build accordion wrapper
	$count = '1';
    $result = '<div class="memberlite_accordion memberlite_accordion-' . $visibility . ' ' . $class . '">';
    $content = str_replace("]<br />", ']', $content);
    $content = str_replace("<br />\n[", '[', $content);
    $result .= do_shortcode($content);
    $result .= '</div>';
    return force_balance_tags($result);
}
add_shortcode('memberlite_accordion', 'memberlitesc_accordion_shortcode');

function memberlitesc_accordion_item_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_accordion_item class="text-center"]
    extract(shortcode_atts(array(
		'class' => '',
		'title' => '',
    ), $atts));

    //build the accordion items
    $result = '<div class="memberlite_accordion-item ' . $class . '">';
	$result .= '<h3>' . $title . '</h3>';
    $result .= '<div class="memberlite_accordion-item-content">';
    $result .= do_shortcode($content);
    $result .= '</div></div>';
    return force_balance_tags($result);
}
add_shortcode('memberlite_accordion_item', 'memberlitesc_accordion_item_shortcode');