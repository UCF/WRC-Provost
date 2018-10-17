<?php $options = get_option(THEME_OPTIONS_NAME);?>
			<div id="bottom" class="row">
				<div class="span12 hr"></div>
				<!--Units -->
				<div id="bottom-contact" class="span4">
					<h3>Contact Us</h3>
					<?php
						if ($options['site_footer_contactus']) {
							print $options['site_footer_contactus'];
						}
					?>
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
