<?php 
/*
Plugin Name: Global Company Options
Description: Adds a page to the admin panel for company info
Author: Melissa Cabral
License: GPLv3
*/

/**
 * Add Admin Panel Page under Settings
 */
add_action( 'admin_menu', 'rad_settings_page' );
function rad_settings_page(){
	add_options_page( 'Company Information', 'Company Info', 'manage_options', 
		'rad-company-info', 'rad_options_form' );
}
/**
 * Callback for the admin page HTML
 */
function rad_options_form(){
	if( ! current_user_can( 'manage_options' ) ):
		wp_die( 'Access Denied' );
	else:
		require( plugin_dir_path( __FILE__ ) . 'rad-options-form.php' );
	endif;
}

/**
 * Whitelist a group of options for storage in the DB
 */
add_action( 'admin_init', 'rad_register_settings' );
function rad_register_settings(){
	register_setting( 'rad_options_group', 'rad_options', 'rad_options_sanitize' );
}


/**
 * Sanitizing Callback
 * @param array containing all the dirty input fields
 */
function rad_options_sanitize($input){
	//strip all the tags and crud from some of the fields
	$input['phone'] = wp_filter_nohtml_kses( $input['phone'] );
	$input['email'] = wp_filter_nohtml_kses( $input['email'] );

	//allow break tags and paragraphs in the address field
	$allowed = array( 
		'br' => array(),
		'p' => array(),
		);
	$input['address'] = wp_kses( $input['address'], $allowed );

	//all clean!  pass the data back to the DB
	return $input;
}

/**
 * Bonus Round! Add convenient Shortcodes
 * place ['phone'] into any post or page to show a dynamic value from our settings 
 */
add_shortcode( 'phone', 'rad_phone_shortcode' );
function rad_phone_shortcode(){
	$values = get_option( 'rad_options' );
	return '<a href="tel:' .  $values['phone'] . '">' . $values['phone'] . '</a>';
}

add_shortcode( 'email', 'rad_email_shortcode' );
function rad_email_shortcode(){
	$values = get_option( 'rad_options' );
	return '<a href="mailto:' . $values['email'] . '">Email Us</a>' ;
}

add_shortcode( 'address', 'rad_address_shortcode' );
function rad_address_shortcode(){
	$values = get_option( 'rad_options' );
	return '<address>' . $values['address'] . '</address>';
}