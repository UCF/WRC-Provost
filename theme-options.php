<?php

/* downloaded from: http://themeshaper.com/2010/06/03/sample-theme-options/ */

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'settings', 'global', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Provost Theme Options' ), __( 'Provost Theme Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'settings' ); ?>
			<?php $options = get_option( 'global' ); ?>

			<table class="form-table">
				<?php
				/**
				 * Google Analytics (leaving blank will disable)
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Google Analytics' ); ?></th>
					<td>
						<input id="global[ga_account]" class="regular-text" type="text" name="global[ga_account]" value="<?php esc_attr_e( $options['ga_account'] ); ?>" style="width:85%;" />
						<br> <label class="description" for="global[ga_account]"><?php _e( 'Google Analytics Account. E.g., <span style="font-family:monospace;font-weight:bold;color:#21759B;">UA-9876543-21</span>.  Leave blank for development.' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	// Say our text option must be safe text with no HTML tags
	foreach($input as $key=>$option){
		$input[$key] = wp_filter_nohtml_kses($option);
	}
	return $input;
}
