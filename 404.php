<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="page-not-found">
		<?php thematic_404()?>
	</div>

<?php get_footer();?>