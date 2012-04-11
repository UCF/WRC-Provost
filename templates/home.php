<?php get_header();?>
	
	<div id="home">
		<div id="top" class="span-24 last">
			<div class="span-15">
				<!-- Slideshow-->
				<?php $gallery = get_home_images();?>
				<?php if ($gallery):?>
				<div class="slideshow">
					<?=$gallery?>
				</div>
				<?php endif;?>
				<div class="clear">&nbsp;</div>
			</div>
			<div class="span-9 last">
				<!-- WRC Quote/Marketing -->
				<div id="quote">
					<?php the_content()?>
				</div>
				
				<!-- News and Announcement Posts -->
				<div id="announcements">
					<ul>
						<?php foreach(get_posts(array(
							'numberposts' => 3,
							'orderby'     => 'date',
							'order'       => 'DESC',
							'post_type'   => 'post',
							'category'    => get_category_by_slug('announcements')->term_id,
						)) as $post):?>
						<li><a href="<?=get_page_link($post->ID)?>"><?=$post->post_title?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				
				<div id="search">
					<?php get_search_form();?>
				</div>
			</div>
		</div>
		<div class="clear">&nbsp;</div>
		<div id="middle" class="span-24 last">
			<ul>
			<?php foreach(get_menu_pages('home-menu') as $i=>$page):$last=!(($i + 1) % 4);?>
				<li class="span-6<?=($last)?' last':'';?>"><a href="<?=get_page_link($page->ID)?>">
					<?=get_the_post_thumbnail($page->ID)?>
					<span class="title"><?=$page->post_title?></span>
				</a></li>
			<?php endforeach;?>
			</ul>
		</div>
		
		<div id="bottom" class="span-24 last">
			<div class="widgets span-8 append-1">
				<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('1st-subsidiary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
			<div class="widgets span-8 append-1">
				<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('2nd-subsidiary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
			<div class="widgets span-6 last">
				<ul>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('3rd-subsidiary-aside') ) : ?>
				<?php endif; ?>
				</ul>
			</div>
			
		</div>
	</div>
	
<?php get_footer();?>