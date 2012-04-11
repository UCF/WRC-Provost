<?php
# Custom Child Theme Functions
# http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/
require_once('custom-post-types.php');
require_once('shortcodes.php');

# Plugin-ins
require_once('custom-post-template/custom-post-templates.php');
require_once('theme-options.php');

$options = get_option('global');

define('PROVOST_THEME_DIR', get_stylesheet_directory());
define('PROVOST_GA_ACCOUNT', $options['ga_account']);
define('PROVOST_THEME_URL', get_bloginfo('stylesheet_directory'));
define('PROVOST_STATIC_URL', PROVOST_THEME_URL.'/static');
define('PROVOST_IMG_URL', PROVOST_STATIC_URL.'/img');
define('PROVOST_JS_URL', PROVOST_STATIC_URL.'/js');
define('PROVOST_CSS_URL', PROVOST_STATIC_URL.'/css');
define('PROVOST_MISC_URL', PROVOST_STATIC_URL.'/misc');

// Parent theme overrides and theme setttings
// ------------------------------------------

#Sets link to be included in head
$LINKS = array(
	"<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />",
	"\n\t<!-- jQuery UI CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/jquery-ui.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/jquery-uniform.css' media='screen, projection' />",
	"\n\t<!-- Blueprint CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-screen.css' media='screen, projection' />",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-print.css' media='print' />",
	"<!--[if lt IE 8]><link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/blueprint-ie.css' media='screen, projection' /><![endif]-->",
	"\n\t<!-- Template CSS -->",
	"<link rel='stylesheet' type='text/css' href='".PROVOST_CSS_URL."/webcom-template.css' media='screen, projection' />",
);

#Sets scripts to be loaded at bottom of page
$SCRIPTS = array(
	"<script src='http://universityheader.ucf.edu/bar/js/university-header.js' type='text/javascript' ></script>",
	"\n\t<!-- jQuery UI Scripts -->",
	"<script src='".PROVOST_JS_URL."/jquery-ui.js' type='text/javascript' ></script>",
	"<script src='".PROVOST_JS_URL."/jquery-browser.js' type='text/javascript' ></script>",
	"<script src='".PROVOST_JS_URL."/jquery-uniform.js' type='text/javascript' ></script>",
	"<script src='http://events.ucf.edu/tools/script.js' type='text/javascript'></script>",
	"<script type='text/javascript'>
		var PROVOST_MISC_URL = '".PROVOST_MISC_URL."';
		var GA_ACCOUNT       = '".PROVOST_GA_ACCOUNT."';
	</script>",
	"<script src='".PROVOST_JS_URL."/script.js' type='text/javascript'></script>",
);


function remove_widgitized_areas($content){
	$widgets_to_remove = array(
		'Index Top',
		'Index Insert',
		'Index Bottom',
		'Single Top',
		'Single Insert',
		'Single Bottom',
		'Page Top',
		'Page Bottom',
	);
	foreach($widgets_to_remove as $widget){
		unset($content[$widget]);
	}
	return $content;
}
add_action('thematic_widgetized_areas', 'remove_widgitized_areas');

function wrc_head_profile($profile){
	return "<head>";
}
add_filter('thematic_head_profile', 'wrc_head_profile');

function childtheme_doctitle($title){
	if ( is_home() || is_front_page() ) {
		return get_bloginfo('name');
	}
	return $title;
}
add_filter('thematic_doctitle', 'childtheme_doctitle');

function wrc_template_redirect(){
	global $post;
	$type  = $post->post_type;
	$title = get_the_title();
	switch($title){
		case 'Home':
			include('templates/home.php');
			die();
	}
	switch($type){
		case 'wrc_update':
			$post_template = get_post_meta( $post->ID, 'custom_post_template', true );
			if(empty($post_template)){
				include('wrc-update-tony.php');
			} else {
				include($post_template);
			}
			die();
	}
}
add_filter('template_redirect', 'wrc_template_redirect');


#Set html 5
function wrc_create_doctype() {
	$content  = "<!DOCTYPE html>\n";
	$content .= "<html";
    return $content;
} // end thematic_create_doctype
add_filter('thematic_create_doctype', 'wrc_create_doctype');


#Set utf-8 meta charset
function wrc_create_contenttype(){
	$content  = "\t<meta charset='utf-8'>\n";
	$content .= "\t<meta http-equiv='X-UA-COMPATIBLE' content='IE=IE8'>\n";
	ob_start();
	?>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
	<![endif]-->
<?php
	$content .= ob_get_clean();
	return $content;
}
add_filter('thematic_create_contenttype', 'wrc_create_contenttype');


#Override default stylesheets
function wrc_create_stylesheet($links){
	global $LINKS;
	$new_links = $LINKS;
	
	$links = explode("\n", $links);
	$links = array_map(create_function('$l', '
		return trim($l);
	'), $links);
	$links = array_filter($links, create_function('$l', '
		return (bool)trim($l);
	'));
	$links = array_merge($new_links, $links);
	
	return "\t".implode("\n\t", $links)."\n";
}
add_filter('thematic_create_stylesheet', 'wrc_create_stylesheet');


#Override default scripts
function wrc_head_scripts($scripts){}
add_filter('thematic_head_scripts', 'wrc_head_scripts');


#Append scripts to bottom of page
function wrc_after(){
	global $SCRIPTS;
	print "\t".implode("\n\t", $SCRIPTS);
}
add_filter('thematic_after', 'wrc_after');

function wrc_footer(){
	print wp_nav_menu(thematic_nav_menu_args());
}
add_action('wp_footer', 'wrc_footer');

#Add custom javascript to admin
function wrc_admin_scripts(){
	wp_enqueue_script('custom-admin', PROVOST_JS_URL.'/admin.js', array('jquery'), False, True);
}
add_action('admin_enqueue_scripts', 'wrc_admin_scripts');

// Theme custom functions
// ----------------------

/**
 * Creates an array 
 **/
function shortcodes(){
	$file = file_get_contents(PROVOST_THEME_DIR.'/shortcodes.php');
	
	$documentation = "\/\*\*(?P<documentation>.*?)\*\*\/";
	$declaration   = "function[\s]+(?P<declaration>[^\(]+)";
	
	$codes = array();
	$auto  = array_filter(installed_custom_post_types(), create_function('$c', '
		return $c->options("use_shortcode");
	'));
	foreach($auto as $code){
		$scode  = $code->prefixless_name().'-list';
		$plural = $code->options('plural_name');
		$doc = <<<DOC
 Outputs a list of {$plural} filtered by tag
 or category.

 Example:
 # Output a maximum of 5 items tagged foo or bar.
 [{$scode} tags="foo bar" limit="5"]

 # Output all objects categorized as foo
 [{$scode} categories="foo"]
DOC;
		$codes[] = array(
			'documentation' => $doc,
			'shortcode'     => $scode,
		);
	}
	
	$found = preg_match_all("/{$documentation}\s*{$declaration}/is", $file, $matches);
	if ($found){
		foreach ($matches['declaration'] as $key=>$match){
			$codes[$match]['documentation'] = $matches['documentation'][$key];
			$codes[$match]['shortcode']     = str_replace(
				array('sc_', '_',),
				array('', '-',),
				$matches['declaration'][$key]
			);
		}
	}
	return $codes;
}

function admin_help(){
	global $post;
	$shortcodes = shortcodes();
	switch($post->post_title){
		default:
			?>
			<h2>Available shortcodes:</h2>
			<ul>
				<?php foreach($shortcodes as $sc):?>
				<li>
					<h3><?=$sc['shortcode']?></h3>
					<p><?=nl2br(str_replace(' *', '', htmlentities($sc['documentation'])))?></p>
				</li>
				<?php endforeach;?>
			</ul>
			<?php
			break;
	}
}


function admin_meta_boxes(){
	global $post;
	add_meta_box('page-help', 'Help', 'admin_help', 'page', 'normal', 'high');
}
add_action('admin_init', 'admin_meta_boxes');

/**
 * Really get the post type.  A post type of revision will return it's parent
 * post type.
 **/
function post_type($post){
	if (is_int($post)){
		$post = get_post($post);
	}
	
	# check post_type field
	$post_type = $post->post_type;
	
	if ($post_type === 'revision'){
		$parent    = (int)$post->post_parent;
		$post_type = post_type($parent);
	}
	
	return $post_type;
}

function hyphenate($string){
	# Automatic hyphentation is difficult so here's a really stupid solution
	$words = array(
		'Commercialization' => 'Commercializ-<br>ation',
		//'Commercialization' => 'Commercializ<wbr>ation',
	);
	
	return str_replace(array_keys($words), array_values($words), $string);
}

/**
 * Returns the name of the custom post type defined by $class
 *
 * @return string
 * @author Jared Lang
 **/
function get_custom_post_type($class){
	$installed = installed_custom_post_types();
	foreach($installed as $object){
		if (get_class($object) == $class){
			return $object->options('name');
		}
	}
	return null;
}

function get_custom_post_type_class($name){
	$installed = installed_custom_post_types();
	foreach($installed as $object){
		if ($object->options('name') == $name){
			return get_class($object);
		}
	}
	return null;
}


/**
 * Returns pages associated with the menu defined by $c;
 *
 * @return array
 * @author Jared Lang
 **/
function get_menu_pages($c){
	return get_posts(array(
		'numberposts' => -1,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'post_type'   => 'page',
		'category'    => get_category_by_slug($c)->term_id,
	));
}


/**
 * Returns published images as html string
 *
 * @return void
 * @author Jared Lang
 **/
function get_home_images($limit=null, $orderby='menu_order'){
	$limit       = ($limit) ? $limit : -1;
	$home_images = new WRCHomeImages();
	$images      = get_posts(array(
		'numberposts' => -1,
		'orderby'     => $orderby,
		'order'       => 'DESC',
		'post_type'   => $home_images->options('name'),
	));
	if ($images){
		$html = '';
		foreach($images as $image){
			$thumbnail_id = get_post_thumbnail_id($image->ID);
			$thumbnail    = get_post($thumbnail_id);
			$html .= sprintf('<div class="clearfix">%s<p class="caption">%s</p></div>', get_the_post_thumbnail($image->ID), $thumbnail->post_excerpt);
		}
		return $html;
	}else{
		return '';
	}
}


/**
 * Tells you if this person has just commented within a given time frame and set
 * of comments.
 *
 * @return void
 * @author Jared Lang
 */
function user_just_commented($comments, $timeframe){
	/*/ This attempts to detect whether or not the user just commented by
	inspecting the last 10 comments passed and comparing their IP address and
	the current time to the comments IP address and post date.
	
	Unfortunately, if someone revists the the page this function is called on
	within the defined timeframe, it will return that they have just commented.
	/*/
	
	$limit    = 10; # Limit number of comments to search in
	$comments = array_slice($comments, -$limit);
	
	foreach($comments as $comment){
		$diff = time() - strtotime($comment->comment_date_gmt);
		if ($diff < $timeframe){
			if ($_SERVER["REMOTE_ADDR"] == $comment->comment_author_IP){
				return True;
			}
		}
	}
	return False;
}

function disallow_direct_load($page){
	if ( $page == basename($_SERVER['SCRIPT_FILENAME'])){
		die ( 'Please do not load this page directly. Thanks!' );
	}
}
?>