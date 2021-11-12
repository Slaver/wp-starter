<?php
/**
 * Custom post types.
 *
 * @package WordPress
 * @subpackage Starter
 */

add_action( 'init', function() {

	/**
	 * Post Type: Products.
	 */
	register_post_type( 'products', [
		'label' => __( 'Products', 'starter' ),
		// @url https://developer.wordpress.org/reference/functions/get_post_type_labels/
		'labels' => [],
		'description' => '',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'delete_with_user' => false,
		'show_in_rest' => true,
		'rest_base' => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive' => 'Products',
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => [ 'slug' => 'product', 'with_front' => true ],
		'query_var' => true,
		'menu_position' => 5,
		'menu_icon' => false,
		'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author' ],
		'taxonomies' => [ 'type' ],
	] );
} );

/**
 * Placing a Custom Post Type Menu Above the Posts Menu Using menu_position?
 *
 * @link https://stackoverflow.com/questions/21424802/issue-on-cpt-custom-menu-position-in-wp
 * @link https://wordpress.stackexchange.com/questions/8779/placing-a-custom-post-type-menu-above-the-posts-menu-using-menu-position
 */
add_action( 'admin_head', function() {
	global $menu;

	$menu[7] = $menu[5];
	unset($menu[5]);
	ksort($menu);
} );