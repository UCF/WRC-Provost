<?php
/*
Template Name: No Sidebar
*/
	get_header();
	the_post();
?>
	
	<div class="page-content" id="<?=$post->post_name?>">
		<h2 class="page-title"><?php the_title();?></h2>
		<article>
			<?php the_content();?>
		</article>
		
		<?php if(get_post_meta($post->ID, 'use-comments', True)):?>
		<!-- Academic Affairs specific template information -->
		<?php thematic_comments_template()?>
		<?php endif;?>
		
	</div>

<?php get_footer();?>