<?php

function sc_person_picture_list($atts) {
	$atts['type']	= ($atts['type']) ? $atts['type'] : null;
	$row_size 		= ($atts['row_size']) ? (intval($atts['row_size'])) : 5;
	$categories		= ($atts['categories']) ? $atts['categories'] : null;
	$org_groups		= ($atts['org_groups']) ? $atts['org_groups'] : null;
	$limit			= ($atts['limit']) ? (intval($atts['limit'])) : -1;
	$join			= ($atts['join']) ? $atts['join'] : 'or';
	$people 		= sc_object_list(
						array(
							'type' => 'profile', 
							'limit' => $limit,
							'join' => $join,
							'categories' => $categories, 
							'org_groups' => $org_groups
						), 
						array(
							'objects_only' => True,
						));
	
	ob_start();
	
	?><div class="person-picture-list"><?
	$count = 0;
	
	foreach($people as $person) {
		
		$image_url = get_featured_image_url($person->ID);
		
		$link = ($person->post_content != '') ? True : False;
		if( ($count % $row_size) == 0) {
			if($count > 0) {
				?></div><?
			}
			?><div class="row"><?
		}
		
		?>
		<div class="person-picture-wrap">
			<? if($link) {?><a href="<?=get_permalink($person->ID)?>"><? } ?>
				<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
				<div class="name"><?=Person::get_name($person)?></div>
				<? if($link) {?></a><?}?>
				<div class="description"><?=get_post_meta($person->ID, 'profile_description', True)?></div>
		</div>
		<?
		$count++;
	}
	?>	</div>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('person-picture-list', 'sc_person_picture_list');

function sc_org_chart($attrs) {
	$deans_list = get_posts(array(
		'numberposts' => 1,
		'post_type'   => 'provost_form',
		'category'    => get_category_by_slug('deans-list')->term_id,
	));
	if (count($deans_list)){
		$deans_list = $deans_list[0];
	}
	$org_chart = get_posts(array(
		'numberposts' => 1,
		'post_type'   => 'provost_form',
		'category'    => get_category_by_slug('org-chart')->term_id,
	));
	if (count($org_chart)){
		$org_chart = $org_chart[0];
	}
	
	
	$category = get_category_by_slug('college-deans');
	$college_deans = ($category) ? get_posts(array(
		'numberposts' => -1,
		'post_type'   => 'profile',
		'category'    => $category->term_id,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	)) : false;
	
	$category = get_category_by_slug('academic-officers');
	$academic_officers = ($category) ? get_posts(array(
		'numberposts' => -1,
		'post_type'   => 'profile',
		'category'    => $category->term_id,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	)) : false;
	
	$category = get_category_by_slug('administrative-staff');
	$administrative_staff = ($category) ? get_posts(array(
		'numberposts' => -1,
		'post_type'   => 'profile',
		'category'    => get_category_by_slug('administrative-staff')->term_id,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	)) : false;
	
	function display_people($people, $id=null){
		?>
		<div class="row"><div class="span8">
		<?
		$count = 0;
		foreach($people as $person) {
			if($count > 0 && ($count % 5) == 0) {
				echo '</div></div><div class="row"><div class="span8">';
			}
			?>
			<div class="person">
			<a href="<?=get_permalink($person->ID)?>">
			<?php
				$img = get_the_post_thumbnail($person->ID);
				if ($img):?>
				<?=$img?>
				<?php else:?>
					<img src="<?=THEME_IMG_URL?>/no-photo.png" alt="Photo Unavailable" />
				<?php endif;?>
				<span class="name"><?=str_replace('', '&nbsp;', $person->post_title)?></span>
			</a>
			<span class="description"><?=get_post_meta($person->ID, 'profile_description', True)?></span>	
			</div>
			<?
			$count++;
		}
		?> </div></div> <?
	}
	ob_start();
	?>
	<div id="org-chart">
		<?php if ($academic_officers):?>
		<h3><?=get_category_by_slug('academic-officers')->name ?> <small><a href="<?=Document::get_url($org_chart)?>">Download PDF <?=$org_chart->post_title?></a></small></h3>
		<?php display_people($academic_officers, 'academic-officers');?>
		<?php endif;?>
		
		<?php if ($college_deans):?>
		<h3><?=get_category_by_slug('college-deans')->name ?> <small><a href="<?=Document::get_url($deans_list)?>">Download PDF <?=$deans_list->post_title?></a></small></h3>
		<?php display_people($college_deans, 'college-deans');?>
		<?php endif;?>
		
		<?php if ($administrative_staff):?>
		<h3><?=get_category_by_slug('administrative-staff')->name ?></h3>
		<?php display_people($administrative_staff, 'administrative-staff');?>
		<?php endif;?>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('sc-org-chart', 'sc_org_chart');
