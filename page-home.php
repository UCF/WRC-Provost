<?php disallow_direct_load('page-home.php');?>
<?php get_header(); the_post();?>
<div class="row page-content" id="<?=$post->post_name?>">
	<div class="span12">
		<div class="row">
			<div class="span7">
				<!-- Slideshow-->
				<?php $gallery = get_home_images();?>
				<?php if ($gallery):?>
				<div id="home-images-carousel" class="carousel slide">
					<!-- Carousel items -->
					<div class="carousel-inner">
						<?=$gallery?>
					</div>
				</div>
				<?php endif;?>
			</div>
			<div class="span5">
			<!-- Provost Quote/Marketing -->
				<div class="row">
					<div id="quote" class="span5">
						<?php the_content()?>
					</div>
				</div>
				<div class="row">
					<!-- News and Announcement Posts -->
					<div id="announcements" class="span5">
						<ul class="unstyled">
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
				</div>
				<div class="row">
					<div class="span5" id="help-search">
						<section>
							<?php get_search_form();?>
						</section>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="middle">
			<div class="span12">
				<div class="row">
					<?php foreach(get_menu_pages('home-menu') as $i=>$page):?>
						<div class="span3"><a href="<?=get_page_link($page->ID)?>">
							<?=get_the_post_thumbnail($page->ID)?>
							<span class="title"><?=$page->post_title?></span>
						</a></div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>