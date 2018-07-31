<?php
/*
Plugin Name: Memberlite Shortcodes
Plugin URI: https://memberlitetheme.com/memberlite-shortcodes/
Description: Shortcodes designed to work with the Memberlite Theme and Memberlite Child Themes.
Version: 1.3
Author: Stranger Studios
Author URI: https://memberlitetheme.com
*/

define( 'MEMBERLITESC_DIR', dirname( __FILE__ ) );
define( 'MEMBERLITESC_URL', plugins_url( '', __FILE__ ) );
define( 'MEMBERLITESC_VERSION', '1.3' );

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
		wp_enqueue_style( 'font-awesome', MEMBERLITESC_URL . '/font-awesome/css/all.min.css', array(), '5.2' );
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

/**
 * Get the available icons by type.
 *
 * @param string type Optional icon type to return (brand, regular, solid).
 * @return array
 */
function memberlite_shortcodes_get_font_awesome_icons( $type = NULL ) {
	if ( $type === 'brand' ) {
        return array( '500px', 'accessible-icon', 'accusoft', 'adn', 'adversal', 'affiliatetheme', 'algolia', 'amazon', 'amazon-pay', 'amilia', 'android', 'angellist', 'angrycreative', 'angular', 'app-store', 'app-store-ios', 'apper', 'apple', 'apple-pay', 'asymmetrik', 'audible', 'autoprefixer', 'avianex', 'aviato', 'aws', 'bandcamp', 'behance', 'behance-square', 'bimobject', 'bitbucket', 'bitcoin', 'bity', 'black-tie', 'blackberry', 'blogger', 'blogger-b', 'bluetooth', 'bluetooth-b', 'btc', 'buromobelexperte', 'buysellads', 'cc-amazon-pay', 'cc-amex', 'cc-apple-pay', 'cc-diners-club', 'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'centercode', 'chrome', 'cloudscale', 'cloudsmith', 'cloudversify', 'codepen', 'codiepie', 'connectdevelop', 'contao', 'cpanel', 'creative-commons', 'creative-commons-by', 'creative-commons-nc', 'creative-commons-nc-eu', 'creative-commons-nc-jp', 'creative-commons-nd', 'creative-commons-pd', 'creative-commons-pd-alt', 'creative-commons-remix', 'creative-commons-sa', 'creative-commons-sampling', 'creative-commons-sampling-plus', 'creative-commons-share', 'css3', 'css3-alt', 'cuttlefish', 'd-and-d', 'dashcube', 'delicious', 'deploydog', 'deskpro', 'deviantart', 'digg', 'digital-ocean', 'discord', 'discourse', 'dochub', 'docker', 'draft2digital', 'dribbble', 'dribbble-square', 'dropbox', 'drupal', 'dyalog', 'earlybirds', 'ebay', 'edge', 'elementor', 'ello', 'ember', 'empire', 'envira', 'erlang', 'ethereum', 'etsy', 'expeditedssl', 'facebook', 'facebook-f', 'facebook-messenger', 'facebook-square', 'firefox', 'first-order', 'first-order-alt', 'firstdraft', 'flickr', 'flipboard', 'fly', 'font-awesome', 'font-awesome-alt', 'font-awesome-flag', 'fonticons', 'fonticons-fi', 'fort-awesome', 'fort-awesome-alt', 'forumbee', 'foursquare', 'free-code-camp', 'freebsd', 'fulcrum', 'galactic-republic', 'galactic-senate', 'get-pocket', 'gg', 'gg-circle', 'git', 'git-square', 'github', 'github-alt', 'github-square', 'gitkraken', 'gitlab', 'gitter', 'glide', 'glide-g', 'gofore', 'goodreads', 'goodreads-g', 'google', 'google-drive', 'google-play', 'google-plus', 'google-plus-g', 'google-plus-square', 'google-wallet', 'gratipay', 'grav', 'gripfire', 'grunt', 'gulp', 'hacker-news', 'hacker-news-square', 'hackerrank', 'hips', 'hire-a-helper', 'hooli', 'hornbill', 'hotjar', 'houzz', 'html5', 'hubspot', 'imdb', 'instagram', 'internet-explorer', 'ioxhost', 'itunes', 'itunes-note', 'java', 'jedi-order', 'jenkins', 'joget', 'joomla', 'js', 'js-square', 'jsfiddle', 'kaggle', 'keybase', 'keycdn', 'kickstarter', 'kickstarter-k', 'korvue', 'laravel', 'lastfm', 'lastfm-square', 'leanpub', 'less', 'line', 'linkedin', 'linkedin-in', 'linode', 'linux', 'lyft', 'magento', 'mailchimp', 'mandalorian', 'markdown', 'mastodon', 'maxcdn', 'medapps', 'medium', 'medium-m', 'medrt', 'meetup', 'megaport', 'microsoft', 'mix', 'mixcloud', 'mizuni', 'modx', 'monero', 'napster', 'neos', 'nimblr', 'nintendo-switch', 'node', 'node-js', 'npm', 'ns8', 'nutritionix', 'odnoklassniki', 'odnoklassniki-square', 'old-republic', 'opencart', 'openid', 'opera', 'optin-monster', 'osi', 'page4', 'pagelines', 'palfed', 'patreon', 'paypal', 'periscope', 'phabricator', 'phoenix-framework', 'phoenix-squadron', 'php', 'pied-piper', 'pied-piper-alt', 'pied-piper-hat', 'pied-piper-pp', 'pinterest', 'pinterest-p', 'pinterest-square', 'playstation', 'product-hunt', 'pushed', 'python', 'qq', 'quinscape', 'quora', 'r-project', 'ravelry', 'react', 'readme', 'rebel', 'red-river', 'reddit', 'reddit-alien', 'reddit-square', 'rendact', 'renren', 'replyd', 'researchgate', 'resolving', 'rev', 'rocketchat', 'rockrms', 'safari', 'sass', 'schlix', 'scribd', 'searchengin', 'sellcast', 'sellsy', 'servicestack', 'shirtsinbulk', 'shopware', 'simplybuilt', 'sistrix', 'sith', 'skyatlas', 'skype', 'slack', 'slack-hash', 'slideshare', 'snapchat', 'snapchat-ghost', 'snapchat-square', 'soundcloud', 'speakap', 'spotify', 'squarespace', 'stack-exchange', 'stack-overflow', 'staylinked', 'steam', 'steam-square', 'steam-symbol', 'sticker-mule', 'strava', 'stripe', 'stripe-s', 'studiovinari', 'stumbleupon', 'stumbleupon-circle', 'superpowers', 'supple', 'teamspeak', 'telegram', 'telegram-plane', 'tencent-weibo', 'themeco', 'themeisle', 'trade-federation', 'trello', 'tripadvisor', 'tumblr', 'tumblr-square', 'twitch', 'twitter', 'twitter-square', 'typo3', 'uber', 'uikit', 'uniregistry', 'untappd', 'usb', 'ussunnah', 'vaadin', 'viacoin', 'viadeo', 'viadeo-square', 'viber', 'vimeo', 'vimeo-square', 'vimeo-v', 'vine', 'vk', 'vnv', 'vuejs', 'weebly', 'weibo', 'weixin', 'whatsapp', 'whatsapp-square', 'whmcs', 'wikipedia-w', 'windows', 'wix', 'wolf-pack-battalion', 'wordpress', 'wordpress-simple', 'wpbeginner', 'wpexplorer', 'wpforms', 'xbox', 'xing', 'xing-square', 'y-combinator', 'yahoo', 'yandex', 'yandex-international', 'yelp', 'yoast', 'youtube', 'youtube-square', 'zhihu' );
    } elseif ( $type === 'regular' ) {
        return array( 'address-book', 'address-card', 'angry', 'arrow-alt-circle-down', 'arrow-alt-circle-left', 'arrow-alt-circle-right', 'arrow-alt-circle-up', 'bell', 'bell-slash', 'bookmark', 'building', 'calendar', 'calendar-alt', 'calendar-check', 'calendar-minus', 'calendar-plus', 'calendar-times', 'caret-square-down', 'caret-square-left', 'caret-square-right', 'caret-square-up', 'chart-bar', 'check-circle', 'check-square', 'circle', 'clipboard', 'clock', 'clone', 'closed-captioning', 'comment', 'comment-alt', 'comment-dots', 'comments', 'compass', 'copy', 'copyright', 'credit-card', 'dizzy', 'dot-circle', 'edit', 'envelope', 'envelope-open', 'eye', 'eye-slash', 'file', 'file-alt', 'file-archive', 'file-audio', 'file-code', 'file-excel', 'file-image', 'file-pdf', 'file-powerpoint', 'file-video', 'file-word', 'flag', 'flushed', 'folder', 'folder-open', 'frown', 'frown-open', 'futbol', 'gem', 'grimace', 'grin', 'grin-alt', 'grin-beam', 'grin-beam-sweat', 'grin-hearts', 'grin-squint', 'grin-squint-tears', 'grin-stars', 'grin-tears', 'grin-tongue', 'grin-tongue-squint', 'grin-tongue-wink', 'grin-wink', 'hand-lizard', 'hand-paper', 'hand-peace', 'hand-point-down', 'hand-point-left', 'hand-point-right', 'hand-point-up', 'hand-pointer', 'hand-rock', 'hand-scissors', 'hand-spock', 'handshake', 'hdd', 'heart', 'hospital', 'hourglass', 'id-badge', 'id-card', 'image', 'images', 'keyboard', 'kiss', 'kiss-beam', 'kiss-wink-heart', 'laugh', 'laugh-beam', 'laugh-squint', 'laugh-wink', 'lemon', 'life-ring', 'lightbulb', 'list-alt', 'map', 'meh', 'meh-blank', 'meh-rolling-eyes', 'minus-square', 'money-bill-alt', 'moon', 'newspaper', 'object-group', 'object-ungroup', 'paper-plane', 'pause-circle', 'play-circle', 'plus-square', 'question-circle', 'registered', 'sad-cry', 'sad-tear', 'save', 'share-square', 'smile', 'smile-beam', 'smile-wink', 'snowflake', 'square', 'star', 'star-half', 'sticky-note', 'stop-circle', 'sun', 'surprise', 'thumbs-down', 'thumbs-up', 'times-circle', 'tired', 'trash-alt', 'user', 'user-circle', 'window-close', 'window-maximize', 'window-minimize', 'window-restore' );
	} elseif ( $type === 'solid' ) {
        return array( 'address-book', 'address-card', 'adjust', 'air-freshener', 'align-center', 'align-justify', 'align-left', 'align-right', 'allergies', 'ambulance', 'american-sign-language-interpreting', 'anchor', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'angry', 'apple-alt', 'archive', 'archway', 'arrow-alt-circle-down', 'arrow-alt-circle-left', 'arrow-alt-circle-right', 'arrow-alt-circle-up', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows-alt', 'arrows-alt-h', 'arrows-alt-v', 'assistive-listening-systems', 'asterisk', 'at', 'atlas', 'atom', 'audio-description', 'award', 'backspace', 'backward', 'balance-scale', 'ban', 'band-aid', 'barcode', 'bars', 'baseball-ball', 'basketball-ball', 'bath', 'battery-empty', 'battery-full', 'battery-half', 'battery-quarter', 'battery-three-quarters', 'bed', 'beer', 'bell', 'bell-slash', 'bezier-curve', 'bicycle', 'binoculars', 'birthday-cake', 'blender', 'blind', 'bold', 'bolt', 'bomb', 'bone', 'bong', 'book', 'book-open', 'book-reader', 'bookmark', 'bowling-ball', 'box', 'box-open', 'boxes', 'braille', 'brain', 'briefcase', 'briefcase-medical', 'broadcast-tower', 'broom', 'brush', 'bug', 'building', 'bullhorn', 'bullseye', 'burn', 'bus', 'bus-alt', 'calculator', 'calendar', 'calendar-alt', 'calendar-check', 'calendar-minus', 'calendar-plus', 'calendar-times', 'camera', 'camera-retro', 'cannabis', 'capsules', 'car', 'car-alt', 'car-battery', 'car-crash', 'car-side', 'caret-down', 'caret-left', 'caret-right', 'caret-square-down', 'caret-square-left', 'caret-square-right', 'caret-square-up', 'caret-up', 'cart-arrow-down', 'cart-plus', 'certificate', 'chalkboard', 'chalkboard-teacher', 'charging-station', 'chart-area', 'chart-bar', 'chart-line', 'chart-pie', 'check', 'check-circle', 'check-double', 'check-square', 'chess', 'chess-bishop', 'chess-board', 'chess-king', 'chess-knight', 'chess-pawn', 'chess-queen', 'chess-rook', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'child', 'church', 'circle', 'circle-notch', 'clipboard', 'clipboard-check', 'clipboard-list', 'clock', 'clone', 'closed-captioning', 'cloud', 'cloud-download-alt', 'cloud-upload-alt', 'cocktail', 'code', 'code-branch', 'coffee', 'cog', 'cogs', 'coins', 'columns', 'comment', 'comment-alt', 'comment-dots', 'comment-slash', 'comments', 'compact-disc', 'compass', 'compress', 'concierge-bell', 'cookie', 'cookie-bite', 'copy', 'copyright', 'couch', 'credit-card', 'crop', 'crop-alt', 'crosshairs', 'crow', 'crown', 'cube', 'cubes', 'cut', 'database', 'deaf', 'desktop', 'diagnoses', 'dice', 'dice-five', 'dice-four', 'dice-one', 'dice-six', 'dice-three', 'dice-two', 'digital-tachograph', 'directions', 'divide', 'dizzy', 'dna', 'dollar-sign', 'dolly', 'dolly-flatbed', 'donate', 'door-closed', 'door-open', 'dot-circle', 'dove', 'download', 'drafting-compass', 'draw-polygon', 'drum', 'drum-steelpan', 'dumbbell', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-open', 'envelope-square', 'equals', 'eraser', 'euro-sign', 'exchange-alt', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'expand-arrows-alt', 'external-link-alt', 'external-link-square-alt', 'eye', 'eye-dropper', 'eye-slash', 'fast-backward', 'fast-forward', 'fax', 'feather', 'feather-alt', 'female', 'fighter-jet', 'file', 'file-alt', 'file-archive', 'file-audio', 'file-code', 'file-contract', 'file-download', 'file-excel', 'file-export', 'file-image', 'file-import', 'file-invoice', 'file-invoice-dollar', 'file-medical', 'file-medical-alt', 'file-pdf', 'file-powerpoint', 'file-prescription', 'file-signature', 'file-upload', 'file-video', 'file-word', 'fill', 'fill-drip', 'film', 'filter', 'fingerprint', 'fire', 'fire-extinguisher', 'first-aid', 'fish', 'flag', 'flag-checkered', 'flask', 'flushed', 'folder', 'folder-open', 'font', 'font-awesome-logo-full', 'football-ball', 'forward', 'frog', 'frown', 'frown-open', 'futbol', 'gamepad', 'gas-pump', 'gavel', 'gem', 'genderless', 'gift', 'glass-martini', 'glass-martini-alt', 'glasses', 'globe', 'globe-africa', 'globe-americas', 'globe-asia', 'golf-ball', 'graduation-cap', 'greater-than', 'greater-than-equal', 'grimace', 'grin', 'grin-alt', 'grin-beam', 'grin-beam-sweat', 'grin-hearts', 'grin-squint', 'grin-squint-tears', 'grin-stars', 'grin-tears', 'grin-tongue', 'grin-tongue-squint', 'grin-tongue-wink', 'grin-wink', 'grip-horizontal', 'grip-vertical', 'h-square', 'hand-holding', 'hand-holding-heart', 'hand-holding-usd', 'hand-lizard', 'hand-paper', 'hand-peace', 'hand-point-down', 'hand-point-left', 'hand-point-right', 'hand-point-up', 'hand-pointer', 'hand-rock', 'hand-scissors', 'hand-spock', 'hands', 'hands-helping', 'handshake', 'hashtag', 'hdd', 'heading', 'headphones', 'headphones-alt', 'headset', 'heart', 'heartbeat', 'helicopter', 'highlighter', 'history', 'hockey-puck', 'home', 'hospital', 'hospital-alt', 'hospital-symbol', 'hot-tub', 'hotel', 'hourglass', 'hourglass-end', 'hourglass-half', 'hourglass-start', 'i-cursor', 'id-badge', 'id-card', 'id-card-alt', 'image', 'images', 'inbox', 'indent', 'industry', 'infinity', 'info', 'info-circle', 'italic', 'joint', 'key', 'keyboard', 'kiss', 'kiss-beam', 'kiss-wink-heart', 'kiwi-bird', 'language', 'laptop', 'laptop-code', 'laugh', 'laugh-beam', 'laugh-squint', 'laugh-wink', 'layer-group', 'leaf', 'lemon', 'less-than', 'less-than-equal', 'level-down-alt', 'level-up-alt', 'life-ring', 'lightbulb', 'link', 'lira-sign', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'lock-open', 'long-arrow-alt-down', 'long-arrow-alt-left', 'long-arrow-alt-right', 'long-arrow-alt-up', 'low-vision', 'luggage-cart', 'magic', 'magnet', 'male', 'map', 'map-marked', 'map-marked-alt', 'map-marker', 'map-marker-alt', 'map-pin', 'map-signs', 'marker', 'mars', 'mars-double', 'mars-stroke', 'mars-stroke-h', 'mars-stroke-v', 'medal', 'medkit', 'meh', 'meh-blank', 'meh-rolling-eyes', 'memory', 'mercury', 'microchip', 'microphone', 'microphone-alt', 'microphone-alt-slash', 'microphone-slash', 'microscope', 'minus', 'minus-circle', 'minus-square', 'mobile', 'mobile-alt', 'money-bill', 'money-bill-alt', 'money-bill-wave', 'money-bill-wave-alt', 'money-check', 'money-check-alt', 'monument', 'moon', 'mortar-pestle', 'motorcycle', 'mouse-pointer', 'music', 'neuter', 'newspaper', 'not-equal', 'notes-medical', 'object-group', 'object-ungroup', 'oil-can', 'outdent', 'paint-brush', 'paint-roller', 'palette', 'pallet', 'paper-plane', 'paperclip', 'parachute-box', 'paragraph', 'parking', 'passport', 'paste', 'pause', 'pause-circle', 'paw', 'pen', 'pen-alt', 'pen-fancy', 'pen-nib', 'pen-square', 'pencil-alt', 'pencil-ruler', 'people-carry', 'percent', 'percentage', 'phone', 'phone-slash', 'phone-square', 'phone-volume', 'piggy-bank', 'pills', 'plane', 'plane-arrival', 'plane-departure', 'play', 'play-circle', 'plug', 'plus', 'plus-circle', 'plus-square', 'podcast', 'poo', 'poop', 'portrait', 'pound-sign', 'power-off', 'prescription', 'prescription-bottle', 'prescription-bottle-alt', 'print', 'procedures', 'project-diagram', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'quidditch', 'quote-left', 'quote-right', 'random', 'receipt', 'recycle', 'redo', 'redo-alt', 'registered', 'reply', 'reply-all', 'retweet', 'ribbon', 'road', 'robot', 'rocket', 'rss', 'rss-square', 'ruble-sign', 'ruler', 'ruler-combined', 'ruler-horizontal', 'ruler-vertical', 'rupee-sign', 'sad-cry', 'sad-tear', 'save', 'school', 'screwdriver', 'search', 'search-minus', 'search-plus', 'seedling', 'server', 'shapes', 'share', 'share-alt', 'share-alt-square', 'share-square', 'shekel-sign', 'shield-alt', 'ship', 'shipping-fast', 'shoe-prints', 'shopping-bag', 'shopping-basket', 'shopping-cart', 'shower', 'shuttle-van', 'sign', 'sign-in-alt', 'sign-language', 'sign-out-alt', 'signal', 'signature', 'sitemap', 'skull', 'sliders-h', 'smile', 'smile-beam', 'smile-wink', 'smoking', 'smoking-ban', 'snowflake', 'solar-panel', 'sort', 'sort-alpha-down', 'sort-alpha-up', 'sort-amount-down', 'sort-amount-up', 'sort-down', 'sort-numeric-down', 'sort-numeric-up', 'sort-up', 'spa', 'space-shuttle', 'spinner', 'splotch', 'spray-can', 'square', 'square-full', 'stamp', 'star', 'star-half', 'star-half-alt', 'star-of-life', 'step-backward', 'step-forward', 'stethoscope', 'sticky-note', 'stop', 'stop-circle', 'stopwatch', 'store', 'store-alt', 'stream', 'street-view', 'strikethrough', 'stroopwafel', 'subscript', 'subway', 'suitcase', 'suitcase-rolling', 'sun', 'superscript', 'surprise', 'swatchbook', 'swimmer', 'swimming-pool', 'sync', 'sync-alt', 'syringe', 'table', 'table-tennis', 'tablet', 'tablet-alt', 'tablets', 'tachometer-alt', 'tag', 'tags', 'tape', 'tasks', 'taxi', 'teeth', 'teeth-open', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'theater-masks', 'thermometer', 'thermometer-empty', 'thermometer-full', 'thermometer-half', 'thermometer-quarter', 'thermometer-three-quarters', 'thumbs-down', 'thumbs-up', 'thumbtack', 'ticket-alt', 'times', 'times-circle', 'tint', 'tint-slash', 'tired', 'toggle-off', 'toggle-on', 'toolbox', 'tooth', 'trademark', 'traffic-light', 'train', 'transgender', 'transgender-alt', 'trash', 'trash-alt', 'tree', 'trophy', 'truck', 'truck-loading', 'truck-monster', 'truck-moving', 'truck-pickup', 'tshirt', 'tty', 'tv', 'umbrella', 'umbrella-beach', 'underline', 'undo', 'undo-alt', 'universal-access', 'university', 'unlink', 'unlock', 'unlock-alt', 'upload', 'user', 'user-alt', 'user-alt-slash', 'user-astronaut', 'user-check', 'user-circle', 'user-clock', 'user-cog', 'user-edit', 'user-friends', 'user-graduate', 'user-lock', 'user-md', 'user-minus', 'user-ninja', 'user-plus', 'user-secret', 'user-shield', 'user-slash', 'user-tag', 'user-tie', 'user-times', 'users', 'users-cog', 'utensil-spoon', 'utensils', 'vector-square', 'venus', 'venus-double', 'venus-mars', 'vial', 'vials', 'video', 'video-slash', 'volleyball-ball', 'volume-down', 'volume-off', 'volume-up', 'walking', 'wallet', 'warehouse', 'weight', 'weight-hanging', 'wheelchair', 'wifi', 'window-close', 'window-maximize', 'window-minimize', 'window-restore', 'wine-glass', 'wine-glass-alt', 'won-sign', 'wrench', 'x-ray', 'yen-sign' );
    } else {
        $font_awesome_icons_array = array_unique( array_merge( memberlite_shortcodes_get_font_awesome_icons( 'brand' ), memberlite_shortcodes_get_font_awesome_icons( 'regular' ), memberlite_shortcodes_get_font_awesome_icons( 'solid' ) ) );
        asort( $font_awesome_icons_array );
        return $font_awesome_icons_array;
    }
}
