<?php
	$wrc_award_program = new WRCAwardProgram();
	$programs = get_posts(array(
		'numberposts' => -1,
		'orderby'     => $orderby,
		'order'       => 'ASC',
		'post_type'   => $wrc_award_program->options('name'),
	));
	ob_start();
?>
	
<div class="faculty-award-programs">
	<h2>Faculty Award Programs</h2>
	<ul class="programs"><?php foreach($programs as $program):?>
		<li>
			<?php
				$url = get_post_meta($program->ID, 'wrc_award_url', True);
				if($url[0] == "/") $url = site_url() . $url;
				printf('<a href="%s">%s<span class="caption">%s</span></a>',
					$url,
					get_the_post_thumbnail($program->ID),
					$program->post_title
				);
			?>
		</li>
	<?php endforeach;?></ul>
	<div class="end"><!-- --></div>
</div>