<?php 

/**
 * Outputs a list of the provost updates
 *
 * @return string
 * @author Jared Lang
 **/
function sc_provost_updates(){
	ob_start();
	include('templates/section-updates.php');
	return ob_get_clean();
}
add_shortcode('sc-provost-updates', 'sc_provost_updates');


/**
 * Outputs the horizontal faculty award programs list.
 *
 * @return string
 * @author Jared Lang
 **/
function sc_faculty_award_programs($attrs){
	ob_start();
	include('templates/section-faculty-award-programs.php');
	return ob_get_clean();
}
add_shortcode('sc-faculty-award-programs', 'sc_faculty_award_programs');


/**
 * Outputs the Academic Officers and College Deans listings
 *
 * @return string
 * @author Jared Lang
 **/
function sc_org_chart(){
	ob_start();
	include('templates/section-organization.php');
	return ob_get_clean();
}
add_shortcode('sc-org-chart', 'sc_org_chart');


/**
 * Outputs forms, organized by the sub-category of 'Forms' they are related to.
 * Uncategorized forms will not display.
 *
 * @return string
 * @author Jared Lang
 **/
function sc_forms(){
	ob_start();
	include('templates/section-forms.php');
	return ob_get_clean();
}
add_shortcode('sc-forms', 'sc_forms');


/**
 * Fetches objects defined by arguments passed, outputs the objects according
 * to the toHTML method located on the object.
 **/
function sc_object($attr){
	if (!is_array($attr)){return '';}
	
	$defaults = array(
		'tags'       => '',
		'categories' => '',
		'type'       => '',
		'limit'      => -1,
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
	);
	$query = new WP_Query($query_array);
	
	global $post;
	ob_start();
	?>
	
	<ul class="object-list <?=$options['type']?>">
		<?php while($query->have_posts()): $query->the_post();
		$class = get_custom_post_type_class($post->post_type);
		$class = new $class;?>
		<li>
			<?=$class->toHTML($post->ID)?>
		</li>
		<?php endwhile;?>
	</ul>
	
	<?php
	$results = ob_get_clean();
	wp_reset_postdata();
	return $results;
}
add_shortcode('sc-object', 'sc_object');

?>