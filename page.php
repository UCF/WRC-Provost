<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="<?=$post->post_name?>">
		<h2 class="page-title"><?php the_title();?></h2>
		<div id="left" class="span-17 append-1">
			<article>
				<?php the_content();?>
			</article>
			
			<?php if(get_post_meta($post->ID, 'use-comments', True)):?>
			<!-- Academic Affairs specific template information -->
			<?php thematic_comments_template()?>
			<?php endif;?>
		</div>
		<div id="right" class="span-6 last">
			
			<!-- Featured Image -->
			<?php if(has_post_thumbnail() and get_the_title() == 'About the WRC'):?>
			<div id="featured-image">
				<?php the_post_thumbnail();?>
			</div>
			<?php endif;?>
			
			<!-- Sub-page List-->
			<?php $children = get_pages(array(
				'child_of'    => $post->ID,
				'parent'      => $post->ID,
				'sort_column' => 'menu_order',
			));
			?>
			<?php if ($children):?>
			<div id="sub-pages">
				<ul>
					<?php foreach($children as $page):?>
					<li><a href="<?=get_permalink($page->ID)?>"><?=$page->post_title?></a></li>
					<?php endforeach;?>
				</ul>
			</div>
			<?php endif;?>
			
			<div id="widgets">
				<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('secondary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
		</div>
		
	</div>

<?php get_footer();?>