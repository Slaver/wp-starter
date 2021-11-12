<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Starter
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comment_count = get_comments_number();
?>

<div id="comments" class="comments-area default-max-width <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php if ( '1' === $comment_count ) : ?>
				<?php esc_html_e( '1 comment', 'starter' ); ?>
			<?php else : ?>
				<?php
				printf(
					esc_html( _nx( '%s comment', '%s comments', $comment_count, 'Comments title', 'starter' ) ),
					esc_html( number_format_i18n( $comment_count ) )
				);
				?>
			<?php endif; ?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'avatar_size' => 60,
				'style'       => 'ol',
				'short_ping'  => true,
            ] );
			?>
		</ol>

		<?php
		the_comments_pagination( [
			'before_page_number' => esc_html__( 'Page', 'starter' ) . ' ',
			'mid_size'           => 0,
			'prev_text'          => sprintf(
				'<span class="nav-prev-text">%s</span>',
				esc_html__( 'Older comments', 'starter' )
			),
			'next_text'          => sprintf(
				'<span class="nav-next-text">%s</span>',
				esc_html__( 'Newer comments', 'starter' )
			),
        ] );
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'starter' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	comment_form( [
		'logged_in_as'       => null,
		'title_reply'        => esc_html__( 'Leave a comment', 'starter' ),
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
    ] );
	?>

</div>