<?php
	$deans_list = get_posts(array(
		'numberposts' => 1,
		'post_type'   => get_custom_post_type('WRCForm'),
		'category'    => get_category_by_slug('deans-list')->term_id,
	));
	if (count($deans_list)){
		$deans_list = $deans_list[0];
	}
	$org_chart = get_posts(array(
		'numberposts' => 1,
		'post_type'   => get_custom_post_type('WRCForm'),
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
		
		<ul class="people"<?php if($id):?> id="<?=$id?>"<?php endif;?>>
		<?php foreach($people as $person):?>
			<li class="person">
				<a href="<?=get_permalink($person->ID)?>">
				<?php
					$img = get_the_post_thumbnail($person->ID);
					if ($img):?>
					<?=$img?>
					<?php else:?>
						<img src="<?=PROVOST_IMG_URL?>/no-photo.png" alt="Photo Unavailable" />
					<?php endif;?>
					<span class="name"><?=str_replace('', '&nbsp;', $person->post_title)?></span>
				</a>
				<span class="description"><?=get_post_meta($person->ID, 'profile_description', True)?></span>
			</li>
		<?php endforeach;?>
		</ul>
		<div class="end"><!-- --></div>
		<?php
	}
?>
<div id="org-chart">
	<?php if ($academic_officers):?>
	<h2><?=get_category_by_slug('academic-officers')->name ?></h2>
	<a href="<?=WRCForm::get_url($org_chart)?>">Download PDF <?=$org_chart->post_title?></a>
	<?php display_people($academic_officers, 'academic-officers');?>
	<?php endif;?>
	
	<?php if ($college_deans):?>
	<h2><?=get_category_by_slug('college-deans')->name ?></h2>
	<a href="<?=WRCForm::get_url($deans_list)?>">Download PDF <?=$deans_list->post_title?></a>
	<?php display_people($college_deans, 'college-deans');?>
	<?php endif;?>
	
	<?php if ($administrative_staff):?>
	<h2><?=get_category_by_slug('administrative-staff')->name ?></h2>
	<?php display_people($administrative_staff, 'administrative-staff');?>
	<?php endif;?>
</div>