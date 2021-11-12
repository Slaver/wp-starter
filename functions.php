<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Starter
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @return void
 */
add_action( 'after_setup_theme', function() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'starter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * This theme does not use a hard-coded <title> tag in the document head,
	 * WordPress will provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Add post-formats support.
	 */
	add_theme_support(
		'post-formats', [
			'link',
			'aside',
			'gallery',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		]
	);

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );

	register_nav_menus([
		'primary' => esc_html__( 'Primary menu', 'starter' ),
		'footer'  => __( 'Secondary menu', 'starter' ),
	]);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	] );

	/*
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	$logo_width  = 300;
	$logo_height = 100;

	add_theme_support( 'custom-logo', [
		'height'               => $logo_height,
		'width'                => $logo_width,
		'flex-width'           => true,
		'flex-height'          => true,
		'unlink-homepage-logo' => true,
	] );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for custom line height controls.
	add_theme_support( 'custom-line-height' );

	// Add support for experimental cover block spacing.
	add_theme_support( 'custom-spacing' );
} );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @return void
 */
add_action( 'widgets_init', function() {
	register_sidebar( [
		'name'          => esc_html__( 'Sidebar', 'starter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
} );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'starter-scripts', get_template_directory_uri() . '/assets/js/scripts.js', [ 'jquery' ], wp_get_theme()->get( 'Version' ), true );

	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

/**
 * Move all scripts to footer in WordPress
 *
 * @url https://gist.github.com/japalekhin/a92274447976d21ca0e81dfe68a39d26
 * @return void
 */
add_action( 'init', function() {
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
} );

/**
 * Disable the emoji's
 *
 * @url https://www.netmagik.com/how-to-disable-emojis-in-wordpress/
 * @return void
 */
add_action( 'init', function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'option_use_smilies', '__return_false' );
} );

/**
 * Disable Attachment Pages Completely
 *
 * @url https://wordpress.stackexchange.com/questions/237762/disable-attachment-pages-completely
 * @return void
 */
add_filter( 'attachment_link', '__return_false' );
add_action( 'template_redirect', function() {
	if( is_attachment() ) {
		$url = wp_get_attachment_url( get_queried_object_id() );
		wp_redirect( $url, 301 );
	}
}, 10 );

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom post types.
//require get_template_directory() . '/inc/post-types.php';

// Custom taxonomies.
//require get_template_directory() . '/inc/post-taxonomies.php';