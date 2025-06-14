<?php
/**
 * Template part for displaying post previews in lists (e.g., Recent Posts section).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-preview' ); ?>>
	<header class="entry-header">
		<?php
		// Always use an H3 for the title in a preview list context
		the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

		if ( 'post' === get_post_type() ):
		  ?>
		<div class="entry-meta">
			<?php
			// Display post meta (date, author, etc.)
			// We'll create a helper function for this in functions.php shortly
			mcinnesdev_theme_posted_on();
			?>
		</div>
		<?php endif; ?>
	</header>
	<?php mcinnesdev_theme_post_thumbnail(); ?>
	<div class="entry-summary">
		<?php
		// Display the post excerpt (short summary)
		the_excerpt();
		?>
	</div>
	<footer class="entry-footer"> <a href="<?php the_permalink(); ?>" class="read-more-link">
		<?php esc_html_e( 'Read More &raquo;', 'mcinnesdev-theme' ); ?>
		</a>
		<?php
		// Optional: display categories/tags here if desired
		// mcinnesdev_theme_entry_footer();
		?>
	</footer>
</article>
