<?php /*
Plugin Name: Custom Post Type - Products
Description: Adds products CPT to our site for the shop section
Author: Melissa Cabral
Version: 0.1
License: GPLv3 or higher

*/

/**
 * Activate Custom post type Admin UI
 * @since 0.1
 */
add_action( 'init', 'rad_register_cpt' );
function rad_register_cpt(){
	register_post_type( 'product', array(
		'public' => true,
		'has_archive' => true,
		'labels' => array(
			'name' => 'Products',
			'singular_name' => 'Product',
			'not_found' => 'No Products Found',
			'add_new_item' => 'Add New Product',
		),
		'rewrite' => array( 'slug' => 'shop' ),
		'supports' => array( 'title' , 'editor', 'thumbnail' , 'excerpt', 
			'custom-fields', 'revisions'  ),
	) );
	//category-like taxonomy for product features
	register_taxonomy( 'brand', 'product', array(
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'brands' ),
		'labels' => array(
			'name' => 'Brands',
			'singular_name' => 'Brand', 
			'add_new_item' => 'Add New Brand',
			'search_items' => 'Search Brands',
			'parent_item' => 'Parent Brand',
		), 
	) );
	//tag-like taxonomy for product features
	register_taxonomy( 'feature', 'product', array(
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'features' ),
		'labels' => array(
			'name' => 'Features',
			'singular_name' => 'Feature', 
			'add_new_item' => 'Add New feature',
			'search_items' => 'Search features',
			'parent_item' => 'Parent feature',
		), 
	) );
}

/**
 * Flush rewrite rules 
 * fixes 404 errors when the CPT is created
 * runs once when the plugin is activated.
 * @since 0.1
 */
function rad_rewrite_flush(){
	 rad_register_cpt(); //the name of our function that registers the CPT
	 flush_rewrite_rules(); //heavy operation! this rebuilds .htaccess file
}
register_activation_hook( __FILE__, 'rad_rewrite_flush' );
