<?php 
/*
Plugin Name: Rad Admin Tweaks
Description: Changes stuff in the admin panel
Author: Melissa Cabral
Version: 0.1
License: GPL3
*/

/**
 * Customize the login screen
 * @since 0.1
 */
//add_action( 'login_head', 'rad_login_style' );
function rad_login_style(){
	?>
	<style type="text/css">
	body.login{
		background-color:#A9D8C0;
	}
	</style>
	<?php
}

/**
 * OPTIONAL: attach external CSS file 
 * @since 0.1
 */
add_action( 'login_enqueue_scripts', 'rad_login_css' );
function rad_login_css(){
	$css_path = plugins_url( 'rad_admin.css', __FILE__ );
	wp_register_style( 'login-style', $css_path );
	wp_enqueue_style( 'login-style' );
}
//change the login logo link from wordpress.org to the home page
add_filter( 'login_headerurl', 'rad_login_link' );
function rad_login_link(){
	return home_url( '/' );
}
//change the title text of the login header link to the description
add_filter( 'login_headertitle', 'rad_login_title' );
function rad_login_title(){
	return get_bloginfo( 'description' );
}

/**
 * Customize the logo on the admin bar
 * @since 0.1
 */
add_action( 'admin_head', 'rad_admin_bar_icon' );
add_action( 'wp_head', 'rad_admin_bar_icon' );

function rad_admin_bar_icon(){
	?>
	<style type="text/css">
		#wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before{
			content: "\f328"; /*smiley face*/
		}
	</style>

	<?php
}

/**
 * Remove Dashboard Widgets
 * @since 0.1
 */
add_action( 'wp_dashboard_setup', 'rad_remove_dash_widgets' );
function rad_remove_dash_widgets(){
	//remove the existing WP developer blog widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	
	//add our own RSS widget
wp_add_dashboard_widget( 'dasboard_rad_feed', 'Melissa\'s site', 'rad_rss_widget_content' );

}

//custom callback for the widget body
function rad_rss_widget_content(){
	echo '<div class="rss-widget">';
	wp_widget_rss_output( array(
		'url' => 'http://rss1.smashingmagazine.com/feed/',
		'items' => 4,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1,
	) );
	echo '</div>';
}