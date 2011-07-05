<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="<?=$post->post_name?>">
		<h2 class="span-24 last"><?php the_title();?></h2>
		
		<div id="left" class="span-17 append-1">
			<?php if($post->post_type == 'profile'): ?>
			<div id="profile">
				<?=get_the_post_thumbnail($person->ID)?>
				<strong><?=get_post_meta($post->ID, 'profile_description', True)?></strong>
				<?php
					$categories = get_the_category();
					foreach($categories as $c){
						echo $c->name;
					}
				?>
			</div>
			<?php endif; ?>
			<article>
			<?php 
				$content = $post->post_content;
				if(!empty($content)){
					the_content();
				} else {
					echo "Coming soon...";
				}
			?>
			</article>
		</div>
		<div id="right" class="span-6 last">
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