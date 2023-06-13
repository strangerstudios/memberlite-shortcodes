<?php
/*
Plugin Name: Memberlite Shortcodes
Plugin URI: https://memberlitetheme.com/memberlite-shortcodes/
Description: Shortcodes designed to work with the Memberlite Theme and Memberlite Child Themes.
Version: 1.3.7
Author: Stranger Studios
Author URI: https://memberlitetheme.com
Text Domain: memberlite-shortcodes
Domain Path: /languages
*/

define( 'MEMBERLITESC_DIR', dirname( __FILE__ ) );
define( 'MEMBERLITESC_URL', plugins_url( '', __FILE__ ) );
define( 'MEMBERLITESC_VERSION', '1.3.7' );

/**
 * Load text domain
 */
function memberlitesc_load_plugin_text_domain() {
	load_plugin_textdomain( 'memberlite-shortcodes', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'memberlitesc_load_plugin_text_domain' );

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
		wp_enqueue_script( 'memberlitesc-js-cookie', MEMBERLITESC_URL . '/js/js.cookie.min.js', array(), MEMBERLITESC_VERSION, true );
		wp_enqueue_script( 'memberlitesc_js', MEMBERLITESC_URL . '/js/memberlite-shortcodes.js', array( 'jquery' ), MEMBERLITESC_VERSION, true );
		wp_enqueue_style( 'memberlitesc_frontend', MEMBERLITESC_URL . '/css/memberlite-shortcodes.css', array(), MEMBERLITESC_VERSION );
		if ( ! defined( 'MEMBERLITE_VERSION' ) ) {
			wp_enqueue_style( 'memberlitesc_frontend_extras', MEMBERLITESC_URL . '/css/memberlite-shortcodes-extras.css', array(), MEMBERLITESC_VERSION );
			wp_enqueue_style( 'font-awesome', MEMBERLITESC_URL . '/font-awesome/css/all.min.css', array(), '6.4' );
		}
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
        return array( '42-group', '500px', 'accessible-icon', 'accusoft', 'adn', 'adversal', 'affiliatetheme', 'airbnb', 'algolia', 'alipay', 'amazon-pay', 'amazon', 'amilia', 'android', 'angellist', 'angrycreative', 'angular', 'app-store-ios', 'app-store', 'apper', 'apple-pay', 'apple', 'artstation', 'asymmetrik', 'atlassian', 'audible', 'autoprefixer', 'avianex', 'aviato', 'aws', 'bandcamp', 'battle-net', 'behance', 'bilibili', 'bimobject', 'bitbucket', 'bitcoin', 'bity', 'black-tie', 'blackberry', 'blogger-b', 'blogger', 'bluetooth-b', 'bluetooth', 'bootstrap', 'bots', 'btc', 'buffer', 'buromobelexperte', 'buy-n-large', 'buysellads', 'canadian-maple-leaf', 'cc-amazon-pay', 'cc-amex', 'cc-apple-pay', 'cc-diners-club', 'cc-discover', 'cc-jcb', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'centercode', 'centos', 'chrome', 'chromecast', 'cloudflare', 'cloudscale', 'cloudsmith', 'cloudversify', 'cmplid', 'codepen', 'codiepie', 'confluence', 'connectdevelop', 'contao', 'cotton-bureau', 'cpanel', 'creative-commons-by', 'creative-commons-nc-eu', 'creative-commons-nc-jp', 'creative-commons-nc', 'creative-commons-nd', 'creative-commons-pd-alt', 'creative-commons-pd', 'creative-commons-remix', 'creative-commons-sa', 'creative-commons-sampling-plus', 'creative-commons-sampling', 'creative-commons-share', 'creative-commons-zero', 'creative-commons', 'critical-role', 'css3-alt', 'css3', 'cuttlefish', 'd-and-d-beyond', 'd-and-d', 'dailymotion', 'dashcube', 'deezer', 'delicious', 'deploydog', 'deskpro', 'dev', 'deviantart', 'dhl', 'diaspora', 'digg', 'digital-ocean', 'discord', 'discourse', 'dochub', 'docker', 'draft2digital', 'dribbble', 'dropbox', 'drupal', 'dyalog', 'earlybirds', 'ebay', 'edge-legacy', 'edge', 'elementor', 'ello', 'ember', 'empire', 'envira', 'erlang', 'ethereum', 'etsy', 'evernote', 'expeditedssl', 'facebook-f', 'facebook-messenger', 'facebook', 'fantasy-flight-games', 'fedex', 'fedora', 'figma', 'firefox-browser', 'firefox', 'first-order-alt', 'first-order', 'firstdraft', 'flickr', 'flipboard', 'fly', 'font-awesome', 'fonticons-fi', 'fonticons', 'fort-awesome-alt', 'fort-awesome', 'forumbee', 'foursquare', 'free-code-camp', 'freebsd', 'fulcrum', 'galactic-republic', 'galactic-senate', 'get-pocket', 'gg-circle', 'gg', 'git-alt', 'git', 'github-alt', 'github', 'gitkraken', 'gitlab', 'gitter', 'glide-g', 'glide', 'gofore', 'golang', 'goodreads-g', 'goodreads', 'google-drive', 'google-pay', 'google-play', 'google-plus-g', 'google-plus', 'google-wallet', 'google', 'gratipay', 'grav', 'gripfire', 'grunt', 'guilded', 'gulp', 'hacker-news', 'hackerrank', 'hashnode', 'hips', 'hire-a-helper', 'hive', 'hooli', 'hornbill', 'hotjar', 'houzz', 'html5', 'hubspot', 'ideal', 'imdb', 'instagram', 'instalod', 'intercom', 'internet-explorer', 'invision', 'ioxhost', 'itch-io', 'itunes-note', 'itunes', 'java', 'jedi-order', 'jenkins', 'jira', 'joget', 'joomla', 'js', 'jsfiddle', 'kaggle', 'keybase', 'keycdn', 'kickstarter-k', 'kickstarter', 'korvue', 'laravel', 'lastfm', 'leanpub', 'less', 'line', 'linkedin-in', 'linkedin', 'linode', 'linux', 'lyft', 'magento', 'mailchimp', 'mandalorian', 'markdown', 'mastodon', 'maxcdn', 'mdb', 'medapps', 'medium', 'medrt', 'meetup', 'megaport', 'mendeley', 'meta', 'microblog', 'microsoft', 'mix', 'mixcloud', 'mixer', 'mizuni', 'modx', 'monero', 'napster', 'neos', 'nfc-directional', 'nfc-symbol', 'nimblr', 'node-js', 'node', 'npm', 'ns8', 'nutritionix', 'octopus-deploy', 'odnoklassniki', 'odysee', 'old-republic', 'opencart', 'openid', 'opera', 'optin-monster', 'orcid', 'osi', 'padlet', 'page4', 'pagelines', 'palfed', 'patreon', 'paypal', 'perbyte', 'periscope', 'phabricator', 'phoenix-framework', 'phoenix-squadron', 'php', 'pied-piper-alt', 'pied-piper-hat', 'pied-piper-pp', 'pied-piper', 'pinterest-p', 'pinterest', 'pix', 'playstation', 'product-hunt', 'pushed', 'python', 'qq', 'quinscape', 'quora', 'r-project', 'raspberry-pi', 'ravelry', 'react', 'reacteurope', 'readme', 'rebel', 'red-river', 'reddit-alien', 'reddit', 'redhat', 'renren', 'replyd', 'researchgate', 'resolving', 'rev', 'rocketchat', 'rockrms', 'rust', 'safari', 'salesforce', 'sass', 'schlix', 'screenpal', 'scribd', 'searchengin', 'sellcast', 'sellsy', 'servicestack', 'shirtsinbulk', 'shopify', 'shopware', 'simplybuilt', 'sistrix', 'sith', 'sitrox', 'sketch', 'skyatlas', 'skype', 'slack', 'slideshare', 'snapchat', 'soundcloud', 'sourcetree', 'space-awesome', 'speakap', 'speaker-deck', 'spotify', 'square-behance', 'square-dribbble', 'square-facebook', 'square-font-awesome-stroke', 'square-font-awesome', 'square-git', 'square-github', 'square-gitlab', 'square-google-plus', 'square-hacker-news', 'square-instagram', 'square-js', 'square-lastfm', 'square-odnoklassniki', 'square-pied-piper', 'square-pinterest', 'square-reddit', 'square-snapchat', 'square-steam', 'square-tumblr', 'square-twitter', 'square-viadeo', 'square-vimeo', 'square-whatsapp', 'square-xing', 'square-youtube', 'squarespace', 'stack-exchange', 'stack-overflow', 'stackpath', 'staylinked', 'steam-symbol', 'steam', 'sticker-mule', 'strava', 'stripe-s', 'stripe', 'stubber', 'studiovinari', 'stumbleupon-circle', 'stumbleupon', 'superpowers', 'supple', 'suse', 'swift', 'symfony', 'teamspeak', 'telegram', 'tencent-weibo', 'the-red-yeti', 'themeco', 'themeisle', 'think-peaks', 'tiktok', 'trade-federation', 'trello', 'tumblr', 'twitch', 'twitter', 'typo3', 'uber', 'ubuntu', 'uikit', 'umbraco', 'uncharted', 'uniregistry', 'unity', 'unsplash', 'untappd', 'ups', 'usb', 'usps', 'ussunnah', 'vaadin', 'viacoin', 'viadeo', 'viber', 'vimeo-v', 'vimeo', 'vine', 'vk', 'vnv', 'vuejs', 'watchman-monitoring', 'waze', 'weebly', 'weibo', 'weixin', 'whatsapp', 'whmcs', 'wikipedia-w', 'windows', 'wirsindhandwerk', 'wix', 'wizards-of-the-coast', 'wodu', 'wolf-pack-battalion', 'wordpress-simple', 'wordpress', 'wpbeginner', 'wpexplorer', 'wpforms', 'wpressr', 'xbox', 'xing', 'y-combinator', 'yahoo', 'yammer', 'yandex-international', 'yandex', 'yarn', 'yelp', 'yoast', 'youtube', 'zhihu' );
    } elseif ( $type === 'regular' ) {
        return array( 'address-book', 'address-card', 'bell-slash', 'bell', 'bookmark', 'building', 'calendar-check', 'calendar-days', 'calendar-minus', 'calendar-plus', 'calendar-xmark', 'calendar', 'chart-bar', 'chess-bishop', 'chess-king', 'chess-knight', 'chess-pawn', 'chess-queen', 'chess-rook', 'circle-check', 'circle-dot', 'circle-down', 'circle-left', 'circle-pause', 'circle-play', 'circle-question', 'circle-right', 'circle-stop', 'circle-up', 'circle-user', 'circle-xmark', 'circle', 'clipboard', 'clock', 'clone', 'closed-captioning', 'comment-dots', 'comment', 'comments', 'compass', 'copy', 'copyright', 'credit-card', 'envelope-open', 'envelope', 'eye-slash', 'eye', 'face-angry', 'face-dizzy', 'face-flushed', 'face-frown-open', 'face-frown', 'face-grimace', 'face-grin-beam-sweat', 'face-grin-beam', 'face-grin-hearts', 'face-grin-squint-tears', 'face-grin-squint', 'face-grin-stars', 'face-grin-tears', 'face-grin-tongue-squint', 'face-grin-tongue-wink', 'face-grin-tongue', 'face-grin-wide', 'face-grin-wink', 'face-grin', 'face-kiss-beam', 'face-kiss-wink-heart', 'face-kiss', 'face-laugh-beam', 'face-laugh-squint', 'face-laugh-wink', 'face-laugh', 'face-meh-blank', 'face-meh', 'face-rolling-eyes', 'face-sad-cry', 'face-sad-tear', 'face-smile-beam', 'face-smile-wink', 'face-smile', 'face-surprise', 'face-tired', 'file-audio', 'file-code', 'file-excel', 'file-image', 'file-lines', 'file-pdf', 'file-powerpoint', 'file-video', 'file-word', 'file-zipper', 'file', 'flag', 'floppy-disk', 'folder-closed', 'folder-open', 'folder', 'font-awesome', 'futbol', 'gem', 'hand-back-fist', 'hand-lizard', 'hand-peace', 'hand-point-down', 'hand-point-left', 'hand-point-right', 'hand-point-up', 'hand-pointer', 'hand-scissors', 'hand-spock', 'hand', 'handshake', 'hard-drive', 'heart', 'hospital', 'hourglass-half', 'hourglass', 'id-badge', 'id-card', 'image', 'images', 'keyboard', 'lemon', 'life-ring', 'lightbulb', 'map', 'message', 'money-bill-1', 'moon', 'newspaper', 'note-sticky', 'object-group', 'object-ungroup', 'paper-plane', 'paste', 'pen-to-square', 'rectangle-list', 'rectangle-xmark', 'registered', 'share-from-square', 'snowflake', 'square-caret-down', 'square-caret-left', 'square-caret-right', 'square-caret-up', 'square-check', 'square-full', 'square-minus', 'square-plus', 'square', 'star-half-stroke', 'star-half', 'star', 'sun', 'thumbs-down', 'thumbs-up', 'trash-can', 'user', 'window-maximize', 'window-minimize', 'window-restore' );
    } elseif ( $type === 'solid' ) {
        return array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'address-book', 'address-card', 'align-center', 'align-justify', 'align-left', 'align-right', 'anchor-circle-check', 'anchor-circle-exclamation', 'anchor-circle-xmark', 'anchor-lock', 'anchor', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'angles-down', 'angles-left', 'angles-right', 'angles-up', 'ankh', 'apple-whole', 'archway', 'arrow-down-1-9', 'arrow-down-9-1', 'arrow-down-a-z', 'arrow-down-long', 'arrow-down-short-wide', 'arrow-down-up-across-line', 'arrow-down-up-lock', 'arrow-down-wide-short', 'arrow-down-z-a', 'arrow-down', 'arrow-left-long', 'arrow-left', 'arrow-pointer', 'arrow-right-arrow-left', 'arrow-right-from-bracket', 'arrow-right-long', 'arrow-right-to-bracket', 'arrow-right-to-city', 'arrow-right', 'arrow-rotate-left', 'arrow-rotate-right', 'arrow-trend-down', 'arrow-trend-up', 'arrow-turn-down', 'arrow-turn-up', 'arrow-up-1-9', 'arrow-up-9-1', 'arrow-up-a-z', 'arrow-up-from-bracket', 'arrow-up-from-ground-water', 'arrow-up-from-water-pump', 'arrow-up-long', 'arrow-up-right-dots', 'arrow-up-right-from-square', 'arrow-up-short-wide', 'arrow-up-wide-short', 'arrow-up-z-a', 'arrow-up', 'arrows-down-to-line', 'arrows-down-to-people', 'arrows-left-right-to-line', 'arrows-left-right', 'arrows-rotate', 'arrows-spin', 'arrows-split-up-and-left', 'arrows-to-circle', 'arrows-to-dot', 'arrows-to-eye', 'arrows-turn-right', 'arrows-turn-to-dots', 'arrows-up-down-left-right', 'arrows-up-down', 'arrows-up-to-line', 'asterisk', 'at', 'atom', 'audio-description', 'austral-sign', 'award', 'b', 'baby-carriage', 'baby', 'backward-fast', 'backward-step', 'backward', 'bacon', 'bacteria', 'bacterium', 'bag-shopping', 'bahai', 'baht-sign', 'ban-smoking', 'ban', 'bandage', 'bangladeshi-taka-sign', 'barcode', 'bars-progress', 'bars-staggered', 'bars', 'baseball-bat-ball', 'baseball', 'basket-shopping', 'basketball', 'bath', 'battery-empty', 'battery-full', 'battery-half', 'battery-quarter', 'battery-three-quarters', 'bed-pulse', 'bed', 'beer-mug-empty', 'bell-concierge', 'bell-slash', 'bell', 'bezier-curve', 'bicycle', 'binoculars', 'biohazard', 'bitcoin-sign', 'blender-phone', 'blender', 'blog', 'bold', 'bolt-lightning', 'bolt', 'bomb', 'bone', 'bong', 'book-atlas', 'book-bible', 'book-bookmark', 'book-journal-whills', 'book-medical', 'book-open-reader', 'book-open', 'book-quran', 'book-skull', 'book-tanakh', 'book', 'bookmark', 'border-all', 'border-none', 'border-top-left', 'bore-hole', 'bottle-droplet', 'bottle-water', 'bowl-food', 'bowl-rice', 'bowling-ball', 'box-archive', 'box-open', 'box-tissue', 'box', 'boxes-packing', 'boxes-stacked', 'braille', 'brain', 'brazilian-real-sign', 'bread-slice', 'bridge-circle-check', 'bridge-circle-exclamation', 'bridge-circle-xmark', 'bridge-lock', 'bridge-water', 'bridge', 'briefcase-medical', 'briefcase', 'broom-ball', 'broom', 'brush', 'bucket', 'bug-slash', 'bug', 'bugs', 'building-circle-arrow-right', 'building-circle-check', 'building-circle-exclamation', 'building-circle-xmark', 'building-columns', 'building-flag', 'building-lock', 'building-ngo', 'building-shield', 'building-un', 'building-user', 'building-wheat', 'building', 'bullhorn', 'bullseye', 'burger', 'burst', 'bus-simple', 'bus', 'business-time', 'c', 'cable-car', 'cake-candles', 'calculator', 'calendar-check', 'calendar-day', 'calendar-days', 'calendar-minus', 'calendar-plus', 'calendar-week', 'calendar-xmark', 'calendar', 'camera-retro', 'camera-rotate', 'camera', 'campground', 'candy-cane', 'cannabis', 'capsules', 'car-battery', 'car-burst', 'car-on', 'car-rear', 'car-side', 'car-tunnel', 'car', 'caravan', 'caret-down', 'caret-left', 'caret-right', 'caret-up', 'carrot', 'cart-arrow-down', 'cart-flatbed-suitcase', 'cart-flatbed', 'cart-plus', 'cart-shopping', 'cash-register', 'cat', 'cedi-sign', 'cent-sign', 'certificate', 'chair', 'chalkboard-user', 'chalkboard', 'champagne-glasses', 'charging-station', 'chart-area', 'chart-bar', 'chart-column', 'chart-gantt', 'chart-line', 'chart-pie', 'chart-simple', 'check-double', 'check-to-slot', 'check', 'cheese', 'chess-bishop', 'chess-board', 'chess-king', 'chess-knight', 'chess-pawn', 'chess-queen', 'chess-rook', 'chess', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'child-combatant', 'child-dress', 'child-reaching', 'child', 'children', 'church', 'circle-arrow-down', 'circle-arrow-left', 'circle-arrow-right', 'circle-arrow-up', 'circle-check', 'circle-chevron-down', 'circle-chevron-left', 'circle-chevron-right', 'circle-chevron-up', 'circle-dollar-to-slot', 'circle-dot', 'circle-down', 'circle-exclamation', 'circle-h', 'circle-half-stroke', 'circle-info', 'circle-left', 'circle-minus', 'circle-nodes', 'circle-notch', 'circle-pause', 'circle-play', 'circle-plus', 'circle-question', 'circle-radiation', 'circle-right', 'circle-stop', 'circle-up', 'circle-user', 'circle-xmark', 'circle', 'city', 'clapperboard', 'clipboard-check', 'clipboard-list', 'clipboard-question', 'clipboard-user', 'clipboard', 'clock-rotate-left', 'clock', 'clone', 'closed-captioning', 'cloud-arrow-down', 'cloud-arrow-up', 'cloud-bolt', 'cloud-meatball', 'cloud-moon-rain', 'cloud-moon', 'cloud-rain', 'cloud-showers-heavy', 'cloud-showers-water', 'cloud-sun-rain', 'cloud-sun', 'cloud', 'clover', 'code-branch', 'code-commit', 'code-compare', 'code-fork', 'code-merge', 'code-pull-request', 'code', 'coins', 'colon-sign', 'comment-dollar', 'comment-dots', 'comment-medical', 'comment-slash', 'comment-sms', 'comment', 'comments-dollar', 'comments', 'compact-disc', 'compass-drafting', 'compass', 'compress', 'computer-mouse', 'computer', 'cookie-bite', 'cookie', 'copy', 'copyright', 'couch', 'cow', 'credit-card', 'crop-simple', 'crop', 'cross', 'crosshairs', 'crow', 'crown', 'crutch', 'cruzeiro-sign', 'cube', 'cubes-stacked', 'cubes', 'd', 'database', 'delete-left', 'democrat', 'desktop', 'dharmachakra', 'diagram-next', 'diagram-predecessor', 'diagram-project', 'diagram-successor', 'diamond-turn-right', 'diamond', 'dice-d6', 'dice-d20', 'dice-five', 'dice-four', 'dice-one', 'dice-six', 'dice-three', 'dice-two', 'dice', 'disease', 'display', 'divide', 'dna', 'dog', 'dollar-sign', 'dolly', 'dong-sign', 'door-closed', 'door-open', 'dove', 'down-left-and-up-right-to-center', 'down-long', 'download', 'dragon', 'draw-polygon', 'droplet-slash', 'droplet', 'drum-steelpan', 'drum', 'drumstick-bite', 'dumbbell', 'dumpster-fire', 'dumpster', 'dungeon', 'e', 'ear-deaf', 'ear-listen', 'earth-africa', 'earth-americas', 'earth-asia', 'earth-europe', 'earth-oceania', 'egg', 'eject', 'elevator', 'ellipsis-vertical', 'ellipsis', 'envelope-circle-check', 'envelope-open-text', 'envelope-open', 'envelope', 'envelopes-bulk', 'equals', 'eraser', 'ethernet', 'euro-sign', 'exclamation', 'expand', 'explosion', 'eye-dropper', 'eye-low-vision', 'eye-slash', 'eye', 'f', 'face-angry', 'face-dizzy', 'face-flushed', 'face-frown-open', 'face-frown', 'face-grimace', 'face-grin-beam-sweat', 'face-grin-beam', 'face-grin-hearts', 'face-grin-squint-tears', 'face-grin-squint', 'face-grin-stars', 'face-grin-tears', 'face-grin-tongue-squint', 'face-grin-tongue-wink', 'face-grin-tongue', 'face-grin-wide', 'face-grin-wink', 'face-grin', 'face-kiss-beam', 'face-kiss-wink-heart', 'face-kiss', 'face-laugh-beam', 'face-laugh-squint', 'face-laugh-wink', 'face-laugh', 'face-meh-blank', 'face-meh', 'face-rolling-eyes', 'face-sad-cry', 'face-sad-tear', 'face-smile-beam', 'face-smile-wink', 'face-smile', 'face-surprise', 'face-tired', 'fan', 'faucet-drip', 'faucet', 'fax', 'feather-pointed', 'feather', 'ferry', 'file-arrow-down', 'file-arrow-up', 'file-audio', 'file-circle-check', 'file-circle-exclamation', 'file-circle-minus', 'file-circle-plus', 'file-circle-question', 'file-circle-xmark', 'file-code', 'file-contract', 'file-csv', 'file-excel', 'file-export', 'file-image', 'file-import', 'file-invoice-dollar', 'file-invoice', 'file-lines', 'file-medical', 'file-pdf', 'file-pen', 'file-powerpoint', 'file-prescription', 'file-shield', 'file-signature', 'file-video', 'file-waveform', 'file-word', 'file-zipper', 'file', 'fill-drip', 'fill', 'film', 'filter-circle-dollar', 'filter-circle-xmark', 'filter', 'fingerprint', 'fire-burner', 'fire-extinguisher', 'fire-flame-curved', 'fire-flame-simple', 'fire', 'fish-fins', 'fish', 'flag-checkered', 'flag-usa', 'flag', 'flask-vial', 'flask', 'floppy-disk', 'florin-sign', 'folder-closed', 'folder-minus', 'folder-open', 'folder-plus', 'folder-tree', 'folder', 'font-awesome', 'font', 'football', 'forward-fast', 'forward-step', 'forward', 'franc-sign', 'frog', 'futbol', 'g', 'gamepad', 'gas-pump', 'gauge-high', 'gauge-simple-high', 'gauge-simple', 'gauge', 'gavel', 'gear', 'gears', 'gem', 'genderless', 'ghost', 'gift', 'gifts', 'glass-water-droplet', 'glass-water', 'glasses', 'globe', 'golf-ball-tee', 'gopuram', 'graduation-cap', 'greater-than-equal', 'greater-than', 'grip-lines-vertical', 'grip-lines', 'grip-vertical', 'grip', 'group-arrows-rotate', 'guarani-sign', 'guitar', 'gun', 'h', 'hammer', 'hamsa', 'hand-back-fist', 'hand-dots', 'hand-fist', 'hand-holding-dollar', 'hand-holding-droplet', 'hand-holding-hand', 'hand-holding-heart', 'hand-holding-medical', 'hand-holding', 'hand-lizard', 'hand-middle-finger', 'hand-peace', 'hand-point-down', 'hand-point-left', 'hand-point-right', 'hand-point-up', 'hand-pointer', 'hand-scissors', 'hand-sparkles', 'hand-spock', 'hand', 'handcuffs', 'hands-asl-interpreting', 'hands-bound', 'hands-bubbles', 'hands-clapping', 'hands-holding-child', 'hands-holding-circle', 'hands-holding', 'hands-praying', 'hands', 'handshake-angle', 'handshake-simple-slash', 'handshake-simple', 'handshake-slash', 'handshake', 'hanukiah', 'hard-drive', 'hashtag', 'hat-cowboy-side', 'hat-cowboy', 'hat-wizard', 'head-side-cough-slash', 'head-side-cough', 'head-side-mask', 'head-side-virus', 'heading', 'headphones-simple', 'headphones', 'headset', 'heart-circle-bolt', 'heart-circle-check', 'heart-circle-exclamation', 'heart-circle-minus', 'heart-circle-plus', 'heart-circle-xmark', 'heart-crack', 'heart-pulse', 'heart', 'helicopter-symbol', 'helicopter', 'helmet-safety', 'helmet-un', 'highlighter', 'hill-avalanche', 'hill-rockslide', 'hippo', 'hockey-puck', 'holly-berry', 'horse-head', 'horse', 'hospital-user', 'hospital', 'hot-tub-person', 'hotdog', 'hotel', 'hourglass-end', 'hourglass-half', 'hourglass-start', 'hourglass', 'house-chimney-crack', 'house-chimney-medical', 'house-chimney-user', 'house-chimney-window', 'house-chimney', 'house-circle-check', 'house-circle-exclamation', 'house-circle-xmark', 'house-crack', 'house-fire', 'house-flag', 'house-flood-water-circle-arrow-right', 'house-flood-water', 'house-laptop', 'house-lock', 'house-medical-circle-check', 'house-medical-circle-exclamation', 'house-medical-circle-xmark', 'house-medical-flag', 'house-medical', 'house-signal', 'house-tsunami', 'house-user', 'house', 'hryvnia-sign', 'hurricane', 'i-cursor', 'i', 'ice-cream', 'icicles', 'icons', 'id-badge', 'id-card-clip', 'id-card', 'igloo', 'image-portrait', 'image', 'images', 'inbox', 'indent', 'indian-rupee-sign', 'industry', 'infinity', 'info', 'italic', 'j', 'jar-wheat', 'jar', 'jedi', 'jet-fighter-up', 'jet-fighter', 'joint', 'jug-detergent', 'k', 'kaaba', 'key', 'keyboard', 'khanda', 'kip-sign', 'kit-medical', 'kitchen-set', 'kiwi-bird', 'l', 'land-mine-on', 'landmark-dome', 'landmark-flag', 'landmark', 'language', 'laptop-code', 'laptop-file', 'laptop-medical', 'laptop', 'lari-sign', 'layer-group', 'leaf', 'left-long', 'left-right', 'lemon', 'less-than-equal', 'less-than', 'life-ring', 'lightbulb', 'lines-leaning', 'link-slash', 'link', 'lira-sign', 'list-check', 'list-ol', 'list-ul', 'list', 'litecoin-sign', 'location-arrow', 'location-crosshairs', 'location-dot', 'location-pin-lock', 'location-pin', 'lock-open', 'lock', 'locust', 'lungs-virus', 'lungs', 'm', 'magnet', 'magnifying-glass-arrow-right', 'magnifying-glass-chart', 'magnifying-glass-dollar', 'magnifying-glass-location', 'magnifying-glass-minus', 'magnifying-glass-plus', 'magnifying-glass', 'manat-sign', 'map-location-dot', 'map-location', 'map-pin', 'map', 'marker', 'mars-and-venus-burst', 'mars-and-venus', 'mars-double', 'mars-stroke-right', 'mars-stroke-up', 'mars-stroke', 'mars', 'martini-glass-citrus', 'martini-glass-empty', 'martini-glass', 'mask-face', 'mask-ventilator', 'mask', 'masks-theater', 'mattress-pillow', 'maximize', 'medal', 'memory', 'menorah', 'mercury', 'message', 'meteor', 'microchip', 'microphone-lines-slash', 'microphone-lines', 'microphone-slash', 'microphone', 'microscope', 'mill-sign', 'minimize', 'minus', 'mitten', 'mobile-button', 'mobile-retro', 'mobile-screen-button', 'mobile-screen', 'mobile', 'money-bill-1-wave', 'money-bill-1', 'money-bill-transfer', 'money-bill-trend-up', 'money-bill-wave', 'money-bill-wheat', 'money-bill', 'money-bills', 'money-check-dollar', 'money-check', 'monument', 'moon', 'mortar-pestle', 'mosque', 'mosquito-net', 'mosquito', 'motorcycle', 'mound', 'mountain-city', 'mountain-sun', 'mountain', 'mug-hot', 'mug-saucer', 'music', 'n', 'naira-sign', 'network-wired', 'neuter', 'newspaper', 'not-equal', 'notdef', 'note-sticky', 'notes-medical', 'o', 'object-group', 'object-ungroup', 'oil-can', 'oil-well', 'om', 'otter', 'outdent', 'p', 'pager', 'paint-roller', 'paintbrush', 'palette', 'pallet', 'panorama', 'paper-plane', 'paperclip', 'parachute-box', 'paragraph', 'passport', 'paste', 'pause', 'paw', 'peace', 'pen-clip', 'pen-fancy', 'pen-nib', 'pen-ruler', 'pen-to-square', 'pen', 'pencil', 'people-arrows', 'people-carry-box', 'people-group', 'people-line', 'people-pulling', 'people-robbery', 'people-roof', 'pepper-hot', 'percent', 'person-arrow-down-to-line', 'person-arrow-up-from-line', 'person-biking', 'person-booth', 'person-breastfeeding', 'person-burst', 'person-cane', 'person-chalkboard', 'person-circle-check', 'person-circle-exclamation', 'person-circle-minus', 'person-circle-plus', 'person-circle-question', 'person-circle-xmark', 'person-digging', 'person-dots-from-line', 'person-dress-burst', 'person-dress', 'person-drowning', 'person-falling-burst', 'person-falling', 'person-half-dress', 'person-harassing', 'person-hiking', 'person-military-pointing', 'person-military-rifle', 'person-military-to-person', 'person-praying', 'person-pregnant', 'person-rays', 'person-rifle', 'person-running', 'person-shelter', 'person-skating', 'person-skiing-nordic', 'person-skiing', 'person-snowboarding', 'person-swimming', 'person-through-window', 'person-walking-arrow-loop-left', 'person-walking-arrow-right', 'person-walking-dashed-line-arrow-right', 'person-walking-luggage', 'person-walking-with-cane', 'person-walking', 'person', 'peseta-sign', 'peso-sign', 'phone-flip', 'phone-slash', 'phone-volume', 'phone', 'photo-film', 'piggy-bank', 'pills', 'pizza-slice', 'place-of-worship', 'plane-arrival', 'plane-circle-check', 'plane-circle-exclamation', 'plane-circle-xmark', 'plane-departure', 'plane-lock', 'plane-slash', 'plane-up', 'plane', 'plant-wilt', 'plate-wheat', 'play', 'plug-circle-bolt', 'plug-circle-check', 'plug-circle-exclamation', 'plug-circle-minus', 'plug-circle-plus', 'plug-circle-xmark', 'plug', 'plus-minus', 'plus', 'podcast', 'poo-storm', 'poo', 'poop', 'power-off', 'prescription-bottle-medical', 'prescription-bottle', 'prescription', 'print', 'pump-medical', 'pump-soap', 'puzzle-piece', 'q', 'qrcode', 'question', 'quote-left', 'quote-right', 'r', 'radiation', 'radio', 'rainbow', 'ranking-star', 'receipt', 'record-vinyl', 'rectangle-ad', 'rectangle-list', 'rectangle-xmark', 'recycle', 'registered', 'repeat', 'reply-all', 'reply', 'republican', 'restroom', 'retweet', 'ribbon', 'right-from-bracket', 'right-left', 'right-long', 'right-to-bracket', 'ring', 'road-barrier', 'road-bridge', 'road-circle-check', 'road-circle-exclamation', 'road-circle-xmark', 'road-lock', 'road-spikes', 'road', 'robot', 'rocket', 'rotate-left', 'rotate-right', 'rotate', 'route', 'rss', 'ruble-sign', 'rug', 'ruler-combined', 'ruler-horizontal', 'ruler-vertical', 'ruler', 'rupee-sign', 'rupiah-sign', 's', 'sack-dollar', 'sack-xmark', 'sailboat', 'satellite-dish', 'satellite', 'scale-balanced', 'scale-unbalanced-flip', 'scale-unbalanced', 'school-circle-check', 'school-circle-exclamation', 'school-circle-xmark', 'school-flag', 'school-lock', 'school', 'scissors', 'screwdriver-wrench', 'screwdriver', 'scroll-torah', 'scroll', 'sd-card', 'section', 'seedling', 'server', 'shapes', 'share-from-square', 'share-nodes', 'share', 'sheet-plastic', 'shekel-sign', 'shield-cat', 'shield-dog', 'shield-halved', 'shield-heart', 'shield-virus', 'shield', 'ship', 'shirt', 'shoe-prints', 'shop-lock', 'shop-slash', 'shop', 'shower', 'shrimp', 'shuffle', 'shuttle-space', 'sign-hanging', 'signal', 'signature', 'signs-post', 'sim-card', 'sink', 'sitemap', 'skull-crossbones', 'skull', 'slash', 'sleigh', 'sliders', 'smog', 'smoking', 'snowflake', 'snowman', 'snowplow', 'soap', 'socks', 'solar-panel', 'sort-down', 'sort-up', 'sort', 'spa', 'spaghetti-monster-flying', 'spell-check', 'spider', 'spinner', 'splotch', 'spoon', 'spray-can-sparkles', 'spray-can', 'square-arrow-up-right', 'square-caret-down', 'square-caret-left', 'square-caret-right', 'square-caret-up', 'square-check', 'square-envelope', 'square-full', 'square-h', 'square-minus', 'square-nfi', 'square-parking', 'square-pen', 'square-person-confined', 'square-phone-flip', 'square-phone', 'square-plus', 'square-poll-horizontal', 'square-poll-vertical', 'square-root-variable', 'square-rss', 'square-share-nodes', 'square-up-right', 'square-virus', 'square-xmark', 'square', 'staff-snake', 'stairs', 'stamp', 'stapler', 'star-and-crescent', 'star-half-stroke', 'star-half', 'star-of-david', 'star-of-life', 'star', 'sterling-sign', 'stethoscope', 'stop', 'stopwatch-20', 'stopwatch', 'store-slash', 'store', 'street-view', 'strikethrough', 'stroopwafel', 'subscript', 'suitcase-medical', 'suitcase-rolling', 'suitcase', 'sun-plant-wilt', 'sun', 'superscript', 'swatchbook', 'synagogue', 'syringe', 't', 'table-cells-large', 'table-cells', 'table-columns', 'table-list', 'table-tennis-paddle-ball', 'table', 'tablet-button', 'tablet-screen-button', 'tablet', 'tablets', 'tachograph-digital', 'tag', 'tags', 'tape', 'tarp-droplet', 'tarp', 'taxi', 'teeth-open', 'teeth', 'temperature-arrow-down', 'temperature-arrow-up', 'temperature-empty', 'temperature-full', 'temperature-half', 'temperature-high', 'temperature-low', 'temperature-quarter', 'temperature-three-quarters', 'tenge-sign', 'tent-arrow-down-to-line', 'tent-arrow-left-right', 'tent-arrow-turn-left', 'tent-arrows-down', 'tent', 'tents', 'terminal', 'text-height', 'text-slash', 'text-width', 'thermometer', 'thumbs-down', 'thumbs-up', 'thumbtack', 'ticket-simple', 'ticket', 'timeline', 'toggle-off', 'toggle-on', 'toilet-paper-slash', 'toilet-paper', 'toilet-portable', 'toilet', 'toilets-portable', 'toolbox', 'tooth', 'torii-gate', 'tornado', 'tower-broadcast', 'tower-cell', 'tower-observation', 'tractor', 'trademark', 'traffic-light', 'trailer', 'train-subway', 'train-tram', 'train', 'transgender', 'trash-arrow-up', 'trash-can-arrow-up', 'trash-can', 'trash', 'tree-city', 'tree', 'triangle-exclamation', 'trophy', 'trowel-bricks', 'trowel', 'truck-arrow-right', 'truck-droplet', 'truck-fast', 'truck-field-un', 'truck-field', 'truck-front', 'truck-medical', 'truck-monster', 'truck-moving', 'truck-pickup', 'truck-plane', 'truck-ramp-box', 'truck', 'tty', 'turkish-lira-sign', 'turn-down', 'turn-up', 'tv', 'u', 'umbrella-beach', 'umbrella', 'underline', 'universal-access', 'unlock-keyhole', 'unlock', 'up-down-left-right', 'up-down', 'up-long', 'up-right-and-down-left-from-center', 'up-right-from-square', 'upload', 'user-astronaut', 'user-check', 'user-clock', 'user-doctor', 'user-gear', 'user-graduate', 'user-group', 'user-injured', 'user-large-slash', 'user-large', 'user-lock', 'user-minus', 'user-ninja', 'user-nurse', 'user-pen', 'user-plus', 'user-secret', 'user-shield', 'user-slash', 'user-tag', 'user-tie', 'user-xmark', 'user', 'users-between-lines', 'users-gear', 'users-line', 'users-rays', 'users-rectangle', 'users-slash', 'users-viewfinder', 'users', 'utensils', 'v', 'van-shuttle', 'vault', 'vector-square', 'venus-double', 'venus-mars', 'venus', 'vest-patches', 'vest', 'vial-circle-check', 'vial-virus', 'vial', 'vials', 'video-slash', 'video', 'vihara', 'virus-covid-slash', 'virus-covid', 'virus-slash', 'virus', 'viruses', 'voicemail', 'volcano', 'volleyball', 'volume-high', 'volume-low', 'volume-off', 'volume-xmark', 'vr-cardboard', 'w', 'walkie-talkie', 'wallet', 'wand-magic-sparkles', 'wand-magic', 'wand-sparkles', 'warehouse', 'water-ladder', 'water', 'wave-square', 'weight-hanging', 'weight-scale', 'wheat-awn-circle-exclamation', 'wheat-awn', 'wheelchair-move', 'wheelchair', 'whiskey-glass', 'wifi', 'wind', 'window-maximize', 'window-minimize', 'window-restore', 'wine-bottle', 'wine-glass-empty', 'wine-glass', 'won-sign', 'worm', 'wrench', 'x-ray', 'x', 'xmark', 'xmarks-lines', 'y', 'yen-sign', 'yin-yang', 'z' );
	} else {
		$font_awesome_icons_array = array_unique( array_merge( memberlite_shortcodes_get_font_awesome_icons( 'brand' ), memberlite_shortcodes_get_font_awesome_icons( 'regular' ), memberlite_shortcodes_get_font_awesome_icons( 'solid' ) ) );
		asort( $font_awesome_icons_array );
		return $font_awesome_icons_array;
	}
}
