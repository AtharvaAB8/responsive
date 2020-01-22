<?php
/**
 * Displays post entry content
 *
 * @package Responsive WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php do_action( 'responsive_before_blog_entry_content' ); ?>
	<div class="entry-content">
		<?php
		if ( 'content' === get_theme_mod( 'responsive_blog_entry_content_type', 'excerpt' ) ) {
			the_content( 'Read More ››' );
		} else {
			the_excerpt();
		}
		?>
	</div>
<?php
do_action( 'responsive_after_blog_entry_content' );
