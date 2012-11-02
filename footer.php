			<div id="bottom" class="row">
				<!-- Colleges-->
				<div id="home-colleges" class="span4">
					<h3>Our Location</h3>
					<iframe width="320" height="240" frameborder="0" src="https://map.ucf.edu/widget?title=&width=300&height=300&illustrated=y&building_id=79" style="border: none; width: 315px; height: 300px;"></iframe>
				</div>
				<!--Units -->
				<div id="home-units" class="span4">
					<h3>Contact Us</h3>
					Contact us info will go here...
				</div>
				<div id="sidebar" class="span4">
					<?php $sidebar_width = 4; get_template_part('includes/sidebar'); ?>
				</div>
			</div>
			<?=wp_nav_menu(array(
				'theme_location' => 'footer-menu', 
				'container'      => 'false', 
				'menu_id'        => 'footer-menu', 
				'fallback_cb'    => false,
				'depth'          => 1,
				'walker'         => new Bootstrap_Walker_Nav_Menu()
				));
			?>
			<div id="footer">
				<div class="row">
					<div class="span3">
						<a class="ignore-external" href="http://www.ucf.edu"><img src="<?=THEME_IMG_URL?>/ucf-large.png" alt="" title="" /></a>
					</div>
					<div class="span9" id="info">
						<?php $options = get_option(THEME_OPTIONS_NAME);?>
						<?php if($options['site_contact'] or $options['organization_name']):?>
						<p>
							Site maintained by the <?php if($options['site_contact'] and $options['organization_name']):?>
							<a href="mailto:<?=$options['site_contact']?>"><?=$options['organization_name']?></a>
							<?php elseif($options['site_contact']):?>
							<a href="mailto:<?=$options['site_contact']?>"><?=$options['site_contact']?></a>
							<?php elseif($options['organization_name']):?>
							<?=$options['organization_name']?>.
							<?php endif;?>
						</p>
						<?php endif;?>
						<p>&copy; University of Central Florida</p>
					</div>
				</div>
			</div>
		</div>
	</body>
	<?="\n".footer_()."\n"?>
</html>