<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

?></main></div></div>
<footer id="colophon" class="site-footer">
  
		<div class="footer-inner-wrapper"> <div class="site-info">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php bloginfo( 'name' ); ?> &copy;2025
				</a>
<!--				<span class="sep"> | </span>-->
				<?php
					/* translators: 1: Theme name, 2: WordPress. */
		// ToDo: remove or link to GitHub repo?
//					printf( esc_html__( 'Proudly powered by %1$s and %2$s.', 'mcinnesdev-theme' ), 'McInnesDev Theme', '<a href="https://wordpress.org/">WordPress</a>' );
				?>
			</div><?php
			// Display the footer menu if it's assigned
			wp_nav_menu( array(
				'theme_location' => 'footer', // Assuming this theme location is registered
        'menu_id' => 'footer-menu',
				'container_class' => 'footer-navigation', // Wrapper for the menu
				'menu_class' => 'footer-menu-list', // NEW: Specific class for the <ul> element
				'depth' => 1, // Only show top-level menu items
				'fallback_cb' => false, // Don't display a default page list if no menu is assigned
			) );
			?>
		</div>
</footer>
<?php wp_footer(); ?>

</body>
</html>