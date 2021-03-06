<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?="\n".header_()."\n"?>
		
		<?php if(GA_ACCOUNT or CB_UID):?>
		
		<script type="text/javascript">
			var _sf_startpt = (new Date()).getTime();
			<?php if(GA_ACCOUNT):?>
			
			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			var _gaq        = _gaq || [];
			_gaq.push(['_setAccount', GA_ACCOUNT]);
			_gaq.push(['_setDomainName', 'none']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);
			<?php endif;?>
			<?php if(CB_UID):?>
			
			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>
			
		</script>
		<?php endif;?>
		
		<?  $post_type = get_post_type($post->ID);
			if(($stylesheet_id = get_post_meta($post->ID, $post_type.'_stylesheet', True)) !== False
				&& ($stylesheet_url = wp_get_attachment_url($stylesheet_id)) !== False) { ?>
				<link rel='stylesheet' href="<?=$stylesheet_url?>" type='text/css' media='all' />
		<? } ?>
		
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript">
			var PROVOST_STATIC_URL = '<?php echo THEME_STATIC_URL; ?>';
		</script>

	</head>
	<body>
		<div class="container" id="header">
			<section>
				<div class="row">
					<h1 class="span12"><a href="<?=bloginfo('url')?>"><?=bloginfo('name')?></a></h1>
				</div>
				<div class="row">	
					<div class="span12">
						<?=wp_nav_menu(array(
							'theme_location' => 'header-menu', 
							'container'      => 'false', 
							'menu_id'        => 'header-menu', 
							'walker'         => new Bootstrap_Walker_Nav_Menu()
							));
						?>
					</div>		
				</div>
			</section>
		</div>
		<div class="container">
