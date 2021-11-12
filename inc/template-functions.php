<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage Starter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function starter_body_classes( array $classes ): array {

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}

	return $classes;
}
add_filter( 'body_class', 'starter_body_classes' );

/**
 * Remove the `no-js` class from body if JS is supported.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function starter_supports_js() {
	echo '<script>document.body.classList.remove("no-js");</script>';
}
add_action( 'wp_footer', 'starter_supports_js' );

/**
 * Adds custom class to the array of posts classes.
 *
 * @param array $classes An array of CSS classes.
 * @return array
 */
function starter_post_classes( array $classes ): array {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'starter_post_classes', 10, 3 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @return void
 */
function starter_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'starter_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The form defaults.
 * @return array
 */
function starter_comment_form_defaults( array $defaults ): array {

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $defaults['comment_field'] );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'starter_comment_form_defaults' );

/**
 * Determines if post thumbnail can be displayed.
 *
 * @return bool
 */
function starter_can_show_post_thumbnail(): bool {
	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @param bool $show_post_thumbnail Whether to show post thumbnail.
	 */
	return apply_filters(
		'starter_can_show_post_thumbnail',
		! post_password_required() && ! is_attachment() && has_post_thumbnail()
	);
}

/**
 * Creates continue reading text.
 */
function starter_continue_reading_text(): string {
	return sprintf(
		esc_html__( 'Continue reading %s', 'starter' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);
}

/**
 * Creates the continue reading link for excerpt.
 */
function starter_continue_reading_link_excerpt() {
	if ( ! is_admin() ) {
		return '&hellip; <a href="' . esc_url( get_permalink() ) . '">' . starter_continue_reading_text() . '</a>';
	}
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'starter_continue_reading_link_excerpt' );

/**
 * Creates continue reading link.
 */
function starter_continue_reading_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . starter_continue_reading_text() . '</a></div>';
	}
}

// Filter the excerpt more link.
add_filter( 'the_content_more_link', 'starter_continue_reading_link' );

if ( ! function_exists( 'starter_post_title' ) ) {
	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @param string $title The title.
	 * @return string
	 */
	function starter_post_title( string $title ): string {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'starter' ) : $title;
	}
}
add_filter( 'the_title', 'starter_post_title' );

/**
 * Retrieve protected post password form content.
 *
 * @param string $output The password form HTML output.
 * @param int|WP_Post $post   Optional. Post ID or WP_Post object. Default is global $post.
 * @return string HTML content for password form for password protected post.
 */
function starter_password_form( string $output, $post = 0 ) {
	$post   = get_post( $post );
	$label  = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
	return '<p class="post-password-message">' . esc_html__( 'This content is password protected. Please enter a password to view.', 'starter' ) . '</p>
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<label class="post-password-form__label" for="' . esc_attr( $label ) . '">' . esc_html_x( 'Password', 'Post password form', 'starter' ) . '</label><input class="post-password-form__input" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" /><input type="submit" class="post-password-form__submit" name="' . esc_attr_x( 'Submit', 'Post password form', 'starter' ) . '" value="' . esc_attr_x( 'Enter', 'Post password form', 'starter' ) . '" /></form>
	';
}
add_filter( 'the_password_form', 'starter_password_form', 10, 2 );

/**
 * Disable Self Pingbacks in WordPress
 * @url http://www.wpbeginner.com/wp-tutorials/how-disable-self-pingbacks-in-wordpress/
 *
 * @param $links
 */
function starter_disable_self_pingbacks( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset($links[$l]);
		}
	}
}
add_action( 'pre_ping', 'starter_disable_self_pingbacks' );

/**
 * Calculate classes for the main <html> element.
 *
 * @return void
 */
function starter_the_html_classes() {
	/**
	 * Filters the classes for the main <html> element.
	 *
	 * @param string The list of classes. Default empty string.
	 */
	$classes = apply_filters( 'starter_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}