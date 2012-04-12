<?php 

/**
 * Outputs forms, organized by the sub-category of 'Forms' they are related to.
 * Uncategorized forms will not display.
 *
 * Example:
 * [sc-forms]
 **/
function sc_forms(){
	ob_start();
	include('templates/section-forms.php');
	return ob_get_clean();
}
add_shortcode('sc-forms', 'sc_forms');


/**
 * Creates a list of objects without output defined by the object outputted.  
 * This shortcode is available if an auto-generated shortcode for the object 
 * you want to list is not available, otherwise use the <object>-list shortcodes
 * instead.
 * 
 * Example:
 *
 * # output all updates tagged important
 * [sc-object type="profile" tags="important"]
 *
 * # output a maximum of 10 units categorized as foo
 * [sc-object type="wrc_form" categories="foo" limit="10"]
 **/
function sc_object($attr){
	if (!is_array($attr)){return '';}
	
	$defaults = array(
		'tags'       => '',
		'categories' => '',
		'type'       => '',
		'limit'      => -1,
		'orderby'    => 'menu_order',
		'order'      => 'ASC'
	);
	$options = array_merge($defaults, $attr);
	
	$tax_query = array(
		'relation' => 'OR',
	);
	
	if ($options['tags']){
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['tags']),
		);
	}
	
	if ($options['categories']){
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['categories']),
		);
	}
	
	$query_array = array(
		'tax_query'      => $tax_query,
		'post_status'    => 'publish',
		'post_type'      => $options['type'],
		'posts_per_page' => $options['limit'],
		'orderby'        => $options['orderby'],
		'order'          => $options['order'],
	);
	$query = new WP_Query($query_array);
	
	global $post;
	ob_start();
	?>
	
	<ul class="object-list <?=$options['type']?>-list">
		<?php while($query->have_posts()): $query->the_post();
		$class = get_custom_post_type_class($post->post_type);
		$class = new $class;
		$html  = $class->toHTML($post->ID, 'li');
		echo $html;
		endwhile;?>
	</ul>
	<div class="clear"><!-- --></div>
	
	<?php
	$results = ob_get_clean();
	wp_reset_postdata();
	return $results;
}
add_shortcode('sc-object', 'sc_object');

?>