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

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php starter_post_thumbnail(); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( [
			'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'starter' ) . '">',
			'after'    => '</nav>',
			'pagelink' => esc_html__( 'Page %', 'starter' ),
        ] );
		?>
	</div>

	<footer class="entry-footer default-max-width">
		<?php starter_entry_meta_footer(); ?>
	</footer>

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article>
