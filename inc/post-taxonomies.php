<?php
/**
 * Custom post taxonomies.
 *
 * @package WordPress
 * @subpackage Starter
 */

add_action( 'init', function() {

	/**
	 * Taxonomy: Styles.
	 */
	register_taxonomy( 'style', [ 'products' ], [
		'label' => __( 'Styles', 'starter' ),
		// @url https://developer.wordpress.org/reference/functions/get_taxonomy_labels/
		'labels' => [],
		'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => [ 'slug' => 'style', 'with_front' => true, ],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'rest_base' => 'style',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit' => false,
	] );
} );
