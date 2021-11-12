<?php
/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Starter
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

    <aside class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside>

<?php endif; ?>
