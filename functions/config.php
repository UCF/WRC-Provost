<?php

/**
 * Responsible for running code that needs to be executed as wordpress is
 * initializing.  Good place to register scripts, stylesheets, theme elements,
 * etc.
 * 
 * @return void
 * @author Jared Lang
 **/
function __init__(){
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	register_nav_menu('header-menu', __('Header Menu'));
	register_nav_menu('footer-menu', __('Footer Menu'));
	
	foreach(Config::$styles as $style){Config::add_css($style);}
	foreach(Config::$scripts as $script){Config::add_script($script);}
	
	global $timer;
	$timer = Timer::start();
	
	wp_deregister_script('l10n');
	set_defaults_for_options();
}
add_action('after_setup_theme', '__init__');



# Set theme constants
#define('DEBUG', True);                  # Always on
#define('DEBUG', False);                 # Always off
define('DEBUG', isset($_GET['debug'])); # Enable via get parameter
define('THEME_URL', get_stylesheet_directory_uri());
define('THEME_ADMIN_URL', get_admin_url());
define('THEME_DIR', get_stylesheet_directory());
define('THEME_INCLUDES_DIR', THEME_DIR.'/includes');
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');
define('THEME_OPTIONS_GROUP', 'settings');
define('THEME_OPTIONS_NAME', 'theme');
define('THEME_OPTIONS_PAGE_TITLE', 'Theme Options');

$theme_options = get_option(THEME_OPTIONS_NAME);
define('GA_ACCOUNT', $theme_options['ga_account']);
define('CB_UID', $theme_options['cb_uid']);
define('CB_DOMAIN', $theme_options['cb_domain']);


/**
 * Set config values including meta tags, registered custom post types, styles,
 * scripts, and any other statically defined assets that belong in the Config
 * object.
 **/
Config::$custom_post_types = array(
	'Page',
	'Person',
	'Post',
	'HomeImage',
	'Form',
);

Config::$custom_taxonomies = array(
	'OrganizationalGroups'
);

/**
 * Configure theme settings, see abstract class Field's descendants for
 * available fields. -- functions/base.php
 **/
Config::$theme_settings = array(
	'Analytics' => array(
		new TextField(array(
			'name'        => 'Google WebMaster Verification',
			'id'          => THEME_OPTIONS_NAME.'[gw_verify]',
			'description' => 'Example: <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
			'default'     => null,
			'value'       => $theme_options['gw_verify'],
		)),
		new TextField(array(
			'name'        => 'Google Analytics Account',
			'id'          => THEME_OPTIONS_NAME.'[ga_account]',
			'description' => 'Example: <em>UA-9876543-21</em>. Leave blank for development.',
			'default'     => null,
			'value'       => $theme_options['ga_account'],
		)),
	),
	'Events' => array(
		new SelectField(array(
			'name'        => 'Events Max Items',
			'id'          => THEME_OPTIONS_NAME.'[events_max_items]',
			'description' => 'Maximum number of events to display whenever outputting event information.',
			'value'       => $theme_options['events_max_items'],
			'default'     => 4,
			'choices'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
			),
		)),
		new TextField(array(
			'name'        => 'Events Calendar URL',
			'id'          => THEME_OPTIONS_NAME.'[events_url]',
			'description' => 'Base URL for the calendar you wish to use. Example: <em>http://events.ucf.edu/mycalendar</em>',
			'value'       => $theme_options['events_url'],
			'default'     => 'http://events.ucf.edu',
		)),
	),
	'Search' => array(
		new RadioField(array(
			'name'        => 'Enable Google Search',
			'id'          => THEME_OPTIONS_NAME.'[enable_google]',
			'description' => 'Enable to use the google search appliance to power the search functionality.',
			'default'     => 1,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['enable_google'],
	    )),
		new TextField(array(
			'name'        => 'Search Domain',
			'id'          => THEME_OPTIONS_NAME.'[search_domain]',
			'description' => 'Domain to use for the built-in google search.  Useful for development or if the site needs to search a domain other than the one it occupies. Example: <em>some.domain.com</em>',
			'default'     => null,
			'value'       => $theme_options['search_domain'],
		)),
		new TextField(array(
			'name'        => 'Search Results Per Page',
			'id'          => THEME_OPTIONS_NAME.'[search_per_page]',
			'description' => 'Number of search results to show per page of results',
			'default'     => 10,
			'value'       => $theme_options['search_per_page'],
		)),
	),
	'Site' => array(
		new TextField(array(
			'name'        => 'Contact Email',
			'id'          => THEME_OPTIONS_NAME.'[site_contact]',
			'description' => 'Contact email address that visitors to your site can use to contact you.',
			'value'       => $theme_options['site_contact'],
		)),
		new TextField(array(
			'name'        => 'Organization Name',
			'id'          => THEME_OPTIONS_NAME.'[organization_name]',
			'description' => 'Your organization\'s name',
			'value'       => $theme_options['organization_name'],
		)),
		new TextareaField(array(
			'name'        => 'Contact Us Information',
			'id'          => THEME_OPTIONS_NAME.'[site_footer_contactus]',
			'description' => 'Contact information for your organization that is available on all pages in the footer.',
			'default'     => '<strong>Linda Walters, Interim Director of the UCF Center for Success of Women Faculty</strong><br>
<a href="mailto:Linda.Walters@ucf.edu">Linda.Walters@ucf.edu</a><br>
<br>
<strong>Fran Ragsdale</strong> <br>
<a href="mailto:Fran.Ragsdale@ucf.edu">Fran.Ragsdale@ucf.edu</a><br>
<br>
<strong>Phone: 407-823-4240</strong> <br>
<br>
<strong>Mailing Address</strong><br>
Center for Success of Women Faculty<br>
University of Central Florida<br>
P.O. Box 160955<br>
Orlando, FL 32816-0955<br>
<br>
<strong>Physical Address</strong><br>
4000 Central Florida Blvd. Orlando, FL 32816<br>
<br>
<strong>Internal Mail (UCF)</strong><br>
Center for Success of Women Faculty <br>
CL1 Room 207 <br>
32816-0955',
			'value'       => $theme_options['site_footer_contactus'],
		)),
	),
	'Social' => array(
		new RadioField(array(
			'name'        => 'Enable OpenGraph',
			'id'          => THEME_OPTIONS_NAME.'[enable_og]',
			'description' => 'Turn on the opengraph meta information used by Facebook.',
			'default'     => 1,
			'choices'     => array(
				'On'  => 1,
				'Off' => 0,
			),
			'value'       => $theme_options['enable_og'],
	    )),
		new TextField(array(
			'name'        => 'Facebook Admins',
			'id'          => THEME_OPTIONS_NAME.'[fb_admins]',
			'description' => 'Comma seperated facebook usernames or user ids of those responsible for administrating any facebook pages created from pages on this site. Example: <em>592952074, abe.lincoln</em>',
			'default'     => null,
			'value'       => $theme_options['fb_admins'],
		)),
		new TextField(array(
			'name'        => 'Facebook URL',
			'id'          => THEME_OPTIONS_NAME.'[facebook_url]',
			'description' => 'URL to the facebook page you would like to direct visitors to.  Example: <em>https://www.facebook.com/CSBrisketBus</em>',
			'default'     => null,
			'value'       => $theme_options['facebook_url'],
		)),
		new TextField(array(
			'name'        => 'Twitter URL',
			'id'          => THEME_OPTIONS_NAME.'[twitter_url]',
			'description' => 'URL to the twitter user account you would like to direct visitors to.  Example: <em>http://twitter.com/csbrisketbus</em>',
			'value'       => $theme_options['twitter_url'],
		)),
	),
);

# Header links
Config::$links = array(
	array('rel' => 'shortcut icon', 'href' => THEME_IMG_URL.'/favicon.ico',),
	array('rel' => 'alternate', 'type' => 'application/rss+xml', 'href' => get_bloginfo('rss_url'),),
);

# Header styles
Config::$styles = array(
	array('admin' => True, 'src' => THEME_CSS_URL.'/admin.css',),
	THEME_STATIC_URL.'/bootstrap/bootstrap/css/bootstrap.css',
);


# Only include gravity forms styles if the plugin is active
include_once(ABSPATH.'wp-admin/includes/plugin.php' );
if(is_plugin_active('gravityforms/gravityforms.php')) {
	array_push(Config::$styles,
		plugins_url( 'gravityforms/css/forms.css' )
	);
}

array_push(Config::$styles,
	THEME_STATIC_URL.'/css/base.css',
	get_bloginfo('stylesheet_url')
);


# Scripts (output in footer)
Config::$scripts = array(
	array('admin' => True, 'src' => THEME_JS_URL.'/admin.js',),
	'//universityheader.ucf.edu/bar/js/university-header.js',
	THEME_STATIC_URL.'/bootstrap/bootstrap/js/bootstrap.js',
	THEME_STATIC_URL.'/js/script.js',
);

function jquery_in_header() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//code.jquery.com/jquery-1.7.1.min.js');
    wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'jquery_in_header');

# Header Meta
Config::$metas = array(
	array('charset' => 'utf-8',),
);

if ($theme_options['gw_verify']){
	Config::$metas[] = array(
		'name'    => 'google-site-verification',
		'content' => htmlentities($theme_options['gw_verify']),
	);
}