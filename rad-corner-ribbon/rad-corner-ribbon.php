<?php 
/*
Plugin Name: Shop Corner Ribbon
Description: Adds a promotional ribbon to the corner of the site
Plugin URI: http://path-to-plugin-support.com
Author: Melissa Cabral
Version 0.1
License: GPLv3 or higher 
*/

/**
 * HTML output for the ribbon
 */
add_action( 'wp_footer', 'rad_ribbon_output' );
function rad_ribbon_output(){
	if( is_front_page() ):
	?>
		<!-- Begin Rad Corner Ribbon by Melissa Cabral -->
		<a href="#" id="rad-corner-ribbon">
		<img src="<?php echo plugins_url( 'images/corner-ribbon.png', __FILE__ ); ?>" 
			alt="Visit the sale items in the shop" />
		</a>
	<?php
	endif;
}

/**
 * Attach the CSS file properly
 */
add_action( 'wp_enqueue_scripts', 'rad_ribbon_style' );
function rad_ribbon_style(){
	if( is_front_page() ):
		//get the path for the CSS file
		$css_file = plugins_url( 'css/style.css', __FILE__ );
		//tell WP it exists
		wp_register_style( 'rad-ribbon-css', $css_file );
		//put it on the page
		wp_enqueue_style( 'rad-ribbon-css' );

		//JS addition
		if(is_admin_bar_showing()):
			//get the path for the JS file
			$js_file = plugins_url( 'js/custom.js', __FILE__ );
			//tell WP it exists
			wp_register_script( 'rad-ribbon-js', $js_file );
			//put it on the page
			wp_enqueue_script( 'rad-ribbon-js' );
		endif; //admin bar showing
	endif;//is front page
}
