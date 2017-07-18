<?php
/*
Plugin Name: Microthemer
Plugin URI: http://www.themeover.com/microthemer
Text Domain: microthemer
Domain Path: /languages
Description: Microthemer is a feature-rich visual design plugin for customizing the appearance of ANY WordPress Theme or Plugin Content (e.g. posts, pages, contact forms, headers, footers, sidebars) down to the smallest detail (unlike typical theme options). For CSS coders, Microthemer is a proficiency tool that allows them to rapidly restyle a WordPress theme or plugin. For non-coders, Microthemer's intuitive interface and "Double-click to Edit" feature opens the door to advanced theme and plugin customization.
Version: 5.0.0.2
Author: Themeover
Author URI: http://www.themeover.com
*/

/* Copyright 2012 by Sebastian Webb @ Themeover */


// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Please do not call this page directly.');
}

// define active
if (!defined('MT_IS_ACTIVE')) {
	define('MT_IS_ACTIVE', true);
}

// define plugin variation
if (!defined('TVR_MICRO_VARIANT')) {
	define('TVR_MICRO_VARIANT', 'themer');
}

// define dev mode
if (!defined('TVR_DEV_MODE')) {
	define('TVR_DEV_MODE', false);
}

// define debug data mode
if (!defined('TVR_DEBUG_DATA')) {
	define('TVR_DEBUG_DATA', false);
}

// define unique id for media query keys
if (!defined('UNQ_BASE')) {
	define('UNQ_BASE', uniqid());
}


// common class for data needed by front and admin
if (!class_exists('tvr_common')) {
	class tvr_common {
		public static function get_custom_code(){
			return array(
				'hand_coded_css' => array (
					'tab-key' => 'all-browsers',
					'label' => esc_html__('All Browsers', 'microthemer'),
					'type' => 'css'
				),
				'ie_css' => array(
					'all' => array (
						'tab-key' => 'all',
						'label' => esc_html__('All versions of IE', 'microthemer'),
						'cond' => 'IE',
						'type' => 'css'
					),
					'nine' => array (
						'tab-key' => 'nine',
						'label' => esc_html__('IE9 and below', 'microthemer'),
						'cond' => 'lte IE 9',
						'type' => 'css'
					),
					'eight' => array (
						'tab-key' => 'eight',
						'label' => esc_html__('IE8 and below', 'microthemer'),
						'cond' => 'lte IE 8',
						'type' => 'css'
					),
					'seven' => array (
						'tab-key' => 'seven',
						'label' => esc_html__('IE7 and below', 'microthemer'),
						'cond' => 'lte IE 7',
						'type' => 'css'
					),
				),
				'js' => array (
					'tab-key' => 'js',
					'label' => esc_html__('JavaScript', 'microthemer'),
					'type' => 'javascript'
				),
			);
		}
	}
}

// only run plugin admin code on admin pages
if ( is_admin() ) {

	// admin class
	if (!class_exists('tvr_microthemer_admin')) {

		// define
		class tvr_microthemer_admin {

			var $version = '5.0.0.2';
			var $db_chg_in_ver = '4.8.9';
			var $locale = '';
			var $time = 0;
			var $current_user_id = -1;
			// set this to true if version saved in DB is different, other actions may follow if new v
			var $new_version = false;
			var $minimum_wordpress = '3.6';
			var $users_wp_version = 0;
			var $page_prefix = '';
			var $optimisation_test = false;
			var $optionsName= 'microthemer_ui_settings';
			var $preferencesName = 'preferences_themer_loader';
			var $micro_ver_num = 'micro_revisions_version';
			var $localizationDomain = "microthemer";
			var $globalmessage = array();
			var $ei = 0; // error index
			var $permissionshelp;
			var $microthemeruipage = 'tvr-microthemer.php';
			var $microthemespage = 'tvr-manage-micro-themes.php';
			var $managesinglepage = 'tvr-manage-single.php';
			var $preferencespage = 'tvr-microthemer-preferences.php';
			var $docspage = 'tvr-docs.php';
			var $demo_video = '//www.youtube.com/embed/if1G_SQt43s?autoplay=1&controls=1&showinfo=0&rel=0&vq=hd1080&wmode=transparent';
			var $total_sections = 0;
			var $total_selectors = 0;
			var $sel_loop_count;
			var $sel_count = 0;
			var $sel_option_count = 0;
			var $sel_lookup = array();
			var $trial = true;
			var $initial_options_html = array();
			var $imported_images = array();
			var $site_url = '';

			// @var array $pages Stores all the plugin pages in an array
			var $all_pages = array();
			// @var array $css_units Stores all the possible CSS units
			var $css_units = array();
			//var $css_unit_sets = array();
			var $default_my_props = array();
			// @var array $options Stores the ui options for this plugin
			var $options = array();
			var $serialised_post = array();
			var $propertyoptions = array();
			var $en_propertyoptions = array();
			var $property_option_groups = array();
			var $shorthand = array();
			var $auto_convert_map = array();
			var $legacy_groups = array();
			var $mob_preview = array();
			// @var array $options Stores the "to be merged" options in
			var $to_be_merged = array();
			var $dis_text = '';
			// @var array $preferences Stores the preferences for this plugin
			var $preferences = array();
			// @var array $file_structure Stores the micro theme dir file structure
			var $file_structure = array();
			// polyfills
			var $polyfills = array('pie'); // , boxsizing
			// temporarily keep track of the tabs that are available for the property group.
			// This saves additional processing at various stages
			var $current_pg_group_tabs = array();
			var $subgroup = '';
			// default preferences set in constructor
			var $default_preferences = array();
			var $default_preferences_dont_reset = array();
			// edge mode fixed settings
			var $edge_mode = array();

			// default media queries
			var $unq_base = '';
			var $default_folders = array();
			var $default_m_queries = array();
			var $mobile_first_mqs = array();
			var $mobile_first_semantic_mqs = array();
			var $mq_sets = array();
			var $comb_devs = array(); // for storing all-devs + MQs in one array
			// set default custom code options (todo make use of this array throughout the program)
			var $custom_code = array();
			var $custom_code_flat = array();

			// @var strings dir/url paths
			var $wp_content_url = '';
			var $wp_content_dir = '';
			var $wp_plugin_url = '';
			var $wp_plugin_dir = '';
			var $thispluginurl = '';
			var $thisplugindir = '';
			var $micro_root_dir = '';
			var $level_map = '';

			// control debug output here

			var $debug_custom = '';
			var $debug_pulled_data = TVR_DEBUG_DATA;
			var $debug_current = TVR_DEBUG_DATA;
			var $debug_import = TVR_DEBUG_DATA;
			var $debug_merge = TVR_DEBUG_DATA;
			var $debug_save = TVR_DEBUG_DATA;
			var $debug_selective_export = TVR_DEBUG_DATA;
			var $show_me = ''; // for quickly printing vars in the top toolbar

			// Class Functions

			/**
			* PHP 4 Compatible Constructor
			function tvr_microthemer_admin(){$this->__construct();}
			 **/

			/**
			* PHP 5 Constructor
			*/
			function __construct(){

				// Stop the plugin if below requirements
				// @taken from ngg gallery: http://wordpress.org/extend/plugins/nextgen-gallery/
				if ( (!$this->required_version()) or (!$this->check_memory_limit()) or defined('TVR_MICROBOTH') or !$this->trial_check() ) {
					return;
				}

				// translatable: apparently one of the commented methods below is correct, but they don't work for me.
				// http://geertdedeckere.be/article/loading-wordpress-language-files-the-right-way
				// JOSE: $this->propertyoptions doesn't get translated if we use init
				load_plugin_textdomain( 'microthemer', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
				//add_action('init', array($this, 'tvr_load_textdomain'));

				add_action('wp_ajax_mtui', array(&$this, 'microthemer_ui_page'));

				// get lang for non-english exceptions (e.g. showing English property labels too)
				$this->locale = get_locale();

				$this->dis_text = __('DISABLED', 'microthemer');
				$this->level_map = array(
					'section' => __('folder', 'microthemer'),
					'selector' => __('selector', 'microthemer'),
					'tab' => __('tab', 'microthemer'),
					'group' => __('group', 'microthemer'),
					'subgroup' => __('styles', 'microthemer'),
					'property' => __('property', 'microthemer'),
					'script' => __('Enqueued Script', 'microthemer')
				);

				// add menu links (all WP admin pages need this)
				if (TVR_MICRO_VARIANT == 'themer') {
					add_action("admin_menu", array(&$this, "microthemer_dedicated_menu"));
				}
				else {
					add_action("admin_menu", array(&$this, "microloader_menu_link"));
				}

				// get the directory paths
				include dirname(__FILE__) .'/get-dir-paths.inc.php';

				/***
				limit the amount of code that runs on non-microthemer admin pages
				-- the main functions need to run for the sake of creating
				menu links to the plugin pages, but the code contained within is conditional.
				 ***/
				// save all plugin pages in an array for evaluation throughout the program
				$this->all_pages = array(
					$this->microthemeruipage,
					$this->microthemespage,
					$this->managesinglepage,
					$this->docspage,
					$this->preferencespage
				);
				$page = isset($_GET['page']) ? $_GET['page'] : false;

				// use quick method of getting preferences at this stage (maybe shift code around another time)
				$this->preferences = get_option($this->preferencesName);

				// add shortcut to Microthemer if preference
				if ( !empty($this->preferences['admin_bar_shortcut']) ) {
					add_action( 'admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999999);
				}

				// only initialize on plugin admin pages
				if ( is_admin() and in_array($page, $this->all_pages) ) {

					// save time for use with ensuring non-cached files
					$this->time = time();

					// reusable text
					$this->text = array(
						'save-button' => esc_attr__("Click to save. Or use a keyboard shortcut.\nWin: Control + S\nMac: Command + S",
							'microthemer')
					);

					$this->permissionshelp = esc_html__('Please see this help article for changing directory and file permissions:', 'microthemer') . ' <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a>.' . esc_html__('Tip: you may want to jump to the "Using an FTP Client" section of the article. But bear in mind that if your web hosting runs windows it may not be possible to adjust permissions using an FTP program. You may need to log into your hosting control panel, or request that your host adjust the permissions for you.', 'microthemer');

					// moved to constructor because __() can't be used on member declarations
					$this->edge_mode = array(
						'available' => false,
						'edge_forum_url' => 'http://themeover.com/forum/topic/edge-mode-usability-testing-new-feature-preview/',
						'cta' => __("Try out the new targeting options for the selector wizard. We've replaced the slider with hover and click functionality.", 'microthemer'),
						'config' => array(
							// 'slideless_wizard' => 1
						),
						'active' => false // evaluated at top of ui page

					);

					// define folders (translatable)
					$this->set_default_folders();

					// custom code
					$this->custom_code = tvr_common::get_custom_code();

					// flatten custom_code array (easier to work with)
					foreach ($this->custom_code as $key => $arr){
						if ($key == 'ie_css'){
							foreach ($arr as $key => $arr){
								$flat[$key] = $arr;
							}
						} else {
							$flat[$key] = $arr;
						}
					}
					$this->custom_code_flat = $flat;

					// define possible CSS units
					$this->css_units = array(

						// Absolute CSS units
						'px'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('pixels; 1px is equal to 1/96th of 1in', 'microthemer')
						),
						'px (implicit)'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('Pixels are added by Microthemer behind the scenes when no unit is specified (this is the default).', 'microthemer')
						),
						'pt'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('points; 1pt is equal to 1/72nd of 1in', 'microthemer')
						),
						'pc'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('picas; 1pc is equal to 12pt', 'microthemer')
						),
						'cm'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('centimeters', 'microthemer')
						),
						'mm'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('millimeters', 'microthemer')
						),
						'in'=> array(
							'type' => 'absolute',
							'desc' => esc_attr__('inches', 'microthemer')
						),
						// Relative units
						'%'=> array(
							'type' => 'relative',
							'desc' => esc_attr__('a percentage relative to another value, typically an enclosing element', 'microthemer')
						),
						'em'=> array(
							'type' => 'relative',
							'desc' => esc_attr__('relative to the font size of the element', 'microthemer')
						),
						'rem'=> array(
							'type' => 'relative',
							'desc' => esc_attr__('relative to the font size of the root element', 'microthemer')
						),
						'ex'=> array(
							'type' => 'relative',
							'desc' => esc_attr__('relative to the x-height of the element\'s font (i.e. the font\'s lowercase letter x).', 'microthemer')
						),
						'ch'=> array(
							'type' => 'relative',
							'desc' => esc_attr__('width of the "0" (ZERO, U+0030) glyph in the element\'s font', 'microthemer')
						),
						// @link http://caniuse.com/#search=viewport
						'vw' => array(
							'type' => 'viewport relative',
							'desc' => esc_attr__('&#37; of viewport\'s width', 'microthemer'),
							'not_supported_in' => array('IE8')
						),
						'vh' => array(
							'type' => 'viewport relative',
							'desc' => esc_attr__('&#37; viewport\'s height', 'microthemer'),
							'not_supported_in' => array('IE8')
						),
						'vmin' => array(
							'type' => 'viewport relative',
							'desc' => esc_attr__('&#37; of viewport\'s smaller dimension', 'microthemer'),
							'not_supported_in' => array('IE8')
							// NOTE: in IE9 it's called 'vm'
						),
						'vmax' => array(
							'type' => 'viewport relative',
							'desc' => esc_attr__('&#37; of viewport\'s larger dimension', 'microthemer'),
							'not_supported_in' => array('IE8', 'IE9', 'IE10', 'IE11')
						),
						'px to em'=> array(
							'type' => 'auto-conversion',
							'desc' => esc_attr__('Enter a number of pixels (with no unit) and Microthemer will automatically convert the value to an equivalent em value.', 'microthemer')
						),
						'px to rem'=> array(
							'type' => 'auto-conversion',
							'desc' => __('Enter a number of pixels (with no unit) and Microthemer will automatically convert the value to an equivalent rem value.', 'microthemer')
						),
						'px to %'=> array(
							'type' => 'auto-conversion',
							'desc' => esc_attr__('Enter a number of pixels (with no unit) and Microthemer will automatically convert the value to an equivalent percentage value.', 'microthemer')
						)
					);


					// easy preview of common devices
					$this->mob_preview = array(
						array('(P) Apple iPhone 4', 320, 480),
						array('(P) Apple iPhone 5', 320, 568),
						array('(P) BlackBerry Z30', 360, 640),
						array('(P) Google Nexus 5', 360, 640),
						array('(P) Nokia N9', 360, 640),
						array('(P) Samsung Gallaxy (All)', 360, 640),
						array('(P) Apple iPhone 6', 375, 667),
						array('(P) Google Nexus 4', 384, 640),
						array('(P) LG Optimus L70', 384, 640),
						array('(P) Apple iPhone 6 Plus', 414, 736),
						// landscape (with some exceptions)
						array('(L) Apple iPhone 4', 480, 320),
						array('(L) Nokia Lumia 520', 533, 320),
						array('(L) Apple iPhone 5', 568, 320),
						array('(P) Google Nexus 7', 600, 960),
						array('(P) BlackBerry PlayBook', 600, 1024),
						array('(L) BlackBerry Z30', 640, 360),
						array('(L) Google Nexus 5', 640, 360),
						array('(L) Nokia N9', 640, 360),
						array('(L) Samsung Gallaxy (All)', 640, 360),
						array('(L) Google Nexus 4', 640, 384),
						array('(L) LG Optimus L70', 640, 384),
						array('(L) Apple iPhone 6', 667, 375),
						array('(L) Apple iPhone 6 Plus', 736, 414),
						array('(P) Apple iPad', 768, 1024),
						array('(P) Google Nexus 10', 800, 1280),
						array('(L) Google Nexus 7', 960, 600),
						array('(L) BlackBerry PlayBook', 1024, 600),
						array('(L) Apple iPad', 1024, 768),
						array('(L) Google Nexus 10', 1280, 800)
					);

					// country codes
					$this->country_codes = array(
						"ab", "aa", "af", "ak", "sq", "am", "ar", "an", "hy", "as", "av", "ae", "ay", "az", "bm", "ba", "eu", "be", "bn", "bh", "bi", "bs", "br", "bg", "my", "ca", "ch", "ce", "ny", "zh", "zh-Hans", "zh-Hant", "cv", "kw", "co", "cr", "hr", "cs", "da", "dv", "nl", "dz", "en", "eo", "et", "ee", "fo", "fj", "fi", "fr", "ff", "gl", "gd", "gv", "ka", "de", "el", "kl", "gn", "gu", "ht", "ha", "he", "hz", "hi", "ho", "hu", "is", "io", "ig", "id, in", "ia", "ie", "iu", "ik", "ga", "it", "ja", "jv", "kl", "kn", "kr", "ks", "kk", "km", "ki", "rw", "rn", "ky", "kv", "kg", "ko", "ku", "kj", "lo", "la", "lv", "li", "ln", "lt", "lu", "lg", "lb", "gv", "mk", "mg", "ms", "ml", "mt", "mi", "mr", "mh", "mo", "mn", "na", "nv", "ng", "nd", "ne", "no", "nb", "nn", "ii", "oc", "oj", "cu", "or", "om", "os", "pi", "ps", "fa", "pl", "pt", "pa", "qu", "rm", "ro", "ru", "se", "sm", "sg", "sa", "sr", "sh", "st", "tn", "sn", "ii", "sd", "si", "ss", "sk", "sl", "so", "nr", "es", "su", "sw", "ss", "sv", "tl", "ty", "tg", "ta", "tt", "te", "th", "bo", "ti", "to", "ts", "tr", "tk", "tw", "ug", "uk", "ur", "uz", "ve", "vi", "vo", "wa", "cy", "wo", "fy", "xh", "yi, ji", "yo", "za", "zu"
					);

					// nth-formulas
					$this->nth_formulas = array(
						'1',
						'2',
						'3',
						'4',
						'5',
						'6',

						'n+2',
						'n+3',
						'n+4',
						'n+5',
						'n+6',

						'-n+1',
						'-n+2',
						'-n+3',
						'-n+4',
						'-n+5',
						'-n+6',

						'odd',
						'even',
						'3n',
						'4n',
						'5n',
						'6n',

						'2n+1',
						'3n+1',
						'4n+1',
						'5n+1',
						'6n+1',
					);

					// string for storing favourites
					$this->fav_css_filters = '';

					// pseudo selectors to show in selector wizard
					$this->css_filters = array(

						// classes found in the body tag, this is built dynamically (MT will add some)
						'page_specific' => array(
							'short_label' => esc_html__('Page-specific', 'microthemer'),
							'label' => esc_html__('Page-specific', 'microthemer'),
							'items' => array(
								// note, if changing key text - must update js_i18n_overlay.cur_pid_filter
								'page-id' => array(
									'text' => esc_html__('page-id', 'microthemer'),
									'tip' => esc_attr__('Microthemer will add the page/post id, thus targeting only the current page.', 'microthemer'),
								),
								// note, if changing key text - must update js_i18n_overlay.cur_pid_filter
								'page-name' => array(
									'text' => esc_html__('page-name', 'microthemer'),
									'tip' => esc_attr__('Microthemer will add the page/post slug, an alternative way to target only the current page. But will need updating if you change the URL of the page.', 'microthemer'),
								),
							)
						),

						// show all pseudo elements
						'pseudo_elements' => array(
							'short_label' => esc_html__('Pseudo elements', 'microthemer'),
							'label' => esc_html__('Pseudo elements', 'microthemer'),
							'items' => array(
								"::after" => array(
									'tip' => esc_attr__('Insert a pseudo HTML element after any normal content the element may have', 'microthemer'),
									'strip' => '1',
								),
								"::before" => array(
									'tip' => esc_attr__('Insert a pseudo HTML element before any normal content the element may have', 'microthemer'),
									'strip' => '1',
								),
								"::first-letter" => array(
									'tip' => esc_attr__('Target the first letter of a block level element', 'microthemer'),
									'strip' => '1',
								),
								"::first-line" => array(
									'tip' => esc_attr__('Target the first line of a block level element', 'microthemer'),
									'strip' => '1',
								),
								"::selection" => array(
									'tip' => esc_attr__('Target the area of an element that is selected by the user', 'microthemer'),
									'strip' => '1',
									'replace' => ':selected',
								),
							)
						),

						// there are lots of pseudo classes, maybe show some (0) as dyn controls like JS libraries
						'pseudo_classes' => array(
							'short_label' => esc_html__('Pseudo classes', 'microthemer'),
							'label' => esc_html__('Pseudo classes', 'microthemer'),
							'items' => array(
								":active" => array( 
									'tip' => esc_attr__('Target elements in the "being clicked" state', 'microthemer'),
									'strip' => '1',
								),
								":checked" =>  array(
									'tip' => esc_attr__('Target "checked" form elements', 'microthemer'),
									'strip' => '1',
									'replace' => '[checked="checked"]'
								),
								":disabled" =>  array(
									'tip' => esc_attr__('Target "disabled" form elements', 'microthemer'),
									'strip' => '1',
									'replace' => '[disabled="disabled"]'
								),
								":empty" =>  array(
									'tip' => esc_attr__('Target elements that have no children', 'microthemer'),
								),
								":enabled" =>  array(
									'tip' => esc_attr__('Target "enabled" form elements', 'microthemer'),
								),
								":first-child" =>  array(
									'tip' => esc_attr__('Target elements that are the first child of their parent', 'microthemer'),
								),
								":first-of-type" =>  array(
									'tip' => esc_attr__('Target elements that are the first child of their parent, of a certian type. For instance, the first <p>, of a parent <div>', 'microthemer'),
								),
								":focus" =>  array(
									'tip' => esc_attr__('Target elements that "have focus". For instance, a textarea being edited.', 'microthemer'),
									'strip' => '1',
								),
								":hover" =>  array(
									'tip' => esc_attr__('Target elements in the "being hovered over" state', 'microthemer'),
									'strip' => '1',
								),
								":in-range" =>  array(
									'tip' => esc_attr__('Target <input type="number"> elements with values no less or more than their min/max attributes respectively.', 'microthemer'),
									'strip' => '1',
									'filter' => 1,
								),
								":invalid" =>  array(
									'tip' => esc_attr__('Target form elements that have an invalid value such as <input type="email"> fields with a malformed email address', 'microthemer'),
									'strip' => '1',
									'filter' => 1 // http://stackoverflow.com/questions/15820780/jquery-support-invalid-selector
								),
								":lang(language)" =>  array(
									'tip' => esc_attr__('Target elements that have a "lang" attribute set to a certain langauage code e.g. lang="en"', 'microthemer'),
									'editable' => array(
										'str' => '(language)',
										'combo' => 'lang_codes'
									)
								),
								":last-child" =>  array(
									'tip' => esc_attr__('Target elements that are the last child of their parent', 'microthemer'),
								),
								":last-of-type" =>  array(
									'tip' => esc_attr__('Target elements that are the last child of their parent, of a certian type. For instance, the last <p>, of a parent <div>', 'microthemer'),
								),
								":link" =>  array(
									'tip' => esc_attr__('Target unvisited links', 'microthemer'),
									'strip' => '1',
								),
								":not(selector)" =>  array(
									'tip' => esc_attr__('Use a selector in between the brackets to exclude elements from the selection.', 'microthemer'),
									'editable' => array(
										'str' => '(selector)',
									)
								),
								":nth-child(n)" =>  array(
									'tip' => esc_attr__('Target elements that are the nth child of their parent', 'microthemer'),
									'editable' => array(
										'str' => '(n)',
										'combo' => 'nth_formulas'
									)
								),
								":nth-last-child(n)" =>  array(
									'tip' => esc_attr__('Target elements that are the nth child of their parent, counting backwards from the last child', 'microthemer'),
									'editable' => array(
										'str' => '(n)',
										'combo' => 'nth_formulas'
									)
								),
								":nth-last-of-type(n)" =>  array(
									'tip' => esc_attr__('Target elements that are the nth child of their parent, of a certain type (e.g. <p>), counting backwards from the last child', 'microthemer'),
									'editable' => array(
										'str' => '(n)',
										'combo' => 'nth_formulas'
									)
								),
								":nth-of-type(n)" =>  array(
									'tip' => esc_attr__('Target elements that are the nth child of their parent, of a certain type (e.g. <p>)', 'microthemer'),
									'editable' => array(
										'str' => '(n)',
										'combo' => 'nth_formulas'
									)
								),
								":only-of-type" =>  array(
									'tip' => esc_attr__('Target elements that are the only child of their parent, of a certain type', 'microthemer'),
								),
								":only-child" =>  array(
									'tip' => esc_attr__('Target elements that are the only child of their parent', 'microthemer'),
								),
								":optional" =>  array(
									'tip' => esc_attr__('Target elements that do not have the "required" attribute set', 'microthemer'),
									'strip' => '1',
									'replace' => '[required!="required"]',
								),
								":out-of-range" =>  array(
									'tip' => esc_attr__('Target <input type="number"> elements with values outside their min/max attributes.', 'microthemer'),
									'strip' => '1',
									'filter' => 1,
								),
								":read-only" =>  array(
									'tip' => esc_attr__('Target elements that have the "readonly" attribute set', 'microthemer'),
									'strip' => '1',
									'replace' => '[readonly="readonly"]',
								),
								":read-write" =>  array(
									'tip' => esc_attr__('Target elements that do not have the "readonly" attribute set', 'microthemer'),
									'strip' => '1',
									'replace' => '[readonly!="readonly"]',
								),
								":required" =>  array(
									'tip' => esc_attr__('Target elements that have the "required" attribute set', 'microthemer'),
									'strip' => '1',
									'replace' => '[required="required"]',
								),
								":root" =>  array(
									'tip' => esc_attr__('Target the html element, using an alternative selector', 'microthemer'),
								),
								":target" =>  array(
									'tip' => esc_attr__('Links can target elements on the same page that have an id attribute. So <a href="#logo">click me</a> would target <img id="logo /> when clicked. And the selector "#logo:target" would apply to the image when the link was clicked. ":target" is used to show/hide elements dynamically without using JavaScript.', 'microthemer'),
								),
								":valid" =>  array(
									'tip' => esc_attr__('Target form elements that have a valid value such as <input type="email"> fields with a correctly formatted email address', 'microthemer'),
									'strip' => '1',
									'filter' => 1
								),
								":visited" => array(
									'tip' => esc_attr__('Target links that have been visited', 'microthemer'),
									'strip' => '1',
								),
							)
						),


					);

					// populate the default media queries
					$this->unq_base = uniqid();
					$this->default_m_queries = array(
						$this->unq_base.'1' => array(
							"label" => __('Large Desktop', 'microthemer'),
							"query" => "@media (min-width: 1200px)",
							//"min" => 1200,
							//"max" => 0
						),
						$this->unq_base.'2' => array(
							"label" => __('Desktop & Tablet', 'microthemer'),
							"query" => "@media (min-width: 768px) and (max-width: 979px)",
							//"min" => 768,
							//"max" => 979
						),
						$this->unq_base.'3' => array(
							"label" => __('Tablet & Phone', 'microthemer'),
							"query" => "@media (max-width: 767px)",
							//"min" => 0,
							//"max" => 767
						),
						$this->unq_base.'4' => array(
							"label" => __('Phone', 'microthemer'),
							"query" => "@media (max-width: 480px)",
							//"min" => 0,
							//"max" => 480
						)
					);
					// alternative mobile first media queries
					$this->mobile_first_mqs = array(
						$this->unq_base.'mf1' => array(
							"label" => __('Tablet >', 'microthemer'),
							"query" => "@media (min-width: 767px)",
							//"min" => 767,
							//"max" => 0
						),
						$this->unq_base.'mf2' => array(
							"label" => __('Desktop >', 'microthemer'),
							"query" => "@media (min-width: 979px)",
							//"min" => 979,
							//"max" => 0
						),
						$this->unq_base.'mf3' => array(
							"label" => __('Large Desktop >', 'microthemer'),
							"query" => "@media (min-width: 1200px)",
							//"min" => 1200,
							//"max" => 0
						)
					);
					// semantically defined breakpoints
					$this->mobile_first_semantic_mqs = array(
						$this->unq_base.'mfs1' => array(
							"label" => __('Narrow <', 'microthemer'),
							"query" => "@media (max-width: 480px)",
							//"min" => 0,
							//"max" => 480
						),
						$this->unq_base.'mfs2' => array(
							"label" => __('2 Col >', 'microthemer'),
							"query" => "@media (min-width: 767px)",
							//"min" => 767,
							//"max" => 0
						),
						$this->unq_base.'mfs3' => array(
							"label" => __('2 to 3 Col', 'microthemer'),
							"query" => "@media (min-width: 767px) and (max-width: 978px)",
							//"min" => 767,
							//"max" => 978
						),
						$this->unq_base.'mfs4' => array(
							"label" => __('3 Col >', 'microthemer'),
							"query" => "@media (min-width: 979px)",
							//"min" => 979,
							//"max" => 0
						),
						$this->unq_base.'mfs5' => array(
							"label" => __('3 Col to Wide', 'microthemer'),
							"query" => "@media (min-width: 979px) and (max-width: 1199px)",
							//"min" => 979,
							//"max" => 1199
						),
						$this->unq_base.'mfs6' => array(
							"label" => __('Wide >', 'microthemer'),
							"query" => "@media (min-width: 1200px)",
							//"min" => 1200,
							//"max" => 0
						)
					);
					$this->mq_sets[esc_html__('Desktop first device MQs', 'microthemer')] = $this->default_m_queries;
					$this->mq_sets[esc_html__('Mobile first device MQs', 'microthemer')] = $this->mobile_first_mqs;
					$this->mq_sets[esc_html__('Mobile first semantic MQs', 'microthemer')] = $this->mobile_first_semantic_mqs;

					// default preferences for devs are a bit different
					$this->default_dev_preferences = array(
						"css_important" => 0,
						"selname_code_synced" => 1,
						"wizard_expanded" => 1,
						//"show_code_editor" => 1,
					);

					// define the default preferences here (these can be reset)
					$this->default_preferences = array(

						// non-coder has diff setting from dev
						"css_important" => 1,
						"selname_code_synced" => 0,
						"wizard_expanded" => 0,
						"show_code_editor" => 0,
						"code_manual_resize" => 0,

						// general
						//"dock_wizard_bottom" => 1,
						"hover_inspect" => 0, // this is hard set in $this->getPreferences()
						"allow_scss" => 0, // if enabled by default, invalid css/scss will prevent stylesheet update.
						"gzip" => 1,
						"ie_notice" => 1,
						"show_extra_actions" => 0, // this is always 0 on page load, not saved via ajax
						"default_sug_values_set" => 0,

						"minify_css" => 0, // because other plugins minify, and an extra thing that can go wrong
						"dark_editor" => 0,
						"draft_mode" => 0,
						"draft_mode_uids" => array(),
						"safe_mode_notice" => 1,
						"color_as_hex" => 0,

						"pie_by_default" => 0,
						"admin_bar_preview" => 1, // because WP jumps out of iframe now
						"admin_bar_shortcut" => 1,
						"top_level_shortcut" => 1, // with auto referrer this is more useful and should be on by default
						"first_and_last" => 0,
						"all_devices_default_width" => '',
						"returned_ajax_msg" => '',
						"returned_ajax_msg_seen" => 1,
						"edge_mode" => 0,
						"edge_config" => array(),
						"tooltip_delay" => 500,
						"clean_uninstall" => 0,
						"my_props" => $this->default_my_props,
						"custom_paths" => array('/'),
						"viewed_import_stylesheets" => array(
							// theme css is an obvious one
							get_stylesheet_directory_uri() . '/style.css',
							// and MT might be useful for authors converting custom code to GUI
							$this->micro_root_url . 'active-styles.css'
						),
						"show_rulers" => 1,
						//"highlighting" => 0,
						"ruler_sizing" => array ('x' => 0, 'y' => 0),
						"show_interface" => 1,
						"enq_js" => array(),
						"num_saves" => 0, // keep track of saves for caching purposes
						// "show_adv_wizard" => 0,
						"adv_wizard_tab" => 'refine-targeting',
						"overwrite_existing_mqs" => 1,
						// defaults dependant on lang
						"tooltip_en_prop" => 1, // $this->is_en() ? 0 : 1,
						//"auto_capitalize" => $this->is_en() ? 1 : 0,
						// stylesheet import options
						"css_imp_only_selected" => 0,
						"css_imp_mqs" => 1,
						"css_imp_sels" => 1,
						"css_imp_styles" => 1,
						"css_imp_friendly" => 1,
						"css_imp_adjust_paths" => 1,
						"css_imp_always_cus_code" => 0,
						"css_imp_copy_remote" => 1, // debating this
						"css_imp_max" => '0',

						"page_specific" => array(),
						"pseudo_classes" => array(),
						"pseudo_elements" => array(),
						"favourite_filter" => array(
							'page-id' => 1,
							':hover' => 1,
						),



					);

					// preferences that should not be reset if user resets global preferences
					$arr['m_queries'] = $this->default_m_queries;
					$this->default_preferences_dont_reset = array(
						"preview_url" => $this->home_url,
						"previous_version" => $this->version,
						"buyer_email" => '',
						"buyer_validated" => false,
						"active_theme" => 'customised',
						"theme_in_focus" => '',
						"last_viewed_selector" => '',
						"mq_device_focus" => 'all-devices',
						"css_focus" => 'all-browsers',
						"view_css_focus" => 'input',
						"pg_focus" => 'font',
						"m_queries" => $this->mq_min_max($arr),
						"code_tabs" => $this->custom_code,
						"initial_scale" => 0,
						// I think I store true/false ie settings in preferences so that frontend script
						// doesn't need to pull out all the options from the DB in order to enqueue the stylesheets.
						// This will have an overhaul soon anyway.
						"ie_css" => array('all' => 0, 'nine' => 0, 'eight' => 0, 'seven' => 0),
						"load_js" => 0,
						//"left_menu_down" => 1,
						//"user_set_mq" => false,
					);

					// get the styles from the DB
					$this->getOptions();

					// get the css props
					$this->getPropertyOptions();

					// get/set the preferences
					$this->getPreferences();

					// create micro-themes dir/blank active-styles.css, copy pie if doesn't exist
					$this->setup_micro_themes_dir();

					// get the file structure - and create micro_root dir if it doesn't exist
					$this->file_structure = $this->dir_loop($this->micro_root_dir);

					// dynamic menus: enq_js, mqs, custom code, animation, presets

					// enq_js
					$this->enq_js_structure = array( // structure
						'slug' => 'enq_js',
						'name' => esc_html__('Enqueued Script', 'microthemer'),
						'add_button' => esc_html__('Add Script', 'microthemer'),
						'combo_add' => 1,
						'combo_add_arrow' => 1,
						'name_stub' => 'tvr_preferences[enq_js]',
						'level' => 'script',
						'items' => array(
							'fields' => array(
								'display_name' => array(
									'type' => 'hidden',
									'label' => 0
								)
							),
							'icon' => array(
								'title' => esc_html__('Reorder Enqueued Script', 'microthemer'),
							),
							'actions' => array(
								'delete' => array(
									'class' => 'delete-item',
									'title' => esc_html__('Remove Enqueued Script', 'microthemer'),
								),
								'disabled' => array(
									'icon_control' => 1
								)
							),
							'edit_fields' => 0
						)
					);

					// media queries
					$this->mq_structure = array( // structure
						'slug' => 'mqs',
						'name' => esc_html__('Media Query', 'microthemer'),
						'add_button' => esc_html__('Add Media Query', 'microthemer'),
						'name_stub' => 'tvr_preferences[m_queries]',
						'level' => 'mquery',
						'base_key' => $this->unq_base,
						'items' => array(
							'fields' => array(
								'label' => array(
									'type' => 'text',
									'label' => esc_html__('Label', 'microthemer'),
									'name_class' => 'edit-item',
									'label_title' => esc_html__('Give your media query a descriptive name', 'microthemer'),
								),
								'query' => array(
									'type' => 'textarea',
									'label' => esc_html__('Media Query', 'microthemer'),
									'label_title' => esc_html__('Set the media query condition', 'microthemer'),
								),
								'hide' => array(
									'type' => 'checkbox',
									'label' => esc_html__('Hide tab in interface', 'microthemer'),
									'label_title' => esc_html__('Hide this tab in the interface if you don\'t need it right now', 'microthemer'),
									'label2' => esc_html__('Yes (no settings will be lost)', 'microthemer')
								),
							),
							'icon' => array(
								'title' => esc_html__('Reorder Media Query', 'microthemer'),
							),
							'actions' => array(
								'delete' => array(
									'class' => 'delete-item',
									'title' => esc_html__('Delete Media Query', 'microthemer'),
								),
								'edit' => array(
									'class' => 'edit-item',
									'title' => esc_html__('Edit Media Query', 'microthemer'),
								),
							)
						)
					);

					// main options menu (should come after preferences have been got/set)
					$default_path = $this->root_rel($this->preferences['preview_url'], false, true);
					$default_path = $default_path ? $default_path : '/';
					$this->menu = array(
						// backwards order as floated right
						'exit' => array(
							'name' => esc_html__('Exit', 'microthemer'),
							'sub' => array(
								'dashboard' => array(
									'name' => esc_html__('WP dashboard', 'microthemer'),
									'title' => esc_attr__("Go to your WordPress dashboard", 'microthemer'),
									'class' => 'back-to-wordpress',
									'item_link' => $this->wp_blog_admin_url
								),
								'frontend' => array(
									'name' => esc_html__('Site frontend', 'microthemer'),
									'title' => esc_attr__("Go to your website", 'microthemer'),
									'class' => 'back-to-frontend',
									'item_link' => $this->preferences['preview_url'],
									'link_id' => 'back-to-frontend'
								),
							)
						),
						'support' => array(
							'name' => esc_html__('Help', 'microthemer'),
							'sub' => array(
								'start_tips' => array(
									'name' => esc_html__('Getting started tips', 'microthemer'),
									'title' => esc_attr__("Quick tips on how to use Microthemer", 'microthemer'),
									'class' => 'program-docs',
									'data_attr' => array(
										'docs-index' => 1
									),
									'dialog' => 1
								),
								'video' => array(
									'name' => esc_html__('Getting started video', 'microthemer'),
									'title' => esc_attr__("Learn basics by watching this getting started video",
										'microthemer'),
									'class' => 'demo-video',
									'link_target' => '_blank',
									'item_link' => $this->demo_video
								),
								'reference' => array(
									'name' => esc_html__('CSS Reference', 'microthemer'),
									'title' => esc_attr__("Learn how to use each CSS property", 'microthemer'),
									'class' => 'program-docs',
									'data_attr' => array(
										'prop-group' => 'font',
										'prop' => 'font_family'
									),
									'dialog' => 1
								),
								'responsive' => array(
									'name' => esc_html__('Responsive tutorial', 'microthemer'),
									'title' => esc_attr__("Learn the basics and CSS layout and responsive design", 'microthemer'),
									'class' => 'responsive-tutorial',
									'link_target' => '_blank',
									'item_link' => 'https://themeover.com/html-css-responsive-design-wordpress-microthemer/'
								),
								'forum' => array(
									'name' => esc_html__('Forum', 'microthemer'),
									'title' => esc_attr__("Learn about each CSS property", 'microthemer'),
									'class' => 'support-forum',
									'link_target' => '_blank',
									'item_link' => 'https://themeover.com/forum/'
								),
							)
						),
						'packs' => array(
							'name' => esc_html__('Packs', 'microthemer'),
							'sub' => array(
								'manage' => array(
									'name' => esc_html__('Manage', 'microthemer'),
									'title' => esc_attr__("Install & manage your design packages", 'microthemer'),
									'class' => 'manage-design-packs',
									'dialog' => 1
								),
								'import' => array(
									'name' => esc_html__('Import', 'microthemer'),
									'title' => esc_attr__("Import from a design pack or CSS stylesheet", 'microthemer'),
									'class' => 'import-from-pack',
									'dialog' => 1
								),
								'export' => array(
									'name' => esc_html__('Export', 'microthemer'),
									'title' => esc_attr__("Export your settings to a design pack", 'microthemer'),
									'class' => 'export-to-pack',
									'dialog' => 1
								),
							)
						),
						'history' => array(
							'name' => esc_html__('History', 'microthemer'),
							'sub' => array(
								'restore_styles' => array(
									'name' => esc_html__('Restore revision', 'microthemer'),
									'title' => esc_attr__("Restore settings from a previous save point", 'microthemer'),
									'class' => 'display-revisions',
									'dialog' => 1
								),
								'clear_styles' => array(
									'name' => esc_html__('Clear styles', 'microthemer'),
									'title' => esc_attr__("Clear all styles, but leave folders and selectors intact",
										'microthemer'),
									'class' => 'clear-styles',

								),
								'ui_reset' => array(
									'name' => esc_html__('Reset everything', 'microthemer'),
									'title' => esc_attr__("Reset the interface to the default empty folders", 'microthemer'),
									'class' => 'folder-reset',
								),
							)
						),
						'view' => array(
							'name' => esc_html__('View', 'microthemer'),
							'sub' => array(
								'show_code_editor' => array(
									'name' => esc_html__('Code editor', 'microthemer'),
									'title' => esc_attr__("Switch code/GUI view", 'microthemer')
										. "\nCtrl+Alt+C",
									'class' => 'edit-css-code',
									'toggle' => $this->preferences['show_code_editor'],
									'toggle_id' => 'toggle-full-code-editor',
									'data-pos' => esc_attr__('Show code editor', 'microthemer'),
									'data-neg' => esc_attr__('Show GUI', 'microthemer'),
								),
								'generated' => array(
									'name' => esc_html__('Generated CSS & JS', 'microthemer'),
									'title' => esc_attr__('View the full CSS and JS code Microthemer generates', 'microthemer'),
									'dialog' => 1,
									'class' => 'display-css-code'
								),
								'preview_url' => array(
									'name' => esc_html__('Change site preview URL', 'microthemer'),
									'short_name' => esc_html__('URL or path', 'microthemer'),
									'title' => esc_attr__("Navigate to any page on your site by entering a custom URL",
											'microthemer') . ' (' .
										esc_attr__("you can also navigate by clicking links in the site preview below",
											'microthemer') . ')',
									'class' => 'switch-preview',
									//'item_class' => 'link menu-input-toggle',
									'text_class' => 'link menu-input-toggle',
									'combo_data' => 'custom_paths',
									'input' => $default_path, //$this->preferences['custom_paths'][0],
									'button' => array(
										'text' => esc_html__('Go', 'microthemer'),
										'class' => 'change-preview-url'
									)
								),
								'fullscreen' => array(
									//'new_set' => 1,
									'name' => esc_html__('Fullscreen', 'microthemer'),
									'title' => esc_attr__("Switch fullscreen mode", 'microthemer'),
									'class' => 'toggle-full-screen',
									'toggle' => 0,
									'data-pos' => esc_attr__('Enable fullscreen mode', 'microthemer'),
									'data-neg' => esc_attr__('Disable fullscreen mode', 'microthemer'),
								),

								// frontend view options
								'show_rulers' => array(
									//'new_set' => 1,
									'name' => esc_html__('Rulers', 'microthemer'),
									'title' => esc_attr__("Toggle rulers", 'microthemer'),
									'class' => 'toggle-rulers',
									'toggle' => $this->preferences['show_rulers'],
									'data-pos' => esc_attr__('Enable rulers', 'microthemer'),
									'data-neg' => esc_attr__('Disable rulers', 'microthemer'),
								),
								'highlighting' => array(
									'keyboard_shortcut' => 'Ctrl + Alt + H',
									'name' => esc_html__('Highlight', 'microthemer'),
									'title' => esc_attr__("Temporarily highlight element(s) that your current selector targets (GUI view only)",
										'microthemer'),
									'toggle' => 0,
									'class' => 'toggle-highlighting',
									'toggle_id' => 'toggle-highlighting'
								),
							)
						),
						'general' => array(
							'name' => esc_html__('General', 'microthemer'),
							'sub' => array(
								'buyer_validated' => array(
									'name' => esc_html__('Unlock Microthemer', 'microthemer'),
									'title' => $this->preferences['buyer_validated'] ?
										esc_attr__('Validate license using a different email address', 'microthemer') :
										esc_attr__('Enter your PayPal email (or the email listed in My Downloads on themeover.com) to unlock Microthemer', 'microthemer'),
									'dialog' => 1,
									'class' => 'unlock-microthemer'
								),
								'draft_mode' => array(
									'name' => esc_html__('Draft mode', 'microthemer'),
									'title' => esc_attr__("Changes will only be visible to your user account in draft mode", 'microthemer'),
									'toggle' => $this->preferences['draft_mode'],
									'class' => 'draft-mode',
									'data-pos' => esc_attr__('Enable draft mode', 'microthemer'),
									'data-neg' => esc_attr__('Disable draft mode', 'microthemer'),
								),
								'preferences' => array(
									'name' => esc_html__('Preferences', 'microthemer'),
									'title' => esc_attr__('Edit global preferences', 'microthemer'),
									'dialog' => 1,
									'class' => 'display-preferences'
								),
								'media_queries' => array(
									'name' => esc_html__('Media queries', 'microthemer'),
									'title' => esc_attr__('Edit media queries', 'microthemer'),
									'dialog' => 1,
									'class' => 'edit-media-queries'
								),
								'js_libraries' => array(
									'name' => esc_html__('JS Libraries', 'microthemer'),
									'title' => esc_attr__('Enqueue WordPress JavaScript libraries', 'microthemer'),
									'dialog' => 1,
									'class' => 'mt-enqueue-js'
								),

							)
						),
					);

					// have a dev menu solely for our testing
					if (TVR_DEV_MODE){
						$this->menu['dev'] = array(
							'name' => esc_html__('Dev', 'microthemer'),
							'sub' => array(
								'show_time_concurrently' => array(
									'name' => esc_html__('Show functions concurrently', 'microthemer'),
									'title' => esc_attr__("Output functions times in browser console as they happen", 'microthemer'),
									'toggle' => 0,
									'class' => 'show_time_concurrently',
									'data-pos' => esc_attr__('Enable', 'microthemer'),
									'data-neg' => esc_attr__('Disable', 'microthemer'),
								),
								'show_total_times' => array(
									'name' => esc_html__('Show total function times', 'microthemer'),
									'short_name' => esc_html__('Order by', 'microthemer'),
									'class' => 'show_total_times',
									'title' => esc_attr__("Show functions that have accrued time since page load and subsequent actions.", 'microthemer'),
									'text_class' => 'link menu-input-toggle',
									'combo_data' => 'show_total_times',
									'input' => 'avg_time', //$this->preferences['custom_paths'][0],
									'button' => array(
										'text' => esc_html__('OK', 'microthemer'),
										'class' => 'change-show_total_times'
									)
								),
								'clear_logs' => array(
									'name' => esc_html__('Clear console logs', 'microthemer'),
									'title' => esc_attr__('Clear everything in the browser console', 'microthemer'),
									'class' => 'clear-console-logs'
								),
								/*
								'test_all_mt_actions' => array(
									'name' => esc_html__('Test every MT action', 'microthemer'),
									'title' => esc_attr__('Run every function in MT specified in auto-test.js', 'microthemer'),
									'class' => 'test_all_mt_actions'
								)*/
							)
						);

					}


					// Write Microthemer version specific array data to JS file (can be static for each version).
					// This can be done in dev mode only (also, some servers don't like creating JS files)
					if (TVR_DEV_MODE){
						$this->write_mt_version_specific_js();
					}

					$ext_updater_file = dirname(__FILE__) .'/includes/plugin-updates/1.5/plugin-update-checker.php';
					if ( TVR_MICRO_VARIANT == 'themer' and file_exists($ext_updater_file) ) {
						require $ext_updater_file;
						$MyUpdateChecker = new PluginUpdateChecker(
							'http://themeover.com/wp-content/tvr-auto-update/meta-info.json?'.$this->time, // prevent cached file from loading
							__FILE__,
							'microthemer'
						);
					}

					// we don't want the WP admin bar on any Microthemer pages
					add_filter('show_admin_bar', '__return_false');

					// "Constants" setup
					// get value for safe mode
					if ( (gettype( ini_get('safe_mode') ) == 'string') ) {
						if ( ini_get('safe_mode') == 'off' ) {
							define('SAFE_MODE', FALSE);
						}
						else {
							define( 'SAFE_MODE', ini_get('safe_mode') );
						}
					}
					else {
						define( 'SAFE_MODE', ini_get('safe_mode') );
					}
					// add scripts and styles
					add_action( 'admin_init', array(&$this, 'add_css'));


					/* this may need work, ocassionally breaks: http://stackoverflow.com/questions/5441784/why-does-ob-startob-gzhandler-break-this-website
					 * $this->show_me = 'zlib.output_compression config: ('
						. ini_get('zlib.output_compression')
						. ') gzipping HTTP_ACCEPT_ENCODING: (' . $_SERVER['HTTP_ACCEPT_ENCODING']
						. ') substr_count: ' . substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');*/
					// only microthemer needs custom jQuery and gzipping
					if (TVR_MICRO_VARIANT == 'themer') {
						add_action('admin_init', array(&$this, 'add_js'));
						// enable gzipping on UI page if defined
						if ( $_GET['page'] == basename(__FILE__) and $this->preferences['gzip'] == 1) {
							if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
								ob_start("ob_gzhandler");
							else
								ob_start();
						}
					}

					/* PAGE SPECIFIC PHP PROCESSING (that must come before page is rendered) */
					if ($page == $this->microthemeruipage or $page == $this->preferencespage){

						// update preferences (because admin bar prefs can't be updated if called later)
						add_action( 'admin_init', array(&$this, 'process_preferences_form'));

					}

				}
			}

			// add a link to the WP Toolbar (this was copied from frontend class - use better method later)
			function custom_toolbar_link($wp_admin_bar) {
				if (!current_user_can('administrator')){
					return false;
				}
				if (!empty($this->preferences['top_level_shortcut'])
					and $this->preferences['top_level_shortcut'] == 1){
					$parent = false;
				} else {
					$parent = 'site-name';
				}

				$args = array(
					'id' => 'wp-mcr-shortcut',
					'title' => 'Microthemer',
					'parent' => $parent,
					'href' => $this->wp_blog_admin_url . 'admin.php?page=' . $this->microthemeruipage,
					'meta' => array(
						'class' => 'wp-mcr-shortcut',
						'title' => __('Jump to the Microthemer interface', 'microthemer')
					)
				);
				$wp_admin_bar->add_node($args);
			}

			// check if an url is valid
			function is_valid_url( $url ) {
				if ( '' != $url ) {
					/* Using a HEAD request, we'll be able to know if the URL actually exists.
					 * the reason we're not using a GET request is because it might take (much) longer. */
					$response = wp_remote_head( $url, array( 'timeout' => 3 ) );
					/* We'll match these status codes against the HTTP response. */
					$accepted_status_codes = array( 200, 301, 302 );

					/* If no error occured and the status code matches one of the above, go on... */
					if ( ! is_wp_error( $response ) &&
						in_array( wp_remote_retrieve_response_code( $response ), $accepted_status_codes ) ) {
						/* Target URL exists. Let's return the (working) URL */
						return $url;
					}
					/* If we have reached this point, it means that either the HEAD request didn't work or that the URL
					 * doesn't exist. This is a fallback so we don't show the malformed URL */
					return '';
				}
				return $url;
			}

			// set defaults for user's property preferences (this runs on every page load)
			function set_my_props_defaults(){

				//$pg_label = '';
				$update2 = false;

				// for resetting during development
				//$this->preferences['my_props']['sug_values'] = array();
				//$this->preferences['default_sug_values_set'] = 0;

				foreach ($this->propertyoptions as $prop_group => $array){
					foreach ($array as $prop => $meta) {

						// we're only interested in props with default units or suggested values
						if ( empty($meta['default_unit']) and empty($meta['sug_values']) ){
							continue;
						}

						// ensure that the default unit is set, this will cater for new props too
						if (!empty($meta['default_unit']) and
							empty($this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'])){
							$update2 = true;
							$this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'] = 'px (implicit)';

						}

						// ensure that the suggested values array is set, this will cater for new props too
						if ( !empty($meta['sug_values']) ){

							$root_cat = !empty($meta['sug_values']['root_cat'])
								? $meta['sug_values']['root_cat']
								: $prop;

							if ( !isset($this->preferences['my_props']['sug_values'][$root_cat]) ){
								$update2 = true;
								$this->preferences['my_props']['sug_values'][$root_cat] = array();
							}

							// unset legacy array that was added in anticipation of this feature, but never used
							if (isset($this->preferences['my_props'][$prop_group]['pg_props'][$prop]['sug_values'])){
								$update2 = true;
								$this->preferences['my_props'][$prop_group]['pg_props'][$prop]['sug_values'] = null;
							}

						}
					}
				}

				// ensure site_colors and saved_colors arrays are set
				$extra_colors = array('site_colors', 'saved_colors');
				foreach ($extra_colors as $index => $key){
					if ( !isset($this->preferences['my_props']['sug_values'][$key]) ){
						$update2 = true;
						$this->preferences['my_props']['sug_values'][$key] = array();
					}
				}


				return $update2;
			}

			// load full set of suggested CSS units
			function update_my_prop_default_units($new_css_units){
				foreach ($this->preferences['my_props'] as $prop_group => $array){

					if ($prop_group == 'sug_values') continue;

					foreach ($this->preferences['my_props'][$prop_group]['pg_props'] as $prop => $arr){
						// skip props with no default unit
						if (empty($this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'])){
							continue;
						}
						/*if ($config['mode'] == 'set'){
							$new_unit = $this->propertyoptions[$prop_group][$prop]['default_unit'][$config['set_key']];
						} elseif ($config['mode'] == 'post'){ */
						if (!empty($new_css_units[$prop_group][$prop])){
							$new_unit = $new_css_units[$prop_group][$prop];
						}
						// set all box model the same
						$box_model_rel = false;
						$first_in_group = false;
						if (!empty($this->propertyoptions[$prop_group][$prop]['rel'])){
							$box_model_rel = $this->propertyoptions[$prop_group][$prop]['rel'];
						}
						if (!empty($this->propertyoptions[$prop_group][$prop]['sub_label'])){
							$first_in_group = $this->propertyoptions[$prop_group][$prop]['sub_label'];
							$first_in_group_val = $new_unit;
						}
						if ($box_model_rel){
							$new_unit = $first_in_group_val;
						}
						//}
						$this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'] = $new_unit;
					}
				}
				return $this->preferences['my_props'];
			}

			// ensure all preferences are defined
			function ensure_defined_preferences($full_preferences){
				$update = $update2 = false;
				foreach ($full_preferences as $key => $value){
					if ( !isset($this->preferences[$key]) ){
						$update = true;
						$this->preferences[$key] = $value;
					}
				}

				// new CSS props will be added over time and the default unit etc must be assigned.
				$update2 = $this->set_my_props_defaults();

				// save new defined prefs if necessary
				if ($update or $update2){
					$this->savePreferences($this->preferences);
				}

				// ensure view_import_stylesheets list has current theme style.css (saves preferences too)
				$this->update_css_import_urls(get_stylesheet_directory_uri() . '/style.css', 'ensure');
			}

			// update viewed_import_stylesheets list array
			function update_css_import_urls($url, $context = 'make top'){

				// if url is already in the array, ensure it's at the top
				$curKey = array_search($url, $this->preferences['viewed_import_stylesheets']);
				if ($context == 'make top'){
					if ($curKey !== false){
						array_splice( $this->preferences['viewed_import_stylesheets'], $curKey, 1 );
					}
					array_unshift( $this->preferences['viewed_import_stylesheets'], $url );
				}

				// unless we're just ensuring e.g. the theme's style.css is in the list
				elseif ($context == 'ensure'){
					if ( !in_array($url, $this->preferences['viewed_import_stylesheets']) ){
						$this->preferences['viewed_import_stylesheets'][] = $url;
					}
				}

				// ensure only 20 items
				$i = 0;
				$pref_array['viewed_import_stylesheets'] = array();
				foreach ($this->preferences['viewed_import_stylesheets'] as $key => $css_url){
					if (++$i > 20) break;
					$pref_array['viewed_import_stylesheets'][] = $css_url;
				}

				//$pref_array['viewed_import_stylesheets'] = array();
				$this->savePreferences($pref_array);
			}


			// @taken from ngg gallery: http://wordpress.org/extend/plugins/nextgen-gallery/
			function required_version() {
				global $wp_version;
				$this->users_wp_version = $wp_version;
				// Check for WP version installation
				$wp_ok = version_compare($wp_version, $this->minimum_wordpress, '>=');
				// if requirements not met
				if ( ($wp_ok == FALSE) ) {
					add_action(
						'admin_notices',
						create_function(
							'',
							'echo \'<div id="message" class="error"><p><strong>' .
								esc_html__('Sorry, Microthemer only runs on WordPress version %s or above. Deactivate Microthemer to remove this message.', 'microthemer') .
							'</strong></p></div>\';'
						)
					);
					return false;
				}
				return true;
			}

			// check the user has a minimal amount of memory
			function check_memory_limit() {

				// get memory limit including unit
				$subject = ini_get('memory_limit'); // e.g. 256M
				//$subject = 268435456; //test
				$pattern = '/([\-0-9]+)/';
				preg_match($pattern, $subject, $matches);
				$this->memory_limit = $matches[0];
				$unit = str_replace($matches[0], '', $subject);

				/* if we have enough return true
				if ($this->memory_limit == 0 or
					$this->memory_limit == -1 or
					$unit == 'G' or
					$unit == 'GB' or
					( ($unit == 'M' or $unit == 'MB') and $this->memory_limit > 16)
				){
					return true;
				}*/

				// cautious memory check that will only throw error if memory is given in MB.
				// Too many variables to safely accommodate all e.g. 0, -1, (int) 268435456, 3GB etc
				if ( ($unit == 'M' or $unit == 'MB') and $this->memory_limit < 16 ){
					// we don't have enough
					add_action(
						'admin_notices',
						create_function(
							'',
							'echo \'<div id="message" class="error"><p><strong>' .
							esc_html__('Sorry, Microthemer has a memory requirement of 16MB or higher to run. Your allocated memory is less than this ('.$subject.'). Deactivate Microthemer to remove this message. Or increase your memory limit.', 'microthemer') .
							'</strong></p></div>\';'
						)
					);
					return false;
				}

				// all good
				return true;
			}

			// check trial mode
			function trial_check() {
				if ( $this->trial === false ) {
					add_action(
						'admin_notices',
						create_function(
							'',
							'echo \'<div id="message" class="error"><p><strong>' .
								sprintf( esc_html__('Please %s to unlock the full program.', 'microthemer') . '<a target="_blank" href="http://themeover.com/microthemer/">' . esc_html__('purchase Microthemer', 'microthemer') . '</a>' ) .
							'</strong></p></div>\';'
						)
					);
					return false;
				}
				return true;
			}

			// Microthemer dedicated menu
			function microthemer_dedicated_menu() {

				// for draft mode and preventing two users overwriting each other's edits
				// get_current_user_id() needs to be here (hooked function)
				$this->current_user_id = get_current_user_id();

				add_menu_page(__('Microthemer UI', 'microthemer'), 'Microthemer', 'administrator', $this->microthemeruipage, array(&$this,'microthemer_ui_page'));
				add_submenu_page('options.php',
					__('Manage Design Packs', 'microthemer'),
					__('Manage Packs', 'microthemer'),
					'administrator', $this->microthemespage, array(&$this,'manage_micro_themes_page'));
				add_submenu_page('options.php',
					__('Manage Single Design Pack', 'microthemer'),
					__('Manage Single Pack', 'microthemer'),
					'administrator', $this->managesinglepage, array(&$this,'manage_single_page'));
				add_submenu_page('options.php',
					__('Microthemer Docs', 'microthemer'),
					__('Documentation', 'microthemer'),
					'administrator', $this->docspage, array(&$this,'microthemer_docs_page'));
				add_submenu_page($this->microthemeruipage,
					__('Microthemer Preferences', 'microthemer'),
					__('Preferences', 'microthemer'),
					'administrator', $this->preferencespage, array(&$this,'microthemer_preferences_page'));
			}

			// Add Microloader menu link in appearance menu
			function microloader_menu_link() {
				add_theme_page('Microloader', 'Microloader', 'administrator', $this->microthemespage, array(&$this,'manage_micro_themes_page'));
			}

			// add support for translation (not using this function right now, rightly or wrongly)
			function tvr_load_textdomain() {
				load_plugin_textdomain('microthemer', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
			}

			// add js
			function add_js() {
				if (TVR_MICRO_VARIANT == 'themer') {

					if (!$this->optimisation_test){
						wp_enqueue_media(); // adds over 1000 lines of code to footer
					}

					// script map
					$scripts = array(

						// jquery/ui
						array('h' => 'jquery-ui-core', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-position', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-sortable', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-draggable', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-slider', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-autocomplete', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-button', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-resizable', 'dep' => 'jquery', 'alwaysInc' => 1),
						array('h' => 'jquery-ui-tooltip', 'dep' => 'jquery', 'alwaysInc' => 1),

						// mt core namespace
						array('h' => 'tvr_core', 'f' => 'mt-core.js'),

						// js libraries (prefix name with mt- if I've edited the library)
						// use ace2, ace3 and have /ace as sub dir for easy globs in gulp file
						array('h' => 'tvr_ace', 'f' => 'lib/ace2/ace/ace.js'),
						array('h' => 'tvr_ace_lang', 'f' => 'lib/ace2/ace/ext-language_tools.js'),
						array('h' => 'tvr_ace_search', 'f' => 'lib/ace2/ace/ext-searchbox.js'),

						array('h' => 'tvr_mcth_colorbox', 'f' => 'lib/colorbox/1.3.19/jquery.colorbox-min.js'),
						array('h' => 'tvr_spectrum', 'f' => 'lib/colorpicker/mt-spectrum.js', 'dep' => array( 'jquery' )),
						array('h' => 'tvr_html_beautify', 'f' => 'lib/beautify-html.min.js'),
						array('h' => 'tvr_sprintf', 'f' => 'lib/sprintf/sprintf.min.js'),
						array('h' => 'tvr_parser', 'f' => 'lib/parser.js'),
						array('h' => 'tvr_cssutilities', 'f' => 'lib/mt-cssutilities.js'),
						//array('h' => 'tvr_cssutilities', 'f' => 'lib/CSSUtilities.js'), // for comparing customised

						// custom modules
						array('h' => 'tvr_mcth_cssprops', 'f' => 'data/program-data.js'), // this will be dyn soon
						array('h' => 'tvr_utilities', 'f' => 'mod/mt-utilities.js'),
						array('h' => 'tvr_init', 'f' => 'mod/mt-init.js'),
						array('h' => 'tvr_mod_ace', 'f' => 'mod/mt-ace.js'),

						// page specific
						array('h' => 'tvr_main_ui', 'f' => 'page/microthemer.js', 'page' => array($this->microthemeruipage)),
						array('h' => 'tvr_man', 'f' => 'page/packs.js', 'page' => 'other'),

						// min (deps.js combines all libraries and includes
						// apart from ace that didn't concat well with it's web workers for some reason
						array('h' => 'tvr_ace', 'f' => '../js-min/ace/ace.js', 'min' => 1),
						array('h' => 'tvr_ace_lang', 'f' => '../js-min/ace/ext-language_tools.js', 'min' => 1),
						array('h' => 'tvr_ace_search', 'f' => '../js-min/ace/ext-searchbox.js', 'min' => 1),

						array('h' => 'tvr_deps', 'f' => '../js-min/deps.js', 'min' => 1),
						array('h' => 'tvr_main_ui', 'f' => '../js-min/microthemer.js', 'min' => 1,
							'page' => array($this->microthemeruipage)),
						array('h' => 'tvr_man', 'f' => '../js-min/packs.js', 'min' => 1, 'page' => 'other'),

					);

					// output scripts based on various conditions
					$js_path = $this->thispluginurl.'js/';
					$v = '?v='.$this->version;
					foreach ($scripts as $key => $arr){
						$dep = !empty($arr['dep']) ? $arr['dep'] : false;

						$do_script = true;

						// filter out page specific scripts
						if (!empty($arr['page'])){
							if ( is_array($arr['page']) and !in_array($_GET['page'], $arr['page'])){
								$do_script = false;
							}
							if ($arr['page'] == 'other' and $_GET['page'] == $this->microthemeruipage){
								$do_script = false;
							}
						}

						// only show correct script for dev/production
						if ( empty($arr['alwaysInc']) ) {
							if ((TVR_DEV_MODE and !empty($arr['min']))
								or (!TVR_DEV_MODE and empty($arr['min']))){
								$do_script = false;
							}
						}


						// register/enqueue
						if ($do_script){
							if (!empty($arr['f'])){
								wp_register_script( $arr['h'], $js_path . $arr['f']. $v, $dep );
							}
							wp_enqueue_script( $arr['h'], $dep );
						}
					}

					// load js strings for translation
					include_once $this->thisplugindir . 'includes/js-i18n.inc.php';

				}
			}

			// add css
			function add_css() {

				// Google fonts
				wp_register_style('tvrGFonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700,700italic,400italic');
				wp_enqueue_style( 'tvrGFonts');

				// if dev mode, enqueue css libraries separately
				if (TVR_DEV_MODE){

					// color picker, colorbox, jquery ui styling
					wp_enqueue_style( 'spectrum-colorpicker',
						$this->thispluginurl . 'js/lib/colorpicker/spectrum.css?v=' . $this->version );
					wp_register_style( 'tvr_mcth_colorbox_styles',
						$this->thispluginurl.'css/colorbox.css?v='.$this->version );
					wp_enqueue_style( 'tvr_mcth_colorbox_styles' );
					wp_register_style( 'tvr_jqui_styles', $this->thispluginurl.'css/jquery-ui1.11.4.css?v='.$this->version );
					wp_enqueue_style( 'tvr_jqui_styles' );

					$main_css_file = $this->thispluginurl.'css/styles.css';

				} else {

					//wp_register_style( 'tvr_mcth_colorbox_styles',
						//$this->thispluginurl.'js/lib/colorbox/1.3.19/colorbox.css?v='.$this->version );
					//wp_enqueue_style( 'tvr_mcth_colorbox_styles' );

					// in production, all css will be minified and concatenated to style.css
					$main_css_file = $this->thispluginurl.'css/concat-styles.min.css';
				}

				// enqueue main stylesheet
				wp_register_style( 'tvr_mcth_styles', $main_css_file.'?v='.$this->version );
				wp_enqueue_style( 'tvr_mcth_styles' );

				// preferences page doesn't want toolbar hack, so add to stylesheet conditionally
				if ($_GET['page'] != $this->preferencespage){
					$custom_css = "
						html, html.wp-toolbar {
							padding-top:0
						}";
					wp_add_inline_style( 'tvr_mcth_styles', $custom_css );
				}
			}

			// build array for property/value input fields
			function getPropertyOptions() {
				$propertyOptions = array();
				$legacy_groups = array();
				include $this->thisplugindir . 'includes/property-options.inc.php';
				$this->propertyoptions = $propertyOptions;

				// populate $property_option_groups and $auto_convert_map array
				foreach ($propertyOptions as $prop_group => $array){
					foreach ($array as $prop => $meta) {
						// pg group
						if ( !empty($meta['pg_label']) ){
							$this->property_option_groups[$prop_group] = $meta['pg_label'];
						}
						// auto convert
						if ( !empty($meta['auto']) ){
							$this->auto_convert_map[$prop] = $meta['auto'];
						}
					}
				}
				$this->legacy_groups = $legacy_groups;

			}

			// update shorthand map array
			function update_shorthand_map($shorthand, $cssf, $prop_group, $prop, $propArr, $sh) {
				//$this->show_me.= print_r($sh[0], true);
				$shorthand[$sh[0]][$cssf] = array(
					'group' => $prop_group,
					'prop' => $prop,
					'index' => $sh[1],
					'config' => !empty($sh[2]) ? $sh[2] : array()
				);
				// signal if prop is !important carrier
				!empty($propArr['important_carrier']) ? $shorthand[$sh[0]][$cssf]['important_carrier'] = 1 : 0;
				// signal if prop can have multiple
				!empty($propArr['multiple']) ? $shorthand[$sh[0]][$cssf]['multiple'] = 1 : 0;
				// and if MT supports this
				!empty($propArr['multiple_sup']) ? $shorthand[$sh[0]][$cssf]['multiple_sup'] = 1 : 0;

				return $shorthand;
			}

			// update the array for checking match criteria when gathering interesting css values from site stylesheets
			function update_gc_css_match($gc_css_match, $type, $val){
				$gc_css_match[] = array(
					'type' => $type,
					'val' => $val
				);
				return $gc_css_match;
			}

			// create static JS file for property options etc that relate to the current version of MT
			function write_mt_version_specific_js() {
				// Create new file if it doesn't already exist
				$js_file = $this->thisplugindir . 'js/data/program-data.js';
				if (!$write_file = fopen($js_file, 'w')) {
					$this->log(
						esc_html__('Permission Error', 'microthemer'),
					'<p>' . sprintf( esc_html__('WordPress does not have permission to create: %s', 'microthemer'), $this->root_rel($js_file) . '. '.$this->permissionshelp ) . '</p>'
					);
				}
				else {
					// some CSS properties need adjustment for jQuery .css() call
					// include any prop that needs special treatment for one reason or another
					$exceptions = array(
						'font-family' => 'google-font',
						'list-style-image' => 'list-style-image',
						'text-shadow' => array(
							'text-shadow-x',
							'text-shadow-y',
							'text-shadow-blur',
							'text-shadow-color'),
						'box-shadow' => array(
							'box-shadow-x',
							'box-shadow-y',
							'box-shadow-blur',
							'box-shadow-spread',
							'box-shadow-color',
							'box-shadow-inset'),
						'background-img-full' => array(
							'background-image',
							'gradient-angle',
							'gradient-a',
							'gradient-b',
							'gradient-b-pos',
							'gradient-c'
							),
						'background-position' => 'background-position',
						'background-position-custom' => array(
							'background-position-x',
							'background-position-y'
						),
						'background-repeat' => 'background-repeat',
						'background-attachment' => 'background-attachment',
						'background-size' => 'background-size',
						'background-clip' => 'background-clip',
						'border-top-left-radius' => 'radius-top-left',
						'border-top-right-radius' => 'radius-top-right',
						'border-bottom-right-radius' => 'radius-bottom-right',
						'border-bottom-left-radius' =>'radius-bottom-left',

						'keys' => array(
							'background-position-x' => array(
								'0%' => 'left',
								'100%' => 'right',
								'50%' => 'center'
							),
							'background-position-y' => array(
								'0%' => 'top',
								'100%' => 'bottom',
								'50%' => 'center'
							),
							'gradient-angle' => array(
								'180deg' => 'top to bottom',
								'0deg' => 'bottom to top',
								'90deg' => 'left to right',
								'-90deg' => 'right to left',
								'135deg' => 'top left to bottom right',
								'-45deg' => 'bottom right to top left',
								'-135deg' => 'top right to bottom left',
								'45deg' => 'bottom left to top right'
							),
							// webkit has a different interpretation of the degrees - doh!
							'webkit-gradient-angle' => array(
								'-90deg' => 'top to bottom',
								'90deg' => 'bottom to top',
								'0deg' => 'left to right',
								'180deg' => 'right to left',
								'-45deg' => 'top left to bottom right',
								'135deg' => 'bottom right to top left',
								'-135deg' => 'top right to bottom left',
								'45deg' => 'bottom left to top right'
							)
						)
					);

					// var for storing then writing json data to JS file
					$data = '';

					// shorthand properties in this array (like padding, font etc) also have longhand single props.
					// At the JS end, these single props can be got from tapping the browser's comp CSS
					// unlike only shorthand props in the $exceptions array above.
					$shorthand = array();

					// longhand for checking against regular css properties
					$longhand = array();

					// reference map/storage for style values from site's stylesheets e.g. color palette
					$gathered_css = array(
						'eligable' => array(),
						'store' => array(
							'site_colors' => array(),
							'saved_colors' => array(),
						),
					);

					// combo array for storing data for comboboxes
					$combo = array();

					// css props for passing jQuery.css() to get computed CSS
					$css_props = array();


					// loop through property options, creating various JS key map arrays
					foreach ($this->propertyoptions as $prop_group => $array) {

						foreach ($array as $prop => $propArr) {

							// this could be replaced with hardcoded values in property-options.inc.php
							$cssf = str_replace('_', '-', $prop);
							$css_props[$prop_group][] = $cssf;


							// update shorthand map
							if (!empty($propArr['sh'])){
								// like with border, border-top, and border-color shorthands affecting 1 prop
								if (is_array($propArr['sh'][0])){
									foreach($propArr['sh'] as $n => $sub_sh){
										foreach($sub_sh as $k => $junk){
											$shorthand = $this->update_shorthand_map($shorthand, $cssf, $prop_group,
												$prop, $propArr, $propArr['sh'][$k]);

											// also update $gathered_css while we're here
											if (!empty($propArr['sug_values'])){
												$gathered_css['eligable'][$propArr['sh'][$k][0]] = 1;
											}
										}
									}
								} else {
									// prop with just one shorthand available
									$shorthand = $this->update_shorthand_map($shorthand, $cssf, $prop_group,
										$prop, $propArr, $propArr['sh']);

									// also update $gathered_css while we're here
									if (!empty($propArr['sug_values'])){
										$gathered_css['eligable'][$propArr['sh'][0]] = 1;
									}

								}
							}

							// update longhand map
							if (empty($propArr['sh'][2]['onlyShort'])){
								$longhand[$cssf] = array(
									'group' => $prop_group,
									'prop' => $prop,
									//'multiple' => !empty($propArr['multiple']) ? 1 : 0,
								);
								// signal if prop can have multiple
								!empty($propArr['multiple']) ? $longhand[$cssf]['multiple'] = 1 : false;
								// and if MT supports this
								!empty($propArr['multiple_sup']) ? $longhand[$cssf]['multiple_sup'] = 1 : 0;
							}

							// update the $gathered_css map
							if (!empty($propArr['sug_values'])){

								// straight property match e.g. font-size
								if (!empty($propArr['sug_values']['this'])){
									$gathered_css['eligable'][$cssf] = 1;
								}

								// populate $gathered_css keys and storage arrays ready for getting vals with JS
								$gc_root_cat = !empty($propArr['sug_values']['root_cat'])
									? $propArr['sug_values']['root_cat']
									: $prop;

								$gathered_css['root_cat_keys'][$prop] = $gc_root_cat;
								$gathered_css['store'][$gc_root_cat] = array();
							}


							// populate combobox array
							if (!empty($array[$prop]['select_options'])){
								$combo[$prop] = $array[$prop]['select_options'];
							}


						}
					}

					//$this->show_me.= print_r($combo, true);

					$this->shorthand = $shorthand;
					$this->longhand = $longhand;

					// text/box-shadow need to be called as one
					$css_props['shadow'][] = 'text-shadow';
					$css_props['shadow'][] = 'box-shadow';
					$css_props['background'][] = 'background-img-full'; // for storing full string (inc gradient)
					$css_props['background'][] = 'extracted-gradient'; // for storing just gradient (for mixed-comp check)
					$css_props['gradient'][] = 'background-image'; // gradient group needs this
					$css_props['gradient'][] = 'background-img-full'; // for storing full string (inc gradient)
					$css_props['gradient'][] = 'extracted-gradient';

					// dev option for showing function times
					$combo['show_total_times'] = array('avg_time', 'total_time', 'calls');

					// set options for :lang(language) pseudo class
					$combo['lang_codes'] = $this->country_codes;

					// suggest some handy nth formulas
					$combo['nth_formulas'] = $this->nth_formulas;

					// ready combo for css_units
					$combo['css_units'] = array_keys( $this->css_units );

					// example scripts for enqueuing
					$combo['enq_js'] = array( 'jquery', 'jquery-form', 'jquery-color', 'jquery-masonry', 'masonry', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-accordion', 'jquery-ui-autocomplete', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-dialog', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-menu', 'jquery-ui-mouse', 'jquery-ui-position', 'jquery-ui-progressbar', 'jquery-ui-selectable', 'jquery-ui-resizable', 'jquery-ui-selectmenu', 'jquery-ui-sortable', 'jquery-ui-slider', 'jquery-ui-spinner', 'jquery-ui-tooltip', 'jquery-ui-tabs', 'jquery-effects-core', 'jquery-effects-blind', 'jquery-effects-bounce', 'jquery-effects-clip', 'jquery-effects-drop', 'jquery-effects-explode', 'jquery-effects-fade', 'jquery-effects-fold', 'jquery-effects-highlight', 'jquery-effects-pulsate', 'jquery-effects-scale', 'jquery-effects-shake', 'jquery-effects-slide', 'jquery-effects-transfer', 'wp-mediaelement', 'schedule', 'suggest', 'thickbox', 'hoverIntent', 'jquery-hotkeys', 'sack', 'quicktags', 'iris', 'json2', 'plupload', 'plupload-all', 'plupload-html4', 'plupload-html5', 'plupload-flash', 'plupload-silverlight', 'underscore', 'backbone' );
					sort($combo['enq_js']);

					// also write full css units array with descriptions
					$data.= 'TvrMT.data.prog.CSSUnits = ' . json_encode($this->css_units) . ';' . "\n\n";

					// finish data string
					$data.= 'TvrMT.data.prog.propExc = ' . json_encode($exceptions) . ';' . "\n\n";
					// not actually using this right now
					//$data.= 'var TvrInputProps = ' . json_encode($input_props) . ';' . "\n\n";
					// key map for shorthand properties
					$data.= 'TvrMT.data.prog.sh = ' . json_encode($shorthand) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.lh = ' . json_encode($longhand) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.gatheredCSS = ' . json_encode($gathered_css) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.CSSProps = ' . json_encode($css_props) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.PGs = ' . json_encode($this->property_option_groups) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.autoMap = ' . json_encode($this->auto_convert_map) . ';' . "\n\n";
					// TvrMT.data.prog.combo needs to be updated with dynamic JS file for suggested values based on user action
					$data.= 'TvrMT.data.prog.combo = ' . json_encode($combo) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.mobPreview = ' . json_encode($this->mob_preview) . ';' . "\n\n";
					$data.= 'TvrMT.data.prog.CSSFilters = ' . json_encode($this->css_filters) . ';' . "\n\n";



					// write and close file
					fwrite($write_file, $data);
					fclose($write_file);
				}

			}

			// display the css filters
			function display_css_filters(){
				$html = '
				<div class="quick-opts first-quick-opts">
					<div class="quick-opts-inner">';

						$i = 0;
						foreach ($this->css_filters as $key => $arr){
							if ($i === 0){
								$extra = $this->css_filter_list(
									$this->css_filters['pseudo_elements']['items'],
									$key,
									$this->css_filters['pseudo_elements']['label']
								);
							} elseif ($i === 1){
								++$i;
								continue;
							} else {
								$extra = '';
							}
							$html.= '
							<div class="mt-col mt-col'.(++$i).'">'
								. $this->css_filter_list(
									$arr['items'],
									$key,
									$arr['label']
								). $extra . '
							</div>';
						}

						$clear_text = esc_html__('Clear all', 'microthemer');
						$html.= '
						<span class="clear-filters-wrap"
							  title="'.esc_html__('Clear all selector adjustments', 'microthemer').'">
							<span class="clear-icon tvr-icon clear-css-filters clear-css-filters-icon"></span>
							<span class="clear-css-filters clear-css-filters-text">'.$clear_text.'</span>
						</span>

					</div>
				</div>';

				return $html;

			}

			// output a list of css filters (pseudo classes, elements, page-specific)
			function css_filter_list($filters, $type, $heading) {
				$html = '
				<div class="filter-heading">'.$heading.'</div>';
				$num_items = count($filters);
				$index = 0;

				// there are lots of pseudo, split into 3 columns
				if (($num_items >= 12)){
					$break = $num_items/3;
					$j = -1;
					foreach($filters as $k => $v){
						if (++$j > $break){
							++$index;
							$j = 0;
						}
						$split_filters[$index][$k] = $v;
					}
				} else {
					$split_filters[0] = $filters;
				}

				// loop through normalised $filters
				foreach ($split_filters as $i => $f){
					$html.= '
					<ul class="css-filter-list flist-'.$type.' cssfl-index-'.$i.'">';
					foreach($f as $key => $arr){
						$text = !empty($arr['text']) ? $arr['text'] : $key;
						$edClass = !empty($arr['editable']) ? ' filter-editable' : '';
						$li =
						$this->ui_toggle(
							$type,
							$arr['tip'],
							$arr['tip'],
							!empty($this->preferences[$type][$key]),
							'css-filter-item filter-'.$this->pseudo_class_format($text) . $edClass,
							false,
							array(
								'tag' => 'li',
								'dataAtts' => array(
									'filter' => $key,
									'type' => $type
								),
								'text' => $text,
								'inner_icon' => $this->ui_toggle(
									'favourite_filter',
									esc_attr__('Favorite this filter', 'microthemer'),
									esc_attr__('Unfavorite this filter', 'microthemer'),
									!empty($this->preferences['favourite_filter'][$key]),
									'tvr-icon star-icon fav-filter ui-toggle ui-par',
									false,
									array(
										'pref_sub_key' => $key
									)
								),
								'pref_sub_key' => $text,
								'css_filter' => $arr
							)
						);
						$html.= $li;
						// save for favs list if required
						if (!empty($this->preferences['favourite_filter'][$key])){
							// the title is a bit annoying on favourites.
							$this->fav_css_filters.= preg_replace('/title=\"([^"]*)\"/i', '', $li, 1);
						}
					}

					// provide an option to remember the choice
					//$html.= '<li class="filter-choice">'.esc_html__('More', 'microthemer').'</li>';

					$html.= '</ul>';
				}

				return $html;
			}

			// @return array - Retrieve the plugin options from the database.
			function getOptions() {
				// default options (html layout sections only - no default selectors)
				if (!$theOptions = get_option($this->optionsName)) {
					$theOptions = $this->default_folders;
					$theOptions['non_section']['hand_coded_css'] = '';
					// add_option rather than update_option (so autoload can be set to no)
					add_option($this->optionsName, $theOptions, '', 'no');
				}
				$this->options = $theOptions;
			}

			function pseudo_class_format($pseudo){
				return str_replace(array( ':', '(', ')' ), '', $pseudo);
			}

			// @return array - Retrieve the plugin plugin preferences from the database.
			function getPreferences() {

				$full_preferences = array_merge($this->default_preferences, $this->default_preferences_dont_reset);

				// default preferences
				if (!$thePreferences = get_option($this->preferencesName)) {
					$thePreferences = $full_preferences;
					// add_option rather than update_option (so autoload can be set to no)
					add_option($this->preferencesName, $thePreferences, '', 'no');
				}

				$this->preferences = $thePreferences;

				// check if this is a new version of Microthemer
				if ($this->preferences['previous_version'] != $this->version){
					$this->new_version = true;
				}

				// for resetting defaults while developing
				unset($this->preferences['css_imp_friendly']);

				// ensure preferences are defined (for when I add new preferences that upgrading users won't have)
				$this->ensure_defined_preferences($full_preferences);

				// we released 5 beta with system for remembering targeting mode on page load, but decided against this
				$this->preferences['hover_inspect'] = 0; // simple fi

			}

			// Save the preferences
			function savePreferences($pref_array) {
				// get the full array of preferences
				$thePreferences = get_option($this->preferencesName);
				// update the preferences array with passed values
				foreach ($pref_array as $key => $value) {
					$thePreferences[$key] = $value;
				}
				// save in DB and go to relevant page
				// don't do deep escape here as it can run more than once
				update_option($this->preferencesName, $thePreferences);
				// update the global preferences array
				$this->preferences = $thePreferences;

				//$this->show_me = '<pre>after preference saved: '.print_r($this->preferences['my_props']['sug_values']['color'], true).'</pre>';

				return true;
			}

			// common function for outputting yes/no radios
			function output_radio_input_lis($opts, $hidden = ''){

				foreach ($opts as $key => $array) {

					// ensure various vars are defined
					$array['label_no'] = ( !empty($array['label_no']) ) ? $array['label_no'] : '';
					$array['default'] = ( !empty($array['default']) ) ? $array['default'] : '';
					$yes_val = ($key == 'draft_mode') ? $this->current_user_id : 1;

					// skip edge mode if not available
					if ($key == 'edge_mode' and !$this->edge_mode['available']){
						continue;
					}

					?>
					<li class="fake-radio-parent <?php echo $hidden; ?>" xmlns="http://www.w3.org/1999/html">
						<label>
							<span title="<?php echo esc_attr($array['explain']); ?>">
								<?php echo esc_html($array['label']); ?>
							</span>
						</label>

						<span class="yes-wrap p-option-wrap">
							<input type='radio' autocomplete="off" class='radio'
							name='tvr_preferences[<?php echo $key; ?>]' value='<?php echo $yes_val; ?>'
							<?php
							if ( !empty($this->preferences[$key])) {
								echo 'checked="checked"';
								$on = 'on';
							} else {
								$on = '';
							}
							?>
							/>
							<span class="fake-radio <?php echo $on; ?>"></span>
							<span class="ef-label"><?php esc_html_e('Yes', 'microthemer'); ?></span>
						</span>
						<span class="no-wrap p-option-wrap">
							<input type='radio' autocomplete="off" class='radio' name='tvr_preferences[<?php echo $key; ?>]' value='0'
							<?php
							if ( (empty($this->preferences[$key]))
							// exception for mq set overwrite as this isn't stored as a global preference
								//and $key != 'overwrite_existing_mqs'
							) {
								echo 'checked="checked"';
								$on = 'on';
							} else {
								$on = '';
							}
							?>
							/>
							<span class="fake-radio <?php echo $on; ?>"></span>
							<span class="ef-label"><?php esc_html_e('No', 'microthemer'); ?></span>
						</span>
					</li>
				<?php
				}
			}

			// common function for text inputs/combos
			function output_text_combo_lis($opts, $hidden = ''){
				foreach ($opts as $key => $array) {
					$input_id = $input_class = $arrow_class = $class = $rel = $arrow = '';
					$input_name = 'tvr_preferences['.$key.']';
					$input_value = ( !empty($this->preferences[$key]) ) ? $this->preferences[$key] : '';

					// does it need a custom id?
					if (!empty($array['input_id'])){
						$input_id = $array['input_id'];
					}
					// does it need a custom input class?
					if (!empty($array['input_class'])){
						$input_class = $array['input_class'];
					}
					// does it need a custom arrow class?
					if (!empty($array['arrow_class'])){
						$arrow_class = $array['arrow_class'];
					}
					// does it need a custom input name?
					if (!empty($array['input_name'])){
						$input_name = $array['input_name'];
					}
					// does it need a custom input value?
					if (!empty($array['input_value'])){
						$input_value = $array['input_value'];
					}

					// exception for css unit set (keep blank)
					if ($input_id == 'css_unit_set'){
						$input_value = '';
					}

					// is it a combobox?
					if (!empty($array['combobox'])){
						$class = 'combobox';
						$rel = 'rel="'.$array['combobox'].'"';
						$arrow = '<span class="combo-arrow '.$arrow_class.'"></span>';
					}
					?>
					<li class="tvr-input-wrap <?php echo $hidden; ?>">
						<label class="text-label">
							<span title="<?php echo esc_attr($array['explain']); ?>">
								<?php echo esc_html($array['label']); ?>
							</span>
						</label>
						<input type='text' autocomplete="off" name='<?php echo esc_attr($input_name); ?>'
							id="<?php echo $input_id; ?>"
							class="<?php echo $class . ' ' . $input_class; ?>" <?php echo $rel; ?>
							value='<?php echo esc_attr($input_value); ?>' />
						<?php echo $arrow; ?>
					</li>
				<?php
				}
			}

			// create revisions table if it doesn't exist
			function createRevsTable() {
				global $wpdb;
				$table_name = $wpdb->prefix . "micro_revisions";
				$micro_ver_num = get_option($this->micro_ver_num);
				// only execut following code if table doesn't exist.
				// dbDelta function wouldn't overwrite table,
				// But table version num shouldn't be updated with current plugin version if it already exists
				if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name or
					$micro_ver_num < $this->db_chg_in_ver ) {
					if ( ! empty( $wpdb->charset ) )
						$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
					if ( ! empty( $wpdb->collate ) )
						$charset_collate .= " COLLATE $wpdb->collate";
					$sql = "CREATE TABLE $table_name (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						user_action TEXT DEFAULT '' NOT NULL,
						data_size VARCHAR(10) DEFAULT '' NOT NULL,
						settings longtext NOT NULL,
						UNIQUE KEY id (id)
						) $charset_collate;";
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					dbDelta($sql);
					// store the table version in the wp_options table (useful for upgrading the DB)
					add_option($this->micro_ver_num, $this->version);
					return true;
				}
				else {
					return false;
				}
			}


			// format user action in same json format - see JS function: TvrUi.user_action() - this isn't very DRY. JS templating would be better.
			function json_format_ua($icon, $item, $val = false){
				$json = '{"items":["'.$item.'"],"val":"'.$val.'","icon":"'.$icon.'","main_class":"",';
				$json.= '"icon_html":"<span class=\"h-i no-click '.$icon.'\" ></span>",';
				$json.= '"html":"<span class=\"history-item history_'.$this->to_param($item).'\"><span class=\"his-items\"><span>'.$item.'</span></span>';
				if ($val){
					$json.= '<span class=\"his-val\">'.$val.'</span>';
				}
				$json.= '</span>"}';
				return $json;
			}

			// Update the Revisions Table
			function updateRevisions($save_data, $user_action = '') {
				$user_action = html_entity_decode($user_action);
				// create/update revisions table if it doesn't already exist or is out of date
				$this->createRevsTable();
				// add the revision to the table
				global $wpdb;
				$table_name = $wpdb->prefix . "micro_revisions";
				$serialized_data = serialize($save_data);
				$data_size = round(strlen($serialized_data)/1000).'KB';
				// $wpdb->insert (columns and data should not be SQL escaped): https://developer.wordpress.org/reference/classes/wpdb/insert/
				$rows_affected = $wpdb->insert( $table_name, array(
					'time' => current_time('mysql'),
					'user_action' => $user_action,
					'data_size' => $data_size,
					'settings' => $serialized_data )
				);
				// check if an old revision needs to be deleted
				$revs = $wpdb->get_results("select id from $table_name order by id asc");
				if ($wpdb->num_rows > 50) {
					//$sql = "delete from $table_name where id = ".$wpdb->escape($revs[0]->id);
					$wpdb->query( $wpdb->prepare("delete from $table_name where id = %d", $revs[0]->id) );
				}
				return true;
			}

			// custom function for time diff as we want seconds
			function human_time_diff( $from, $to = '' ) {

				if ( empty( $to ) ) {
					$to = time();
				}

				$diff = (int) abs( $to - $from );

				if ( $diff < 60 ) {
					//$since = $diff . ' secs';
					$since = sprintf( _n( '%s sec', '%s secs', $diff ), $diff );
				} elseif ( $diff < HOUR_IN_SECONDS ) {
					$mins = round( $diff / MINUTE_IN_SECONDS );
					if ( $mins <= 1 )
						$mins = 1;
					/* translators: min=minute */
					$since = sprintf( _n( '%s min', '%s mins', $mins ), $mins );
				} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
					$hours = round( $diff / HOUR_IN_SECONDS );
					if ( $hours <= 1 )
						$hours = 1;
					$since = sprintf( _n( '%s hour', '%s hours', $hours ), $hours );
				} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
					$days = round( $diff / DAY_IN_SECONDS );
					if ( $days <= 1 )
						$days = 1;
					$since = sprintf( _n( '%s day', '%s days', $days ), $days );
				} elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
					$weeks = round( $diff / WEEK_IN_SECONDS );
					if ( $weeks <= 1 )
						$weeks = 1;
					$since = sprintf( _n( '%s week', '%s weeks', $weeks ), $weeks );
				} elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
					$months = round( $diff / MONTH_IN_SECONDS );
					if ( $months <= 1 )
						$months = 1;
					$since = sprintf( _n( '%s month', '%s months', $months ), $months );
				} elseif ( $diff >= YEAR_IN_SECONDS ) {
					$years = round( $diff / YEAR_IN_SECONDS );
					if ( $years <= 1 )
						$years = 1;
					$since = sprintf( _n( '%s year', '%s years', $years ), $years );
				}
				return $since;
			}

			// Get Revisions for displaying in table
			function getRevisions() {

				// get the full array of revisions
				global $wpdb;
				$table_name = $wpdb->prefix . "micro_revisions";
				//$revs = $wpdb->get_results("select id, user_action, data_size, date_format(time, '%D %b %Y %H:%i') as datetime
				$revs = $wpdb->get_results("select id, user_action, data_size, unix_timestamp(time) as timestamp
				from $table_name order by id desc");
				$total_rows = $wpdb->num_rows;
				// if no revisions, explain
				if ($total_rows == 0) {
					return '<span id="revisions-table">' .
						esc_html__('No Revisions have been created yet. This will happen after your next save.', 'microthemer') .
					'</span>';
				}
				// if one revision, it's the same as the current settings, explain
				if ($total_rows == 1) {
					return '<span id="revisions-table">' .
						esc_html__('The only revision is a copy of your current settings.', 'microthemer') .
					'</span>';
				}
				// revisions exist so prepare table
				//<th>' . esc_html__('Num', 'microthemer') . '</th>
					//<th>' . esc_html__('Size', 'microthemer') . '</th>
				$rev_table =
				'
				<table id="revisions-table">
				<thead>
				<tr>
					<th>' . esc_html__('Size', 'microthemer') . '</th>
					<th>' . esc_html__('Time', 'microthemer') . '</th>
					<th colspan="2">' . esc_html__('User Action', 'microthemer') . '</th>
					<th>' . esc_html__('Restore', 'microthemer') . '</th>
				</tr>
				</thead>';

				// tap into WordPress native JSON functions
				if( !class_exists('Moxiecode_JSON')) {
					require_once($this->thisplugindir . 'includes/class-json.php');
				}
				$json_object = new Moxiecode_JSON();

				$i = 0;
				foreach ($revs as $rev) {
					$time_ago = $this->human_time_diff($rev->timestamp);
					//$time_ago = $this->getTimeSince($rev->timestamp);
					// get traditional save or new history which will be in json obj
					$user_action = $rev->user_action;
					$rev_icon = $main_class = '';
					$legacy_new_class = 'legacy-hi';
					if (strpos($user_action, '{"') !== false){
						$ua = $json_object->decode($rev->user_action);
						$legacy_new_class = 'new-hi';
						$user_action = $ua['html'];
						$rev_icon = $ua['icon_html'];
						$main_class = $ua['main_class'];
					}

					$niceDate = date('l jS \of F Y H:i:s', $rev->timestamp);

					//<td class="rev-num">'.$total_rows.'</td>
					//<td class="rev-size">'.$rev->data_size.'</td>
					$rev_table.= '
					<tr class="'.$legacy_new_class.'">
						<td class="rev-size">'.$rev->data_size.'</td>
						<td class="rev-time tvr-help" title="'.$niceDate.'">'.
							sprintf(esc_html__('%s ago', 'microthemer'), $time_ago).'</td>
						<td class="rev-icon '.$main_class.'">'.$rev_icon.'</td>
						<td class="rev-action '.$main_class.'">'.$user_action.'</td>
						<td>';
						if ($i == 0) {
							$rev_table.= esc_html__('Current', 'microthemer');
						}
						else {
							$rev_table.='<span class="link restore-link" rel="mt_action=restore_rev&tvr_rev='.$rev->id.'">' . esc_html__('Restore', 'microthemer') . '</span>';
						}
						$rev_table.='</td>
					</tr>';
					--$total_rows;
					++$i;
				}
				$rev_table.= '</table>';
				return $rev_table;
			}

			// Restore a revision
			function restoreRevision($rev_key) {
				// get the revision
				global $wpdb;
				$table_name = $wpdb->prefix . "micro_revisions";
				$rev = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $rev_key) );
				$rev->settings = unserialize($rev->settings);
				// add css units, mq keys (extra tabs) etc to settings display correctly
				$filtered_json = $this->filter_incoming_data('restore', $rev->settings);
				// restore to options DB field
				update_option($this->optionsName, $filtered_json);
				$this->options = get_option($this->optionsName); // this DB interaction doesn't seem necessary...
				return true;
			}

			// Save the UI styles to the database - create hybrid of settings from existing non-loaded styles and saved styles
			function saveUiOptions($theOptions){
				// create debug save file if specified at top of script

				if ($this->debug_save) {
					$debug_file = $this->debug_dir . 'debug-save.txt';
					$write_file = fopen($debug_file, 'w');
					$data = '';
					$data.= "\n\n" . __('### The new options', 'microthemer') . "\n\n";
					$data.= print_r($theOptions, true);
					$data.= "\n\n" . __('### The existing options in the DB', 'microthemer') . "\n\n";
					$data.= print_r($this->options, true);
				}
				// loop through all the state trackers
				if (!empty($theOptions['non_section']['view_state']) and is_array($theOptions['non_section']['view_state'])) {
					foreach($theOptions['non_section']['view_state'] as $section_name => $array) {
						// need to use existing non-loaded sections again soon...

						// loop through the selector trackers
						if (is_array($array)) {
							foreach ( $array as $css_selector => $view_state) {

								if ($css_selector == 'this') continue;

								// if the selector options haven't been pulled into the UI, use existing
								if ($view_state == 0) {
									// check if user disabled/enabled non-loaded sel before overwriting
									$dis = false;
									if (!empty($theOptions[$section_name][$css_selector]['disabled'])){
										$dis = true;
									}
									// replace sel with settings in DB
									$theOptions[$section_name][$css_selector] = $this->options[$section_name][$css_selector];
									// disable if necessary
									if ($dis){
										$theOptions[$section_name][$css_selector]['disabled'] = 1;
									}
									// or re-enable if necessary
									elseif (!$dis and !empty($theOptions[$section_name][$css_selector]['disabled'])){
										unset($theOptions[$section_name][$css_selector]['disabled']);
									}

								}

								// media query values will also need to be pulled from existing settings
								// I think $this->options['non_section']['m_query'] is the right array to iterate over because
								// if m_query didn't have any settings before, it will be added by $theOptions['non_section']['m_query']
								if (!empty($this->options['non_section']['m_query']) and
									is_array($this->options['non_section']['m_query'])) {
									foreach ($this->options['non_section']['m_query'] as $m_key => $array) {
										// if MQ not loaded, pull in from existing
										if ($view_state == 0) {
											if (!empty($array[$section_name][$css_selector])
												and is_array($array[$section_name][$css_selector])) {
												$theOptions['non_section']['m_query'][$m_key][$section_name][$css_selector] = $array[$section_name][$css_selector];
											}
										}
										// If MQ has loaded it will already be part of $theOptions array.
										// But it will potentially be in the wrong order (first). So unset then re-add.
										else {
											if (!empty($theOptions['non_section']['m_query'][$m_key][$section_name][$css_selector])){
												$cache_new_mq = $theOptions['non_section']['m_query'][$m_key][$section_name][$css_selector];
												unset($theOptions['non_section']['m_query'][$m_key][$section_name][$css_selector]);
												$theOptions['non_section']['m_query'][$m_key][$section_name][$css_selector] = $cache_new_mq;
											}
										}
									}
								}


							}
						}
					}
				}
				if ($this->debug_save) {
					$data.= "\n\n" . __('### The hybrid options', 'microthemer') . "\n\n";
					$data.= print_r($theOptions, true);
					fwrite($write_file, $data);
					fclose($write_file);
				}
				update_option($this->optionsName, $theOptions);
				$this->options = get_option($this->optionsName);

				return true;
			}

			// Resest the options.
			function resetUiOptions(){
				delete_option($this->optionsName);
				$this->getOptions(); // reset the defaults
				$pref_array = array();
				$pref_array['active_theme'] = 'customised';
				$pref_array['theme_in_focus'] = '';
				$pref_array['num_saves'] = 0;
				$this->savePreferences($pref_array);
				return true;
			}

			// clear the style definitions - leaving all the sections and selectors intact
			function clearUiOptions() {
				if (is_array($this->options['non_section']['view_state'])) {
					foreach($this->options['non_section']['view_state'] as $section_name => $array) {
						// loop through the selector trackers
						if (is_array($array)) {
							foreach ( $array as $css_selector => $view_state) {
								if ($css_selector == 'this') { continue; }
								// reset styles array to defaults
								foreach ($this->property_option_groups as $group => $junk){
									$option_groups[$group] = '';
								}
								$this->options[$section_name][$css_selector]['styles'] = $option_groups;
							}
						}
					}
				}
				// clear the custom code
				$this->options['non_section']['hand_coded_css'] = '';
				$this->options['non_section']['ie_css']['all'] = '';
				$this->options['non_section']['ie_css']['nine'] = '';
				$this->options['non_section']['ie_css']['eight'] = '';
				$this->options['non_section']['ie_css']['seven'] = '';
				$this->options['non_section']['js'] = '';
				// clear all media query settings
				$this->options['non_section']['m_query'] = array();

				// update the options in the DB
				update_option($this->optionsName, $this->options);
				$this->options = get_option($this->optionsName); // necessary?
				return true;
			}

			function log($short, $long, $type = 'error', $preset = false, $vars = array()){
				// some errors are the same, reuse the text
				if ($preset) {
					if ($preset == 'revisions'){
						$this->globalmessage[++$this->ei]['short'] = __('Revision log update failed.', 'microthemer');
						$this->globalmessage[$this->ei]['type'] = 'error';
						$this->globalmessage[$this->ei]['long'] = '<p>' . esc_html__('Adding your latest save to the revisions table failed.', 'microthemer') . '</p>';
					} elseif ($preset == 'json-decode'){
						$this->globalmessage[++$this->ei]['short'] = __('Decode json error', 'microthemer');
						$this->globalmessage[$this->ei]['type'] = 'error';
						$this->globalmessage[$this->ei]['long'] = '<p>' . sprintf(esc_html__('WordPress was not able to convert %s into a usable format.', 'microthemer'), $this->root_rel($vars['json_file']) ) . '</p>';
					}

				} else {
					$this->globalmessage[++$this->ei]['short'] = $short;
					$this->globalmessage[$this->ei]['type'] = $type;
					$this->globalmessage[$this->ei]['long'] = $long;
				}
			}

			// save ajax-generated global msg in db for showing on next page load
			function cache_global_msg(){
				$pref_array = array();
				$pref_array['returned_ajax_msg'] = $this->globalmessage;
				$pref_array['returned_ajax_msg_seen'] = 0;
				$this->savePreferences($pref_array);
			}

			// display the logs
			function display_log(){

				// if the page is reloading after an ajax request, we may have unseen status messages to show - merge the two
				if (!empty($this->preferences['returned_ajax_msg']) and !$this->preferences['returned_ajax_msg_seen']){
					$cached_global = $this->preferences['returned_ajax_msg'];
					if (is_array($this->globalmessage)){
						$this->globalmessage = array_merge($this->globalmessage, $cached_global);
					} else {
						$this->globalmessage = $cached_global;
					}
					// clear the cached message as it is beign shown
					$pref_array['returned_ajax_msg'] = '';
					$pref_array['returned_ajax_msg_seen'] = 1;
					$this->savePreferences($pref_array);
				}
				$html = '';
				if (!empty($this->globalmessage)) {
					$html.= '<ul class="logs">'; // so 'loading WP site' msg doesn't overwrite
					foreach ($this->globalmessage as $key => $log) {
						if ($log['type'] == 'dev-notice'){
							continue;
						}
						$html .= $this->display_log_item($log['type'], $log, $key);
					}
					$html .= '</ul><span id="data-msg-pending" rel="1"></span>';
				} else {
					$html.= '<ul class="logs"></ul><span id="data-msg-pending" rel="0"></span>';
				}
				return $html;
			}

			// display log item - used as template so need as function to keep html consistent
			function display_log_item($type, $log, $key, $id = ''){
				$html = '
				<li '.$id.' class="tvr-'.$type.' tvr-message row-'.($key+1).'">
					<span class="short">'.$log['short'].'</span>
					<div class="long">'.$log['long'].'</div>
				</li>';
				return $html;
			}

			// circumvent max_input_vars by passing one serialised input that can be unpacked with this function
			function my_parse_str($string, &$result) {
				if($string==='') return false;
				$result = array();
				// find the pairs "name=value"
				$pairs = explode('&', $string);
				foreach ($pairs as $pair) {
					// use the original parse_str() on each element
					parse_str($pair, $params);
					$k=key($params);
					if(!isset($result[$k])) {
						$result+=$params;
					}
					else {
						if (is_array($result[$k])){
							//echo '<pre>key:'. $k . "\n";
							//echo 'params:';
							//print_r($params);
							//$result[$k]+=$params[$k];
							$result[$k] = $this->array_merge_recursive_distinct($result[$k], $params[$k]);
							// 'result:';
							//print_r($result);
							//echo '</pre>';
						}
					} //
					//else $result[$k]+=$params[$k];
				}
				return true;
			}

			// better recursive array merge function listed on the function's PHP page
			function array_merge_recursive_distinct ( array &$array1, array &$array2 ){
				$merged = $array1;
				foreach ( $array2 as $key => &$value )
				{
					if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
					{
						$merged [$key] = $this->array_merge_recursive_distinct ( $merged [$key], $value );
					}
					else
					{
						$merged [$key] = $value;
					}
				}

				return $merged;
			}

			// process preferences form
			function process_preferences_form(){
				if (isset($_POST['tvr_preferences_form'])) {

					check_admin_referer('tvr_preferences_submit');

					$pref_array = $this->deep_unescape($_POST['tvr_preferences'], 0, 1, 1);
					$pref_array['num_saves'] = ++$this->preferences['num_saves'];

					// CSS units need saving in a different way (as my_props is more than just css units)
					$pref_array = $this->update_default_css_units($pref_array);
					if ($this->savePreferences($pref_array)) {
						$this->log(
							esc_html__('Preferences saved', 'microthemer'),
							'<p>' . esc_html__('Your Microthemer preferences have been successfully updated.', 'microthemer') . '</p>',
							'notice'
						);
						// the admin bar shortcut needs to be applied here else it will only show on next page load
						if (!empty($this->preferences['admin_bar_shortcut'])) {
							add_action( 'admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999999);
						} else {
							remove_action( 'admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999999 );
						}
					}
					// save last message in database so that it can be displayed on page reload (just once)
					$this->cache_global_msg();
				}
			}

			// update the preferences array with the new units when the user saves the preferences
			function update_default_css_units($pref_array){
				// cache the posted css units
				$new_css_units = $pref_array['new_css_units'];
				// then discard as junk
				unset($pref_array['new_css_units']);
				// update the existing my_props array
				$pref_array['my_props'] = $this->update_my_prop_default_units($new_css_units);
				return $pref_array;
			}

			// process posted zip file (do this on manage and single hence wrapped in a funciton )
			function process_uploaded_zip() {
				if (isset($_POST['tvr_upload_micro_submit'])) {
					check_admin_referer('tvr_upload_micro_submit');
					if ($_FILES['upload_micro']['error'] == 0) {
						$this->handle_zip_package();
					}
					// there was an error - save in global message
					else {
						$this->log_file_upload_error($_FILES['upload_micro']['error']);
					}
				}
			}

			// &preview= and ?preview= cause problems - strip
			function strip_preview_params($url){
				// could use preg_split('/ /', $str, -1, PREG_SPLIT_OFFSET_CAPTURE);
				$url = explode('preview_id=', $url);
				$url = rtrim($url[0], '?&');
				return $url;
			}

			// update the iframe preview url
			function maybe_set_preview_url($nonce_key = false){
				if (isset($_GET['mt_preview_url'])) {
					// the $nonce may be checked outside of this function, if not the key will be passed in
					if ($nonce_key) {
						$nonce = $_REQUEST['_wpnonce'];
						if ( ! wp_verify_nonce( $nonce, $nonce_key ) ) {
							die( 'Security check failed' );
						}
					}

					// update preview url in DB
					$url = strip_tags(rawurldecode($_GET['mt_preview_url']));
					$pref_array['preview_url'] = $this->strip_preview_params($url);

					// path won't be set if this is triggered after user clicked WP Toolbar MT link
					if (!empty($_GET['mt_preview_path'])){
						$path = strip_tags(rawurldecode($_GET['mt_preview_path']));
						// insert new url at start of custom_paths array
						if (!in_array($path, $this->preferences['custom_paths'])){
							array_unshift($this->preferences['custom_paths'], $path);
							// ensure only 20 items
							$i = 0;
							foreach ($this->preferences['custom_paths'] as $key => $path){
								if (++$i > 20) break;
								$pref_array['custom_paths'][] = $path;
							}
						}
					}

					$this->savePreferences($pref_array);
				}
			}

			// Microthemer UI page
			function microthemer_ui_page() {

				// only run code if it's the ui page
				if ( isset($_GET['page']) and $_GET['page'] == $this->microthemeruipage ) {

					// simple ajax operations that can be executed from any page, pointing to ui page
					if (isset($_GET['mcth_simple_ajax'])) {

						// check ajax nonce, exception for preferences which has own nonce check (not just set via ajax)
						if (!isset($_POST['tvr_preferences_form'])) {
							check_ajax_referer( 'mcth_simple_ajax', '_wpnonce' );
						}

						// save general preferences
						if (isset($_POST['tvr_preferences_form'])) {
							$this->process_preferences_form();
							wp_die();
						}

						// if it's an options save request
						if( isset($_GET['mt_action']) and $_GET['mt_action'] == 'mt_save_interface') {

							//echo 'show_me from ajax save (before): <pre> '.print_r($this->preferences['my_props']['sug_values']['color'], true).'</pre>';

							$circumvent_max_input_vars = true;
							if ($circumvent_max_input_vars){
								$this->my_parse_str($_POST['tvr_serialized_data'], $this->serialised_post);
							} else {
								parse_str($_POST['tvr_serialized_data'], $this->serialised_post); // for debugging
							}

							$debug = false;
							if ($debug){
								echo '<pre>';
								print_r($this->serialised_post);
								echo '</pre>';
							}

							// remove slashes and custom escaping so that DB data is clean
							$this->serialised_post['tvr_mcth'] =
								$this->deep_unescape($this->serialised_post['tvr_mcth'], 1, 1, 1);
							// save settings in DB
							if ($this->saveUiOptions($this->serialised_post['tvr_mcth'])) {
								$saveOk = esc_html__('Settings saved', 'microthemer');
								$this->log(
									$saveOk,
									'<p>' . esc_html__('The UI interface settings were successfully saved.', 'microthemer') . '</p>',
									'notice'
								);
							}
							else {
								$this->log(
									esc_html__('Settings failed to save', 'microthemer'),
									'<p>' . esc_html__('Saving your setting to the database failed.', 'microthemer') . '</p>'
								);
							}



							$new_select_option = '';

							// check if settings need to be exported to a design pack
							if ($this->serialised_post['export_to_pack'] == 1) {
								$theme = htmlentities($this->serialised_post['export_pack_name']);
								$context = 'existing';
								$do_option_insert = false;
								if ($this->serialised_post['new_pack'] == 1){
									$context = 'new';
									$do_option_insert = true;
								}
								// function return sanitised theme name
								$theme = $this->update_json_file($theme, $context);
								// save new sanitised theme in span for updating select menu via jQuery
								if ($do_option_insert) {
									$new_select_option = $theme;
								}
								//$user_action.= sprintf( esc_html__(' & Export to %s', 'microthemer'), '<i>'. $this->readable_name($theme). '</i>');
							}
							// else its a standard save of custom settings
							else {
								$theme = 'customised';
								//$user_action.= esc_html__(' (regular)', 'microthemer');
							}
							// update active-styles.css
							$this->update_active_styles($theme);
							// update the revisions DB field
							if (!$this->updateRevisions($this->options, $this->serialised_post['tvr_mcth']['non_section']['meta']['user_action'])) {
								$this->log('','','error', 'revisions');
							}

							//echo 'carrots!';
							//wp_die();

							// return the globalmessage and then kill the program - this action is always requested via ajax
							// also fullUIData as an interim way to keep JS ui data up to date (post V5 will have new system with less http)
							$html = '<div id="microthemer-notice">' . $this->display_log() . '

								<div class="script-feedback">
									<span id="sanit-export-name">'.$new_select_option.'</span>
									<span id="google-url-to-refresh">'.$this->preferences['g_url'].'</span>
								</div>
							</div>';

							// we're returning a JSON obejct here, the HTML is added as a property of the object
							$response = array(
								'html'=> $html,
								'uiData'=> $this->options
								//'uiData'=> array()
							);

							echo json_encode($response); //$html;

							wp_die();
						}

						// ajax - load selectors and/or selector options
						if ( isset($_GET['mt_action']) and $_GET['mt_action'] == 'tvr_microthemer_ui_load_styles') {
							//check_admin_referer('tvr_microthemer_ui_load_styles');
							$section_name = strip_tags($_GET['tvr_load_section']);
							$css_selector = strip_tags($_GET['tvr_load_selector']);
							$array = $this->options[$section_name][$css_selector];
							echo '<div id="tmp-wrap">';
							echo $this->all_option_groups_html($section_name, $css_selector, $array);
							echo '</div>';
							// output pulled data to debug file
							if ($this->debug_pulled_data){
								$debug_file = $this->debug_dir . 'debug-pulled-data.txt';
								$write_file = fopen($debug_file, 'w');
								$data = '';
								$data.= esc_html__('Custom debug output', 'microthemer') . "\n\n";
								$data.= $this->debug_custom;
								$data.= "\n\n" . esc_html__('Last pulled data', 'microthemer') . "\n\n";
								$data.= print_r($this->options[$section_name][$css_selector], true);
								fwrite($write_file, $data);
								fclose($write_file);
							}
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// ajax - toggle draft mode
						if (isset($_GET['draft_mode'])) {

							$pref_array['draft_mode'] = intval($_GET['draft_mode']);
							// save current user in array
							if ($pref_array['draft_mode']){
								$pref_array['draft_mode_uids'][$this->current_user_id] = $this->current_user_id;
							} else {
								// reset if draft mode is off
								$pref_array['draft_mode_uids'] = array();
							}
							$this->savePreferences($pref_array);
							wp_die();
						}

						// selname_code_synced
						if (isset($_GET['selname_code_synced'])) {
							$pref_array['selname_code_synced'] = intval($_GET['selname_code_synced']);
							$this->savePreferences($pref_array);
							wp_die();
						}

						// code_manual_resize
						if (isset($_GET['code_manual_resize'])) {
							$pref_array['code_manual_resize'] = intval($_GET['code_manual_resize']);
							$this->savePreferences($pref_array);
							wp_die();
						}

						// ace full page html
						if (isset($_GET['wizard_expanded'])) {
							$pref_array['wizard_expanded'] = intval($_GET['wizard_expanded']);
							$this->savePreferences($pref_array);
							wp_die();
						}


						/*// wizard footer/right dock
						if (isset($_GET['dock_wizard_bottom'])) {
							$pref_array['dock_wizard_bottom'] = intval($_GET['dock_wizard_bottom']);
							$this->savePreferences($pref_array);
							wp_die();
						}
						*/

						// instant hover inspection
						if (isset($_GET['hover_inspect'])) {
							$pref_array['hover_inspect'] = intval($_GET['hover_inspect']);
							$this->savePreferences($pref_array);
							wp_die();
						}

						// ajax - update preview url after page navigation
						if (isset($_GET['mt_preview_url'])) {
							$this->maybe_set_preview_url();
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// ajax - update preview url after page navigation
						if (isset($_GET['import_css_url'])) {
							// update view_import_stylesheets list with possible new stylesheet
							$this->update_css_import_urls(strip_tags(rawurldecode($_GET['import_css_url'])));
							wp_die();
						}

						// code editor focus
						if (isset($_GET['show_code_editor'])) {
							$pref_array = array();
							$pref_array['show_code_editor'] = intval($_GET['show_code_editor']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// ruler show/hide
						if (isset($_GET['show_rulers'])) {
							$pref_array = array();
							$pref_array['show_rulers'] = intval($_GET['show_rulers']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// show/hide whole interface
						if (isset($_GET['show_interface'])) {
							$pref_array = array();
							$pref_array['show_interface'] = intval($_GET['show_interface']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// active MQ tab
						if (isset($_GET['mq_device_focus'])) {
							$pref_array = array();
							$pref_array['mq_device_focus'] = htmlentities($_GET['mq_device_focus']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// active CSS tab
						if (isset($_GET['css_focus'])) {
							$pref_array = array();
							$pref_array['css_focus'] = htmlentities($_GET['css_focus']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// update suggested values
						if (isset($_GET['update_sug_values'])) {

							$pref_array = array();
							$root_cat = $_GET['update_sug_values'];

							// tap into WordPress native JSON functions
							if( !class_exists('Moxiecode_JSON') ) {
								require_once($this->thisplugindir . 'includes/class-json.php');
							}

							$json_object = new Moxiecode_JSON();

							$data = $json_object->decode( stripslashes($_POST['tvr_serialized_data']) );

							// if we're setting suggested values for all properties
							if ($root_cat == 'all'){
								$this->preferences['my_props']['sug_values'] = $data;
								$pref_array['default_sug_values_set'] = 1;
							} else {
								// just setting suggestions for a type of property e.g. site_colors
								$this->preferences['my_props']['sug_values'][$root_cat] = $data;
							}

							$pref_array['my_props'] = $this->preferences['my_props'];
							$this->savePreferences($pref_array);

							echo '<pre>posted array: '.print_r($data, true).'</pre>';

							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// active property group
						if (isset($_GET['pg_focus'])) {
							$pref_array = array();
							$pref_array['pg_focus'] = htmlentities($_GET['pg_focus']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// remember selector wizard tab
						if (isset($_GET['adv_wizard_tab'])) {
							$pref_array = array();
							$pref_array['adv_wizard_tab'] = htmlentities($_GET['adv_wizard_tab']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// last viewed selector
						if (isset($_GET['last_viewed_selector'])) {
							$pref_array = array();
							$pref_array['last_viewed_selector'] = htmlentities($_GET['last_viewed_selector']);
							$this->savePreferences($pref_array);
							// kill the program - this action is always requested via ajax. no message necessary
							wp_die();
						}

						// download pack
						if (!empty($_GET['mt_action']) and
							$_GET['mt_action'] == 'tvr_download_pack') {
							if (!empty($_GET['dir_name'])) {
								// first of all, copy any images from the media library
								$pack = $_GET['dir_name'];
								$dir = $this->micro_root_dir . $pack;
								$json_config_file = $dir . '/config.json';
								if ($library_images = $this->get_linked_library_images($json_config_file)){
									foreach($library_images as $key => $path){
										$root_rel_path = $this->root_rel($path, false, true);
										$basename = basename($root_rel_path);
										$orig = rtrim(ABSPATH,"/"). $root_rel_path;
										$img_paths[] = $new = $dir . '/' . $basename;
										$replacements[$path] = $this->root_rel(
											$this->micro_root_url . $pack . '/' . $basename, false, true
										);
										if (!copy($orig, $new)){
											$this->log(
												esc_html__('Library image not downloaded', 'microthemer'),
												'<p>' . sprintf(esc_html__('%s could not be copied to the zip download file', 'microthemer'), $root_rel_path) . '</p>',
												'warning'
											);
											$download_status = 0;
										}
									}
									// cache original config file data
									$orig_json_data = $this->get_file_data($json_config_file);

									// update image paths in config.json for zip only (we'll restore shortly)
									$this->replace_json_paths($json_config_file, $replacements, $orig_json_data);
								}

								// now zip the contents
								if (
									$this->create_zip(
									$this->micro_root_dir,
									$pack,
									$this->thisplugindir.'zip-exports/')
									){
									$download_status = 1;
								} else {
									$download_status = 0;
								}
							}
							else {
								$download_status = 0;
							}
							// delete any media library images temporarily copied to the directory
							if ($library_images){
								// restore orgin config.json paths
								$this->write_file($json_config_file, $orig_json_data);
								// delete images
								foreach ($img_paths as $key => $path){
									if (!unlink($path)){
										$this->log(
											esc_html__('Temporary image could not be deleted.', 'microthemer'),
											'<p>' . sprintf( esc_html__('%s was temporarily copied to your theme pack before download but could not be deleted after the download operation finished.', 'microthemer'), $this->root_rel($root_rel_path) ) . '</p>',
											'warning'
										);
									}
								}
							}
							echo '
							<div id="microthemer-notice">'
								. $this->display_log() . '
								<span id="download-status" rel="'.$download_status.'"></span>
							</div>';
							wp_die();
						}

						// delete pack
						if (!empty($_GET['mt_action']) and
							$_GET['mt_action'] == 'tvr_delete_micro_theme') {
							if (!empty($_GET['dir_name']) and $this->tvr_delete_micro_theme($_GET['dir_name'])){
								$delete_status = 1;
							} else {
								$delete_status = 0;
							}
							echo '
							<div id="microthemer-notice">'
								. $this->display_log() . '
								<span id="delete-status" rel="'.$delete_status.'"></span>
							</div>';
							wp_die();
						}

						// download remote css file
						if (!empty($_GET['mt_action']) and
							$_GET['mt_action'] == 'tvr_get_remote_css') {
							$config['allowed_ext'] = array('css');
							$r = $this->get_safe_url(rawurldecode($_GET['url']), $config);
							echo '
							<div id="microthemer-notice">'
								. $this->display_log() . '
								<div id="remote-css">'.(!empty($r['content']) ? $r['content'] : 0).'</div>
							</div>';
							wp_die();
						}

						// if it's an import request
						if ( !empty($_POST['import_pack_or_css']) ){

							// if importing raw CSS
							if (!empty($_POST['stylesheet_import_json'])){

								$context = esc_attr__('Raw CSS', 'microthemer');
								$json_str = stripslashes($_POST['stylesheet_import_json']);
								$p = $_POST['tvr_preferences'];

								// checkbox values must be explicitly evaluated
								$p['css_imp_only_selected'] = !empty($p['css_imp_only_selected']) ? 1 : 0;

								// handle remote image import. See plugins that do this:
								// https://premium.wpmudev.org/blog/download-remote-images-into-wordpress/
								if (!empty($_POST['get_remote_images'])){

									$r_images = explode('|', $_POST['get_remote_images']);
									$do_copy = false;
									$remote_images = array();
									$all_r = array();
									foreach ($r_images as $i => $both){
										$tmp = explode(',', $both);
										$path_in_data = $tmp[0];
										$full_url = $tmp[1];
										// save to temp dir first
										$r = $this->get_safe_url($full_url, array(
											'allowed_ext' => array('jpg', 'jpeg', 'gif', 'png', 'svg'),
											'tmp_file' => 1
										));

										if ($r){
											$remote_images[$path_in_data] = $r['tmp_file'];
											$do_copy = true;
											//$all_r[++$i] = $r;
										}

									}

									// do image copy function
									if ($do_copy){

										$updated_json_str = $this->import_pack_images_to_library(
											false,
											'custom',
											$json_str,
											$remote_images
										);

										$json_str = $updated_json_str ? $updated_json_str : $json_str;
									}

								}

								// load the json file
								$this->load_json_file(false, 'custom', $context, $json_str);

								// save the import preferences
								$this->savePreferences($p);
							}

							// if importing an MT design pack
							else {


								$theme_name = sanitize_file_name(sanitize_title(htmlentities($_POST['import_from_pack_name'])));


								$json_file = $this->micro_root_dir . $theme_name . '/config.json';

								$context = $_POST['tvr_import_method'];

								// import any background images that may need moving to the media library and update json
								$this->import_pack_images_to_library($json_file, $theme_name);

								// load the json file
								$this->load_json_file($json_file, $theme_name, $context);

							}

							// update the revisions DB field
							if (!$this->updateRevisions($this->options, $this->json_format_ua(
								'import-from-pack lg-icon',
								esc_html__('Import', 'microthemer') . ' ('.$context.'):&nbsp;',
								$this->readable_name($theme_name)
							))) {
								$this->log('','','error', 'revisions');
							}

							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}



						// if it's a reset request
						elseif( isset($_GET['mt_action']) and $_GET['mt_action'] == 'tvr_ui_reset'){
							if ($this->resetUiOptions()) {
								$this->update_active_styles('customised');
								$item = esc_html__('Folders were reset', 'microthemer');
								$this->log(
									$item,
									'<p>' . esc_html__('The default empty folders have been reset.', 'microthemer') . '</p>',
									'notice'
								);
								// update the revisions DB field
								if (!$this->updateRevisions($this->options, $this->json_format_ua(
									'folder-reset lg-icon',
									$item
								))) {
									$this->log(
										esc_html__('Revision failed to save', 'microthemer'),
										'<p>' . esc_html__('The revisions table could not be updated.', 'microthemer') . '</p>',
										'notice'
									);
								}
							}
							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}

						// if it's a clear styles request
						elseif(isset($_GET['mt_action']) and $_GET['mt_action'] == 'tvr_clear_styles'){
							if ($this->clearUiOptions()) {
								$this->update_active_styles('customised');
								$item = esc_html__('Styles were cleared', 'microthemer');
								$this->log(
									$item,
									'<p>' . esc_html__('All styles were cleared, but your folders and selectors remain fully intact.', 'microthemer') . '</p>',
									'notice'
								);
								// update the revisions DB field
								if (!$this->updateRevisions($this->options, $item)) {
									$this->log('', '', 'error', 'revisions');
								}
							}
							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}

						// if it's an email error report request
						elseif(isset($_GET['mt_action']) and $_GET['mt_action'] == 'tvr_error_email'){
							$body = "*** MICROTHEMER ERROR REPORT | ".date('d/m/Y h:i:s a', $this->time)." *** \n\n";
							$body .= "PHP ERROR \n" . stripslashes($_POST['tvr_php_error']) . "\n\n";
							$body .= "BROWSER INFO \n" . stripslashes($_POST['tvr_browser_info']) . "\n\n";
							$body .= "SERIALISED POSTED DATA \n" . stripslashes($_POST['tvr_serialised_data']) . "\n\n";
							// An error can occur EITHER when saving to DB OR creating the active-styles.css
							// The php error line number will reveal this. If the latter is true, the DB data contains the posted data too (FYI)
							$body .= "SERIALISED DATA IN DB \n" . serialize($this->options). "\n\n";
							// write file to error-reports dir
							$file_path = 'error-reports/error-'.date('Y-m-d').'.txt';
							$error_file = $this->thisplugindir . $file_path;
							$write_file = fopen($error_file, 'w');
							fwrite($write_file, $body);
							fclose($write_file);
							// Determine from email address. Try to use validated customer email. Don't contact if not Microthemer customer.
							if ( !empty($this->preferences['buyer_email']) ) {
								$from_email = $this->preferences['buyer_email'];
								$body .= "MICROTHEMER CUSTOMER EMAIL \n" . $from_email;
							}
							else {
								$from_email = get_option('admin_email');
							}
							// Try to send email (won't work on localhost)
							$subject = 'Microthemer Error Report | ' . date('d/m/Y', $this->time);
							$to = 'support@themeover.com';
							$from = "Microthemer User <$from_email>";
							$headers = "From: $from";
							if(@mail($to,$subject,$body,$headers)) {
								$this->log(
									esc_html__('Email successfully sent', 'microthemer'),
									'<p>' . esc_html__('Your error report was successfully emailed to Themeover. Thanks, this really does help.', 'microthemer') . '</p>',
									'notice'
								);
							}
							else {
								$error_url = $this->thispluginurl . $file_path;
								$this->log(
									esc_html__('Report email failed', 'microthemer'),
									'<p>' . esc_html__('Your error report email failed to send (are you on localhost?)', 'microthemer') . '</p>
								<p>' .
									wp_kses(
										sprintf(
											__('Please email <a %1$s>this report</a> to %2$s', 'microthemer'),
											'target="_blank" href="' .$error_url . '"',
											'<a href="mailto:support@themeover.com">support@themeover.com</a>'
										),
										array( 'a' => array( 'href' => array(), 'target' => array() ) )
									)
									. '</p>'
								);
							}
							echo '
						<div id="microthemer-notice">'. $this->display_log() . '</div>';
							wp_die();
						}

						// if it's a restore revision request
						if(isset($_GET['mt_action']) and $_GET['mt_action'] == 'restore_rev'){
							$rev_key = $_GET['tvr_rev'];
							if ($this->restoreRevision($rev_key)) {
								$item = esc_html__('Previous settings restored', 'microthemer');
								$this->log(
									$item,
									'<p>' . esc_html__('Your settings were successfully restored from a previous save.', 'microthemer') . '</p>',
									'notice'
								);
								$this->update_active_styles('customised');
								// update the revisions DB field
								if (!$this->updateRevisions($this->options, $this->json_format_ua(
									'display-revisions lg-icon',
									$item
								))) {
									$this->log('','','error', 'revisions');
								}
							}
							else {
								$this->log(
									esc_html__('Settings restore failed', 'microthemer'),
									'<p>' . esc_html__('Data could not be restored from a previous save.', 'microthemer') . '</p>'
								);
							}
							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}

						// if it's a get revision ajax request
						elseif(isset($_GET['mt_action']) and $_GET['mt_action'] == 'get_revisions'){
							echo '<div id="tmp-wrap">' . $this->getRevisions() . '</div>'; // outputs table
							wp_die();
						}


						/* PREFERENCES FUNCTIONS MOVED TO MAIN UI */

						// update the MQs
						if (isset($_POST['tvr_media_queries_submit'])){
							// remove backslashes from $_POST
							$_POST = $this->deep_unescape($_POST, 0, 1, 1);
							// get the initial scale and default width for the "All Devices" tab
							$pref_array['initial_scale'] = $_POST['tvr_preferences']['initial_scale'];
							$pref_array['all_devices_default_width'] = $_POST['tvr_preferences']['all_devices_default_width'];
							// reset default media queries if all empty
							$action = '';
							if (empty($_POST['tvr_preferences']['m_queries'])) {
								$pref_array['m_queries'] = $this->default_m_queries;
								$action = 'reset';
							} else {
								$pref_array['m_queries'] = $_POST['tvr_preferences']['m_queries'];
								$action = 'update';
							}
							// are we merging/overwriting with a new media query set
							if (!empty($_POST['tvr_preferences']['load_mq_set'])){
								//print_r($this->mq_sets);
								$action = 'load_set';
								$new_set = $_POST['tvr_preferences']['load_mq_set'];
								$new_mq_set = $this->mq_sets[$new_set];
								$pref_array['overwrite_existing_mqs'] = $_POST['tvr_preferences']['overwrite_existing_mqs'];
								if (!empty($pref_array['overwrite_existing_mqs'])){
									$pref_array['m_queries'] = $new_mq_set;
									$load_action = esc_html__('replaced', 'microthemer');
								} else {
									$pref_array['m_queries'] = array_merge($pref_array['m_queries'], $new_mq_set);
									$load_action = esc_html__('was merged with', 'microthemer');
								}
							}

							// format media query min/max width (height later) and units
							$pref_array['m_queries'] = $this->mq_min_max($pref_array);

							// save and preset message
							$pref_array['num_saves'] = ++$this->preferences['num_saves'];
							if ($this->savePreferences($pref_array)) {

								switch ($action) {
									case 'reset':
										$this->log(
											esc_html__('Media queries were reset', 'microthemer'),
											'<p>' . esc_html__('The default media queries were successfully reset.', 'microthemer') . '</p>',
											'notice'
										);
										break;
									case 'update':
										$this->log(
											esc_html__('Media queries were updated', 'microthemer'),
											'<p>' . esc_html__('Your media queries were successfully updated.', 'microthemer') . '</p>',
											'notice'
										);
										break;
									case 'load_set':
										$this->log(
											esc_html__('Media query set loaded', 'microthemer'),
											'<p>' . sprintf( esc_html__('A new media query set %1$s your existing media queries: %2$s', 'microthemer'), $load_action, htmlentities($_POST['tvr_preferences']['load_mq_set']) ) . '</p>',
											'notice'
										);
										break;
								}

							}
							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}

						// update the MQs
						if (isset($_POST['mt_enqueue_js_submit'])){
							// remove backslashes from $_POST
							$_POST = $this->deep_unescape($_POST, 0, 1, 1);
							$pref_array['enq_js'] = $_POST['tvr_preferences']['enq_js'];
							$pref_array['num_saves'] = ++$this->preferences['num_saves'];
							// save and present message
							if ($this->savePreferences($pref_array)) {
								$this->log(
									esc_html__('Enqueued scripts were updated', 'microthemer'),
									'<p>' . esc_html__('Your enqueued scripts were successfully updated.', 'microthemer') . '</p>',
									'notice'
								);
							}
							// save last message in database so that it can be displayed on page reload (just once)
							$this->cache_global_msg();
							wp_die();
						}

						// reset default preferences
						if (isset($_POST['tvr_preferences_reset'])) {
							check_admin_referer('tvr_preferences_reset');
							$pref_array = $this->default_preferences;
							if ($this->savePreferences($pref_array)) {
								$this->log(
									esc_html__('Preferences were reset', 'microthemer'),
									'<p>' . esc_html__('The default program preferences were reset.', 'microthemer') . '</p>',
									'notice'
								);
							}
						}


						// css filter configs
						$filter_types = array('page_specific', 'pseudo_classes', 'pseudo_elements', 'favourite_filter');
						foreach ($filter_types as $type){
							if (isset($_GET[$type])) {
								$this->preferences[$type][$_GET['pref_sub_key']] = intval($_GET[$type]);
								$pref_array[$type] = $this->preferences[$type];
								$this->savePreferences( $pref_array );
								//echo '<pre>'. print_r($this->preferences[$type], true).'</pre>';
								wp_die();
							}
						}

						// if we got to hear, the ajax request didn't work as intended, so warn
						echo 'Yo! The Ajax call failed to trigger any function. Sort it out.';
						wp_die();

					}

					// Not an ajax call, show the interface

					// validate email
					if (isset($_POST['tvr_ui_validate_submit'])) {
						// urlencode allows for Gmail + chars in email
						$params = 'email='.rawurlencode($_POST['tvr_preferences']['buyer_email']).'&domain='.$this->home_url;
						//$this->show_me = $params;
						$validation = wp_remote_fopen('http://themeover.com/wp-content/tvr-auto-update/validate.php?'.$params);
						//$this->show_me = $validation;
						if ($validation) {
							$_POST['tvr_preferences']['buyer_validated'] = 1;
							$this->trial = 0;
							if (!$this->preferences['buyer_validated']) { // not already validated
								$this->log(
									esc_html__('Full program unlocked!', 'microthemer'),
									'<p>' . esc_html__('Your email address has been successfully validated. Microthemer\'s full program features have been unlocked!', 'microthemer') . '</p>',
									'notice'
								);
							} else {
								$this->log(
									esc_html__('Already validated', 'microthemer'),
									'<p>' . esc_html__('Your email address has already been validated. The full program is currently active.', 'microthemer') . '</p>',
									'notice'
								);
							}
						}
						else {
							//=chris please do checks on why validation failed here and report to user
							$_POST['tvr_preferences']['buyer_validated'] = 0;
							$this->trial = true;
							$this->log(
								esc_html__('Validation failed', 'microthemer'),
								'<p>' . esc_html__('Your email address could not be validated. Please try the following:', 'microthemer') . '</p>
								<ul>' .
								'<li>' . wp_kses(
									sprintf(
										__('Make sure you are entering your <b>PayPal email address</b> (which may be different from your themeover.com member email address you registered with, or the email address you provided when downloading the free trial). The correct email address to unlock the program will be shown on <a %s>My Downloads</a>', 'microthemer' ),
										'target="_blank" href="http://rebrand.themeover.com/login/"' ),
									array( 'a' => array( 'href' => array(), 'target' => array() ), 'b' => array() )
								) . '</li>' .
								'<li>' . wp_kses(
									sprintf(
										__('If you purchased Microthemer from <b>CodeCanyon</b>, please send us a "Validate my email" message via the contact form on the right hand side of <a %s>this page</a> (you will need to ensure that you are logged in to CodeCanyon).', 'microthemer'),
										'target="_blank" href="http://codecanyon.net/user/themeover"' ),
									array( 'a' => array( 'href' => array(), 'target' => array() ), 'b' => array() )
								) . '</li>' .
								'<li>' . wp_kses(
									sprintf(
										__('The connection to Themeover\'s server may have failed due to an intermittent network error. <span %s>Resubmitting your email one more time</span> may do the trick.', 'microthemer'),
										'class="link show-dialog" rel="unlock-microthemer"' ),
									array( 'span' => array() ) )
								. '</li>' .
								'<li>' . wp_kses(__('Try temporarily <b>disabling any plugins</b> that may be blocking Microthemer\'s connection to the valid users database on themeover.com. You can re-enable them after you unlock Microthemer. WP Security plugins sometimes block Microthemer.', 'microthemer'), array( 'b' => array() )) . '</li>' .
								'<li>' . esc_html__('Security settings on your server may block all outgoing PHP connections to domains not on a trusted whitelist (e.g. sites that are not wordpress.org). Ask your web host about unblocking themeover.com - even if they just do it temporarily to allow you to activate the plugin.', 'microthemer') . '</li>'
								. '</ul>
								<p>' .
								wp_kses(
									sprintf(
										__('If none of the above solve your problem please send WP login details for the site you\'re working on using <a %1$s>this secure contact form</a>. Please remember to include the URL to your website along with the username and password. If you\'d prefer not to provide login details please send us an email via the <a %1$s>contact form</a> to discuss alternative measures.', 'microthemer'),
										'target="_blank" href="https://themeover.com/support/contact/"'),
									array( 'a' => array(
										'href' => array(), 'target' => array() )
									)
								)
								. '</p>'
							);
						}
						$pref_array = $_POST['tvr_preferences'];
						if (!$this->savePreferences($pref_array)) {
							$this->log(
								esc_html__('Unlock status not saved', 'microthemer'),
								'<p>' . esc_html__('Your validation status could not be saved. The program may need to be unlocked again.', 'microthemer') . '</p>'
							);
						}
					}

					// if draft mode is on, but user accessing MT GUI isn't in draft_mode_uids array,
					// add them so they see latest draft changes
					if ($this->preferences['draft_mode'] and
						!in_array($this->current_user_id, $this->preferences['draft_mode_uids'])){
						$pref_array['draft_mode_uids'] = $this->preferences['draft_mode_uids'];
						$pref_array['draft_mode_uids'][$this->current_user_id] = $this->current_user_id;
						$this->savePreferences($pref_array);
					}

					// if user navigates from front to MT via toolbar, set previous front page in preview
					$this->maybe_set_preview_url('mt-front-nonce');

					// include user interface
					include $this->thisplugindir . 'includes/tvr-microthemer-ui.php';

				}
			}

			// Documentation page
			function microthemer_docs_page(){
				// only run code on docs page
				if ($_GET['page'] == $this->docspage) {
					include $this->thisplugindir . 'includes/internal-docs.php';
				}
			}

			// Documentation menu
			function docs_menu($propertyOptions, $cur_prop_group, $cur_property){
				?>
				<div id="docs-menu">
					<ul class="docs-menu">
						<li class="doc-item css-ref-side">
							<?php $this->show_css_index($propertyOptions, $cur_prop_group, $cur_property); ?>
						</li>
					</ul>
				</div>
				<?php
			}

			// function for showing all CSS properties
			function show_css_index($propertyOptions, $cur_prop_group, $cur_property) {
				// output all help snippets
				$i = 1;
				foreach ($propertyOptions as $property_group_name => $prop_array) {
					$ul_class = $arrow_cls = '';
					if ($i&1) { $ul_class.= 'odd'; }
					if ($property_group_name == $cur_prop_group) { $ul_class.= ' show-content'; $arrow_cls = 'on'; }
					//if ($property_group_name == 'code') continue;
					?>
					<ul id="<?php echo $property_group_name; ?>"
						class="css-index <?php echo $ul_class; ?> accordion-menu">

						<li class="css-group-heading accordion-heading">
							<span class="pg-icon pg-icon-<?php echo $property_group_name; ?> no-click"></span>
							<span class="menu-arrow accordion-menu-arrow tvr-icon <?php echo $arrow_cls; ?>" title="Open/close group"></span>
							<span class="text-for-group"><?php echo $this->property_option_groups[$property_group_name]; ?></span>
						</li>

						<?php
						foreach ($prop_array as $property_id => $array) {
							$li_class = '';
							if ($property_id == $cur_property) { $li_class.= 'current'; }
							if (!empty($array['field-class'])) { $li_class.= ' '.$array['field-class']; }
							?>
							<li class="property-item accordion-item <?php echo $li_class; ?>">
								<a href="<?php echo 'admin.php?page=' . $this->docspage; ?>&prop=<?php echo $property_id; ?>&prop_group=<?php echo $property_group_name; ?>">
									<span class="option-icon-<?php echo $property_id; ?> option-icon no-click"></span>
									<span class="option-text"><?php echo $array['label']; ?></span>
								</a>

							</li><?php
						}
						++$i;
						?>
					</ul>
				<?php
				}
			}



			// Manage Micro Themes page
			function manage_micro_themes_page() {
				// only run code if it's the manage themes page
				if ( $_GET['page'] == $this->microthemespage ) {

					// handle zip upload
					$this->process_uploaded_zip();

					// notify that design pack was successfully deleted (operation done via ajax on single pack page)
					if (!empty($_GET['mt_action']) and $_GET['mt_action'] == 'tvr_delete_ok') {
						check_admin_referer('tvr_delete_ok');
						$this->log(
							esc_html__('Design pack deleted', 'microthemer'),
							'<p>' . esc_html__('The design pack was successfully deleted.', 'microthemer') . '</p>',
							'notice'
						);
					}

					/* create new micro theme
					if (isset($_POST['tvr_create_micro_submit'])) {
						check_admin_referer('tvr_create_micro_submit');
						$micro_name = esc_attr( $_POST['micro_name']);
						if ( !empty($micro_name) ) {
							$this->create_micro_theme($micro_name, 'create', '');
						}
						else {
							$this->log(
								esc_html__('Please specify a name', 'microthemer'),
								'<p>' . esc_html__('You didn\'t enter anything in the "Name" field. Please try again.', 'microthemer') . '</p>'
							);

						}
					}
					*/

					// handle edit micro selection
					if (isset($_POST['tvr_edit_micro_submit'])) {
						check_admin_referer('tvr_edit_micro_submit');
						$pref_array = array();
						$pref_array['theme_in_focus'] = $_POST['preferences']['theme_in_focus'];
						$this->savePreferences($pref_array);
					}

					// activate theme
					if (
						!empty($_GET['mt_action']) and
						$_GET['mt_action'] == 'tvr_activate_micro_theme') {
						check_admin_referer('tvr_activate_micro_theme');
						$theme_name = $this->preferences['theme_in_focus'];
						$json_file = $this->micro_root_dir . $theme_name . '/config.json';
						$this->load_json_file($json_file, $theme_name);
						// update the revisions DB field
						$user_action = sprintf(
							esc_html__('%s Activated', 'microthemer'),
							'<i>' . $this->readable_name($theme_name) . '</i>'
						);
						if (!$this->updateRevisions($this->options, $user_action)) {
							$this->log('', '', 'error', 'revisions');
						}
					}
					// deactivate theme
					if (
						!empty($_GET['mt_action']) and
						$_GET['mt_action'] == 'tvr_deactivate_micro_theme') {
						check_admin_referer('tvr_deactivate_micro_theme');
						$pref_array = array();
						$pref_array['active_theme'] = '';
						if ($this->savePreferences($pref_array)) {
							$this->log(
								esc_html__('Item deactivated', 'microthemer'),
								'<p>' .
								sprintf(
									esc_html__('%s was deactivated.', 'microthemer'),
									'<i>'.$this->readable_name($this->preferences['theme_in_focus']).'</i>' )
								. '</p>',
								'notice'
							);
						}
					}

					// include manage micro interface (both loader and themer plugins need this)
					include $this->thisplugindir . 'includes/tvr-manage-micro-themes.php';
				}
			}

			// Manage single page
			function manage_single_page() {
				// only run code on preferences page
				if( $_GET['page'] == $this->managesinglepage ) {

					// handle zip upload
					$this->process_uploaded_zip();

					// update meta.txt
					if (isset($_POST['tvr_edit_meta_submit'])) {
						check_admin_referer('tvr_edit_meta_submit');
						$this->update_meta_file($this->micro_root_dir . $this->preferences['theme_in_focus'] . '/meta.txt');
					}

					// update readme.txt
					if (isset($_POST['tvr_edit_readme_submit'])) {
						check_admin_referer('tvr_edit_readme_submit');
						$this->update_readme_file($this->micro_root_dir . $this->preferences['theme_in_focus'] . '/readme.txt');
					}

					// upload a file
					if (isset($_POST['tvr_upload_file_submit'])) {
						check_admin_referer('tvr_upload_file_submit');
						$this->handle_file_upload();
					}

					// delete a file
					if (
						!empty($_GET['mt_action']) and
						$_GET['mt_action'] == 'tvr_delete_micro_file') {
						check_admin_referer('tvr_delete_micro_file');
						$root_rel_path = $this->root_rel($_GET['file'], false, true);
						$delete_ok = true;
						// remove the file from the media library
						if ($_GET['location'] == 'library'){
							global $wpdb;
							$img_path = $_GET['file'];
							// We need to get the images meta ID.
							/*$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($img_path)
								. "' AND post_type = 'attachment'";*/
							$query = $wpdb->prepare("SELECT ID FROM wp_posts where guid = '%s' AND post_type = 'attachment'", esc_url($img_path));
							$results = $wpdb->get_results($query);
							// And delete it
							foreach ( $results as $row ) {
								//delete the image and also delete the attachment from the Media Library.
								if ( false === wp_delete_attachment( $row->ID )) {
									$delete_ok = false;
								}
							}
						}
						// regular delete of pack file
						else {
							if ( !unlink(ABSPATH . $root_rel_path) ) {
								$delete_ok = false;
							} else {
								// remove from file_structure array
								$file = basename($root_rel_path);
								if (!$this->is_screenshot($file)){
									$key = $file;
								} else {
									$key = 'screenshot';
									// delete the screenshot-small too
									$thumb = str_replace('screenshot', 'screenshot-small', $root_rel_path);
									if (is_file(ABSPATH . $thumb)){
										unlink(ABSPATH . $thumb);
										unset($this->file_structure[$this->preferences['theme_in_focus']][basename($thumb)]);
									}
								}
								unset($this->file_structure[$this->preferences['theme_in_focus']][$key]);
							}
						}
						if ($delete_ok){
							$this->log(
								esc_html__('File deleted', 'microthemer'),
								'<p>' . sprintf( esc_html__('%s was successfully deleted.', 'microthemer'), htmlentities($root_rel_path) ) . '</p>',
								'notice'
							);
							// update paths in json file
							$json_config_file = $this->micro_root_dir . $this->preferences['theme_in_focus'] . '/config.json';
							$this->replace_json_paths($json_config_file, array($root_rel_path => ''));
						} else {
							$this->log(
								esc_html__('File delete failed', 'microthemer'),
								'<p>' . sprintf( esc_html__('%s was not deleted.', 'microthemer'), htmlentities($root_rel_path) ) . '</p>'
							);
						}
					}


					// include preferences interface (only microthemer)
					if (TVR_MICRO_VARIANT == 'themer') {
						include $this->thisplugindir . 'includes/tvr-manage-single.php';
					}

				}
			}

			// Preferences page
			function microthemer_preferences_page() {
				// only run code on preferences page
				if( $_GET['page'] == $this->preferencespage ) {

					// include preferences interface (only microthemer)
					if (TVR_MICRO_VARIANT == 'themer') {
						// this is a separate include because it needs to have separate page for changing gzip
						$page_context = $this->preferencespage;
						echo '
						<div id="tvr" class="wrap tvr-wrap">
							<span id="ui-url" rel="admin.php?page=' . $this->preferencespage.'"></span>
							<div id="pref-standalone">
							<div id="full-logs">
								'.$this->display_log().'
							</div>';
							include $this->thisplugindir . 'includes/tvr-microthemer-preferences.php';
							echo '
							</div>';

							$this->hidden_ajax_loaders();

						echo '
						</div>';
					}
				}
			}

			/* add run if admin page condition...? */

			/***
			Generic Functions
			***/

			// get min/max media query screen size
			function get_screen_size($q, $minmax) {
				$pattern = "/$minmax-width:\s*([0-9\.]+)\s*(px|em|rem)/";
				if (preg_match($pattern, $q, $matches)) {
					//echo print_r($matches);
					return $matches;
				} else {
					return 0;
				}
			}

			// show plugin menu
			function plugin_menu() {
				?>
				<div id='plugin-menu' class="fixed-subsection">
				<h3>Plugin Menu</h3>
				<div class='menu-option-wrap'>
				<a id="tvr-item-1" href='admin.php?page=<?php echo $this->microthemeruipage;?>' title="<?php esc_attr_e('Go to Microthemer UI Page', 'microthemer') ?>">UI</a>
				<a id="tvr-item-2" href='admin.php?page=<?php echo $this->microthemespage;?>' title="<?php esc_attr_e('Go to Manage Micro Themes Page', 'microthemer') ?>">Manage</a>
				<a id="tvr-item-3" href='admin.php?page=<?php echo $this->preferencespage;?>' title="<?php esc_attr_e('Go to Microthemer Preferences Page', 'microthemer') ?>">Options</a>
				</div>
				</div>
				<?php
			}

			// show need help videos
			function need_help_notice() {
				if ($this->preferences['need_help'] == '1' and TVR_MICRO_VARIANT != 'loader') {
					?>
					<p class='need-help'><b><?php esc_html_e('Need Help?', 'microthemer'); ?></b>
					<?php echo wp_kses(
						sprintf(
							__('Browse Our <span %1$s>Video Guides</span> and <span %2$s>Tutorials</span> or <span %3$s>Search Our Forum</span>', 'microthemer'),
							'class="help-trigger" rel="' . $this->thispluginurl.'includes/help-videos.php',
							'class="help-trigger" rel="' . $this->thispluginurl.'includes/tutorials.php',
							'class="help-trigger" rel="' . $this->thispluginurl.'includes/search-forum.php'
						),
						array( 'span' => array() )
					); ?></p>
				<?php
				}
			}

			/* Simple function to check for the browser
			For checking chrome faster notice and FF bug if $.browser is deprecated soon
			http://php.net/manual/en/function.get-browser.php */
			function check_browser(){
				$u_agent = $_SERVER['HTTP_USER_AGENT'];
				$ub = 'unknown-browser';
				if(preg_match('/(MSIE|Trident)/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
					$ub = "MSIE";
				}
				elseif(preg_match('/Firefox/i',$u_agent)){
					$ub = "Firefox";
				}
				elseif(preg_match('/Chrome/i',$u_agent)){
					$ub = "Chrome";
				}
				elseif(preg_match('/Safari/i',$u_agent)){
					$ub = "Safari";
				}
				elseif(preg_match('/Opera/i',$u_agent)){
					$ub = "Opera";
				}
				elseif(preg_match('/Netscape/i',$u_agent)){
					$ub = "Netscape";
				}
				return $ub;
			}

			// ie notice
			function ie_notice() {
				// display ie message unless disabled
				//global $is_IE;
				if ($this->preferences['ie_notice'] == '1' and $this->check_browser() != 'Chrome') {
					$this->log(
						esc_html__('Chrome Is Faster', 'microthemer'),
						'<p>' .
						sprintf(
							esc_html__('We\'ve noticed that Microthemer runs considerably faster in Chrome than other browsers. Actions like switching tabs, property groups, and accessing preferences are instant in Chrome but can incur a half second delay on other browsers. Speed improvements will be a major focus in our next phase of development. But for now, you can avoid these issues simply by using Microthemer with %1$s. Internet Explorer 9 and below isn\'t supported at all.', 'microthemer'),
							'<a target="_blank" href="http://www.google.com/intl/' . esc_attr_x('en-US', 'Chrome URL slug: https://www.google.com/intl/en-US/chrome/browser/welcome.html', 'microthemer') . '/chrome/browser/welcome.html">Google Chrome</a>'
						)
						. '</p><p>' .
						wp_kses(__('<b>Note</b>: Web browsers do not conflict with each other, you can install as many as you want on your computer at any one time. But if you love your current browser you can turn this message off on the preferences page.', 'microthemer'), array( 'b' => array() ))
					. '</p>',
						'warning'
					);
				}
			}

			// tell them to get validated
			function validate_reminder() {
				if (!$this->preferences['buyer_validated'] and TVR_MICRO_VARIANT == 'themer') {
					?>
					<div id='validate-reminder' class="error">
					<p><b><?php esc_html_e('IMPORTANT - Free Trial Mode is Active', 'microthemer'); ?></b><br /> <br />
						<?php echo wp_kses(
							sprintf( __('Please <a %s>validate your purchase to unlock the full program</a>.', 'microthemer'),
								'href="admin.php?page=tvr-microthemer-preferences.php#validate"' ),
								array( 'a' => array( 'href' => array() ) ) ); ?>
						<br />
						<?php esc_html_e('The Free Trial limits you to editing or creating 15 Selectors.', 'microthemer'); ?>
					</p>
					<p><?php echo wp_kses(
						sprintf( __('Purchase a <a %1$s>Standard</a> ($45) or <a %1$s>Developer</a> ($90) License Now!', 'microthemer'),
							'target="_blank" href="http://themeover.com/microthemer/"'),
							array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></p>
					<p><?php echo wp_kses(
						sprintf( __('<b>This Plugin is Supported!</b> Themeover provides the <a %s>best forum support</a> you\'ll get any where (and it\'s free of course)',
								'microthemer'),
							'target="_blank" href="http://themeover.com/forum/"' ),
							array( 'a' => array( 'href' => array(), 'target' => array() ), 'b' => array() ) ); ?></p>
					</div>
				<?php
				}
			}

			// show server info
			function server_info() {
				global $wpdb;
				// get MySQL version
				$sql_version = $wpdb->get_var("SELECT VERSION() AS version");
				// evaluate PHP safe mode
				if(ini_get('safe_mode')) {
					$safe_mode = 'On';
				}
				else {
					$safe_mode = 'Off';
				}
				?>
				&nbsp;Operating System:<br />&nbsp;<b><?php echo PHP_OS; ?> (<?php echo (PHP_INT_SIZE * 8) ?> Bit)</b><br />

				&nbsp;MySQL Version:<br />&nbsp;<b><?php echo $sql_version; ?></b><br />
				&nbsp;PHP Version:<br />&nbsp;<b><?php echo PHP_VERSION; ?></b><br />
				&nbsp;PHP Safe Mode:<br />&nbsp;<b><?php echo $safe_mode; ?></b><br />
				<?php
			}

			// get all-devs and the MQS into a single simple array
			function combined_devices(){
				$comb_devs['all-devices'] = array(
					'label' => esc_html__('All Devices', 'microthemer'),
					'query' => esc_html__('General CSS that will apply to all devices', 'microthemer'),
					'min' => 0,
					'max' => 0
				);
				foreach ($this->preferences['m_queries'] as $key => $m_query) {
					$comb_devs[$key] = $m_query;
				}
				return $comb_devs;
			}

			// get micro-theme dir file structure
			function dir_loop($dir_name) {
				if (empty($this->file_structure)) {
					$this->file_structure = array();
				}
				// check for micro-themes folder, create if doesn't already exist
				if ( !is_dir($dir_name) ) {
					if ( !wp_mkdir_p($dir_name) ) {
						$this->log(
							esc_html__('/micro-themes folder error', 'microthemer'),
							'<p>' .
							sprintf(
								esc_html__('WordPress was not able to create the %s directory.', 'microthemer'),
								$this->root_rel($dir_name)
							) . $this->permissionshelp . '</p>'
						);
						return false;
					}
				}
				if ($handle = opendir($dir_name)) {
					$count = 0;
					 /* This is the correct way to loop over the directory. */
					 while (false !== ($file = readdir($handle))) {
						if ($file != '.' and $file != '..' and $file != '_debug') {
							$file = htmlentities($file); // just in case
							if ($this->is_acceptable($file) or !preg_match('/\./',$file)) {
								 // if it's a directory
								 if (!preg_match('/\./',$file) ) {
									$this->file_structure[$file] = '';
									$next_dir = $dir_name . $file . '/';
									// loop through the contents of the micro theme
									$this->dir_loop($next_dir);
								 }
								 // it's a normal file
								 else {
									$just_dir = str_replace($this->micro_root_dir, '', $dir_name);
									$just_dir = str_replace('/', '', $just_dir);
									if ($this->is_screenshot($file)){
										$this->file_structure[$just_dir]['screenshot'] = $file;
									} else {
										$this->file_structure[$just_dir][$file] = $file;
									}

									++$count;
								}
							}
						}
					}
					closedir($handle);
				}
				if (is_array($this->file_structure)) {
					ksort($this->file_structure);
				}
				return $this->file_structure;
			}

			// display abs file path relative to the root dir (for notifications)
			function root_rel($path, $markup = true, $url = false) {
				// normalise \/ slashes
				$abspath_fs = untrailingslashit(str_replace('\\', '/', ABSPATH));
				$path = str_replace('\\', '/', $path);
				if ($markup == true) {
					$rel_path = '<b><i>/' . str_replace($abspath_fs, '', $path) . '</i></b>';
				}
				else {
					$rel_path = str_replace($abspath_fs, '', $path);
				}
				// root relative url (works on mixed ssl sites and if WP is in a subfolder of the doc root - getenv())
				if ($url){
					$script_name = getenv("SCRIPT_NAME");
					$rel_path = substr($script_name, 0, -(strlen($script_name))) . str_replace($this->site_url, '', $path);
				}
				return $rel_path;
			}

			// get extension
			function get_extension($file) {
				$ext = strtolower(substr($file, strrpos($file, '.') + 1));
				$ext = explode('?', $ext);
				return $ext[0];
			}

			// use wp_remote_fopen with some validation checks
			function get_safe_url($uri, $config = array(), $msg_type = 'warning') {

				$r = array();

				// bail if not an URL
				if (!preg_match('/^(https?:)?\/\//i', $uri)){
					$this->log(
						esc_html__('Invalid URL', 'microthemer'),
						'<p>'.esc_html($uri).'</p>',
						'error'
					);
					return false;
				}

				// bail if not correct extension
				if (!empty($config['allowed_ext']) && !in_array($this->get_extension($uri), $config['allowed_ext'])) {
					$this->log(
						esc_html__('Disallowed file extension', 'microthemer'),
						'<p>Please enter an URL with one of the following extensions: '.
						implode(', ', $config['allowed_ext']).'</p>',
						'error'
					);
					return false;
				}

				// check if file exists
				if (!$this->url_exists($uri)){
					return false;
				}

				// it seems ok so get contents of file into string
				if (!$r['content'] = wp_remote_fopen($uri)){
					$this->log(
						esc_html__('File is empty', 'microthemer'),
						'<p>'.esc_html($uri).'</p>',
						$msg_type
					);
					return false;
				}

				// do we need to save as file in tmp dir?
				if (!empty($config['tmp_file'])){
					$r['tmp_file'] = $this->thistmpdir . basename($uri);
					$this->write_file($r['tmp_file'], $r['content']);
				}

				return $r;
			}

			// check if an URL exists (WP can return 404 custom page giving illusion file exists)
			function url_exists($url) {
				$response = wp_remote_get( esc_url_raw($url) );
				// my half-done ssl on localhost fails here, so warn others
				if ( is_wp_error( $response ) ) {
					$str = '';
					foreach ($response->errors as $key => $err_arr){
						$str.= '<p>'.$key.': '.implode(', ', $err_arr).'</p>';
					}
					$this->log(
						esc_html__('Could not get file', 'microthemer'),
						'<p>'.esc_html($url). '</p>'
						.$str
					);
					return false;
				}
				if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
					$this->log(
						esc_html__('File does not exist', 'microthemer'),
						'<p>'.esc_html($url).'</p>'
					);
					return false;
				}
				return true;
			}

			// is english
			function is_en() {
				if ($this->locale == 'en_GB' or $this->locale == 'en_US') return true;
				return false;
			}

			// WordPress normalises magic_quotes, if magic_quotes are enabled.
			// Even though deprecated: http://wordpress.stackexchange.com/questions/21693/wordpress-and-magic-quotes
			// Useful WP functions: stripslashes_deep() and add_magic_quotes() (both recursive)
			// $do is for easy dev experimenting.
			function stripslashes($val, $do = false){
				return $do ? stripslashes_deep($val): $val;
			}
			function addslashes($val, $do){
				return $do ? add_magic_quotes($val): $val;
			}
			// WP magic_quotes hack doesn't escape \ properly, so this is my workaround
			function unescape_cus_slashes($val){
				return str_replace('&#92;', '\\', $val);
			}
			// Another workaround I came up with along time ago without fully understanding wp magic_quotes, but works too.
			function unescape_cus_quotes($val){
				$val = str_replace('cus-quot;', '"', $val);
				$val = str_replace('cus-#039;', '\'', $val);
				return $val;
			}
			// Unescape slashes and cus quotes recursively
			function deep_unescape($array, $cus_quotes = false, $slashes = false, $cus_slashes = false){
				foreach ( (array) $array as $k => $v ) {
					if (is_array($v)) {
						$array[$k] = $this->deep_unescape($v, $cus_quotes, $slashes, $cus_slashes);
					} else {
						if ($cus_quotes){
							$array[$k] = $this->unescape_cus_quotes($v);
						}
						if ($slashes){
							$array[$k] = stripslashes($array[$k]);
						}
						if ($cus_slashes){
							$array[$k] = $this->unescape_cus_slashes($array[$k]);
						}
					}
				}
				return $array;
			}

			// make server folder readable
			function readable_name($name) {
				$readable_name = str_replace('_', ' ', $name);
				$readable_name = ucwords(str_replace('-', ' ', $readable_name));
				return $readable_name;
			}

			// convert text to param (same as JS function)
			function to_param($str) {
				$str = str_replace(' ', '_', $str);
				$str = strtolower(preg_replace("/[^A-Za-z0-9_]/", '', $str));
				return $str;
			}

			// populate the default folders global array with translated strings
			function set_default_folders() {
				$folders = array(
					'general' => __('General', 'microthemer'), // Auto-create General 2, 3 etc when +25 selectors
					'header' => __('Header', 'microthemer'),
					'main_menu' => __('Main Menu', 'microthemer'),
					'content' => __('Content', 'microthemer'),
					'sidebar' => __('Sidebar', 'microthemer'),
					'footer' => __('Footer', 'microthemer')
				);
				foreach ($folders as $en_slug => $label){
					//$this->default_folders[$this->to_param($label)] = '';
					$this->default_folders[$this->to_param($label)]['this'] = array(
						'label' => $label
					);
				}
			}

			// check if the file is an image
			function is_image($file) {
				$ext = $this->get_extension($file);
				if ($ext == 'jpg' or
				$ext == 'jpeg' or
				$ext == 'png' or
				$ext == 'gif'
				) {
					return true;
				}
				else {
					return false;
				}
			}

			// check if it's a screenshot image
			function is_screenshot($file) {
				if(strpos($file, 'screenshot.', 0) !== false) {
					return true;
				}
				else {
					return false;
				}
			}

			// check a multidimentional array for a value
			function in_2dim_array($str, $array, $target_key){
				foreach ($array as $key => $arr2) {
					if ($arr2[$target_key] == $str) {
						return $key;
					}
				}
				return false;
			}

			//check if the file is acceptable
			function is_acceptable($file) {
				$ext = $this->get_extension($file);
				if ($ext == 'jpg' or
				$ext == 'jpeg' or
				$ext == 'png' or
				$ext == 'gif' or
				$ext == 'txt' or
				$ext == 'json' or
				$ext == 'psd' or
				$ext == 'ai'
				) {
					return true;
				}
				else {
					return false;
				}
			}


			// get list of acceptable file types
			function get_acceptable() {
				$acceptable = array (
					'jpg',
					'jpeg',
					'png',
					'gif',
					'txt',
					'json',
					'psd',
					'ai');
					return $acceptable;
			}

			// rename dir if dir with same name exists in same location
			function rename_if_required($dir_path, $name) {
				if ( is_dir($dir_path . $name ) ) {
					$suffix = 1;
					do {
						$alt_name = substr ($name, 0, 200 - ( strlen( $suffix ) + 1 ) ) . "-$suffix";
						$dir_check = is_dir($dir_path . $alt_name);
						$suffix++;
					} while ( $dir_check );
					return $alt_name;
				}
				return false;
			}

			// rename the to-be-merged section
			function get_alt_section_name($section_name, $orig_settings, $new_settings) {
				$suffix = 2;
				do {
					$alt_name = substr ($section_name, 0, 200 - ( strlen( $suffix ) + 1 ) ) . "_$suffix";
					$context = 'alt-check';
					$conflict = $this->is_name_conflict($alt_name, $orig_settings, $new_settings, $context);
					$suffix++;
				} while ( $conflict );
				// also need to have index value by itself so return array.
				$alt = array(
					'name' => $alt_name,
					'index' => $suffix-1
				);
				return $alt;
				//return $alt_name;
			}

			// check if the section name exists in the orig_settings or the new_settings (possible after name modification)
			function is_name_conflict($alt_name, $orig_settings, $new_settings, $context='') {
				if ( ( isset($orig_settings[$alt_name]) // conflicts with orig settings or
				or ($context == 'alt-check' and isset($new_settings[$alt_name]) )) // conflicts with new settings (and is an alt name)
				and $alt_name != 'non_section' // and is a section
				) {
					return true; // conflict
				}
				else {
					return false; // no name conflict
				}
			}

			/***
			Microthemer UI Functions
			***/

			// ui dialog html (start)
			function start_dialog($id, $heading, $class = '', $tabs = array() ) {
				$content_class = '';
				// set dialog specific classes
				if ($id != 'manage-design-packs' and $id != 'program-docs' and $id != 'display-css-code'){
					$content_class.= 'scrollable-area';
				}
				if ($id == 'display-css-code' or $id == 'import-from-pack'){
					$content_class.= ' tvr-editor-area';
				}

				if ( !empty( $tabs ) ) {
					$class.= ' has-mt-tabs';
				}
				$html = '<div id="'.$id.'-dialog" class="tvr-dialog '.$class.' hidden">
				<div class="dialog-main">
					<div class="dialog-inner">
						<div class="heading dialog-header">
							<span class="dialog-icon"></span>
							<span class="text">'.$heading.'</span>

							<span class="tvr-icon close-icon close-dialog"></span>
							<span class="dialog-status"><span></span></span>
						</div>';

				// If there are any tabs, the content is preceded by a tab menu
				if ( !empty( $tabs ) ) {

					$dialog_tab_param = str_replace('-', '_', $id);
					$dialog_tab_val = !empty($this->preferences[$dialog_tab_param]) ?
						$this->preferences[$dialog_tab_param] : 0;

					$html.='
					<div class="dialog-tabs query-tabs">
						<input class="dialog-focus" type="hidden"
						name="tvr_mcth[non_section]['.$dialog_tab_param.']"
						value="'.$dialog_tab_val.'" />';
						// maybe add functionality to remember pref tab at a later date.
						for ($i = 0; $i < count($tabs); $i++) {
							$html .= '
							<span class="' . ($i == 0 ? 'active' : '' )
								. ' mt-tab dialog-tab dialog-tab-'.$i.'" rel="'.''.$i.'">
								' . $tabs[$i] . '
							</span>';
						}
					$html .= '
					</div>';
				}
				$html .= '<div class="dialog-content '.$content_class.'">';
				return $html;
			}

			function dialog_button($button_text, $type, $class, $title = ''){
				$tAttr = $title ? 'title="'.$title.'"' : '';
				if ($type == 'span'){
					$button = '<span class="tvr-button dialog-button '.$class.'" '.$tAttr.'>'.$button_text.'</span>';
				} else {
					$button = '<input name="tvr_'.strtolower(str_replace('-', '_', $class)).'_submit"
					type="submit" value="'. esc_attr($button_text) .'"
					class="tvr-button dialog-button" '.$tAttr.' />';
				}

				return $button;
			}

			// ui dialog html (end)
			function end_dialog($button_text, $type = 'span', $class = '', $title = '') {
				$button = $this->dialog_button($button_text, $type, $class, $title);
				$html = '

							</div>
							<div class="dialog-footer">
							'.$this->system_menu(true). $button. '
							</div>
						</div>
					</div>
				</div>';
				return $html;
			}

			// render ajax loaders for dynamic insertion
			function hidden_ajax_loaders(){
				?>
				<div id="a-loaders">
					<img id="loading-gif-template" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-green.gif" />
					<img id="loading-gif-template-wbg" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-wbg.gif" />
					<img id="loading-gif-template-mgbg" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-mgbg.gif" />
					<img id="loading-gif-template-sec" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/sec-ajax-loader-green.gif" />
					<img id="loading-gif-template-sel" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/sel-ajax-loader-green.gif" />
				</div>
				<?php
			}

			// output clear icon for section, selector, tab, or pg
			function clear_icon($level){
				$title = esc_attr__('Clear', 'microthemer') .  ' ' . $this->level_map[$level];
				return '<span class="tvr-icon clear-icon" title="'.$title.'" data-input-level="'.$level.'"></span>';
			}

			function save_icon($class = ''){
				return '<div class="save-button code-save '.$class.' tvr-icon" title="'.$this->text['save-button'].'"></div>';
			}

			function extra_actions_icon($id = false){

				return $this->ui_toggle(
					'show_extra_actions',
					!$id ? 'conditional' : esc_attr__('Show more actions', 'microthemer'),
					!$id ? 'conditional' : esc_attr__('Show less actions', 'microthemer'),
					!$id ? false : $this->preferences['show_extra_actions'],
					'extra-actions-toggle tvr-icon',
					$id,
					array(
						'dataAtts' => array(
							'no-save' => 1,
							'dyn-tt-root' => $id ? false : 'show_extra_actions'
						)
					)
				);
			}

			// hover inspect button
			// an alias is used in wizard mode so content flows to right of variable width button
			function hover_inspect_button($id = false){

				$tip = esc_attr__("Keyboard shortcut: Ctrl+Alt+T", 'microthemer');

				return $this->ui_toggle(
					'hover_inspect',
					!$id ? 'conditional' : esc_attr__('Enable targeting mode', 'microthemer')."\n".$tip,
					!$id ? 'conditional' : esc_attr__('Disable targeting mode', 'microthemer')."\n".$tip,
					!$id ? false : $this->preferences['hover_inspect'],
					'hover-inspect-toggle',
					$id,
					array(
						'text' => esc_html__('Target', 'microthemer'),
						'dataAtts' => array(
							'no-save' => 1,
							'dyn-tt-root' => $id ? false : 'hover-inspect-toggle'
						)
					)
				);
			}

			// alias for switching to code view ($id will always be false come to think of it)
			function code_view_icon($id = false){

				return $this->ui_toggle(
					'show_code_editor',
					!$id ? 'conditional' : esc_attr__('Code view', 'microthemer'),
					!$id ? 'conditional' : esc_attr__('GUI view', 'microthemer'),
					!$id ? false : $this->preferences['show_code_editor'],
					'toggle-full-code-editor',
					$id,
					array(
						'text' => esc_html__('Code', 'microthemer'),
						'dataAtts' => array(
							'dyn-tt-root' => $id ? false : 'toggle-full-code-editor',


							// would need to dynamically update the aliases text if using this
							//'text-pos' => esc_html__('Code', 'microthemer'),
							//'text-neg' => esc_html__('GUI', 'microthemer')
						)
					)
				);
			}

			function manual_resize_icon($editorType){
				return $this->ui_toggle(
					'code_manual_resize',
					'conditional',
					'conditional',
					false,
					'editor-resize-icon tvr-icon',
					false,
					// instruct tooltip to get content dynamically
					array('dataAtts' => array(
						'dyn-tt-root' => 'code_manual_resize',
						'editor-type'=> $editorType
					))
				);
			}

			// output feather icon for section, selector, tab, or pg
			function feather_icon($level){
				return '<span class="tvr-icon feather-icon '.$level.'-feather" data-input-level="'.$level.'"></span>';
			}

			// output icon for toggling full interface feature e.g. dock right/bottom
			function ui_toggle($aspect, $pos, $neg, $on, $class, $id = false, $config = array()){

				if ($on){
					$title = $neg;
					$class.= ' on';
				} else {
					$title = $pos;
				}

				$id = $id ? 'id="'.$id.'"' : '';

				// determine tagname
				$tag = !empty($config['tag']) ? $config['tag'] : 'span';

				// css_filter needs to pass
				$pref_sub_key = !empty($config['pref_sub_key']) ? 'data-pref_sub_key="'.$config['pref_sub_key'].'"' : '';

				// e.g. css filter has an inside favourite icon
				$inner_icon = !empty($config['inner_icon']) ? $config['inner_icon'] : '';

				// output arbitrary data atts
				$dataAtts = '';
				if (!empty($config['dataAtts'])){
					foreach ($config['dataAtts'] as $dat => $dat_val){
						$dataAtts.= 'data-'.$dat.'="'.$dat_val.'" ';
					}
				}

				// Note: uit-par may need to be var
				$html = '
				<'.$tag.' '.$id.' class="ui-toggle uit-par '.$class.'" title="'.$title.'"
					  data-pos="'.$pos.'"
					  data-neg="'.$neg.'"
					  '.$dataAtts.'
					  '.$pref_sub_key.'
					  data-aspect="'.$aspect.'">';

				// add text if not an icon
				if (!empty($config['text'])){

					$text = $config['text'];

					// show/hide advanced wizard options uses conditional text, as would most text toggles
					if ($text == 'conditional'){
						$text = $on ? $config['dataAtts']['text-neg'] : $config['dataAtts']['text-pos'];
					}

					// check if an input needs to be added
					if (!empty($config['css_filter']['editable'])){
						$ed = $config['css_filter']['editable'];
						$rel = !empty($ed['combo']) ? 'rel="'.$ed['combo'].'"' : '';
						$combo = '<span class="tvr-input-wrap">'.
						'<input type="text" class="combobox cssfilter-combo" name="'.$ed['str'].'" '.$rel.'
						value="'.trim($ed['str'], "()").'"
						 />
						</span>';
						// the replace str has brackets to ensure we get the right (n) in e.g. nth-child(n)
						$text = '<span class="pre-edfil ui-toggle">' .
						str_replace($ed['str'], '(</span>'.$combo.'<span class="post-edfil ui-toggle">)</span>', $text);
					}

					$html.= $inner_icon . $text;
				}

				$html.= '</'.$tag.'>';
				return $html;
			}

			// feather, chain, important, pie, disable icons
			function icon_control(
				$con,
				$on,
				$level,
				$section_name = '',
				$css_selector = '',
				$key = '',
				$group = '',
				$subgroup = '',
				$prop = '',
				$mq_stem = 'tvr_mcth'){

				// common atts
				$icon_id = '';
				$input = '';
				$tracker_class = $con.'-tracker';
				$icon_class = $con.'-toggle input-icon-toggle';
				$icon_inside = '';

				// set MQ stub for tab and pg inputs
				$imp_key = '';
				if ($mq_stem == 'tvr_mcth' and $key != 'all-devices'){
					$mq_stem.= '[non_section][m_query]['.$key.']';
					$imp_key = '[m_query]['.$key.']';
				}

				// icon specific
				if ($con == 'disabled'){
					$icon_class.= ' tvr-icon disabled-icon '.$level.'-disabled';
					$pos_title = esc_attr__('Disable', 'microthemer') .  ' ' . $this->level_map[$level];
					$neg_title = esc_attr__('Enable', 'microthemer') .  ' ' . $this->level_map[$level];
				} elseif ($con == 'chained') {
					$icon_class.= ' tvr-icon chained-icon '.$subgroup.'-chained';
					$pos_title = esc_attr__('Link fields', 'microthemer');
					$neg_title = esc_attr__('Unlink fields', 'microthemer');
				} elseif ($con == 'important') {
					$pos_title = esc_attr__('Add !important', 'microthemer');
					$neg_title = esc_attr__('Remove !important', 'microthemer');
					$icon_inside = 'i';
				} elseif ($con == 'pie') {
					$icon_class.= ' tvr-icon';
					$pos_title = esc_attr__('Turn CSS3 PIE polyfill on', 'microthemer');
					$neg_title = esc_attr__('Turn CSS3 PIE polyfill off', 'microthemer');
				} elseif ($con == 'show_css_filters') {
					$icon_class.= ' tvr-icon settings-icon quick-opts-wrap tvr-fade-in click-toggle"';
					$pos_title = esc_attr__('Show selector modifiers', 'microthemer');
					$neg_title = esc_attr__('Hide selector modifiers', 'microthemer');
					$icon_id = 'id="show_css_filters-toggle"';

					// display css filters
					$icon_inside = $this->display_css_filters();


				}

				// generate input if item is on
				$title = $pos_title; // do what toggle is there for
				if (!empty($on)){
					$title = $neg_title; // undo what toggle is there for
					switch ($level) {
						case "section":
							$name = $mq_stem . '['.$section_name.'][this]';
							break;
						case "selector":
							$name = $mq_stem . '['.$section_name.']['.$css_selector.']';
							break;
						case "tab-input":
							$tracker_class.= '-'.$key;
							$name = $mq_stem . '['.$section_name.']['.$css_selector.'][tab]';
							break;
						case "subgroup":
							$name = $mq_stem . '['.$section_name.']['.$css_selector.'][pg_'.$con.']['.$subgroup.']';
							break;
						case "script":
							$name = 'tvr_preferences[enq_js]['.$section_name.']';
							break;
						default:
							$name = '';
					}
					$name.= '['.$con.']';
					// important is only for props, and has different structure
					if ($con == 'important'){
						$name = 'tvr_mcth[non_section][important]'.$imp_key.'['.$section_name.']['.$css_selector.']['.$group.']['.$prop.']';
					}
					$input = '<input class="'.$tracker_class.'" type="hidden" name="'.$name.'" value="1" />';
					$icon_class.= ' active';
				}

				// generate icon
				$icon = '<span '.$icon_id.' class="'.$icon_class.'" title="'.$title.'" data-pos="'.$pos_title.'"
				data-neg="'.$neg_title.'"  data-input-type="'.$con.'"
							data-input-level="'.$level.'">'.$icon_inside.'</span>';

				// with feather on tabs, icon and input are output separately
				if ($con == 'disabled'){
					if ($level == 'tab'){
						$input = '';
					} elseif ($level == 'tab-input'){
						$icon = '';
					}
				}

				// with important, a placeholder is used for css3 options that only need one 'i'
				if (!empty($this->propertyoptions[$group][$prop]['hide imp'])) {
					$icon = '<span class="imp-placeholder">i</span>';
				}

				// return control
				return $input . $icon;
			}

			// output header
			function manage_packs_header($page){
				?>
				<ul class="pack-manage-options">
					<li class="upload">
						<form name='upload_micro_form' id="upload-micro-form" method="post" enctype="multipart/form-data"
							action="<?php echo 'admin.php?page='. $page;?>" >
							<?php wp_nonce_field('tvr_upload_micro_submit'); ?>
							<input id="upload_pack_input" type="file" name="upload_micro" />
							<input class="tvr-button upload-pack" type="submit" name="tvr_upload_micro_submit"
								value="<?php esc_attr_e('+ Upload New', 'microthemer'); ?>" title="<?php esc_attr_e('Upload a new design pack', 'microthemer'); ?>" />
						</form>
					</li>
					<!--<li>
						<a class="tvr-button" target="_blank" title="Submit one of your design packs for sale/downlaod on themeover.com"
							href="https://themeover.com/sell-micro-themes/submit-micro-theme/">Submit To Marketplace</a>
					</li>
					<li>
						<a class="tvr-button" target="_blank" title="Browse Themeover's marketplace of design packs for various WordPress themes and plugins"
							href="http://themeover.com/theme-packs/">Browse Marketplace</a>
					</li>-->
				</ul>
				<?php
			}

			// output meta spans and logs tmpl for manage pages
			function manage_packs_meta(){
				?>
				<span id="ajaxUrl" rel="<?php echo $this->site_url.'/wp-admin/admin.php?page='.$this->microthemeruipage.'&mcth_simple_ajax=1&_wpnonce='.wp_create_nonce('mcth_simple_ajax') ?>"></span>
				<span id="delete-ok" rel='admin.php?page=<?php echo $this->microthemespage;?>&mt_action=tvr_delete_ok&_wpnonce=<?php echo wp_create_nonce('tvr_delete_ok'); ?>'></span>
				<span id="zip-folder" rel="<?php echo $this->thispluginurl.'zip-exports/'; ?>"></span>
				<?php

				echo $this->display_log_item('error', array('short'=> '', 'long'=> ''), 0, 'id="log-item-template"');
			}

			function pack_pagination($page, $total_pages, $total_packs, $start, $end) {
				?>
				<ul class="tvr-pagination">
					<?php
					$i = $total_pages;
					while ($i >= 1){
						echo '
						<li class="page-item">';
						if ($i == $page) {
							echo '<span>'.$i.'</span>';
						} else {
							echo '<a href="admin.php?page='. $this->microthemespage . '&packs_page='.$i.'">'.$i.'</a>';
						}
						echo '
						</li>';
						--$i;
					}
					echo '<li class="displaying-x">' .
						sprintf(esc_html__('Displaying %1$s - %2$s of %3$s', 'microthemer'), $start, $end, $total_packs) . '</li>';

					if (!empty($this->preferences['theme_in_focus']) and $total_packs > 0){
						$url = 'admin.php?page=' . $this->managesinglepage . '&design_pack=' . $this->preferences['theme_in_focus'];
						$name = $this->readable_name($this->preferences['theme_in_focus']);
						?>
						<li class="last-modified" rel="<?php echo $this->preferences['theme_in_focus']; ?>">
							<?php esc_html_e('Last modified design pack: ', 'microthemer'); ?><a title="<?php printf(esc_attr__('Edit %s', 'microthemer'), $name); ?>"
								href="<?php echo $url; ?>"><?php echo esc_html($name); ?>
							</a>
						</li>
						<?php
					}
				?>
				</ul>
				<?php
			}

			/*
			function display_left_menu_icons() {

				if ($this->preferences['buyer_validated']){
					$unlock_class = 'unlocked';
					$unlock_title = esc_attr__('Validate license using a different email address', 'microthemer');
				} else {
					$unlock_class = '';
					$unlock_title = esc_attr__('Enter your PayPal email (or the email listed in My Downloads) to unlock Microthemer', 'microthemer');
				}

				// set 'on' buttons
				$code_editor_class = $this->preferences['show_code_editor'] ? ' on' : '';
				$ruler_class = $this->preferences['show_rulers'] ? ' on' : '';


				//
				$html = '
					<div class="unlock-microthemer '.$unlock_class.' v-left-button show-dialog popup-show" rel="unlock-microthemer" title="'.$unlock_title.'"></div>

					<div id="save-interface" class="save-interface v-left-button" title="' . esc_attr__('Manually save UI settings (Ctrl+S)', 'microthemer') . '"></div>

					<div id="toggle-highlighting" class="v-left-button"
					title="'. esc_attr__('Toggle highlighting', 'microthemer') .'"></div>

					<div id="toggle-rulers" class="toggle-rulers v-left-button '.$ruler_class.'"
						title="'. esc_attr__('Toggle rulers on/off', 'microthemer') .'"></div>

					<div class="ruler-tools v-left-button tvr-popright-wrap">

						<div class="tvr-popright">
							<div class="popright-sub">
								<div id="remove-guides" class="remove-guides v-left-button"
						title="'. esc_attr__('Remove all guides', 'microthemer') .'"></div>
							</div>
						</div>
					</div>


					<div class="code-tools v-left-button tvr-popright-wrap popup-show">

						<div id="edit-css-code" class="edit-css-code v-left-button new-icon-group '.$code_editor_class.'"
						title="'. esc_attr__('Code editor view', 'microthemer') .'"></div>

						<div class="tvr-popright">
							<div class="popright-sub">
								<div id="display-css-code" class="display-css-code v-left-button show-dialog popup-show" rel="display-css-code" title="' . esc_attr__('View the CSS code Microthemer generates', 'microthemer') . '"></div>
							</div>
						</div>
					</div>


					<div class="preferences-tools v-left-button tvr-popright-wrap popup-show">

						<div class="display-preferences v-left-button show-dialog popup-show" rel="display-preferences" title="' . esc_attr__('Set your global Microthemer preferences', 'microthemer') . '"></div>

						<div class="tvr-popright">
							<div class="popright-sub">

								<div class="edit-media-queries v-left-button show-dialog popup-show" rel="edit-media-queries"
					title="' . esc_attr__('Edit Media Queries', 'microthemer') . '"></div>

							</div>
						</div>
					</div>


					<div class="pack-tools v-left-button tvr-popright-wrap popup-show">

						<div class="manage-design-packs v-left-button show-dialog new-icon-group popup-show" rel="manage-design-packs" title="' . esc_attr__('Install & Manage your design packages', 'microthemer') . '"></div>

						<div class="tvr-popright">
							<div class="popright-sub">

								<div class="import-from-pack v-left-button show-dialog popup-show" rel="import-from-pack" title="' . esc_attr__('Import settings from a design pack', 'microthemer') . '"></div>

					<div class="export-to-pack v-left-button show-dialog popup-show" rel="export-to-pack" title="' . esc_attr__('Export your work as a design pack', 'microthemer') . '"></div>

							</div>
						</div>
					</div>


					<!--<div class="display-share v-left-button show-dialog" rel="display-share" title="' . esc_attr__('Spread the word about Microthemer', 'microthemer') . '"></div>-->




					<div class="reset-tools v-left-button tvr-popright-wrap popup-show">

						<div class="display-revisions v-left-button show-dialog new-icon-group popup-show" rel="display-revisions" title="' . esc_attr__("Restore settings from a previous save point", 'microthemer') . '"></div>

						<div class="tvr-popright">
							<div class="popright-sub">
								<div id="ui-reset" class="v-left-button folder-reset"
								title="' . esc_attr__("Reset the interface to the default empty folders", 'microthemer') . '"></div>
								<div id="clear-styles" class="v-left-button styles-reset"
								title="' . esc_attr__("Clear all styles, but leave folders and selectors intact", 'microthemer') . '"></div>
							</div>
						</div>
					</div>


					<div data-docs-index="1" class="program-docs v-left-button show-dialog new-icon-group popup-show" rel="program-docs"
					title="' . esc_attr__("Learn how to use Microthemer", 'microthemer') . '"></div>

					<div class="toggle-full-screen v-left-button" rel="toggle-full-screen"
					title="' . esc_attr__("Full screen mode", 'microthemer') . '"></div>

					<a class="back-to-wordpress v-left-button" title="' . esc_attr__("Return to WordPress dashboard", 'microthemer') . '"
					href="'.$this->wp_blog_admin_url.'"></a>';
				return $html;

			}
			*/


			// display the main menu
			function system_menu($dialog_footer = false){

				$html = '<ul class="mt-options-menu">';

				// menu groups
				foreach ($this->menu as $group_key => $arr){

					$html.= '
					<li class="mt-group '.$group_key.'">
						<span>'. $arr['name'] . '</span>';
					if (!empty($arr['sub'])){
						$html.= '<ul class="mt-sub">';

						// menu items
						foreach ($arr['sub'] as $item_key => $arr2){

							// dialog footer only needs a subset of options
							if ($dialog_footer and empty($arr2['dialog'])) continue;

							// format the data attributes
							$data_attr = '';
							if ( !empty($arr2['data_attr']) ){
								foreach($arr2['data_attr'] as $da_key => $da_value){
									$data_attr.= 'data-'.$da_key.'="'.$da_value.'"';
								}
							}

							// format rel, class, id, data
							$rel = !empty($arr2['dialog']) ? 'rel="'.$arr2['class'].'"' : '';
							$id = !empty($arr2['id']) ? 'id="'.$arr2['id'].'"' : '';
							$link_id = !empty($arr2['link_id']) ? 'id="'.$arr2['link_id'].'"' : '';
							$link_target = !empty($arr2['link_target']) ? 'target="'.$arr2['link_target'].'"' : '';
							$icon_id = !empty($arr2['icon_id']) ? 'id="'.$arr2['icon_id'].'"' : '';
							$icon_class = !empty($arr2['class']) ? $arr2['class'] : '';
							$text_class = !empty($arr2['text_class']) ? $arr2['text_class'] : '';
							$text_attr = !empty($arr2['short_name']) ?
								'data-sl="'.$arr2['short_name'].'" data-ll="'.$arr2['name'].'"' : '';
							$class = 'item-' . $icon_class;
							$class.= (isset($arr2['toggle'])) ? ' mt-toggle' : '';
							$class.= (isset($arr2['item_link'])) ? ' item-link' : '';
							$class.= (!empty($arr2['new_set'])) ? ' new-set' : '';
							$show_dialog = $class.= (!empty($arr2['dialog'])) ? ' show-dialog' : '';

							// item
							$html.= '<li '.$id.' '.$data_attr.' '.$rel.' class="mt-item '.$item_key.' '.$class.'"
							>';

							// should a link wrap the icon and text?
							if (!empty($arr2['item_link'])){
								$html.= '<a '.$link_id.' '.$link_target.' href="'.$arr2['item_link'].'">';
							}

							// icon
							$html.= '<span '.$icon_id.' class="mt-menu-icon '.$icon_class.' '.$show_dialog.'"></span>';

							// text label
							$colon = isset($arr2['toggle']) & ($item_key!= 'highlighting') ? ':' : '';
							$html.= '<span class="mt-menu-text '.$show_dialog.' '.$text_class.'"
							title="'.$arr2['title'].'" '.$text_attr.'>'
								.$arr2['name'].$colon.'</span>';

							// do we need toggle?
							if (isset($arr2['toggle'])){
								$html.= $this->toggle($item_key, $arr2);
							}

							// do we display keyboard shortcut
							if (isset($arr2['keyboard_shortcut'])){
								$html.= '<span class="keyboard-sh">'.$arr2['keyboard_shortcut'].'</span>';
							}

							// do we need input?
							if (isset($arr2['input'])){
								$html.= '
								<div class="combobox-wrap tvr-input-wrap hidden">
									<input type="text" name="set_preview_url" class="combobox"
									rel="'.$arr2['combo_data'].'"
									value="'.$arr2['input'].'" />
									<span class="combo-arrow"></span>
									<span class="tvr-button '.$arr2['button']['class'].'">
								'.$arr2['button']['text'].'
								</span>
								</div>
								';
							}

							if (!empty($arr2['item_link'])){
								$html.= '</a>';
							}

							$html.= '</li>';
						}
						$html.= '</ul>';
					}
					$html.= '</li>';
				}
				$html.= '</ul>';
				return $html;
			}

			function toggle($item_key, $arr){
				$on = $arr['toggle'] ? 'on' : '';
				$id = !empty($arr['toggle_id']) ? 'id="'.$arr['toggle_id'].'"' : '';
				// set dynamic title (adding this feature slowly)
				$pos_neg = $title = '';
				if( !empty($arr['data-pos']) ){
					$pos_neg = 'data-pos="'.$arr['data-pos'].'" data-neg="'.$arr['data-neg'].'" ';
					$title = !$on ? $arr['data-pos'] : $arr['data-neg'];
					$title = 'title="'.$title.'"';
				}

				$html = '';
				//$html.= print_r($on, true);
				$html.= '
				<div '.$id.' class="onoffswitch ui-toggle uit-par '.$on.'"
				data-aspect="'.$item_key.'" '.$pos_neg.' '.$title.'>
					<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
					id="myonoffswitch-'.$item_key.'">
					<label class="onoffswitch-label ui-toggle" for="myonoffswitch-'.$item_key.'">
						<span class="onoffswitch-inner ui-toggle"></span>
						<span class="onoffswitch-switch ui-toggle"></span>
					</label>
				</div>';
				return $html;
			}

			// Resolve property/value input fields
			function resolve_input_fields(
				$section_name,
				$css_selector,
				$array,
				$property_group_array,
				$property_group_name,
				$property,
				$value,
				$con = 'reg',
				$key = 1,
				$sel_code) {
				$html = '';
				// don't display legacy properties or the image display field
				if (!$this->is_legacy_prop($property_group_name, $property) and !strpos($property, 'img_display') ){
					include $this->thisplugindir . 'includes/resolve-input-fields.inc.php';
				}
				return $html;
			}

			// Global system for creating dynamic menus (data, structure, config)
		    // Note: passing array/objs into PHP/JS functions over lots of params should become standard practice
			function dyn_menu($d, $s, $c) {

				$base_key = !empty($s['base_key']) ? 'data-base-key="'.$s['base_key'].'"' : '';
				$html = '<div id="dyn-wrap-'.$s['slug'].'" class="dyn-wrap"
				data-slug="'.$s['slug'].'" '.$base_key.'>';

				// add controls if required
				if (!empty($c['controls'])){
					$input_class = !empty($s['add_button']) ? 'combobox' : '';
					$combo_arrow = '';
					if (!empty($s['combo_add_arrow'])) {
						$combo_arrow = '<span class="combo-arrow"></span>';
						$input_class.= ' has-arrows';
					}
					$html.= '
					<div class="tvr-new-item">
						<span class="tvr-input-wrap">
							<input type="text" class="new-item-input '.$input_class.'" name="new_item[name]" rel="'.$s['slug'].'">
							'.$combo_arrow.'
						</span>
						<span class="new-item-add tvr-button" title="'.$s['add_button'].'">'.$s['add_button'].'</span>
					</div>';
				}


				// loop through data (maybe try to make this a recursive function)
				$html.= '
				<ul id="'.$s['slug'].'-dyn-menu" class="tvr-dyn-menu">';

				foreach ($d as $k => $arr){

					$html.= $this->dyn_item($s, $k, $arr);
				}

				$html.= '
				</ul>
				</div>'; // dyn-wrap

				return $html;
			}

			function dyn_item($s, $k, $arr){

				$fields = $s['items']['fields'];

				// resolve display name, class etc
				$display_name = !empty($arr['display_name']) ? $arr['display_name'] : $arr['label'];
				$name_class = !empty($fields['label']['name_class']) ? ' '.$fields['label']['name_class'] : '';

				$html = '';
				// li item
				$html.= '
				<li id="'.$s['slug'].'-'.$k.'" class="dyn-item '.$s['level'].'-tag '.$s['slug'].' '.$s['slug'].'-'.$s['level'].'">';

				// row with sortable icon, name
				$dis_class = !empty($this->preferences['enq_js'][$k]['disabled']) ? 'item-disabled' : '';
				$html.= '
				<div class="'.$s['level'].'-row item-row '.$dis_class.'">
					<span class="'.$s['slug'].'-icon tvr-icon sortable-icon" title="'.$s['items']['icon']['title'].'"></span>
					<span class="name-text '.$s['level'].'-name'.$name_class.'">'.esc_html($display_name).'</span>';

				$html.= '
				<span class="manage-'.$s['level'].'-icons manage-icons">';

				// do action icons
				foreach ($s['items']['actions'] as $action => $a_arr){

					// output icon control e.g. disabled
					if (!empty($a_arr['icon_control'])){
						$html.= $this->icon_control(
							$action,
							!empty($this->preferences['enq_js'][$k]['disabled']),
							$s['level'],
							$k,
							'',
							'all-devices', // just to skip mq stuff
							'',
							'',
							$s['name_stub']
						);
					} else {
						// regular icon
						$a_class = !empty($a_arr['class']) ? $a_arr['class'] : '';
						$html.= '
						<span class="'.$a_class. ' '.$action.'-'.$s['level'].' tvr-icon '.$action.'-icon"
						title="'.$a_arr['title'].'"></span>';
					}

				}

				// end action icons and row
				$html.= '
					</span>
				</div>';

				// edit fields (for enq_js just hidden input so no need to have edit icon)
				$html.= '
				<div class="edit-item-form float-form hidden">';

				// editing or hidden input fields
				foreach ($s['items']['fields'] as $input_name => $f_arr){
					$input_type = $f_arr['type'];
					$val = !empty($arr[$input_name]) ? $arr[$input_name] : '';
					$input = '<input type="'.$input_type.'" class="'.$s['level'].'-'.$input_name.'"
								name="'.$s['name_stub'].'['.$k.']['.$input_name.']" value="'.esc_html($val).'">';

					// just input if hidden
					if ($input_type == 'hidden'){
						$html.= $input;
					} else {
						// form fields
						$f_class = $input_type == 'checkbox' ? 'mq-checkbox-wrap' : '';
						$html.= '
						<p class="'.$f_class.'">
							<label title="'.$f_arr['label_title'].'">'.$f_arr['label'].':</label>';
							// regular text input, checkbox
							if ($input_type != 'textarea'){
								$html.= $input;
								if ($input_type == 'checkbox'){
									$html.= '<span class="fake-checkbox "></span>
									<span class="ef-label">'.$f_arr['label2'].'</span>';
								}
							} else {
								// text area
								$html.= '<textarea class="'.$s['level'].'-'.$input_name.'"
								name="'.$s['name_stub'].'['.$k.']['.$input_name.']">'.esc_html($val).'</textarea>';
							}
							$html.= '
						</p>';
					}
				}

				// maybe add recursive functionality for sub items here if needed/possible

				$html.= '
				</li>';

				return $html;
			}

			// menu section html
			function menu_section_html($section_name, $array) {

				$section_name = esc_attr($section_name); //=esc

				// get folder display name
				$display_section_name = $this->get_folder_name_inc_legacy($section_name, $array);

				$selector_count_state = $this->selector_count_state($array);

				// generate html code for sections in this loop to save having to do a 2nd loop later
				$this->initial_options_html[$this->total_sections] = $this->section_html($section_name, $array);

				$sec_class = '';

				// user disabled
				$disabled = false;
				if (!empty($array['this']['disabled'])){
					$disabled = true;
					$sec_class.= ' item-disabled';
				}

				// should feather be displayed?
				if ($selector_count_state > 0 ) {
					// need deep search of values in selectors
					if ($this->section_has_values($section_name, $array, true)){
						$sec_class.= ' hasValues';
					}
				}
				$folder_title = esc_attr__("Reorder folder", 'microthemer');

				?>
				<li id="<?php echo 'strk-'.$section_name; ?>" class="section-tag strk strk-sec <?php echo $sec_class; ?>">
					<!--<input type="hidden" class="register-section" name="tvr_mcth[<?php //echo $section_name; ?>]" value="" />-->
					<input type="hidden" class="section-display-name"
						name="tvr_mcth[<?php echo $section_name;?>][this][label]"
						value="<?php echo esc_attr($display_section_name); ?>" />
					<input type='hidden' class='view-state-input section-tracker'
						   name='tvr_mcth[non_section][view_state][<?php echo $section_name; ?>][this]' value='0' />
					<div class="sec-row item-row">
					<span class="menu-arrow folder-menu-arrow tvr-icon"></span>
					<span class="folder-icon tvr-icon sortable-icon" title="<?php echo $folder_title; ?>" data-title="<?php echo $folder_title; ?>"></span>

					<?php //echo $this->feather_icon('section'); ?>
					<span class="section-name item-name"
						 <?php /*title="<?php esc_attr_e("Folder", 'microthemer'); ?>" */ ?>
						>
						<span class="name-text selector-count-state"
							rel="<?php echo $selector_count_state; ?>"><?php echo $display_section_name; ?></span>
							<?php
							if ($selector_count_state > 0) {
								echo ' <span class="folder-count-wrap count-wrap">(<span class="folder-state-count state-count">'.$selector_count_state.'</span>)</span>';
							}
							// update global $total_selectors count
							$this->total_selectors = $this->total_selectors + $selector_count_state;
							?>
						</span>
						<span class="edit-section-form hidden">
							<input type='text' class='rename-input' name='rename_section'
								value='<?php echo $display_section_name; ?>' />
								<span class='rename-button tvr-button' title="<?php esc_attr_e("Rename folder", 'microthemer'); ?>">
									<?php printf( esc_html__('Rename', 'microthemer') ); ?>
								</span>
								<span class='cancel-rename-section cancel link' title="<?php esc_attr_e("Cancel rename", 'microthemer'); ?>">
									<?php printf( esc_html__('Cancel', 'microthemer') ); ?>
								</span>
						</span>
						<span class="manage-section-icons manage-icons">

							<?php
							// toggle for extra action icons
							echo $this->extra_actions_icon();
							/*echo $this->ui_toggle(
								'show_extra_actions',
								'conditional', // only wizard toggle has title/on class (easier than maintaining dynamically)
								'conditional',
								false,
								'extra-actions-toggle tvr-icon',
								false,
								// instruct tooltip to get content dynamically
								array('dataAtts' => array(
									'dyn-tt-root' => 'show_extra_actions',
									'no-save' => 1
								))
							);
							*/
							?>

							<span class="extra-row-actions">
								<span class="reveal-add-selector tvr-icon add-icon" title="<?php esc_attr_e("Add selector to this folder", 'microthemer'); ?>"></span>
								<span class="copy-section tvr-icon copy-icon" title="<?php esc_attr_e("Copy Folder", 'microthemer'); ?>"></span>
								<span class="delete-section tvr-icon delete-icon" title="<?php esc_attr_e("Delete folder", 'microthemer'); ?>"></span>
								<?php echo $this->clear_icon('section'); ?>

							</span>


							<?php echo $this->icon_control('disabled', $disabled, 'section', $section_name); ?>

							<span class="toggle-rename-section tvr-icon edit-icon" title="<?php esc_attr_e("Rename Folder", 'microthemer'); ?>"></span>

						</span>
					</div>

						<ul class="selector-sub">
							<li class="add-selector-list-item">
								<div class="sel-row item-row">
									<?php
									$tip = esc_html__('Non-coders should use the selector wizard instead of using these form fields.', 'microthemer') . '<br />' . esc_html__('Just double-click something on your site!');
									if (!$this->optimisation_test){
										$this->selector_add_modify_form('add', $tip);
									}
									?>
								</div>

							</li>
							<?php
							if (!$this->optimisation_test){
								if ( is_array($array) ) {
									$sel_loop_count = 0;
									foreach ( $array as $css_selector => $array) {
										if ($css_selector == 'this') continue;
										++$sel_loop_count;
										++$this->sel_count;
										// selector list item
										$this->menu_selector_html($section_name, $css_selector, $array, $sel_loop_count);
									}
								}
							}
							?>

						</ul>
						<?php

					?>

				</li>
			<?php
			}



			// menu single selector html
			function menu_selector_html($section_name, $css_selector, $array, $sel_loop_count) {

				$sel_class = '';

				/* determine which style groups are active
				$style_count_state = 0;
				foreach ($this->propertyoptions as $property_group_name => $junk) {
					if ($this->pg_has_values_inc_legacy_inc_mq($section_name, $css_selector, $array, $property_group_name)) {
						++$style_count_state;
					}
				}*/

				$style_count_state = $this->selector_has_values($section_name, $css_selector, $array, true);

				// trial disabled (all sels will be editable even in free trial in future)
				if (!$this->preferences['buyer_validated'] and $this->sel_count > 15 ) {
					$sel_class.= 'trial-disabled'; // visually signals disabled and, prevents editing
				}

				// user disabled
				$disabled = false;
				if (!empty($array['disabled'])){
					$disabled = true;
					$sel_class.= ' item-disabled';
				}

				// should feather be displayed?
				if ($style_count_state > 0) {
					$sel_class.= ' hasValues';
				}

				// can't recall why I went down this route of storing label and code in piped single value.
				if (is_array($array) and !empty($array['label'])){
					$labelCss = explode('|', $array['label']);
					// convert my custom quote escaping in recognised html encoded single/double quotes
					$selector_title = esc_attr(str_replace('cus-', '&', $labelCss[1]));
				} else {
					$labelCss = array('', '');
					$array['label'] = '';
					$selector_title = '';
				}

				?>
				<li id="<?php echo 'strk-'.$section_name.'-'.$css_selector; ?>" class="selector-tag strk strk-sel <?php echo $sel_class; ?>">

					<input type='hidden' class='register-selector' name='tvr_mcth[<?php echo $section_name; ?>][<?php echo $css_selector; ?>]' value='' />
					<input type='hidden'
						class='view-state-input selector-tracker' name='tvr_mcth[non_section][view_state][<?php echo $section_name;?>][<?php echo $css_selector;?>]' value='0' />
					<input type='hidden' class='selector-label' name='tvr_mcth[<?php echo $section_name; ?>][<?php echo $css_selector; ?>][label]' value='<?php echo $array['label']; ?>' />

					<div class="sel-row item-row">
						<span class="tvr-icon selector-sortable-icon sortable-icon" title="<?php esc_attr_e("Reorder selector", 'microthemer'); ?>"></span>
						<?php echo $this->feather_icon('selector'); ?>
						<span class="selector-name item-name change-selector" title="<?php echo $selector_title; ?>">
						<span class="name-text style-count-state change-selector"
							rel="<?php echo $style_count_state; ?>"><?php echo $labelCss[0]; ?></span>
							<?php
							/* FEATHER SYSTEM SUPERSEDES
							if ($style_count_state > 0) {
								echo ' <span class="count-wrap change-selector">(<span class="state-count change-selector">'.$style_count_state.'</span>)</span>';
							}
							*/
							?>
						</span>
						<span class="manage-selector-icons manage-icons">

							<?php
							// toggle for extra action icons
							echo $this->extra_actions_icon();
							/*echo $this->ui_toggle(
								'show_extra_actions',
								'conditional', // only wizard toggle has title/on class (easier than maintaining dynamically)
								'conditional',
								false,
								'extra-actions-toggle tvr-icon',
								false,
								// instruct tooltip to get content dynamically
								array('dataAtts' => array(
									'dyn-tt-root' => 'show_extra_actions'
								))
							);
							*/
							?>

							<span class="extra-row-actions">
								<span class="tvr-icon selector-icon retarget-selector" title="<?php esc_attr_e("Re-target selector ", 'microthemer'); ?>"></span>
								<span class="copy-selector tvr-icon copy-icon" title="<?php esc_attr_e("Copy selector", 'microthemer'); ?>"></span>
							<span class="delete-selector tvr-icon delete-icon" title="<?php esc_attr_e("Delete selector", 'microthemer'); ?>"></span>
								<?php echo $this->clear_icon('selector'); ?>
							</span>

							<?php echo $this->icon_control('disabled', $disabled, 'selector', $section_name, $css_selector); ?>
							<span class="toggle-modify-selector tvr-icon edit-icon" title="<?php esc_attr_e("Edit selector", 'microthemer'); ?>"></span>

							<span class="tvr-icon hightlight-icon highlight-preview" title="<?php esc_attr_e("Highlight selector", 'microthemer'); ?>"></span>
						</span>
						<?php
						$tip = esc_html__('Give your selector a better descriptive name and/or modify the CSS selector code.', 'microthemer');
						if (!$this->optimisation_test){
							$this->selector_add_modify_form('edit', $tip, $labelCss, $section_name, $css_selector);
						}
						?>
					</div>
				</li>
			<?php
			}

			// add/modify selector form
			function selector_add_modify_form($con, $tip, $labelCss = '', $section_name ='', $css_selector = '') {
				$display = ucwords($con);
				if (is_array($labelCss)) {
					$display_selector_name = esc_attr($labelCss[0]);
					// convert my custom quote escaping in recognised html encoded single/double quotes
					$selector_css = esc_attr(str_replace('cus-', '&', $labelCss[1]));
				} else {
					$display_selector_name = '';
					$selector_css = '';
				}

				// save current sels in quick lookup array
				if (!empty($selector_css)){
					$this->sel_lookup[$selector_css] = 'strk-'.$section_name.'-'.$css_selector;
				}

				?>
				<div class='<?php echo $con; ?>-selector-form float-form hidden'>
					<!--<p class="tip">

						<span><?php echo $tip; ?></span>

					</p>-->
					<p class="menu-sel-name-edit">
						<label><?php esc_html_e('Label:', 'microthemer'); ?></label>
						<span class="tvr-input-wrap selector-name-input-wrap">
							<input type='text' class='selector-name-input' name='<?php echo $con; ?>_selector[label]' value='<?php echo esc_attr($display_selector_name); ?>' />
						</span>
					</p>
					<p>
						<label><?php esc_html_e('Code:', 'microthemer'); ?></label>
						<span class="tvr-input-wrap selector-css-input-wrap">
							<input type='text' class='selector-css-textarea' name='<?php echo $con; ?>_selector[css]' value='<?php echo $selector_css; ?>' />
						</span>

					</p>

					<?php echo $this->ui_toggle(
						'selname_code_synced',
						'conditional', // only wizard toggle has title/on class (easier than maintaining dynamically)
						'conditional',
						false,
						'code-chained-icon tvr-icon selname-code-sync',
						false,
						// instruct tooltip to get content dynamically
						array('dataAtts' => array(
							'dyn-tt-root' => 'selname_code_synced'
						))
					); ?>

					<p class="sel-toggles">
						<?php
						if ($con == 'edit'){
							?>
							<span class="polyfills">
								<?php
								foreach ($this->polyfills as $poly){
									if ($this->preferences[$poly.'_by_default'] != 1){
										$on = false;
										if (!empty($this->options[$section_name][$css_selector][$poly])) {
											$on = true;
										}
										echo $this->icon_control($poly, $on, 'selector', $section_name, $css_selector);
									}
								}
								?>
							</span>
							<?php
							// output any disabled tab inputs
							foreach ($this->combined_devices() as $key => $m_query){
								// normalise $opts array for checking
								if ($key == 'all-devices'){
									$opts = $this->options;
								} else {
									if (empty($this->options['non_section']['m_query'][$key])){
										continue;
									}
									$opts = $this->options['non_section']['m_query'][$key];
								}
								if (!empty($opts[$section_name][$css_selector]['tab']['disabled'])){
									echo $this->icon_control('disabled', true, 'tab-input', $section_name, $css_selector, $key);
								}
							}
						}


						// translation friendly button display
						$button_name = __("Create Selector", 'microthemer');
						if ($display == 'Edit') {
							$button_name = __("Save Selector", 'microthemer');
						}
						?>
						<span class='<?php echo $con; ?>-selector tvr-button'
								title="<?php echo esc_attr($button_name); ?>">
							<?php echo esc_html($button_name); ?>
						</span>
							<span class="cancel-<?php echo $con; ?>-selector cancel link"><?php esc_html_e('Cancel', 'microthemer'); ?></span>
					</p>
				</div>
			<?php
			}

			// section html
			function section_html($section_name, $array) {
				$html = '';
				$html.= '
				<li id="opts-'.$section_name.'" class="section-wrap section-tag">
					'.$this->all_selectors_html($section_name, $array).'
				</li>';
				return $html;
			}

			function all_selectors_html($section_name, $array, $force_load = 0) {
				$html = '';
				$html.= '<ul class="opts-selectors-sub">';
					// loop the CSS selectors if they exist
					if (!$this->optimisation_test){
						if ( is_array($array) ) {
							$this->sel_loop_count = 0; // reset count of selector in section
							foreach ($array as $css_selector => $sel_array) {
								if ($css_selector == 'this') continue;
								++$this->sel_loop_count;
								$html .= $this->single_selector_html($section_name, $css_selector, $sel_array, $force_load);
							}
						}
					}
				$html.= '</ul>';
				return $html;
			}

			// selector html
			function single_selector_html($section_name, $css_selector, $array, $force_load = 0) {
				++$this->sel_option_count;
				$html = '';
				$css_selector = esc_attr($css_selector); //=esc
				// disable sections locked by trial
				if (!$this->preferences['buyer_validated'] and $this->sel_option_count > 15) {
					$trial_disabled = 'trial-disabled';
				} else {
					$trial_disabled = '';
				}
				$html.= '<li id="opts-'.$section_name.'-'.$css_selector.'"
				class="selector-tag selector-wrap '.$trial_disabled.'">';
				// only load style options if we need to force load
				if ($force_load == 1) {
					$html.= $this->all_option_groups_html($section_name, $css_selector, $array);
				}
				$html.= '</li>';
				return $html;
			}

			// determine the number of selectors in the array
			function selector_count_state($array) {
				$selector_count_state = count($array);
				$selector_count_recursive = count($array, COUNT_RECURSIVE);

				// if the 2 values are the same, the $selector_count_state variable refers to an empty value
				if ($selector_count_state == $selector_count_recursive) {
					$selector_count_state = 0;
				}
				// [this] will be counted as extra selector. Fix.
				if ($selector_count_state > 0 and array_key_exists('this', $array)){
					--$selector_count_state;
				}
				return $selector_count_state;
			}


			// display property group icons and options
			function all_option_groups_html($section_name, $css_selector, $array){

				// get the last viewed property group
				$pg_focus = ( !empty($array['pg_focus']) ) ? $array['pg_focus'] : '';

				// display pg icons
				$html = '
				<ul class="styling-option-icons">';

					// store the last active pg so we can return to it
					$html.= '<input class="pg-focus" type="hidden"
						name="tvr_mcth['.$section_name.']['.$css_selector.'][pg_focus]"
					value="'.$pg_focus.'" />';

					// display the pg icons
					foreach ($this->propertyoptions as $property_group_name => $junk) {

						/* LEAVE THIS FOR JS
						 * check if the property group should be "on" (indicating styles have been added)
						$class = ( $this->pg_has_values_inc_legacy_inc_mq(
							$section_name,
							$css_selector,
							$array,
							$property_group_name) ) ? 'on hasValues' : '';
						*/

						$class = '';

						 // check if the property group should be "active" (in focus)
						 if ($property_group_name == $pg_focus) {
							 //$class.= ' active'; // don't do this while we trial the continuity system
						 }

						 // icon
						 $html.='
						 <li class="pg-icon pg-icon-'.$property_group_name.' '.$class.'"
						 rel="'.$property_group_name.'" title="'.$this->property_option_groups[$property_group_name].'">
						 </li>';
					 }

				$html.='
				</ul>';

				// display actual fields
				$html.='
				<ul class="styling-options">';

					// do all-device and MQ fields
					foreach ($this->propertyoptions as $property_group_name => $junk) {
						 $html.= $this->single_option_group_html(
							 $section_name,
							 $css_selector,
							 $array,
							 $property_group_name,
							 $pg_focus);
					}

					$html.= '
				</ul>';

				return $html;
			}

			// if a pg group has loaded but no values were added we don't want to load it into the dom
			function pg_has_values($array){
				if (empty($array) or !is_array($array)){
					return false;
				}
				$no_values = true;
				foreach ($array as $key => $value){
					// must allow zero values!
					if ( !empty($value) or $value === 0 or $value === '0'){
						$no_values = false;
						break;
					}
				}
				return $no_values ? false : true;
			}

			// are legacy values present for pg group?
			function has_legacy_values($styles, $property_group_name){
				$legacy_values = false;
				if (!empty($this->legacy_groups[$property_group_name]) and is_array($this->legacy_groups[$property_group_name])){
					foreach ($this->legacy_groups[$property_group_name] as $leg_group => $array){
						// check if the pg has values and they are specifically ones have have moved to this pg
						if ( !empty($styles[$leg_group]) and
							$this->pg_has_values($styles[$leg_group]) and
							$this->props_moved_to_this_pg($styles[$leg_group], $array)){
							$legacy_values = $styles[$leg_group];
							break;
						}
					}
				}
				return $legacy_values;
			}

			function pg_has_values_inc_legacy($array, $property_group_name){
				$styles_found = false;
				if (!empty($array['styles'][$property_group_name]) and $this->pg_has_values($array['styles'][$property_group_name])) {
					$styles_found['cur_leg'] = 'current';
				} elseif (!empty($array['styles']) and $this->has_legacy_values($array['styles'], $property_group_name)){
					$styles_found['cur_leg'] = 'legacy';
				}
				return $styles_found;
			}

			// look for any values in property group, including legacy values - and optionally, media query values
			function pg_has_values_inc_legacy_inc_mq($section_name, $css_selector, $array, $property_group_name){

				// first just look for values in all devices (most likely)
				if ($styles_found = $this->pg_has_values_inc_legacy($array, $property_group_name)) {
					$styles_found['dev_mq'] = 'all-devices';
					return $styles_found;
				} else {
					// look for media query tabs with values too
					// - use preferences mqs for loop because any mq keys in options not in there will not be output
					// also active_queries doesn't currently get updated after deleting an MQ tab via popup
					if (is_array($this->preferences['m_queries'])) {
						foreach ($this->preferences['m_queries'] as $mq_key => $junk) {
							// now check $options
							if (!empty($this->options['non_section']['m_query'][$mq_key][$section_name][$css_selector])){
								$array = $this->options['non_section']['m_query'][$mq_key][$section_name][$css_selector];
								if ($styles_found = $this->pg_has_values_inc_legacy($array, $property_group_name)) {
									$styles_found['dev_mq'] = 'mq';
									break;
								}
							}
						}
					}

					/*
					if (!empty($this->options['non_section']['active_queries']) and
						is_array($this->options['non_section']['active_queries'])) {
						foreach ($this->options['non_section']['active_queries'] as $mq_key => $junk) { // here
							if (!empty($this->options['non_section']['m_query'][$mq_key][$section_name][$css_selector])){
								$array = $this->options['non_section']['m_query'][$mq_key][$section_name][$css_selector];
								if ($styles_found = $this->pg_has_values_inc_legacy($array, $property_group_name)) {
									$styles_found['dev_mq'] = 'mq';
									break;
								}
							}
						}
					}*/
					return $styles_found;
				}
			}

			// does the selector contain any styles?
			function selector_has_values($section_name, $css_selector, $array, $deep){
				$style_count_state = 0;
				foreach ($this->propertyoptions as $property_group_name => $junk) {
					// ui menus need deep analysis of settings, but stylesheet only looks at mq/regular arrays one at a time
					// and legacy values will have already been dealt with
					if ($deep){
						if ($this->pg_has_values_inc_legacy_inc_mq($section_name, $css_selector, $array, $property_group_name)) {
							++$style_count_state;
						}
					} else {
						if (!empty($array['styles'][$property_group_name]) and
							$this->pg_has_values($array['styles'][$property_group_name])) {
							++$style_count_state;
						}
					}
				}
				return $style_count_state;
			}

			// does the folder contain any styles?
			function section_has_values($section_name, $array, $deep){
				$style_count_state = 0;
				if ( is_array($array) ) {
					foreach ($array as $css_selector => $sel_array) {
						if ($this->selector_has_values($section_name, $css_selector, $sel_array, $deep)){
							++$style_count_state;
						}
					}
				}
				return $style_count_state;
			}

			// does the $ui_data array have values?
			function ui_data_has_values($ui_data, $deep){
				$style_count_state = 0;
				if (!empty($ui_data) and is_array($ui_data)){
					foreach ($ui_data as $section_name => $array){
						if ($this->section_has_values($section_name, $array, $deep)){
							++$style_count_state;
						}
					}
				}
				return $style_count_state;
			}

			// ensure that specific legacy props have moved to this pg
			function props_moved_to_this_pg($leg_group_styles, $array){
				// loop through legacy props to see if style values exist
				if (is_array($array)){
					foreach ($array as $legacy_prop => $legacy_prop_legend_key){
						if (!empty($leg_group_styles[$legacy_prop])){
							return true;
						}
					}
				}
				return false;
			}

			// determine if options property is legacy or not
			function is_legacy_prop($property_group_name, $property){
				$legacy = false;
				foreach ($this->legacy_groups as $new_group => $array){
					foreach ($array as $leg_group => $arr2){
						foreach ($arr2 as $leg_prop => $legacy_prop_legend_key) {
							if ($property_group_name == $leg_group and $property == $leg_prop) {
								$legacy = $new_group; // return new group for legacy property
								break;
							}
						}
					}
				}
				return $legacy;
			}

			// function to get legacy value (inc !important) if it exists
			function populate_from_legacy_if_exists($styles, $sel_imp_array, $prop){
				$target_leg_prop = false;
				$legacy_adjusted['value'] = false;
				$legacy_adjusted['imp'] = '';
				foreach ($this->legacy_groups as $pg => $leg_group_array){
					foreach ($leg_group_array as $leg_group => $leg_prop_array){
						// look for prop in value: 1 = same as key
						foreach ($leg_prop_array as $leg_prop => $legend_key){
							// prop may have legacy values
							if ( ($prop == $leg_prop and $legend_key) == 1 or $prop == $legend_key){
								$target_leg_prop = $leg_prop;

							} elseif (is_array($legend_key)){
								// loop through array
								if (in_array($prop, $legend_key)){
									$target_leg_prop = $leg_prop;
								}
							}
							// if the property had a previous location, check for a value
							if ($target_leg_prop){
								if (!empty($styles[$leg_group][$target_leg_prop])){
									$legacy_adjusted['value'] = $styles[$leg_group][$target_leg_prop];
									if (!empty($sel_imp_array[$leg_group][$target_leg_prop])){
										$legacy_adjusted['imp'] = $sel_imp_array[$leg_group][$target_leg_prop];
									}
									break 3; // break out of all loops
								}
							}
						}
					}
				}
				return $legacy_adjusted;
			}

			// new system that doesn't restrict section name format
			function get_folder_name_inc_legacy($section_name, $array){
				// legacy 1
				$display_section_name = ucwords(str_replace('_', ' ', $section_name));
				// legacy 2 (abandoned because I don't like having this stored in non_section)
				if (!empty($this->options['non_section']['display_name'][$section_name])) {
					$display_section_name = $this->options['non_section']['display_name'][$section_name];
				}
				// current
				if (!empty($this->options[$section_name]['this']['label'])) {
					$display_section_name = $this->options[$section_name]['this']['label'];
				}
				return $display_section_name;
			}


			// output all the options for a given property group
			function single_option_group_html(
				$section_name,
				$css_selector,
				$array,
				$property_group_name,
				$pg_focus){

				// check if the property group should be "active" (in focus)
				$pg_show_class = ( $property_group_name == $pg_focus ) ? 'show' : '';

				// main pg wrapper
				$html ='
				<li id="opts-'.$section_name.'-'.$css_selector.'-'.$property_group_name.'"
						 class="group-tag group-tag-'.$property_group_name.' hidden '.$pg_show_class.'">';

					// output all devices and MQ fields
					$html.= $this->single_device_fields(
							$section_name,
							$css_selector,
							$array,
							$property_group_name,
							$pg_show_class);

				$html.= '
				</li>';

				return $html;
			}

			// function for outputting all devices and MQs without repeating code
			function single_device_fields(
				$section_name,
				$css_selector,
				$array,
				$property_group_name,
				$pg_show_class){

				$html = '';

				// output all fields
				foreach ($this->combined_devices() as $key => $m_query){

					$property_group_array = false;
					$con = 'reg';

					// get array val if MQ
					if ($key != 'all-devices'){
						$con = 'mq';
						$array = false;
						if (!empty($this->options['non_section']['m_query'][$key][$section_name][$css_selector])) {
							$array = $this->options['non_section']['m_query'][$key][$section_name][$css_selector];
						}
					}

					// need to check for existing styles (inc legacy)
					if ( $array and $styles_found = $this->pg_has_values_inc_legacy(
						$array,
						$property_group_name) ) {

						// if there are current styles for the all devices tab, retrieve them
						if ($styles_found['cur_leg'] == 'current'){
							$property_group_array = $array['styles'][$property_group_name];
						}

						// if only legacy values exist set empty array so inputs are displayed
						else {
							$property_group_array = array();
						}
					}

					// show fields even if no values if tab is current
					if ( !$property_group_array and $this->preferences['mq_device_focus'] == $key and $pg_show_class){
						$property_group_array = array();
					}

					/*$this->debug_custom.= $section_name.'> '.$css_selector .'> '
						. $m_query['label'] .' ('.$key .') > '. $property_group_name .'> '
						. print_r( $property_group_array, true ). 'Arr: ' . is_array($array) . "\n\n";*/

					// output fields if needed
					if ( is_array( $property_group_array ) ) {

						// visible if tab is active
						$show_class = ( $this->preferences['mq_device_focus'] == $key ) ? 'show' : '';

						// pass current CSS selector
						$sel_code = '';
						if (!empty($array['label'])){ // not sure why this would be - troubleshoot
							$sel_meta = explode('|', $array['label']);
							$sel_code = !empty($sel_meta[1]) ? $sel_meta[1] : '';
						}

						// this is contained in a separate function because the li always needs to exist
						// as a wrapper for the tmpl div
						$html.= $this->single_option_fields(
							$section_name,
							$css_selector,
							$array,
							$property_group_array,
							$property_group_name,
							$show_class,
							false,
							$key,
							$con,
							$sel_code);

					}
				}

				return $html;
			}

			// the options fields part of the property group (which can be added as templates)
			function single_option_fields(
				$section_name,
				$css_selector,
				$array,
				$property_group_array,
				$property_group_name,
				$show_class,
				$template = false,
				$key = 'all-devices',
				$con = 'reg',
				$sel_code = 'selector_code'){

				// is this template HTML?
				$id = ( $template ) ? 'id="option-group-template-'.$property_group_name. '"' : '';

				// do all-devices fields
				$html = '
				<div '.$id.' class="property-fields hidden property-'.$property_group_name.'
				property-fields-'. $key . ' ' . $show_class.'">
					';

					// merge to allow for new properties added to property-options.inc.php (array with values must come 2nd)
					$property_group_array = array_merge($this->propertyoptions[$property_group_name], $property_group_array);

					// output individual property fields
					foreach ($property_group_array as $property => $value) {

						// filter prop
						$property = esc_attr($property);

						/* if a new CSS property has been added with array_merge(), $value will be something like:
						Array ( [label] => Left [default_unit] => px [icon] => position_left )
						- so just set to nothing if it's an array
						*/
						$value = ( !is_array($value) ) ? esc_attr($value) : '';

						// format input fields
						$html.= $this->resolve_input_fields(
							$section_name,
							$css_selector,
							$array,
							$property_group_array,
							$property_group_name,
							$property,
							$value,
							$con,
							$key,
							$sel_code
						);
					}

					$html.= '
				</div>';

				return $html;
			}


			// check for legacy device_focus values (e.g. padding/margin for padding_margin)
			function device_focus_inc_legacy($section_name, $css_selector, $property_group_name, $property_group_array){
				$device_array = array();
				$device_key = '';
				if (!empty($this->options[$section_name][$css_selector]['device_focus'])){
					$device_array = $this->options[$section_name][$css_selector]['device_focus'];
				}
				$dtab = 'all-devices';
				// check for regular device tab focus
				if (!empty($device_array[$property_group_name])){
					$device_key = $device_array[$property_group_name];
				}
				// check for legacy pg name
				elseif (!empty($this->legacy_groups[$property_group_name])){
					foreach($this->legacy_groups[$property_group_name] as $leg_pg => $junk){
						if (!empty($device_array[$leg_pg])){
							$device_key = $device_array[$leg_pg];
							break;
						}
					}
				}
				// check if the tab in focus actually has any field values
				if (!empty($this->current_pg_group_tabs[$device_key])){
					$dtab = $device_key;
				} else {
					// fallback to a tab that does have values
					foreach ($this->current_pg_group_tabs as $key){
						$dtab = $key;
						break;
					}
				}
				return $dtab;
			}

			// media query option in "Edit media queries" - also used for template
			function edit_mq_row(
				$m_query = array('label' => '', 'query' => ''),
				$key = 'key',
				$i = 0,
				$template = true){
					$li_class = 'mq-row-'.$i;
					if ($template){
						$li_class = 'm-query-tpl';
					}
					?>
					<li class="mq-row <?php echo $li_class; ?>">
						<span class="del-m-query tvr-icon delete-icon" title="<?php esc_attr_e("Delete this media query", 'microthemer'); ?>"></span>
						<div class="mq-edit-wrap mq-label-wrap">
							<label title="<?php esc_attr_e('Give your media query a descriptive name', 'microthemer'); ?>"><?php esc_html_e('Label:', 'microthemer'); ?></label>
							<input class="m-label" type="text" name="tvr_preferences[m_queries][<?php echo $key; ?>][label]"
								value="<?php echo esc_attr($m_query['label']); ?>" />
						</div>
						<div class="mq-edit-wrap mq-query-wrap">
							<label title="<?php esc_attr_e("Set the media query condition", 'microthemer'); ?>">
								<?php esc_html_e('Media Query:', 'microthemer'); ?></label>
							<textarea class="m-code"
								name="tvr_preferences[m_queries][<?php echo $key; ?>][query]"
									><?php echo esc_html($m_query['query']); ?></textarea>
						</div>
						<div class="mq-edit-wrap mq-checkbox-wrap">
							<label title="<?php esc_attr_e("Hide this tab in the interface if you don't need it right now and you'd like to keep the number of tabs in the interface manageably low", 'microthemer'); ?>">
								<?php esc_html_e('Hide Tab In Interface', 'microthemer'); ?>:</label>
							<?php
							$checked = '';
							$on = '';
							if ( !empty($this->preferences['m_queries'][$key]['hide']) ){
								$checked = 'cecked="checked"';
								$on = 'on';
							}
							?>
							<input type="checkbox" name="tvr_preferences[m_queries][<?php echo $key; ?>][hide]"
								value="1" <?php echo $checked; ?> />
							<span class="fake-checkbox <?php echo $on ?>"></span>
							<span class="ef-label">
								<?php esc_attr_e('Yes (no settings will be lost)', 'microthemer'); ?>
							</span>
						</div>
					</li>
				<?php
			}

			// format media query min/max width (height later) and units
			function mq_min_max($pref_array){
				// check the media query min/max values
				foreach($pref_array['m_queries'] as $key => $mq_array) {
					$m_conditions = array('min', 'max');
					foreach ($m_conditions as $condition){
						$matches = $this->get_screen_size($mq_array['query'], $condition);
						$pref_array['m_queries'][$key][$condition] = 0;
						if ($matches){
							$pref_array['m_queries'][$key][$condition] = intval($matches[1]);
							$pref_array['m_queries'][$key][$condition.'_unit'] = $matches[2];
						}
					}
				}
				return $pref_array['m_queries'];
			}

			// The new UI always shows the MQ tabs.
			// This happens even when no selectors are showing, so a different approach is needed
			function global_media_query_tabs(){

				$html = '
				<div class="query-tabs">

					<span class="edit-mq show-dialog"
					title="' . esc_attr__('Edit media queries', 'microthemer') . '" rel="edit-media-queries">
					</span>

					<input class="device-focus" type="hidden"
					name="tvr_mcth[non_section][device_focus]"
					value="'.$this->preferences['mq_device_focus'].'" />';

					// display tabs
					foreach ($this->combined_devices() as $key => $m_query){

						// don't show if hidden by the user
						if ( !empty($m_query['hide']) ) continue;

						// should the tab be active? - let JS handle this
						//$class = ($this->preferences['mq_device_focus'] == $key) ? 'active' : '';

						$html.= '
						<span class="quick-opts-wrap tvr-fade-in mt-tab mq-tab mq-tab-'.$key.'" rel="'.$key.'">' .
							// disabled check is always done with JS after loading the selector, no need to check item-disabled class
							'<span class="mq-tab-txt">' . $m_query['label']. '</span>
							 <span class="quick-opts tvr-dots dots-above">
							 	<div class="quick-opts-inner">'
									. $this->icon_control('disabled', false, 'tab')
									. $this->clear_icon('tab'). '
									<span class="tvr-icon info-icon" title="'.$m_query['query'].'"></span>
								</div>
							 </span>
						</span>';
					}


					$html.= '

					<div class="clear"></div>

				</div>';

				return $html;
			}

			// check for 2 values on border-radius corner
			function check_two_radius($radius, $c2){
				$check = explode(' ', $radius);
				// if there are more than two values
				if (!empty($check[1])){
					$radius = $check[0];
					$c2[] = $check[1];
				} else {
					// if ANY 2nd corners have been found so far, but not on this occasion, default to the existing radius
					if ($c2){
						$c2[] = $radius;
					}
				}
				$corner = array($radius, $c2);
				return $corner;
			}

			// check if e.g. box-sahdow-x has none/inherit/initial
			function is_single_keyword($val) {
				return in_array($val, array('none', 'initial', 'inherit'));
			}

			// add px unit if no unit specified (and qualifies)
			function maybe_apply_px($property_group_name, $property, $value) {
				$value = trim($value);
				if (!empty($this->propertyoptions[$property_group_name][$property]['default_unit'])) {
					// if single plain number add px
					if ( is_numeric($value) and $value != 0){
						$value.= 'px';
					}
					// if space separated values, apply to each segment
					if (strpos($value, ' ')) {
						$m = explode(' ', $value);
						foreach ($m as $k => $v){
							$arr[$k] = $v;
							if ( is_numeric($v) and $v != 0){
								$arr[$k].= 'px';
							}
						}
						$value = implode(' ', $arr);
					}
				}
				return $value;
			}

			// check if !important should be used for CSS3 line
			function tvr_css3_imp($section_name, $css_selector_slug, $property_group_name, $prop, $con, $mq_key) {
				if ($this->preferences['css_important'] != '1') {
					if ($con == 'mq') {
						$important_val = !empty($this->options['non_section']['important']['m_query'][$mq_key][$section_name][$css_selector_slug][$property_group_name][$prop]) ? '1' : '';
					} else {
						$important_val = !empty($this->options['non_section']['important'][$section_name][$css_selector_slug][$property_group_name][$prop]) ? '1' : '';
					}
					if ($important_val == '1') {
						$css_important = ' !important';
					}
					else {
						$css_important = '';
					}
				} else {
					$css_important = ' !important';
				}
				return $css_important;
			}

			// tranform MT form settings into stylesheet data
			function convert_ui_data($ui_data, $sty, $con, $key = '1') {

				$tab = $sec_breaks = $mq_key = "";
				if ($con == 'mq') {
					// don't output media query if no values inside
					if (!$this->ui_data_has_values($ui_data, false)){
						return $sty;
					}
					$mq_key = $key;
					$mq_label = $this->preferences['m_queries'][$key]['label'];
					$mq_query = $this->preferences['m_queries'][$key]['query'];
					$tab = "\t";
					$sec_breaks = "";
					$sty['data'].= "\n\n/*[ $mq_label ]*/\n$mq_query {\n";
				}

				// loop through the sections
				foreach ( $ui_data as $section_name => $array) {

					// skip non_section stuff or empty sections
					if ($section_name == 'non_section' or
						!$this->section_has_values($section_name, $array, false)) {
						continue;
					}

					// get the section name, accounting for legacy data structure
					$display_section_name = $this->get_folder_name_inc_legacy($section_name, $array);

					// check if section been disabled on regular ui array as this happens on that level
					!empty($this->options[$section_name]['this']['disabled'])
						? $display_section_name.= ' ('.$this->dis_text.')' : false;

					// make sections same width by adding extra = and accounting for char length
					$eq_str = $this->eq_str($display_section_name);
					$sty['data'].= $sec_breaks."\n$tab/*= $display_section_name $eq_str */\n";

					// if section disabled, continue
					if (!empty($this->options[$section_name]['this']['disabled'])) { continue; }

					// loop the CSS selectors - section_has_values() already tells us array is good
					foreach ( $array as $css_selector => $array ) {

						// skip this or empty selectors
						if ($css_selector == 'this' or
							!$this->selector_has_values($section_name, $css_selector, $array, false)) {
							continue;
						}

						// sort out the css selector - need to get css label/code from regular ui array
						if ($con == 'mq') {
							$array['label'] = $this->options[$section_name][$css_selector]['label'];
						}
						$label_array = explode('|', $array['label']);
						$css_label = $label_array[0]; // ucwords(str_replace('_', ' ', $label_array[0]));
						$sel_code = $label_array[1];

						$opening_sel = $sel_code . ' {';
						if (!empty($array['tab']['disabled']) or
							!empty($this->options[$section_name][$css_selector]['disabled'])) {
							$opening_sel = '';
							$css_label.= ' ('.$this->dis_text.')';
						}

						// output opening sel
						$sty['data'].= "\n$tab/** $display_section_name >> $css_label **/\n$tab{$opening_sel}\n";

						// move on if sel disabled
						if (empty($opening_sel)) { continue; }


						// loop the groups of properties for the selector
						$pie_relevant = false;
						if ( is_array( $array['styles'] ) ) {
							foreach ( $array['styles'] as $property_group_name => $property_group_array ) {
								if ( is_array( $property_group_array ) ) {

									$disabled = false;
									foreach ($property_group_array as $property => $value) {

										// skip bg_img_display as it's just for display, real value has already been processed
										if ($property == 'background_imageimg_display') continue;

										$prop_array = $this->propertyoptions[$property_group_name][$property];

										// check if new sub group
										if (!empty($prop_array['sub_label'])) {
											$subgroup_label = $prop_array['sub_label'];
											$subgroup = $prop_array['sub_slug'];
											// check if sub group is disabled
											$disabled = false;
											if (!empty($array['pg_disabled'][$subgroup])) {
												$disabled = true;
												$sty['data'] .= $tab . "	/* $subgroup_label $this->dis_text */\n";
												continue;
											}
										} else {
											// it's a subsequent prop in the sub-group. Skip if disabled
											if ($disabled){
												continue;
											}
										}

										// we don't want the display_img fields in the stylesheet
										if ($property == 'list_style_imageimg_display'
											or $property == 'background_imageimg_display'){
											continue;
										}

										// get the appropriate value for !important
										if (empty($this->options['non_section']['important'])) {
											$important_val = 0;
										} else {
											if ($con == 'mq') {
												$important_val = !empty($this->options['non_section']['important']['m_query'][$mq_key][$section_name][$css_selector][$property_group_name][$property]) ? '1' : 0;
											} else {
												$important_val = !empty($this->options['non_section']['important'][$section_name][$css_selector][$property_group_name][$property]) ? '1' : 0;
											}
										}

										if ( $value != '' ) {

											// account for old PHP versions with magic quotes
											$value = $this->stripslashes($value);

											// check if !important should be added
											if ($this->preferences['css_important'] != '1') {
												$sty['css_important'] = ($important_val == '1') ? ' !important' : '';
											}

											// special case for css3 properties
											if (in_array($property, $sty['css3'])) {
												include $this->thisplugindir . 'includes/resolve-css3.inc.php';
											}

											// regular css prop
											else {
												$property_slug = $property;
												$property = str_replace('_', '-', $property);

												// exception for images
												if ( ($property == 'background-image' or $property == 'list-style-image')
													and $value != 'none') {
													$sty['data'].= $tab."	$property: url(\""
														.$this->root_rel($value, false, true)."\"){$sty['css_important']};\n";
												}

												// exception for custom css
												elseif ($property == 'css') {
													$t_value = str_replace("\t", $tab."\t", $value);
													$sty['data'].= $tab."	$t_value\n";
												}

												// exception for font family with Google selected
												elseif ($property == 'font-family' and $value == 'Google Font...') {
													// do nothing
												}

												// exception for google font
												elseif ($property == 'google-font' and $value) {
													$sty['g_fonts_used'] = true;
													// separate variant from font name
													$fv = explode(" (", $value);
													$f_name = $fv[0];
													$f_var = str_replace(' ', '', $fv[1]);
													$f_var = str_replace(')', '', $f_var);
													// save unique fonts in array for building Google CSS URL
													$url_font_value = str_replace(' ', '+', $f_name);
													if (empty($sty['g_fonts'][$url_font_value][$f_var])) {
														$sty['g_fonts'][$url_font_value][$f_var] = 1;
													}
													$sty['data'] .= $tab . "	font-family: '$f_name'{$sty['css_important']};\n";
												}

												// default method
												else {
													// check if value needs px extension
													$val_with_unit = $this->maybe_apply_px($property_group_name, $property_slug, $value);
													$sty['data'].= $tab."	$property: {$val_with_unit}{$sty['css_important']};
";
												}
												// if opacity property, add cross-browser rules too.
												if ($property == 'opacity') {
													$percent = $value*100;
													$sty['data'].= $tab.'	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity='.$percent.')"'.$sty['css_important'].';
'.$tab.'	filter: alpha(opacity='.$percent.')'.$sty['css_important'].';
'.$tab.'	-moz-opacity:'.$value.$sty['css_important'].';
'.$tab.'	-khtml-opacity: '.$value.$sty['css_important'].';
';
												}
											}
										}
									}
								}
							}
						}
						// determine if CSS3 PIE needs calling (don't add to body as all other pie will break)
						if ($pie_relevant
							and $sel_code != 'body'
							and $sel_code != 'html'
							and ($this->preferences['pie_by_default'] == 1 or !empty($array['pie']))
						) {
							$sty['data'].= $tab."	behavior: url(".$sty['pie'].");\n";
							// auto-apply position:relative if prefered and position hasn't been explicitly defined
							if ( empty($array['styles']['position']['position']) ) {
								$sty['data'].= $tab."	position: relative; /* " .
									esc_attr_x('Because CSS3 PIE is enabled. It requires this to work.',
										'CSS comment', 'microthemer') . " */\n";
							}
						}

						$sty['data'].= "$tab}\n";


						// output comma'd selectors on different lines (let it be maybe)
						// $sel_code = str_replace(", ", ",\n", $sel_code);
						// convert custom escaped single & double quotes back to normal ( [type="submit"] )

						// already done with deep at save point, keep for legacy reasons for while (Nov 17, 2015)
						//$sel_code = $this->unescape_cus_quotes($sel_code);

						/*

						$count_styles = count($array);

						// check for use of curly braces
						$curly = strpos($sel_code, '{');


						// adjust selector if curly braces are present
						if ($curly!== false) {
							$curly_array = explode("{", $sel_code);
							$sel_code = $curly_array[0];
							// save custom styles in an array for later output
							$cusStyles = explode(";", str_replace('}', '', $curly_array[1]) );
						} else {
							$cusStyles = false;
						}

						// media_query_buttons

						// if there are styles or the user has entered hand-coded styles
						if ( ($con != 'mq' and $count_styles > 2)
							or ($con != 'mq' and $curly!== false )
							or ($con == 'mq' and $count_styles > 1) ) {
							// If disabled, warn and don't ouput opening {
							// The individual tab may be disabled. Or the whole selector may be disabled.
							// Check global selector using regular ui array
						}
						*/

					}


				}
				// return the modified $sty array
				if ($con == 'mq') {
					$sty['data'].= "}";
				}
				return $sty;
			}

			// write to a file (make more use of this function)
			function write_file($file, $data){
				// the file will be created if it doesn't exist. otherwise it is overwritten.
				$write_file = fopen($file, 'w');
				// if write is unsuccessful for some reason
				if (false === fwrite($write_file, $data)) {
					$this->log(
						esc_html__('File write error', 'microthemer'),
						'<p>' . sprintf(esc_html__('Writing to %s failed.', 'microthemer'),
							$this->root_rel($file)) . $this->permissionshelp.'</p>'
					);
					return false;
				}
				fclose($write_file);
				return true;
			}

			function eq_str($name){
				$eq_signs = 25-strlen($name);
				$eq_signs = $eq_signs > -1 ? $eq_signs : 0;
				$eq_str = '';
				for ($x = $eq_signs; $x >= 0; $x--) {
					$eq_str.= '=';
				}
				return $eq_str;
			}

			// update active-styles.css
			function update_active_styles($activated_from, $context = '') {

				// get path to active-styles.css
				$act_styles = $this->micro_root_dir.'active-styles.css';

				// check for micro-themes folder and create if it doesn't exist
				$this->setup_micro_themes_dir();

				// bail if stylesheet isn't writable
				if ( !is_writable($act_styles) ) {
					$this->log(
						esc_html__('Write stylesheet error', 'microthemer'),
						'<p>' . esc_html__('WordPress does not have "write" permission for: ', 'microthemer')
						. '<span title="'.$act_styles.'">'. $this->root_rel($act_styles) . '</span>
						. '.$this->permissionshelp.'</p>'
					);
					return false;
				}

				// setup vars for later comparison
				$sty['g_fonts'] = array();
				$sty['g_fonts_used'] = false;
				$sty['prop_key_array'] = $this->property_option_groups;

				// determine if !important should be added to all styles
				$sty['css_important'] = $this->preferences['css_important'] == '1' ? ' !important' : '';

				// get path to PIE.php in case it needs to be called
				// this will work on ssl pages & localhost with sites in sub directory of document root
				$poly_path = substr(getenv("SCRIPT_NAME"), 0, -19)
					. str_replace($this->site_url, '', $this->micro_root_url);
				$sty['pie'] = $poly_path . 'PIE.php';

				// css3 properties
				$sty['css3'] = array(
					'gradient_a',
					'gradient_b',
					'gradient_b_pos',
					'gradient_c',
					'gradient_angle',
					'border_top_left_radius',
					'border_top_right_radius',
					'border_bottom_right_radius',
					'border_bottom_left_radius',
					'box_shadow_color',
					'box_shadow_x',
					'box_shadow_y',
					'box_shadow_blur',
					'box_shadow_spread',
					'box_shadow_inset',
					'text_shadow_color',
					'text_shadow_x',
					'text_shadow_y',
					'text_shadow_blur'
				);

				// store stylesheet data in a object that can be passed and returned to function
				$sty['data'] = '/*  MICROTHEMER STYLES  */' . "\n\n";

				// check if hand coded have been set - output before other css
				if ( !empty($this->options['non_section']['hand_coded_css'])
					and trim($this->options['non_section']['hand_coded_css']) != '' ) {
					$name = esc_attr_x('Hand Coded CSS', 'CSS comment', 'microthemer');
					$eq_str = $this->eq_str($name);
					$sty['data'].= "/*= $name $eq_str */\n\n";
					$sty['data'].= $this->options['non_section']['hand_coded_css'] ."\n";
				}

				// convert ui data to regular css output
				$sty = $this->convert_ui_data($this->options, $sty, 'regular');

				// convert ui data to media query css output
				if (!empty($this->options['non_section']['m_query']) and is_array($this->options['non_section']['m_query'])) {
					foreach ($this->preferences['m_queries'] as $key => $m_query) {
						// process media query if it has been in use at all
						if (!empty($this->options['non_section']['m_query'][$key]) and
							is_array($this->options['non_section']['m_query'][$key])){
							$sty = $this->convert_ui_data($this->options['non_section']['m_query'][$key], $sty, 'mq', $key);
						}
					}
				}

				// update the preferences value for active theme - custom/theme name
				$pref_array = array();
				$g_ie_array = array();

				// build google font url
				if (!empty($sty['g_fonts_used'])) {
					$g_url = '//fonts.googleapis.com/css?family=';
					$first = true;

					foreach ($sty['g_fonts'] as $url_font_value => $v_array) {
						if ($first) {
							$first = false;
						} else {
							$g_url.='|';
						}
						$g_url.= $url_font_value;
						// add any variations to string
						$v_first = true;
						$v_string = '';
						foreach ($v_array as $f_var => $val) {
							if ( empty($f_var) ) {
								continue;
							}
							if ($v_first) {
								$v_string.= ':';
								$v_first = false;
							} else {
								$v_string.=',';
							}
							$v_string.= $f_var.'';
							$g_ie_array[] = $url_font_value . ':' . $f_var;
						}
						$g_url.= $v_string;

					}
				} else {
					$g_url = '';
				}
				$pref_array['g_fonts_used'] = $sty['g_fonts_used'];
				$pref_array['g_url'] = $g_url;
				$pref_array['g_ie_array'] = $g_ie_array;

				if ($activated_from != 'customised' and $context != __('Merge', 'microthemer')) {
					$pref_array['theme_in_focus'] = $activated_from;
					$pref_array['active_theme'] = $activated_from;

				}
				if ($context == __('Merge', 'microthemer') or $activated_from == 'customised') {
					$pref_array['active_theme'] = 'customised'; // a merge means a new custom configuration
				}
				$pref_array['num_saves'] = ++$this->preferences['num_saves'];
				if ($this->savePreferences($pref_array) and $activated_from != 'customised') {
					$this->log(
						esc_html__('Design pack activated', 'microthemer'),
						'<p>' . esc_html__('The design pack was successfully activated.', 'microthemer') . '</p>',
						'dev-notice'
					);
				}

				// get user config for draft
				$file_stub = $this->preferences['draft_mode'] ? 'draft' : 'active';

				// if scss is enabled, compile (use for minify too, maybe use specific tool later)
				if ($this->preferences['allow_scss']){
					// add uncompiled scss to array
					$uncompiled = $sty['data'];
					$file_name = $file_stub . '-styles.scss';
					$css_files[] = array(
						'name' => $file_name,
						'data' => $uncompiled
					);

					$scss = '';
					require $this->thisplugindir . "includes/scssphp/mt-scss.php";

					// catch any compilation errors
					try {
						$sty['data'] = $scss->compile($sty['data']);
					} catch (Exception $e) {
						// write data to file so they can see their mistake
						$this->write_file($this->micro_root_dir . $file_name, $uncompiled);
						// get the line number from error message
						preg_match('/line:? ([0-9]+)$/', $e->getMessage(), $matches);
						$line = !empty($matches[1]) ? $matches[1] : 0;
						$action = esc_html__('View the problem line in your SCSS code', 'microthemer');
						$this->log(
							esc_html__('SCSS error - compilation failed', 'microthemer'),
							'<p>'.esc_html__('An error was found in your SCSS code which prevented it from
							being compiled into regular CSS code. Only valid SCSS code can be compiled.', 'microthemer') . '</p>
							<p><b>' . htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8').'</b></p>
							<p><span id="scss-line-error" class="link show-dialog" rel="display-css-code"
							data-tab="0" data-line="'.$line.'" title="'.$action.'">'
							.$action
							. '</span></p>'
						);
						echo '
						<div id="microthemer-notice">'. $this->display_log() . '</div>';
						return false;
					}
				}

				// add compiled or raw css to array
				$targetFile = $file_stub . '-styles.css';
				$css_files[] = array(
					'name' => $targetFile,
					'data' => $sty['data']
				);

				// do we minify?
				if ($this->preferences['minify_css']){
					if (version_compare(PHP_VERSION, '5.3') < 0) {
						$css_files[] = array(
							'name' => 'min.'.$targetFile,
							'data' => '/* ' .esc_html__('Minification is not supported. Your version of PHP is below 5.3. ', '') .
								esc_html__('Please upgrade PHP to version 5.3+ to use minification') . " */\n\n" . $sty['data']
						);
					} else {
						require $this->thisplugindir . "includes/min-css-js/mt-minify.php";
					}
				}

				// write all necessary files
				foreach ($css_files as $key => $file){
					$this->write_file($this->micro_root_dir . $file['name'], $file['data']);
				}

				// write to the ie specific stysheets if user defined
				$this->update_ie_sheets();

				// write any js code to external script file
				$this->update_javascript();
			}

			// update the external JS file or add to head if that is enabled
			// some hosts block the creation of .js files with PHP
			function update_javascript() {
				$val = !empty($this->options['non_section']['js']) ?
					trim($this->options['non_section']['js']) : '';
				if (!empty($val)) {
					$pref_array['load_js'] = 1;
				} else {
					// script editor is empty
					$pref_array['load_js'] = 0;
				}
				// always update file otherwise JS can't be cleared
				$file_stub = $this->preferences['draft_mode'] ? 'draft' : 'active';
				$script = $this->micro_root_dir.$file_stub.'-scripts.js';
				$this->write_file($script, $val);
				/*if (!$this->write_file($script, $val)){
					$this->log(
						esc_html__('Host may block JS created with PHP', 'microthemer'),
						'<p>' . esc_html__('I.', 'microthemer').'</p>'
					);
				}*/
				// update the preferences so that the script is/isn't called in the <head>
				$this->savePreferences($pref_array);
			}

			// update ie specific stylesheets
			function update_ie_sheets() {
				if ( !empty($this->options['non_section']['ie_css']) and
				is_array($this->options['non_section']['ie_css']) ) {
					foreach ($this->options['non_section']['ie_css'] as $key => $val) {
						// if has custom styles
						$trim_val = trim($val);
						if (!empty($trim_val)) {
							$pref_array['ie_css'][$key] = $this->custom_code['ie_css'][$key]['cond'];
						} else {
							// no value for stylesheet specified
							$pref_array['ie_css'][$key] = 0;
						}
						// always update file otherwise CSS can't be cleared
						$file_stub = $this->preferences['draft_mode'] ? 'draft-' : '';
						$stylesheet = $this->micro_root_dir.$file_stub.'ie-'.$key.'.css';
						$this->write_file($stylesheet, $val);
					}
					// update the preferences so that the stylesheets are called in the <head>
					$this->savePreferences($pref_array);
				}
			}


			// write settings to .json file
			function update_json_file($theme, $context = '') {

				$theme = sanitize_file_name(sanitize_title($theme));

				// create micro theme of 'new' has been requested
				if ($context == 'new') {
					// Check for micro theme with same name
					if ($alt_name = $this->rename_if_required($this->micro_root_dir, $theme)) {
						$theme = $alt_name; // $alt_name is false if no rename was required
					}
					if (!$this->create_micro_theme($theme, 'export', ''))
						return false;
				}

				// Create new file if it doesn't already exist
				$json_file = $this->micro_root_dir.$theme.'/config.json';
				$task = 'updated';
				if (!file_exists($json_file)) {
					$task = 'created';
					if (!$write_file = fopen($json_file, 'w')) { // this creates a blank file for writing
						$this->log(
							esc_html__('Create json error', 'microthemer'),
							'<p>' . esc_html__('WordPress does not have permission to create: ', 'microthemer')
							. $this->root_rel($json_file) . '. '.$this->permissionshelp.'</p>'
						);
						return false;
					}
				}

				// check if json file is writable
				if (!is_writable($json_file)){
					$this->log(
						esc_html__('Write json error', 'microthemer'),
						'<p>' . esc_html__('WordPress does not have "write" permission for: ', 'microthemer')
						. $this->root_rel($json_file) . '. '.$this->permissionshelp.'</p>'
					);
					return false;
				}

				// tap into WordPress native JSON functions
				if( !class_exists('Moxiecode_JSON') ) {
					require_once($this->thisplugindir . 'includes/class-json.php');
				}
				$json_object = new Moxiecode_JSON();

				// copy full options to var for filtering
				$json_data = $this->options;

				// loop through full options
				foreach ($this->options as $section_name => $array) {

					// if the section wasn't selected, remove it from json data var (along with the view_state var)
					if ( empty($this->serialised_post['export_sections'])
						or (!array_key_exists($section_name, $this->serialised_post['export_sections']) )
						and $section_name != 'non_section') {

						// remove the regular section data and view states
						unset($json_data[$section_name]);
						unset($json_data['non_section']['view_state'][$section_name]);

						// need to remove all media query settings for unchecked sections too
						if (!empty($json_data['non_section']['m_query']) and
							is_array($json_data['non_section']['m_query'])) {
							foreach ($json_data['non_section']['m_query'] as $m_key => $array) {
								unset($json_data['non_section']['m_query'][$m_key][$section_name]);
							}
						}
					}
				}

				// set handcoded css to nothing if not marked for export
				if ( empty($this->serialised_post['export_sections']['hand_coded_css'])) {
					$json_data['non_section']['hand_coded_css'] = '';
				}

				// set js to nothing if not marked for export
				if ( empty($this->serialised_post['export_sections']['js'])) {
					$json_data['non_section']['js'] = '';
				}

				// ie too
				foreach ($this->preferences['ie_css'] as $key => $value) {
					if ( empty($this->serialised_post['export_sections']['ie_css'][$key])) {
						$json_data['non_section']['ie_css'][$key] = '';
					}
				}

				// create debug selective export file if specified at top of script
				if ($this->debug_selective_export) {
					$data = '';
					$debug_file = $this->debug_dir . 'debug-selective-export.txt';
					$write_file = fopen($debug_file, 'w');
					$data.= esc_html__('The Selectively Exported Options', 'microthemer') . "\n\n";
					$data.= print_r($json_data, true);
					$data.= "\n\n" . esc_html__('The Full Options', 'microthemer') . "\n\n";
					$data.= print_r($this->options, true);
					fwrite($write_file, $data);
					fclose($write_file);
				}

				// write data to json file
				if ($data = $json_object->encode($json_data)) {
					// the file will be created if it doesn't exist. otherwise it is overwritten.
					$write_file = fopen($json_file, 'w');
					fwrite($write_file, $data);
					fclose($write_file);
					// report
					if ($task == 'updated'){
						$this->log(
							esc_html__('Settings exported', 'microthemer'),
							'<p>' . esc_html__('Your settings were successfully exported to: ',
								'microthemer') . '<b>'.$theme.'</b></p>',
							'notice'
						);
					}
				}
				else {
					$this->log(
						esc_html__('Encode json error', 'microthemer'),
						'<p>' . esc_html__('WordPress failed to convert your settings into json.', 'microthemer') . '</p>'
					);
				}



				return $theme; // sanitised theme name
			}

			// pre-process import or restore data
			function filter_incoming_data($con, $data){

				// Unitless css values may need to be auto-adjusted, including MQs
				$filtered_json = $this->filter_json_css_units($data);
				if (!empty($filtered_json['non_section']['m_query']) and
					is_array($filtered_json['non_section']['m_query'])) {
					foreach ($filtered_json['non_section']['m_query'] as $m_key => $array) {
						$filtered_json['non_section']['m_query'][$m_key] = $this->filter_json_css_units($array);
					}
				}

				// compare media queries in import/restore to existing
				$mq_analysis = $this->analyse_mqs(
					$filtered_json['non_section']['active_queries'],
					$this->preferences['m_queries']
				);

				// check if enq_js needs to be added
				if ($this->new_enq_js(
					$this->preferences['enq_js'],
					$filtered_json['non_section']['active_enq_js']
				)){
					$pref_array['enq_js'] = array_merge(
						$this->preferences['enq_js'],
						$filtered_json['non_section']['active_enq_js']
					);
					if ($this->savePreferences($pref_array)) {
						$this->log(
							esc_html__('JS libraries added', 'microthemer'),
							'<p>' . esc_html__('The settings you added depend on JavaScript libraries that are different from your current setup. These have been imported to ensure correct functioning.',
								'microthemer') . '</p>',
							'warning'
						);
					}
				}

				// check if the import/restore contains the same media queries but with different keys
				// if so, set the keys the same.
				// new queries also trigger this because new queries get assigned fresh keys
				if ($mq_analysis['replacements_needed']){
					foreach ($mq_analysis['replacements'] as $student_key => $role_model_key){
						$filtered_json = $this->replace_mq_keys($student_key, $role_model_key, $filtered_json);
					}
				}

				// check for new media queries in the import
				if ($mq_analysis['new']) {

					// merge the new queries with the current workspace mqs
					$pref_array['m_queries'] = array_merge(
							$this->preferences['m_queries'],
							$mq_analysis['new']
						);

					// format media query min/max width (height later) and units
					$pref_array['m_queries'] = $this->mq_min_max($pref_array);

					// save the new queries
					if ($this->savePreferences($pref_array)) {
						$this->log(
							esc_html__('Media queries added', 'microthemer'),
							'<p>' . esc_html__('The settings you added contain media queries that are different from the ones in your current setup. In order for all styles to display correctly, these additional media queries have been imported into your workspace.',
								'microthemer') . '</p>
								<p>' . wp_kses(
								sprintf(
									__('Please <span %s>review (and possibly rename) the imported media queries</span>. Note: they are marked with "(imp)", which you can remove from the label name once you\'ve reviewed them.', 'microthemer'),
									'class="link show-dialog" rel="edit-media-queries"' ),
								array( 'span' => array() )
							) . ' </p>',
							'warning'
						);
					}
				}

				// just for debugging
				if ($this->debug_import) {

					// get this before modifying in any way
					$debug_mqs['incoming_active_queries'] = $data['non_section']['active_queries'];
					$debug_mqs['orig'] = $this->preferences['m_queries'];
					$debug_mqs['new'] = $mq_analysis['new'];
					$debug_mqs['merged'] = $debug_mqs['new'] ? $pref_array['m_queries'] : false;
					$debug_mqs['mq_analysis'] = $mq_analysis;

					$debug_file = $this->debug_dir . 'debug-'.$con.'.txt';
					$write_file = fopen($debug_file, 'w');
					$data = '';
					$data.= "\n\n### 1. Key Debug Analysis \n\n";
					$data.= print_r($debug_mqs, true);
					$data.= "\n\n### 2. The UNMODIFIED incoming data\n\n";
					$data.= print_r($data, true);
					$data.= "\n\n### 3. The (potentially) MODIFIED incoming data\n\n";
					$data.= print_r($filtered_json, true);
					fwrite($write_file, $data);
					fclose($write_file);
				}

				// return the filtered data and mq analysis
				return $filtered_json;
			}

			// load .json file - or json data if already got
			function load_json_file($json_file, $theme_name, $context = '', $data = false) {

				// if json data wasn't passed in to function, get it
				if ( !$data ){

					// bail if file is missing or cannot read
					if ( !$data = $this->get_file_data( $json_file ) ) {
						return false;
					}
				}

				// tap into WordPress native JSON functions
				if( !class_exists('Moxiecode_JSON') ) {
					require_once($this->thisplugindir . 'includes/class-json.php');
				}
				$json_object = new Moxiecode_JSON();

				// convert to array
				if (!$json_array = $json_object->decode($data)) {
					$this->log('', '', 'error', 'json-decode', array('json_file', $json_file));
					return false;
				}

				// json decode was successful

				// replace mq keys, add new to the UI, add css units if necessary.
				$filtered_json = $this->filter_incoming_data('import', $json_array);

				// merge the arrays if merge (must come after key analysis/replacements)
				if ($context == __('Merge', 'microthemer') or $context == esc_attr__('Raw CSS', 'microthemer')) {
					$filtered_json = $this->merge($this->options, $filtered_json);
				} else {
					// Only update theme_in_focus if it's not a merge
					$pref_array['theme_in_focus'] = $theme_name;
					$this->savePreferences($pref_array);
				}

				// updates options var, save settings, and update stylesheet
				$this->options = $filtered_json;
				$this->saveUiOptions($this->options);
				$this->update_active_styles($theme_name, $context);

				// import success
				$this->log(
					esc_html__('Settings were imported', 'microthemer'),
					'<p>' . esc_html__('The design pack settings were successfully imported.', 'microthemer') . '</p>',
					'notice'
				);

			}

			// ensure mq keys in pref array and options match
			//- NOTE A SIMPLER SOLUTION WOULD BE TO CONVERT ARRAY INTO STRING AND THEN DO str_replace (may have side effects though)
			function replace_mq_keys($student_key, $role_model_key, $options) {
				$old_new_mq_map[$student_key] = $role_model_key;
				// replace the relevant array keys - unset() doesn't work on $this-> so slightly convoluted solution used
				$cons = array('active_queries', 'm_query');
				$updated_array = array();
				foreach ($cons as $stub => $context) {
					unset($updated_array);
					if (is_array($options['non_section'][$context])) {
						foreach ($options['non_section'][$context] as $cur_key => $array) {
							if ($cur_key == $student_key) {
								$key = $role_model_key;
							} else {
								$key = $cur_key;
							}
							$updated_array[$key] = $array;
						}
						$options['non_section'][$context] = $updated_array; // reassign main array with updated keys array
					}
				}
				// and also the !important media query keys
				$updated_array = array();
				if (!empty($options['non_section']['important']['m_query']) and
					is_array($options['non_section']['important']['m_query'])) {
					foreach ($options['non_section']['important']['m_query'] as $cur_key => $array) {
						if ($cur_key == $student_key) {
							$key = $role_model_key;
						} else {
							$key = $cur_key;
						}
						$updated_array[$key] = $array;
					}
					$options['non_section']['important']['m_query'] = $updated_array; // reassign main array with updated keys array
				}
				// annoyingly, I also need to do a replace on device_focus key values for all selectors
				foreach($options as $section_name => $array) {
					if ($section_name == 'non_section') { continue; }
					// loop through the selectors
					if (is_array($array)) {
						foreach ($array as $css_selector => $sub_array) {
							if (is_array($sub_array['device_focus'])) {
								foreach ( $sub_array['device_focus'] as $prop_group => $value) {
									// replace the value if it is an old key
									if (!empty($old_new_mq_map[$value])) {
										$options[$section_name][$css_selector]['device_focus'][$prop_group] = $old_new_mq_map[$value];
									}
								}
							}
						}
					}
				}
				return $options;
			}


			// merge the new settings with the current settings
			function merge($orig_settings, $new_settings) {
				// create debug merge file if set at top of script
				if ($this->debug_merge) {
					$debug_file = $this->debug_dir . 'debug-merge.txt';
					$write_file = fopen($debug_file, 'w');
					$data = '';
					$data.= "\n\n" . __('### The to existing options (before merge)', 'microthemer') . "\n\n";
					$data.= print_r($orig_settings, true);

					$data .= "\n\n" . esc_html__('### The imported options (before any folder renaming)', 'microthemer') . "\n\n";
					$data .= print_r($new_settings, true);

				}
				if (is_array($new_settings)) {
					// check if search needs to be done on important and m_query arrays
					$mq_arr = $imp_arr = false;
					if (!empty($new_settings['non_section']['m_query']) and is_array($new_settings['non_section']['m_query'])){
						$mq_arr = $new_settings['non_section']['m_query'];
					}
					if (!empty($new_settings['non_section']['important']) and is_array($new_settings['non_section']['important'])){
						$imp_arr = $new_settings['non_section']['important'];
					}

					// loop through new sections to check for section name conflicts
					foreach($new_settings as $section_name => $array) {
						// if a name conflict exists
						if ( $this->is_name_conflict($section_name, $orig_settings, $new_settings, 'first-check') ) {
							// create a non-conflicting new name
							$alt = $this->get_alt_section_name($section_name, $orig_settings, $new_settings);
							$alt_name = $alt['name'];
							$alt_index = $alt['index'];
							// rename the to-be-merged section and the corresponding non_section extras
							$new_settings[$alt_name] = $new_settings[$section_name];
							$new_settings[$alt_name]['this']['label'] = $new_settings[$alt_name]['this']['label'].' '.$alt_index;
							$new_settings['non_section']['view_state'][$alt_name] = $new_settings['non_section']['view_state'][$section_name];
							unset($new_settings[$section_name]);
							unset($new_settings['non_section']['view_state'][$section_name]);
							// also rename all the corresponding [m_query] folder names (ouch)
							if ($mq_arr){
								foreach ($mq_arr as $mq_key => $arr){
									foreach ($arr as $orig_sec => $arr){
										// if the folder name exists in the m_query array, replace
										if ($section_name == $orig_sec){
											$new_settings['non_section']['m_query'][$mq_key][$alt_name] = $new_settings['non_section']['m_query'][$mq_key][$section_name];
											unset($new_settings['non_section']['m_query'][$mq_key][$section_name]);
										}
									}
								}
							}
							// and the [important] folder names (double ouch)
							if ($imp_arr){
								foreach ($imp_arr as $orig_sec => $arr){
									// if it's MQ important values
									if ($orig_sec == 'm_query'){
										foreach ($imp_arr['m_query'] as $mq_key => $arr){
											foreach ($arr as $orig_sec => $arr){
												// if the folder name exists in the m_query array, replace
												if ($section_name == $orig_sec){
													$new_settings['non_section']['important']['m_query'][$mq_key][$alt_name] = $new_settings['non_section']['important']['m_query'][$mq_key][$section_name];
													unset($new_settings['non_section']['important']['m_query'][$mq_key][$section_name]);
												}
											}
										}
									} else {
										// regular important value
										$new_settings['non_section']['important'][$alt_name] = $new_settings['non_section']['important'][$section_name];
										unset($new_settings['non_section']['important'][$section_name]);
									}
								}
							}
						}
					}


					if ($this->debug_merge) {
						$data .= "\n\n" . esc_html__('### The imported options (after folder renaming)', 'microthemer') . "\n\n";
						$data .= print_r($new_settings, true);
					}

					// now that we've checked for and corrected possible name conflicts
					// merge the arrays (recursively to avoid overwriting)
					$merged_settings = $this->array_merge_recursive_distinct($orig_settings, $new_settings);

					// the hand-coded CSS of the imported settings needs to be appended to the original
					foreach ($this->custom_code as $key => $arr){
						// if regular main custom css or JS
						if ($key == 'hand_coded_css' or $key == 'js'){
							$new_code = trim($new_settings['non_section'][$key]);
							if (!empty($new_code)) {
								$merged_settings['non_section'][$key] =
									$orig_settings['non_section'][$key]
									. "\n\n/* " . esc_html_x('Imported CSS', 'CSS comment', 'microthemer') . " */\n"
									. $new_settings['non_section'][$key];
							} else {
								// the imported pack has no custom code so keep the original
								$merged_settings['non_section'][$key] = $orig_settings['non_section'][$key];
							}
						}
						// if ie css
						elseif ($key == 'ie_css'){
							foreach ($arr as $key2 => $arr2){
								$new_code = trim($new_settings['non_section'][$key][$key2]);
								if (!empty($new_code)) {
									$merged_settings['non_section'][$key][$key2] =
										$orig_settings['non_section'][$key][$key2]
										. "\n\n/* " . esc_html_x('Code from design pack imported with Merge', 'CSS comment', 'microthemer') . " */\n"
										. $new_settings['non_section'][$key][$key2];
								} else {
									// the imported pack has no custom code so keep the original
									$merged_settings['non_section'][$key][$key2] = $orig_settings['non_section'][$key][$key2];
								}
							}
						}
					}
				}
				// maybe do some more processing here

				if ($this->debug_merge) {
					$data.= "\n\n" . __('### The Merged options', 'microthemer') . "\n\n";
					$data.= print_r($merged_settings, true);
					fwrite($write_file, $data);
					fclose($write_file);
				}
				return $merged_settings;
			}

			// add js deps in import if not
			function new_enq_js($cur_enq_js, $imp_enq_js){
				foreach ($imp_enq_js as $k => $arr){
					if (empty($cur_enq_js[$k])) return true;
				}
				return false;
			}

			// get an array of current mq keys paired with replacements -
		    // compare against 'role model' to base current array on
			function analyse_mqs($student_mqs, $role_model_mqs){
				$mq_analysis['new'] = false;
				$mq_analysis['replacements_needed'] = false;
				$i = 0;
				if (!empty($student_mqs) and is_array($student_mqs)) {
					foreach ($student_mqs as $student_key => $student_array){
						$replacement_key = $this->in_2dim_array($student_array['query'], $role_model_mqs, 'query');
						// if new media query
						if ( !$replacement_key ) {
							// ensure key is unique by using unique base from last page load
							// otherwise previously exported keys could overwrite rather add to existing MQs (if the query was changed after exporting)
							$new_key = $this->unq_base.++$i;
							$mq_analysis['new'][$new_key]['label'] = $student_array['label']. esc_html_x(' (imp)', '(imported media query)', 'microthemer');
							$mq_analysis['new'][$new_key]['query'] = $student_array['query'];
							// as we're defining new keys, the ui data keys will need replacing too
							$mq_analysis['replacements_needed'] = true;
							$mq_analysis['replacements'][$student_key] = $new_key;
						}
						// else store replacement key
						else {
							if ($replacement_key != $student_key){
								$mq_analysis['replacements_needed'] = true;
								$mq_analysis['replacements'][$student_key] = $replacement_key;
							}
						}
					}
				}
				return $mq_analysis;
			}


			/***
			Manage Micro Theme Functions
			***/

			function setup_micro_themes_dir(){
				if ( !is_dir($this->micro_root_dir) ) {
					// create root micro-themes dir
					if ( !wp_mkdir_p( $this->micro_root_dir, 0755 ) ) {
						$this->log(
							esc_html__('/micro-themes create error', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('WordPress was not able to create the %s directory.', 'microthemer'),
								$this->root_rel($this->micro_root_dir)
							) . $this->permissionshelp . '</p>'
						);
						return false;
					}
				} else {
					// micro-themes dir does exist, clean lose pack files that may exist due to past bug
					$this->maybe_clean_micro_root(); // 7.7.2016 - we can remove after a few months.
				}

				// create _scss dir if it doesn't exist (at some point)

				// copy pie over if needed
				if (!$this->maybe_copy_pie()) return false;

				// also create blank active-styles else 404 before user adds styles
				$prime_files = array(
					$this->micro_root_dir.'active-styles.css',
					$this->micro_root_dir.'min.active-styles.css',
					$this->micro_root_dir.'draft-styles.css',
					$this->micro_root_dir.'min.draft-styles.css',
					$this->micro_root_dir.'active-styles.scss',
				);
				if (!$this->maybe_create_stylesheet($prime_files)) return false;

				// all good
				return true;
			}

			// clean lose pack files that may exist due to past bug
			function maybe_clean_micro_root(){
				$files = array(
					'meta.txt',
					'debug-save.txt',
					'debug-current.txt',
					'debug-pulled-data.txt',
					'debug-selective-export.txt',
					'debug-merge.txt',
					'debug-overwrite.txt'
				);
				foreach ($files as $key => $file){
					$file = $this->micro_root_dir . $file;
					if (file_exists($file)){
						unlink($file);
					}
				}
			}

			// create active-styles if it doesn't already exist
			function maybe_create_stylesheet($prime_files){
				if (is_array($prime_files)){
					foreach($prime_files as $key => $file){
						if (!file_exists($file)) {
							if (!$write_file = fopen($file, 'w')) {
								$this->log(
									esc_html__('Create stylesheet error', 'microthemer'),
									'<p>' . esc_html__('WordPress does not have permission to create: ', 'microthemer') .
									$this->root_rel($file) . '. '.$this->permissionshelp.'</p>'
								);
								return false;
							}
							fclose($write_file);
						}
					}
				}
				return true;
			}

			// copy pie files so Microthemer styles can still be used following uninstall
			function maybe_copy_pie(){
				$pie_files = array('PIE.php', 'PIE.htc');
				foreach($pie_files as $file){
					$orig = $this->thisplugindir . '/pie/' . $file;
					$new = $this->micro_root_dir . $file;
					if (file_exists($new)){
						continue;
					}
					if (!copy($orig, $new)){
						$this->log(
							esc_html__('CSS3 PIE not copied', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('CSS3 PIE (%s) could not be copied to correct location. This is needed to support gradients, rounded corners and box-shadow in old versions of Internet Explorer.', 'microthemer'),
								$file
							) . '</p>',
							'error'
						);
						return false;
					}
				}
				return true;
			}

			// create micro theme
			function create_micro_theme($micro_name, $action, $temp_zipfile) {
				// sanitize dir name
				$name = sanitize_file_name( $micro_name );
				$error = false;
				// extra bit need for zip uploads (removes .zip)
				if ($action == 'unzip') {
					$name = substr($name, 0, -4);
				}
				// check for micro-themes folder and create if doesn't exist
				$error = !$this->setup_micro_themes_dir() ? true : false;

				// check if the micro-themes folder is writable
				if ( !is_writeable( $this->micro_root_dir ) ) {
					$this->log(
						esc_html__('/micro-themes write error', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('The directory %s is not writable.', 'microthemer'),
							$this->root_rel($this->micro_root_dir)
						) . $this->permissionshelp . '</p>'
					);
					$error = true;
				}
				// Check for micro theme with same name
				if ($alt_name = $this->rename_if_required($this->micro_root_dir, $name)) {
					$name = $alt_name; // $alt_name is false if no rename was required
				}
				// abs path
				$this_micro_abs = $this->micro_root_dir . $name;
				// Create new micro theme folder
				if ( !wp_mkdir_p ( $this_micro_abs ) ) {
					$this->log(
						esc_html__('design pack create error', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('WordPress was not able to create the %s directory.', 'microthemer'), $this->root_rel($this_micro_abs)
						). '</p>'
					);
					$error = true;
				}
				// Check folder permission
				if ( !is_writeable( $this_micro_abs ) ) {
					$this->log(
						esc_html__('design pack write error', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('The directory %s is not writable.', 'microthemer'), $this->root_rel($this_micro_abs)
						) . $this->permissionshelp . '</p>'
					);
					$error = true;
				}
				if (SAFE_MODE and $this->preferences['safe_mode_notice'] == '1') {
					$this->log(
						esc_html__('Safe-mode is on', 'microthemer'),
						'<p>' . esc_html__('The PHP server setting "Safe-Mode" is on.', 'microthemer')
						. '</p><p>' . wp_kses(
								sprintf(
									__('<b>This isn\'t necessarily a problem. But if the design pack "%1$s" hasn\'t been created</b>, please create the directory %2$s manually and give it permission code 777.', 'microthemer'),
									$this->readable_name($name), $this->root_rel($this_micro_abs)
								),
								array( 'b' => array() )
						) . $this->permissionshelp
					. '</p>',
					'warning'
					);
					$error = true;
				}
				// unzip if required
				if ($action == 'unzip') {
					// extract the files
					$this->extract_files($this_micro_abs, $temp_zipfile);
					// get the final name of the design pack from the meta file
					$name = $this->rename_from_meta($this_micro_abs . '/meta.txt', $name);
					if ($name){
						// import bg images to media library and update paths if any are found
						$json_config_file = $this->micro_root_dir . $name . '/config.json';
						$this->import_pack_images_to_library($json_config_file, $name);
					}
					// add the dir to the file structure array
					$this->dir_loop($this->micro_root_dir . $name);
				}
				// if creating blank shell or exporting UI settings, need to create meta.txt and readme.txt
				if ($action == 'export') {
					// set the theme name value
					$_POST['theme_meta']['Name'] = $this->readable_name($name);
					$this->update_meta_file($this_micro_abs . '/meta.txt');
					$this->update_readme_file($this_micro_abs . '/readme.txt');

				}
				// update the theme_in_focus value in the preferences table
				$pref_array['theme_in_focus'] = $name;
				if (!$this->savePreferences($pref_array)) {
					// not much cause for returning an error
				}
				// if still no error, the action worked
				if ($error != true) {
					if ($action == 'create') {
						$this->log(
							esc_html__('Design pack created', 'microthemer'),
							'<p>' . esc_html__('The design pack directory was successfully created on the server.', 'microthemer') . '</p>',
							'notice'
						);
					}
					if ($action == 'unzip') {
						$this->log(
							esc_html__('Design pack installed', 'microthemer'),
							'<p>' . esc_html__('The design pack was successfully uploaded and extracted. You can import it into your Microthemer workspace any time using the') .
							' <span class="show-parent-dialog link" rel="import-from-pack">' . esc_html__('import option', 'microthemer') . '</span>'.
							'<span id="update-packs-list" rel="' . $this->readable_name($name) . '"></span>.</p>',
							'notice'
						);
					}
					if ($action == 'export') {
						$this->log(
							esc_html__('Settings exported', 'microthemer'),
							'<p>' . esc_html__('Your settings were successfully exported as a design pack directory on the server.', 'microthemer') . '</p>',
							'notice'
						);
					}
				}
				return true;
			}

			// rename zip form meta.txt name value
			function rename_from_meta($meta_file, $name){
				$orig_name = $name;
				if (is_file($meta_file) and is_readable($meta_file)) {
					$meta_info = $this->read_meta_file($meta_file);
					$name = strtolower(sanitize_file_name( $meta_info['Name'] ));
					// rename the directory if it doesn't already have the correct name
					if ($orig_name != $name){
						if ($alt_name = $this->rename_if_required($this->micro_root_dir, $name)) {
							$name = $alt_name; // $alt_name is false if no rename was required
						}
						rename($this->micro_root_dir . $orig_name, $this->micro_root_dir . $name);
					}
					return $name;
				} else {
					// no meta file error
					$this->log(
						esc_html__('Missing meta file', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('The zip file doesn\'t contain a necessary %s file or it could not be read.', 'microthemer'),
							$this->root_rel($meta_file)
						) . '</p>'
					);
					return false;
				}
			}

			// read the data from a file into a string
			function get_file_data($file){
				if (!is_file($file)){
					$this->log(
						esc_html__('File doesn\'t exist', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('%s does not exist on the server.', 'microthemer'),
							$this->root_rel($file)
						) . '</p>'
					);
					return false;
				}
				if (!is_readable($file)){
					$this->log(
						esc_html__('File not readable', 'microthemer'),
						'<p>' . sprintf(
							esc_html__(' %s could not be read.', 'microthemer'),
							$this->root_rel($file)
						) . '</p>'
						. $this->permissionshelp
					);
					return false;
				}
				$fh = fopen($file, 'r');
				$data = fread($fh, filesize($file));
				fclose($fh);
				return $data;
			}

			// get image paths from the config.json file
			function get_image_paths($data){

				$img_array = array();

				// look for images
				preg_match_all('/"(background_image|list_style_image|border_image_src)":"([^none][A-Za-z0-9 _\-\.\\/&\(\)\[\]!\{\}\?:=]+)"/',
					$data,
					$img_array,
					PREG_PATTERN_ORDER);

				// ensure $img_array only contains unique images
				foreach ($img_array[2] as $key => $config_img_path) {

					// if it's not unique, remove
					if (!empty($already_got[$config_img_path])){
						unset($img_array[2][$key]);
					}
					$already_got[$config_img_path] = 1;
				}

				if (count($img_array[2]) > 0) {
					return $img_array;
				} else {
					return false;
				}
			}

			// get media library images linked to from the config.json file
			function get_linked_library_images($json_config_file){

				// get config data
				if (!$data = $this->get_file_data($json_config_file)) {
					return false;
				}

				// get images from the config file that should be imported
				if (!$img_array = $this->get_image_paths($data)) {
					return false;
				}

				// loop through the image array, remove any images not in the media library
				foreach ($img_array[2] as $key => $config_img_path) {
					// has uploads path and doesn't also exist in pack dir (yet to be moved) - may be an unnecessary check
					if (strpos($config_img_path, '/uploads/')!== false and !is_file($this->micro_root_dir . $config_img_path)){
						$library_images[] = $config_img_path;
					}
				}
				if (is_array($library_images)){
					return $library_images;
				} else {
					return false;
				}

			}

			// encode or decode json todo replace other $json_object actions with this function (and test)
			function json($action, $data, $json_file = ''){

				// tap into WordPress native JSON functions
				if( !class_exists('Moxiecode_JSON') ) {
					require_once($this->thisplugindir . 'includes/class-json.php');
				}

				$json_object = new Moxiecode_JSON();

				// convert to array
				if ($action == 'decode'){
					if (!$json_array = $json_object->decode($data)) {
						$this->log('', '', 'error', 'json-decode', array('json_file', $json_file));
						return false;
					}
					return $json_array;
				}

				// convert to json string
				elseif ($action == 'encode'){
					if (!$json_str = $json_object->encode($data)) {
						$this->log(
							esc_html__('Encode json error', 'microthemer'),
							'<p>' . esc_html__('WordPress failed to convert your settings into json.', 'microthemer') . '</p>'
						);
						return false;
					}
					return $json_str;
				}
			}

			// import images in a design pack to the media library and update image paths in config.json
			function import_pack_images_to_library($json_config_file, $name, $data = false, $remote_images = false){

				// reset imported images
				$this->imported_images = array();

				// get config data if not passed in
				if (!$data) {
					if (!$data = $this->get_file_data($json_config_file)) {
						return false;
					}
				}

				// get images from the config file if not passed in
				if (!$remote_images) {
					if (!$img_array = $this->get_image_paths($data)) {
						return false;
					}
					$img_array = $img_array[2];
				} else {
					$img_array = $remote_images;
				}


				// loop through the image array
				foreach ($img_array as $key => $img_path) {

					$just_image_name = basename($img_path);

					// if remote image found in stylesheet downloaded to /tmp dir
					if ($remote_images){
						$tmp_image = $img_path; // C:/
						$orig_config_path = $key; // url
					} else {
						// else pack image found in zip
						$tmp_image = $this->micro_root_dir . $name . '/' . $just_image_name; // C:/
						$orig_config_path = $img_path; // url
					}

					// import the file to the media library if it exists
					if (file_exists($tmp_image)) {
						$this->imported_images[$just_image_name]['orig_config_path'] = $orig_config_path;

						// note import_image_to_library() updates 'success' and 'new_config_path'
						$id = $this->import_image_to_library($tmp_image, $just_image_name);

						// report wp error if problem
						if ( $id === 0 or is_wp_error($id) ) {
							if (is_wp_error($id)){
								$wp_error = '<p>'. $id->get_error_message() . '</p>';
							} else {
								$wp_error = '';
							}
							$this->log(
								esc_html__('Move to media library failed', 'microthemer'),
								'<p>' . sprintf(
									esc_html__('%s was not imported due to an error.', 'microthemer'),
									$this->root_rel($tmp_image)
								) . '</p>'
								. $wp_error
							);
						}
					}
				}

				// first report successfully moved images
				$moved_list =
				'<ul>';
				$moved = false;
				foreach ($this->imported_images as $just_image_name => $array){
					if (!empty($array['success'])){
						$moved_list.= '
						<li>
							'.$just_image_name.'
						</li>';
						$moved = true;
						// also update the json data string
						$replacements[$array['orig_config_path']] = $array['new_config_path'];
					}
				}
				$moved_list.=
				'</ul>';

				// move was successful, update paths
				if ($moved){
					$this->log(
						esc_html__('Images transferred to media library', 'microthemer'),
						'<p>' . esc_html__('The following images were transferred from the design pack to your WordPress media library:', 'microthemer') . '</p>'
						. $moved_list,
						'notice'
					);
					// update paths in json file
					return $this->replace_json_paths($json_config_file, $replacements, $data, $remote_images);
				}
			}

			// update paths in json file
			function replace_json_paths($json_config_file, $replacements, $data = false, $remote_images = false){

				if (!$data){
					if (!$data = $this->get_file_data($json_config_file)) {
						return false;
					}
				}

				// replace paths in string
				$replacement_occurred = false;
				foreach ($replacements as $orig => $new){
					if (strpos($data, $orig) !== false){
						$replacement_occurred = true;
						$data = str_replace($orig, $new, $data);
					}
				}
				if (!$replacement_occurred){
					return false;
				}

				// just return updated json data if loading css stylesheet
				if ($remote_images){
					$this->log(
						esc_html__('Image paths updated', 'microthemer'),
						'<p>' . esc_html__('Images paths were successfully updated to reflect the new location or deletion of an image(s).', 'microthemer') . '</p>',
						'notice'
					);
					return $data;
				}

				// update the config.json image paths for images successfully moved to the library
				if (is_writable($json_config_file)) {
					if ($write_file = fopen($json_config_file, 'w')) {
						if (fwrite($write_file, $data)) {
							fclose($write_file);
							$this->log(
								esc_html__('Images paths updated', 'microthemer'),
								'<p>' . esc_html__('Images paths were successfully updated to reflect the new location or deletion of an image(s).', 'microthemer') . '</p>',
								'notice'
							);
							return true;
						}
						else {
							$this->log(
								esc_html__('Image paths failed to update.', 'microthemer'),
								'<p>' . esc_html__('Images paths could not be updated to reflect the new location of the images transferred to your media library. This happened because Microthemer could not rewrite the config.json file.', 'microthemer') . '</p>' . $this->permissionshelp
							);
							return false;
						}
					}
				}
			}

			// Unitless css values need to be auto-adjusted to explicit pixels if the user's preference
			// for the prop is not 'px (implicit)' and the value is a unitless number
			// Conversely, px values need to be removed if implicit pixels is set (and not custom code value)
			// Note: we can't do e.g. em conversion here as we don't know the DOM context
			function filter_json_css_units($data, $context = 'reg'){
				$filtered_json = $data;
				foreach ($filtered_json as $section_name => $array){
					if ($section_name == 'non_section') {
						continue;
					}
					if (is_array($array)) {
						foreach ($array as $css_selector => $arr) {
							if ( is_array( $arr['styles'] ) ) {
								foreach ($arr['styles'] as $prop_group => $arr2) {
									if (is_array($arr2)) {
										foreach ($arr2 as $prop => $value) {
											// we're finally at property, does it have a default unit?
											if (!empty($this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'])){
												$default_unit = $this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'];
											} else {
												continue;
											}
											// it has a default, is it something other than px (implicit)
											if ($default_unit == 'px (implicit)'){
												// we should convert pixel values to plain numbers (if not custom code)
												if ($prop_group != 'code' and strpos($value, 'px') !== false){
													$filtered_json[$section_name][$css_selector]['styles'][$prop_group][$prop] =
														str_replace('px', '', $value);
												}
												continue;
											}
											// if the value is a unitless number apply px as the user doesn't have implicit pixels set
											if (is_numeric($value) and $value != 0){
												$filtered_json[$section_name][$css_selector]['styles'][$prop_group][$prop] = $value . 'px';
											}
										}
									}
								}
							}
						}
					}
				}
				return $filtered_json;
			}

			//Handle an individual file import.
			function import_image_to_library($file, $just_image_name, $post_id = 0, $import_date = false) {
				set_time_limit(60);
				// Initially, Base it on the -current- time.
				$time = current_time('mysql', 1);
				// A writable uploads dir will pass this test. Again, there's no point overriding this one.
				if ( ! ( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] ) ) {
					$this->log(
						esc_html__('Uploads folder error', 'microthemer'),
						$uploads['error']
					);
					return 0;
				}

				$wp_filetype = wp_check_filetype( $file, null );
				$type = $ext = false;
				extract( $wp_filetype );
				if ( ( !$type || !$ext ) && !current_user_can( 'unfiltered_upload' ) ) {
					$this->log(
						esc_html__('Wrong file type', 'microthemer'),
						'<p>' . esc_html__('Sorry, this file type is not permitted for security reasons.', 'microthemer') . '</p>'
					);
					return 0;
				}

				//Is the file already in the uploads folder?
				if ( preg_match('|^' . preg_quote(str_replace('\\', '/', $uploads['basedir'])) . '(.*)$|i', $file, $mat) ) {
					$filename = basename($file);
					$new_file = $file;

					$url = $uploads['baseurl'] . $mat[1];

					$attachment = get_posts(array( 'post_type' => 'attachment', 'meta_key' => '_wp_attached_file', 'meta_value' => ltrim($mat[1], '/') ));
					if ( !empty($attachment) ) {
						$this->log(
							esc_html__('Image already in library', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('%s already exists in the WordPress media library and was therefore not moved', 'microthemer'),
								$filename
							) . '</p>',
							'warning'
						);
						return 0;
					}
					//OK, Its in the uploads folder, But NOT in WordPress's media library.
				} else {
					$filename = wp_unique_filename( $uploads['path'], basename($file));

					// copy the file to the uploads dir
					$new_file = $uploads['path'] . '/' . $filename;
					if ( false === @rename( $file, $new_file ) ) {
						$this->log(
							esc_html__('Move to library failed', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('%1$s could not be moved to %2$s', 'microthemer'),
								$filename,
								$uploads['path']
							) . '</p>',
							'warning'
						);
						return 0;
					}


					// Set correct file permissions
					$stat = stat( dirname( $new_file ));
					$perms = $stat['mode'] & 0000666;
					@ chmod( $new_file, $perms );
					// Compute the URL
					$url = $uploads['url'] . '/' . $filename;
				}

				//Apply upload filters
				$return = apply_filters( 'wp_handle_upload', array( 'file' => $new_file, 'url' => $url, 'type' => $type ) );
				$new_file = $return['file'];
				$url = $return['url'];
				$type = $return['type'];

				$title = preg_replace('!\.[^.]+$!', '', basename($new_file));
				$content = '';

				// update the array for replacing paths in config.json
				$this->imported_images[$just_image_name]['success'] = true;
				$this->imported_images[$just_image_name]['new_config_path'] = $this->root_rel($url, false, true);

				// use image exif/iptc data for title and caption defaults if possible
				if ( $image_meta = @wp_read_image_metadata($new_file) ) {
					//if ( '' != trim($image_meta['title']) )
						//$title = trim($image_meta['title']);
					if ( '' != trim($image_meta['caption']) )
						$content = trim($image_meta['caption']);
				}

				//=sebcus the title should reflect a possible file rename e.g. image1 - happens above ^
				//$title = str_replace('.'.$ext, '', $filename);

				if ( $time ) {
					$post_date_gmt = $time;
					$post_date = $time;
				} else {
					$post_date = current_time('mysql');
					$post_date_gmt = current_time('mysql', 1);
				}

				// Construct the attachment array
				$attachment = array(
					'post_mime_type' => $type,
					'guid' => $url,
					'post_parent' => $post_id,
					'post_title' => $title,
					'post_name' => $title,
					'post_content' => $content,
					'post_date' => $post_date,
					'post_date_gmt' => $post_date_gmt
				);

				$attachment = apply_filters('afs-import_details', $attachment, $file, $post_id, $import_date);

				//Win32 fix:
				$new_file = str_replace( strtolower(str_replace('\\', '/', $uploads['basedir'])), $uploads['basedir'], $new_file);

				// Save the data
				$id = wp_insert_attachment($attachment, $new_file, $post_id);
				if ( !is_wp_error($id) ) {
					$data = wp_generate_attachment_metadata( $id, $new_file );
					wp_update_attachment_metadata( $id, $data );
				}
				//update_post_meta( $id, '_wp_attached_file', $uploads['subdir'] . '/' . $filename );

				return $id;
			}

			// handle zip package
			function handle_zip_package() {
				$temp_zipfile = $_FILES['upload_micro']['tmp_name'];
				$filename = $_FILES['upload_micro']['name']; // it won't be this name for long
				// Chrome return a empty content-type : http://code.google.com/p/chromium/issues/detail?id=6800
				if ( !preg_match('/chrome/i', $_SERVER['HTTP_USER_AGENT']) ) {
					// check if file is a zip file
					if ( !preg_match('/(zip|download|octet-stream)/i', $_FILES['upload_micro']['type']) ) {
						@unlink($temp_zipfile); // del temp file
						$this->log(
							esc_html__('Faulty zip file', 'microthemer'),
							'<p>' . esc_html__('The uploaded file was faulty or was not a zip file.', 'microthemer') . '</p>
						<p>' . esc_html__('The server recognised this file type: ', 'microthemer') . $_FILES['upload_micro']['type'].'</p>'
						);
						return false;
					}
				}
				$this->create_micro_theme($filename, 'unzip', $temp_zipfile);
			}

			// handle zip extraction
			function extract_files($dir, $file) {
				// tap into native WP zip handling
				if( !class_exists('PclZip')) {
					require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
				}
				$archive = new PclZip($file);
				// extract all files in one folder - the callback functions
				// (tvr_microthemer_getOnlyValid)
				// have to be external to this class
				if ($archive->extract(PCLZIP_OPT_PATH, $dir, PCLZIP_OPT_REMOVE_ALL_PATH,
										PCLZIP_CB_PRE_EXTRACT, 'tvr_micro'.TVR_MICRO_VARIANT.'_getOnlyValid') == 0) {
					$this->log(
						esc_html__('Extract zip error', 'microthemer'),
						'<p>' . esc_html__('Error : ', 'microthemer') . $archive->errorInfo(true).'</p>'
					);
				}
			}

			// handle zip archiving
			function create_zip($path_to_dir, $dir_name, $zip_store) {
				$error = false;
				if( !class_exists('PclZip')) {
					require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
				}
				// check if the /zip-exports dir is writable first
				if (is_writable($zip_store)) {
					$archive = new PclZip($zip_store.$dir_name.'.zip');
					// create zip
					$v_list = $archive->create($path_to_dir.$dir_name,
										 PCLZIP_OPT_REMOVE_PATH, $path_to_dir);
					if ($v_list == 0) {
						$error = true;
						$this->log(
							esc_html__('Create zip error', 'microthemer'),
							'<p>' . esc_html__('Error : ', 'microthemer') . $archive->errorInfo(true).'</p>'
						);
					}
					else {
						$this->log(
							esc_html__('Zip package created', 'microthemer'),
							'<p>' . esc_html__('Zip package successfully created.', 'microthemer') .
							'<a href="'.$this->thispluginurl.'zip-exports/'.$dir_name.'.zip">' .
							esc_html__('Download zip file', 'microthemer') . '</a>
						</p>',
							'notice'
						);
					}
				}
				else {
					$error = true;
					$this->log(
						esc_html__('Zip store error', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('The directory %s is not writable.', 'microthemer'),
							$this->root_rel($zip_store)
						) . $this->permissionshelp . '</p>'
					);
				}
				// verdict
				if ($error){
					return false;
				} else {
					return true;
				}
			}

			// read meta data from file
			function read_meta_file($meta_file) {
				// create default meta.txt file if it doesn't exist
				if (!is_file($meta_file)) {
					$_POST['theme_meta']['Name'] = $this->readable_name($this->preferences['theme_in_focus']);
					$this->update_meta_file($this->micro_root_dir . $this->preferences['theme_in_focus'].'/meta.txt');
				}
				if (is_file($meta_file)) {
					// check if it's readable
					if ( is_readable($meta_file) ) {
						//disable wptexturize
						remove_filter('get_theme_data', 'wptexturize');
						return $this->flx_get_theme_data( $meta_file );
					}
					else {
						$abs_meta_path = $this->micro_root_dir . $this->preferences['theme_in_focus'].'/meta.txt';

						$this->log(
							esc_html__('Read meta.txt error', 'microthemer'),
							'<p>' . esc_html__('WordPress does not have permission to read: ', 'microthemer') .
							$this->root_rel($abs_meta_path) . '. '.$this->permissionshelp.'</p>'
						);
						return false;
					}
				}
			}

			// read readme.txt data from file
			function read_readme_file($readme_file) {
				// create default readme file if it doesn't exist
				if (!is_file($readme_file)) {
					$this->update_readme_file($this->micro_root_dir . $this->preferences['theme_in_focus'].'/readme.txt');
				}
				if (is_file($readme_file)) {
					// check if it's readable
					if ( is_readable($readme_file) ) {
						$fh = fopen($readme_file, 'r');
						$length = filesize($readme_file);
						if ($length == 0) {
							$length = 1;
						}
						$data = fread($fh, $length);
						fclose($fh);
						return $data;
					}
					else {
						$abs_readme_path = $this->micro_root_dir . $this->preferences['theme_in_focus'].'/readme.txt';
						$this->log(
							esc_html__('Read readme.txt error', 'microthemer'),
							'<p>' . esc_html__('WordPress does not have permission to read: ', 'microthemer'),
							$this->root_rel($abs_readme_path) . '. '.$this->permissionshelp.'</p>'
						);
						return false;
					}
				}
			}

			// adapted WordPress function for reading and formattings a template file
			function flx_get_theme_data( $theme_file ) {
				$default_headers = array(
					'Name' => 'Theme Name',
					'PackType' => 'Pack Type',
					'URI' => 'Theme URI',
					'Description' => 'Description',
					'Author' => 'Author',
					'AuthorURI' => 'Author URI',
					'Version' => 'Version',
					'Template' => 'Template',
					'Status' => 'Status',
					'Tags' => 'Tags'
					);
				// define allowed tags
				$themes_allowed_tags = array(
					'a' => array(
						'href' => array(),'title' => array()
						),
					'abbr' => array(
						'title' => array()
						),
					'acronym' => array(
						'title' => array()
						),
					'code' => array(),
					'em' => array(),
					'strong' => array()
				);
				// get_file_data() - WP 2.8 compatibility function created for this
				$theme_data = get_file_data( $theme_file, $default_headers, 'theme' );
				$theme_data['Name'] = $theme_data['Title'] = wp_kses( $theme_data['Name'], $themes_allowed_tags );
				$theme_data['PackType'] = wp_kses( $theme_data['PackType'], $themes_allowed_tags );
				$theme_data['URI'] = esc_url( $theme_data['URI'] );
				$theme_data['Description'] = wp_kses( $theme_data['Description'], $themes_allowed_tags );
				$theme_data['AuthorURI'] = esc_url( $theme_data['AuthorURI'] );
				$theme_data['Template'] = wp_kses( $theme_data['Template'], $themes_allowed_tags );
				$theme_data['Version'] = wp_kses( $theme_data['Version'], $themes_allowed_tags );
				if ( empty($theme_data['Status']) )
					$theme_data['Status'] = 'publish';
				else
					$theme_data['Status'] = wp_kses( $theme_data['Status'], $themes_allowed_tags );

				if ( empty($theme_data['Tags']) )
					$theme_data['Tags'] = array();
				else
					$theme_data['Tags'] = array_map( 'trim', explode( ',', wp_kses( $theme_data['Tags'], array() ) ) );

				if ( empty($theme_data['Author']) ) {
					$theme_data['Author'] = $theme_data['AuthorName'] = __('Anonymous');
				} else {
					$theme_data['AuthorName'] = wp_kses( $theme_data['Author'], $themes_allowed_tags );
					if ( empty( $theme_data['AuthorURI'] ) ) {
						$theme_data['Author'] = $theme_data['AuthorName'];
					} else {
						$theme_data['Author'] = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', $theme_data['AuthorURI'], esc_html__( 'Visit author homepage' ), $theme_data['AuthorName'] );
					}
				}
				return $theme_data;
			}

			// delete theme
			function tvr_delete_micro_theme($dir_name) {
				$error = false;
				// loop through files if they exist
				if (is_array($this->file_structure[$dir_name])) {
					foreach ($this->file_structure[$dir_name] as $dir => $file) {
						if (!unlink($this->micro_root_dir . $dir_name.'/'.$file)) {
							$this->log(
								esc_html__('File delete error', 'microthemer'),
								'<p>' . esc_html__('Unable to delete: ', 'microthemer') .
								$this->root_rel($this->micro_root_dir .
									$dir_name.'/'.$file) . '</p>'
							);
							$error = true;
						}
					}
				}
				if ($error != true) {
					$this->log(
						'Files successfully deleted',
						'<p>' . sprintf(
							esc_html__('All files within %s were successfully deleted.', 'microthemer'),
							$this->readable_name($dir_name)
						) . '</p>',
						'dev-notice'
					);
					// attempt to delete empty directory
					if (!rmdir($this->micro_root_dir . $dir_name)) {
						$this->log(
							esc_html__('Delete directory error', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('The empty directory: %s could not be deleted.', 'microthemer'),
								$this->readable_name($dir_name)
							) . '</p>'
						);
						$error = true;
					}
					else {
						$this->log(
							esc_html__('Directory successfully deleted', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('%s was successfully deleted.', 'microthemer'),
								$this->readable_name($dir_name)
							) . '</p>',
							'notice'
						);

						// reset the theme_in_focus value in the preferences table
						$pref_array['theme_in_focus'] = '';
						if (!$this->savePreferences($pref_array)) {
							// not much cause for a message
						}
						if ($error){
							return false;
						} else {
							return true;
						}
					}
				}
			}

			// update the meta file
			function update_meta_file($meta_file) {
				// check if the micro theme dir needs to be renamed
				if (isset($_POST['prev_micro_name']) and ($_POST['prev_micro_name'] != $_POST['theme_meta']['Name'])) {
					$orig_name = $this->micro_root_dir . $this->preferences['theme_in_focus'];
					$new_theme_in_focus = sanitize_file_name(sanitize_title($_POST['theme_meta']['Name']));
					// need to do unique dir check here too
					// Check for micro theme with same name
					if ($alt_name = $this->rename_if_required($this->micro_root_dir, $new_theme_in_focus)) {
						$new_theme_in_focus = $alt_name;
						// The dir had to be automatically renamed so update the visible name
						$_POST['theme_meta']['Name'] = $this->readable_name($new_theme_in_focus);
					}
					$new_name = $this->micro_root_dir . $new_theme_in_focus;
					// if the directory is writable
					if (is_writable($orig_name)) {
						if (rename($orig_name, $new_name)) {
							// if rename is successful...

							// the meta file will have a different location now
							$meta_file = str_replace($this->preferences['theme_in_focus'], $new_theme_in_focus, $meta_file);

							// update the files array directory key
							$cache = $this->file_structure[$this->preferences['theme_in_focus']];
							$this->file_structure[$new_theme_in_focus] = $cache;
							unset($this->file_structure[$this->preferences['theme_in_focus']]);

							// update the value in the preferences table
							$pref_array = array();
							$pref_array['theme_in_focus'] = $new_theme_in_focus;
							if ($this->savePreferences($pref_array)) {
								$this->log(
									esc_html__('Design pack renamed', 'microthemer'),
									'<p>' . esc_html__('The design pack directory was successfully renamed on the server.', 'microthemer') . '</p>',
									'notice'
								);
							}
						}
						else {
							$this->log(
								esc_html__('Directory rename error', 'microthemer'),
								'<p>' . sprintf(
									esc_html__('The directory %s could not be renamed for some reason.', 'microthemer'),
									$this->root_rel($orig_name)
								) . '</p>'
							);
						}
					}
					else {
						$this->log(
							esc_html__('Directory rename error', 'microthemer'),
							'<p>' . sprintf(
								esc_html__('WordPress does not have permission to rename the directory %1$s to match your new theme name "%2$s".', 'microthemer'),
								$this->root_rel($orig_name),
								htmlentities($this->readable_name($_POST['theme_meta']['Name']))
								) . $this->permissionshelp.'.</p>'
						);
					}
				}


				// Create new file if it doesn't already exist
				if (!file_exists($meta_file)) {
					if (!$write_file = fopen($meta_file, 'w')) {
						$this->log(
							sprintf( esc_html__('Create %s error', 'microthemer'), 'meta.txt' ),
							'<p>' . sprintf(esc_html__('WordPress does not have permission to create: %s', 'microthemer'), $this->root_rel($meta_file) . '. '.$this->permissionshelp ) . '</p>'
						);
					}
					else {
						fclose($write_file);
					}
					$task = 'created';
					// set post variables if undefined (might be following initial export)

					if (!isset($_POST['theme_meta']['Description'])) {

						$current_user = wp_get_current_user();

						//global $user_identity;
						//get_currentuserinfo();
						/* get the user's website (fallback on site_url() if null)
						$user_info = get_userdata($user_ID);
						if ($user_info->user_url != '') {
							$author_uri = $user_info->user_url;
						}
						else {
							$author_uri = site_url();
						}*/
						// get parent theme name and version
						//$theme_data = wp_get_theme(get_stylesheet_uri());
						// $template = $theme_data['Name'] . ' ' . $theme_data['Version'];
						//$template = $theme_data['Name'];
						$_POST['theme_meta']['Description'] = "";
						$_POST['theme_meta']['PackType'] ='';
						$_POST['theme_meta']['Author'] = $current_user->display_name;
						$_POST['theme_meta']['AuthorURI'] = '';
						// $_POST['theme_meta']['Template'] = get_current_theme();
						$_POST['theme_meta']['Template'] = '';
						$_POST['theme_meta']['Version'] = '1.0';
						$_POST['theme_meta']['Tags'] = '';

					}
				}
				else {
					$task = 'updated';
				}



				// check if it's writable - // need to remove carriage returns
				if ( is_writable($meta_file) ) {

					/*
					note: if DateCreated is missing the pack was made before june 12.
					This may or may not be useful information.
					*/

					//removed Theme URI: '.strip_tags(stripslashes($_POST['theme_meta']['URI'])).'

					$data = '/*
Theme Name: '.strip_tags(stripslashes($_POST['theme_meta']['Name'])).'
Pack Type: '.strip_tags(stripslashes($_POST['theme_meta']['PackType'])).'
Description: '.strip_tags(stripslashes(str_replace(array("\n", "\r"), array(" ", ""), $_POST['theme_meta']['Description']))).'
Author: '.strip_tags(stripslashes($_POST['theme_meta']['Author'])).'
Author URI: '.strip_tags(stripslashes($_POST['theme_meta']['AuthorURI'])).'
Template: '.strip_tags(stripslashes($_POST['theme_meta']['Template'])).'
Version: '.strip_tags(stripslashes($_POST['theme_meta']['Version'])).'
Tags: '.strip_tags(stripslashes($_POST['theme_meta']['Tags'])).'
DateCreated: '.date('Y-m-d').'
*/';

					 // the file will be created if it doesn't exist. otherwise it is overwritten.
					 $write_file = fopen($meta_file, 'w');
					 fwrite($write_file, $data);
					 fclose($write_file);
					 // success message
					$this->log(
						'meta.txt '.$task,
						'<p>' . sprintf( esc_html__('The %1$s file for the design pack was %2$s', 'microthemer'), 'meta.txt', $task ) . '</p>',
						'dev-notice'
					);
				}
				else {
					$this->log(
						sprintf( esc_html__('Write %s error', 'microthemer'), 'meta.txt'),
						'<p>' . esc_html__('WordPress does not have "write" permission for: ', 'microthemer') .
						$this->root_rel($meta_file) . '. '.$this->permissionshelp.'</p>'
					);
				}

			}

			// update the readme file
			function update_readme_file($readme_file) {
				// Create new file if it doesn't already exist
				if (!file_exists($readme_file)) {
					if (!$write_file = fopen($readme_file, 'w')) {
						$this->log(
							sprintf( esc_html__('Create %s error', 'microthemer'), 'readme.txt'),
							'<p>' . sprintf(
							esc_html__('WordPress does not have permission to create: %s', 'microthemer'),
							$this->root_rel($readme_file) . '. '.$this->permissionshelp
						) . '</p>'
						);
					}
					else {
						fclose($write_file);
					}
					$task = 'created';
					// set post variable if undefined (might be defined if theme dir has been
					// created manually and then user is submitting readme info for the first time)
					if (!isset($_POST['tvr_theme_readme'])) {
						$_POST['tvr_theme_readme'] = '';
					}
				}
				else {
					$task = 'updated';
				}
				// check if it's writable
				if ( is_writable($readme_file) ) {
					$data = stripslashes($_POST['tvr_theme_readme']); // don't use striptags so html code can be added
					 // the file will be created if it doesn't exist. otherwise it is overwritten.
					 $write_file = fopen($readme_file, 'w');
					 fwrite($write_file, $data);
					 fclose($write_file);
					 // success message
					 $this->log(
						'readme.txt '.$task,
						'<p>' . sprintf(
							esc_html__('The %1$s file for the design pack was %2$s', 'microthemer'),
							'readme.txt', $task
						) . '</p>',
						'dev-notice'
					 );
				}
				else {
					$this->log(
						sprintf( esc_html__('Write %s error', 'microthemer'), 'readme.txt'),
						'<p>' . esc_html__('WordPress does not have "write" permission for: ', 'microthemer') .
						$this->root_rel($readme_file) . '. '.$this->permissionshelp.'</p>'
					);
				}
			}

			// handle file upload
			function handle_file_upload() {
				// if no error
				if ($_FILES['upload_file']['error'] == 0) {
					$file = $_FILES['upload_file']['name'];
					// check if the file has a valid extension
					if ($this->is_acceptable($file)) {
						$dest_dir = $this->micro_root_dir . $this->preferences['theme_in_focus'].'/';
						// check if the directory is writable
						if (is_writeable($dest_dir) ) {
							// copy file if safe
							if (is_uploaded_file($_FILES['upload_file']['tmp_name'])
							and copy($_FILES['upload_file']['tmp_name'], $dest_dir . $file)) {
								$this->log(
									esc_html__('File successfully uploaded', 'microthemer'),
									'<p>' . wp_kses(
										sprintf(
											__('<b>%s</b> was successfully uploaded.', 'microthemer'),
											htmlentities($file)
										),
										array( 'b' => array() )
									) . '</p>',
									'notice'
								);
								// update the file_structure array
								$this->file_structure[$this->preferences['theme_in_focus']][$file] = $file;

								// resize file if it's a screeshot
								if ($this->is_screenshot($file)) {
									$img_full_path = $dest_dir . $file;
									// get the screenshot size, resize if too big
									list($width, $height) = getimagesize($img_full_path);
									if ($width > 896 or $height > 513){
										$this->wp_resize(
											$img_full_path,
											896,
											513,
											$img_full_path);
									}
									// now do thumbnail
									$thumbnail = $dest_dir . 'screenshot-small.'. $this->get_extension($file);
									$root_rel_thumb = $this->root_rel($thumbnail);
									if (!$final_dimensions = $this->wp_resize(
										$img_full_path,
										145,
										83,
										$thumbnail)) {
										$this->log(
											esc_html__('Screenshot thumbnail error', 'microthemer'),
											'<p>' . wp_kses(
												sprintf(
													__('Could not resize <b>%s</b> to thumbnail proportions.', 'microthemer'),
													$root_rel_thumb
												),
												array( 'b' => array() )
											) . $img_full_path .
											esc_html__(' thumb: ', 'microthemer') .$thumbnail.'</p>'
										);
									}
									else {
										// update the file_structure array
										$file = basename($thumbnail);
										$this->file_structure[$this->preferences['theme_in_focus']][$file] = $file;
										$this->log(
											esc_html__('Screenshot thumbnail successfully created', 'microthemer'),
											'<p>' . sprintf(
												esc_html__('%s was successfully created.', 'microthemer'),
												$root_rel_thumb
											) . '</p>',
											'notice'
										);
									}
								}


							}
						}
						// it's not writable
						else {
							$this->log(
								esc_html__('Write to directory error', 'microthemer'),
								'<p>'. esc_html__('WordPress does not have "Write" permission to the directory: ', 'microthemer') .
								$this->root_rel($dest_dir) . '. '.$this->permissionshelp.'.</p>'
							);
						}
					}
					else {
						$this->log(
							esc_html__('Invalid file type', 'microthemer'),
							'<p>' . esc_html__('You have uploaded a file type that is not allowed.', 'microthemer') . '</p>'
						);

					}
				}
				// there was an error - save in global message
				else {
					$this->log_file_upload_error($_FILES['upload_file']['error']);
				}
			}

			// log file upload problem
			function log_file_upload_error($error){
				switch ($error) {
					case 1:
						$this->log(
							esc_html__('File upload limit reached', 'microthemer'),
							'<p>' . esc_html__('The file you uploaded exceeded your "upload_max_filesize" limit. This is a PHP setting on your server.', 'microthemer') . '</p>'
						);
						break;
					case 2:
						$this->log(
							esc_html__('File size too big', 'microthemer'),
							'<p>' . esc_html__('The file you uploaded exceeded your "max_file_size" limit. This is a PHP setting on your server.', 'microthemer') . '</p>'
						);
						break;
					case 3:
						$this->log(
							esc_html__('Partial upload', 'microthemer'),
							'<p>' . esc_html__('The file you uploaded only partially uploaded.', 'microthemer') . '</p>'
						);
						break;
					case 4:
						$this->log(
							esc_html__('No file uploaded', 'microthemer'),
							'<p>' . esc_html__('No file was detected for upload.', 'microthemer') . '</p>'
						);
						break;
				}
			}

			// resize image using wordpress functions
			function wp_resize($path, $w, $h, $dest, $crop = true){
				$image = wp_get_image_editor( $path );
				if ( ! is_wp_error( $image ) ) {
					$image->resize( $w, $h, $crop );
					$image->save( $dest );
					return true;
				} else {
					return false;
				}
			}

			// resize image
			function resize($img, $max_width, $max_height, $newfilename) {
				//Check if GD extension is loaded
				if (!extension_loaded('gd') && !extension_loaded('gd2')) {
					$this->log(
						esc_html__('GD not loaded', 'microthemer'),
						'<p>' . esc_html__('The PHP extension GD is not loaded.', 'microthemer') . '</p>'
					);
					return false;
				}
				//Get Image size info
				$imgInfo = getimagesize($img);
				switch ($imgInfo[2]) {
					case 1: $im = imagecreatefromgif($img); break;
					case 2: $im = imagecreatefromjpeg($img); break;
					case 3: $im = imagecreatefrompng($img); break;
					default:
						$this->log(
							esc_html__('File type error', 'microthemer'),
							'<p>' . esc_html__('Unsuported file type. Are you sure you uploaded an image?', 'microthemer') . '</p>'
						);

					return false; break;
				}
				// orig dimensions
				$width = $imgInfo[0];
				$height = $imgInfo[1];
				// set proportional max_width and max_height if one or the other isn't specified
				if ( empty($max_width)) {
					$max_width = round($width/($height/$max_height));
				}
				if ( empty($max_height)) {
					$max_height = round($height/($width/$max_width));
				}
				// abort if user tries to enlarge a pic
				if (($max_width > $width) or ($max_height > $height)) {
					$this->log(
						esc_html__('Dimensions too big', 'microthemer'),
						'<p>' . sprintf(
							esc_html__('The resize dimensions you specified (%1$s x %2$s) are bigger than the original image (%3$s x %4$s). This is not allowed.', 'microthemer'),
							$max_width, $max_height, $width, $height
						) . '</p>'
					);
					return false;
				}

				// proportional resizing
				$x_ratio = $max_width / $width;
				$y_ratio = $max_height / $height;
				if (($width <= $max_width) && ($height <= $max_height)) {
					$tn_width = $width;
					$tn_height = $height;
				}
				else if (($x_ratio * $height) < $max_height) {
					$tn_height = ceil($x_ratio * $height);
					$tn_width = $max_width;
				}
				else {
					$tn_width = ceil($y_ratio * $width);
					$tn_height = $max_height;
				}
				// for compatibility
				$nWidth = $tn_width;
				$nHeight = $tn_height;
				$final_dimensions['w'] = $nWidth;
				$final_dimensions['h'] = $nHeight;
				$newImg = imagecreatetruecolor($nWidth, $nHeight);
				/* Check if this image is PNG or GIF, then set if Transparent*/
				if(($imgInfo[2] == 1) or ($imgInfo[2]==3)) {
					imagealphablending($newImg, false);
					imagesavealpha($newImg,true);
					$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
					imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
				}
				imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
				// Generate the file, and rename it to $newfilename
				switch ($imgInfo[2]) {
					case 1: imagegif($newImg,$newfilename); break;
					case 2: imagejpeg($newImg,$newfilename); break;
					case 3: imagepng($newImg,$newfilename); break;
					default:
					$this->log(
						esc_html__('Image resize failed', 'microthemer'),
						'<p>' . esc_html__('Your image could not be resized.', 'microthemer') . '</p>'
					);
					return false;
					break;
				}
				return $final_dimensions;
			}
			// next function


		} // End Class
	} // End if class exists statement

	/***
	PCLZIP only seems to accept non Class member functions, hence the following functions appear here
	***/

	// check file types (microthemer)
	if (!function_exists('tvr_microthemer_getOnlyValid')) {
		function tvr_microthemer_getOnlyValid($p_event, &$p_header) {
			// avoid null byte hack (THX to Dominic Szablewski)
			if ( strpos($p_header['filename'], chr(0) ) !== false )
				$p_header['filename'] = substr ( $p_header['filename'], 0, strpos($p_header['filename'], chr(0) ));
			$info = pathinfo($p_header['filename']);
			// check for extension
			$ext = array('jpeg', 'jpg', 'png', 'gif', 'txt', 'json', 'psd', 'ai');
			if ( in_array( strtolower($info['extension']), $ext) ) {
				// For MAC skip the ".image" files
				if ($info['basename']{0} == '.' )
					return 0;
				else
					return 1;
			}
			// ----- all other files are skipped
			else {
				return 0;
			}
		}
	}

	/*if (!function_exists('tvr_microloader_getOnlyValid')) {
		// check file types (microloader)
		function tvr_microloader_getOnlyValid($p_event, &$p_header) {
			// avoid null byte hack (THX to Dominic Szablewski)
			if ( strpos($p_header['filename'], chr(0) ) !== false )
				$p_header['filename'] = substr ( $p_header['filename'], 0, strpos($p_header['filename'], chr(0) ));
			$info = pathinfo($p_header['filename']);
			// check for extension
			$ext = array('jpeg', 'jpg', 'png', 'gif', 'txt', 'json', 'psd', 'ai');
			if ( in_array( strtolower($info['extension']), $ext) ) {
				// For MAC skip the ".image" files
				if ($info['basename']{0} == '.' )
					return 0;
				else
					return 1;
			}
			// ----- all other files are skipped
			else {
				return 0;
			}
		}
	}
	*/
	// PCLZIP_CB_POST_EXTRACT is an option too: http://www.phpconcept.net/pclzip/user-guide/49

	/***
	INSTANTIATE THE ADMIN CLASS
	***/
	if (class_exists('tvr_microthemer_admin')) {
		$tvr_microthemer_admin_var = new tvr_microthemer_admin();
	}

} // ends 'if is_admin()' condition

// frontend code - insert active-styles.css in head section if active
if (!is_admin()) {
	// admin class
	if (!class_exists('tvr_microthemer_frontend')) {
		// define
		class tvr_microthemer_frontend {

			// @var string The preferences string name for this plugin
			var $time = 0;
			var $preferencesName = 'preferences_themer_loader';
			// @var array $preferences Stores the ui options for this plugin
			var $preferences = array();
			var $version = '5.0.0.2';
			var $microthemeruipage = 'tvr-microthemer.php';
			var $mt_front_nonce = 'mt-temp-nonce';
			var $file_stub = '';
			var $min_stub = '';
			var $num_save_append = '';
			var $menu_item_counts = array(); // for adding first/last classes to menus
			var $menu_item_count = 0;

			/**
			* PHP 4 Compatible Constructor

			function tvr_microthemer_frontend(){$this->__construct();}
			 * */
			/**
			* PHP 5 Constructor
			*/

			function __construct(){


				$this->time = time();

				// check that styles are active
				$this->preferences = get_option($this->preferencesName);

				// translatable: apparently one of the commented methods below is correct, but they don't work for me.
				// http://geertdedeckere.be/article/loading-wordpress-language-files-the-right-way
				// JOSE: $this->propertyoptions doesn't get translated if we use init
				load_plugin_textdomain( 'microthemer', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
				//add_action('init', array($this, 'tvr_load_textdomain'));

				// get path variables
				include dirname(__FILE__) .'/get-dir-paths.inc.php';


				// get custom code var
				$this->custom_code = tvr_common::get_custom_code();

				// get draft, minify, and num saves
				add_action( 'plugins_loaded', array(&$this, 'init_mt_vars'));

				// add active-styles.css (if not preview)
				if (!isset($_GET['tvr_micro'])) {
					add_action( 'wp_print_styles', array(&$this, 'add_css'), 999999);
				}
				// else add the preview css
				else {
					add_action( 'wp_print_styles', array(&$this, 'add_preview_css'), 999999);
				}

				// add shortcut to Microthemer
				if (!empty($this->preferences['admin_bar_shortcut'])) {
					add_action( 'admin_bar_menu', array(&$this, 'custom_toolbar_link'), 999999);
				}

				// add viewport = 1 if set in preferences
				if ($this->preferences['initial_scale'] == 1) {
					add_action('wp_head', array(&$this, 'viewport_meta') );
				}

				// add meta_tag if logged in - else undefined iframeUrl variable creates break error
				add_action( 'wp_head', array(&$this, 'add_meta_tag'));

				// add frontend script
				add_action( 'wp_enqueue_scripts', array(&$this, 'add_js'));

				// add mt body classes (page-id and slug)
				add_filter( 'body_class', array(&$this, 'add_body_classes') );

				// insert dynamic classes to menus if preferred todo this if fixed, tell forum user
				// https://themeover.com/forum/topic/microthemer-conflicting-with-plugin-responsive-menu/#post-9046
				if (!function_exists('add_first_and_last')) {
					if (!empty($this->preferences['first_and_last'])) {
						add_filter('nav_menu_css_class', array(&$this, 'add_first_and_last_classes'), 10, 3);
					}
				}

				// filter the HTML just before it's sent to the browser - no need for now.
				/*if (false) {
					add_action('get_header', array(&$this, 'tvr_head_buffer_start'));
					add_action('wp_head', array(&$this, 'tvr_head_buffer_end'));
				}*/

			} // end constructor

			/* remove parent style.css and replace with microthemer reset.css
			function tvr_head_buffer_callback($buffer) {
				// modify buffer here, and then return the updated code
				$buffer = str_replace(get_stylesheet_uri(), $this->thispluginurl.'css/frontend/reset.css', $buffer);
				return $buffer;
			}
			// start buffer
			function tvr_head_buffer_start() {
				ob_start(array(&$this, "tvr_head_buffer_callback"));
			}
			// end buffer
			function tvr_head_buffer_end() {
				ob_end_flush();
			}
			*/

			function init_mt_vars(){
				// get_current_user_id() needs to be here (hooked function)
				$this->current_user_id = get_current_user_id();
				$this->file_stub = ($this->preferences['draft_mode'] and
					in_array($this->current_user_id, $this->preferences['draft_mode_uids'])) ? 'draft' : 'active';
				$this->min_stub = $this->preferences['minify_css'] ? 'min.': '';
				$num_saves = !empty($this->preferences['num_saves']) ? $this->preferences['num_saves'] : 0;
				$this->num_save_append = '?mts=' . $num_saves;



			}

			// add a link to the WP Toolbar
			function custom_toolbar_link($wp_admin_bar) {

				if (!current_user_can('administrator')){
					//return false;
				}

				// wp_create_nonce must be inside a function/hooked else it fails
				$this->mt_front_nonce = wp_create_nonce( 'mt-front-nonce' );

				if (empty($this->preferences['top_level_shortcut'])
					or $this->preferences['top_level_shortcut'] == 1){
					$parent = false;
				} else {
					$parent = 'site-name';
				}

				// MT admin page with front page param passed in for quick editing
				$href = $this->wp_blog_admin_url . 'admin.php?page=' . $this->microthemeruipage .
				'&mt_preview_url=' . rawurlencode($this->currentPageURL())
				. '&_wpnonce=' . $this->mt_front_nonce;

				$args = array(
					'id' => 'wp-mcr-shortcut',
					'title' => 'Microthemer',
					'parent' => $parent,
					'href' => $href,
					'meta' => array(
						'class' => 'wp-mcr-shortcut',
						'title' => __('Jump to the Microthemer interface', 'microthemer')
					)
				);
				$wp_admin_bar->add_node($args);
			}

			// determine dependent style sheets - sometimes a theme includes style.css AFTER active-styles.css (e.g. classipress)
			function dep_stylesheets() {
				/*
				// redundant, but kept as an example in case this method is ever needed
				$cur_theme = strtolower(get_current_theme());
				switch ($cur_theme) {
					case "classipress":
						$deps = array('at-main', 'at-color');
						break;
					default:
						$deps = false;
				}
				return $deps;
				*/
				return false;
			}


			// add stylesheet function
			function add_css() {

				// if it's a preview don't cache the css file
				if (is_user_logged_in()) {
					$append = '?nocache=' . $this->time;
				} else {
					$append = $this->num_save_append;
				}
				if ( !empty($this->preferences['active_theme']) ) {
					// register css - check theme name so relevant dependencies can be added
					$deps = $this->dep_stylesheets();

					// check if Google Fonts stylesheet needs to be called
					if (!empty($this->preferences['g_fonts_used'])) {
						// add fonts subset url param if defined
						if (!empty($this->preferences['gfont_subset'])) {
							$this->preferences['g_url'] = $this->preferences['g_url'] . $this->preferences['gfont_subset'];
						}
						wp_register_style( 'micro'.TVR_MICRO_VARIANT.'_g_font', $this->preferences['g_url'], false );
						wp_enqueue_style( 'micro'.TVR_MICRO_VARIANT.'_g_font' );
					}

					$url = $this->micro_root_url. $this->min_stub . $this->file_stub .'-styles.css';
					wp_register_style( 'microthemer', $url . $append, $deps );
					wp_enqueue_style( 'microthemer' );

					// check if ie-specific stylesheets need to be called
					global $is_IE;
					if ( $is_IE ) {
						global $wp_styles;
						foreach ($this->preferences['ie_css'] as $key => $cond){
							if (!empty($this->preferences['ie_css'][$key])) {
								$file_stub = ($this->file_stub == 'draft') ? $this->file_stub.'-' : '';
								$path = $this->micro_root_url.$file_stub.'ie-'.$key.'.css'.$append;
								wp_register_style( 'tvr_ie_'.$key, $path);
								wp_enqueue_style( 'tvr_ie_'.$key. 'microthemer' );
								$wp_styles->add_data('tvr_ie_'.$key, 'conditional', $cond);
							}
						}
					}

				}
				// only include firebug style overlay css if user is logged in
				if (is_user_logged_in() and TVR_MICRO_VARIANT == 'themer') {
					// register
					$min = !TVR_DEV_MODE ? '.min' : '';
					wp_register_style( 'micro'.TVR_MICRO_VARIANT.'-overlay-css',
						$this->thispluginurl.'css/frontend'.$min.'.css?v='.$this->version );
					// enqueue
					wp_enqueue_style( 'micro'.TVR_MICRO_VARIANT.'-overlay-css');
				}
			}

			// add preview css
			function add_preview_css() {
				if (is_user_logged_in()) {
					$append = '?nocache=' . $this->time;
				}
				$deps = $this->dep_stylesheets();
				wp_register_style( 'micro_theme_preview', $this->micro_root_url.intval($_GET['tvr_micro']).'.css'.$append, $deps );
				wp_enqueue_style( 'micro_theme_preview' );
			}

			// get the current page for iframe-meta and loading WP page after clicking WP admin MT option
			function currentPageURL() {
				$curpageURL = 'http';
				if (!empty($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on") {$curpageURL.= "s";}
				$curpageURL.= "://";
				if ($_SERVER["SERVER_PORT"] != "80") {
					$curpageURL.= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
					$curpageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				return $curpageURL;
			}

			// add viewport intial scale = 1
			function viewport_meta() {
				?>
				<!-- Microthemer viewport setting -->
				<meta name="viewport" content="width=device-width, initial-scale=1"/>
				<?php
			}

			// add meta iframe-url tracker (for remembering the preview page)
			function add_meta_tag() {
				if ( is_user_logged_in() ) {
					?><meta name='iframe-url' id='iframe-url' content='<?php echo rawurlencode($this->currentPageURL());?>' /><meta name='mt-show-admin-bar' id='mt-show-admin-bar' content='<?php echo $this->preferences['admin_bar_preview'];?>' /><?php
				}
			}

			// add firebug style overlay js if user is logged in
			function add_js() {
				if ( is_user_logged_in() and TVR_MICRO_VARIANT == 'themer') {
					// testing only - swap default jQuery with 2.x for future proofing
					/*
					$jq2 = false;
					if ($jq2){
						wp_deregister_script('jquery');
						wp_register_script('jquery', ($this->thispluginurl.'js/jq2.js'));
					}*/

					wp_enqueue_script( 'jquery' );
					$min = !TVR_DEV_MODE ? '-min' : '/page';
					wp_register_script( 'tvr_mcth_frontend',
						$this->thispluginurl.'js'.$min.'/frontend.js?v='.$this->version, array('jquery') );
					wp_enqueue_script( 'tvr_mcth_frontend' );
				}

				// enqueue any native wp libraries the user has specified
				$deps = array(''); // maybe make frontend.js dep (if looged in) so MT can catch errors
				if (!empty($this->preferences['enq_js']) and is_array($this->preferences['enq_js'])){
					foreach ($this->preferences['enq_js'] as $k => $arr){
						if (empty($arr['disabled'])){
							wp_enqueue_script($arr['display_name']);
							$deps[] = $arr['display_name'];
						}
					}
				}

				// enqueue user custom js if needed
				if (!empty($this->preferences['load_js'])) {
					// add minification support soon
					$path = $this->micro_root_url . $this->file_stub . '-scripts.js' . $this->num_save_append;
					wp_register_script('mt_user_js', $path);
					wp_enqueue_script('mt_user_js', false, $deps);
				}
			}

			// add page/post id for easy page targeting (and slug as ids change on development)
			function add_body_classes($classes){
				global $post;
				if ( isset( $post ) ) {
					$classes[] = 'mt-'.$post->ID;
					$classes[] = 'mt-'.$post->post_type.'-'.$post->post_name;
				}
				return $classes;
			}

			// add first and last classes to menus
			function add_first_and_last_classes( $classes, $item, $args ) {

				// store menu item count if not done already
				if (empty($this->menu_item_counts[ $args->menu->slug ])){
					$this->menu_item_counts[ $args->menu->slug ] = $args->menu->count;
					$this->menu_item_count = 0;
				}

				// add first or last item
				if ( $this->menu_item_count === 0 ) {
					$classes[] = 'menu-item-first';
				} else if ( $this->menu_item_count === $this->menu_item_counts[ $args->menu->slug ]-1 ) {
					$classes[] = 'menu-item-last';
				}

				$this->menu_item_count++;

				//echo '<pre>$args: '.print_r($args, true).'</pre>';
				//echo '<pre>$item: '.print_r($item, true).'</pre>';
				return $classes;
			}
			/*function add_first_and_last( $items ) {
				$position = strrpos($items, 'class="menu-item', -1);
				$items=substr_replace($items, 'menu-item-last ', $position+7, 0);
				$position = strpos($items, 'class="menu-item');
				$items=substr_replace($items, 'menu-item-first ', $position+7, 0);
				return $items;
			}*/

		} // end class
	} // end 'if(!class_exists)'

	// instantiate the frontend class
	if (class_exists('tvr_microthemer_frontend')) {
		$tvr_microthemer_frontend_var = new tvr_microthemer_frontend();
	}

} // end 'is_admin()'

?>
