<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	<div class="row" id="<?=$post->post_name?>">
		<div class="span9 page-content">
			<h2><?php the_title();?></h2>
			<?php the_content();?>
		</div>
	</div>
<?php get_footer();?>