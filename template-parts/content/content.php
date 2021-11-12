<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Starter
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
		the_content(
			starter_continue_reading_text()
		);

		wp_link_pages([
			'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'starter' ) . '">',
			'after'    => '</nav>',
			'pagelink' => esc_html__( 'Page %', 'starter' ),
        ]);

		?>
	</div>

	<footer class="entry-footer default-max-width">
		<?php starter_entry_meta_footer(); ?>
	</footer>
</article>
