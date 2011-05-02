<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="<?=$post->post_name?>">
		<h2 class="page-title"><?php the_title();?></h2>
		<article>
			<?php the_content();?>
		</article>
	</div>

<?php get_footer();?>