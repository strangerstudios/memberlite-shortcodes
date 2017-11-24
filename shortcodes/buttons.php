<?php
function memberlitesc_btn_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_btn style="success" href="http://www.paidmembershipspro.com" text="Paid Memberships Pro" icon="info"]
    extract(shortcode_atts(array(
		'style' => 'default',
		'class' => '',
		'href' => '#',
		'icon' => '',
		'target' => 'self',
		'text' => 'Go to Link'
    ), $atts));
	
    //css classes based on styles
    $styles = explode(",", $style);
	$style_classes = array();
	foreach($styles as $onestyle) {
		$style_classes[] = 'btn_'.trim($onestyle);
	}

	//combine with classes passed in as an attribute
	if( $style === 'link' ) {
		$class = trim(implode(' ', $style_classes) . ' ' . $class);
	} else {
		$class = trim('btn ' . implode(' ', $style_classes) . ' ' . $class);
	}

	$r = '<a class="' . $class . '" href="' . $href . '" target="_' . $target . '">';

	if(!empty($icon)) {
		$r .= '<i class="fa fa-' . $icon . '"></i>';	
	}
    $r .= $text;
    $r .= '</a>';
    return $r;
}
remove_shortcode('memberlite_btn');
add_shortcode('memberlite_btn', 'memberlitesc_btn_shortcode');
