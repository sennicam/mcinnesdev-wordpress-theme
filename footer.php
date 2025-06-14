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
    <div class="site-info">
<?php /* REMOVING 'Powered By' disclaimer.  ToDo: make this a theme option?
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mcinnesdev-theme' ) ); ?>">
            <?php
            printf( esc_html__( 'Powered by %s', 'mcinnesdev-theme' ), 'WordPress' );
            ?>
        </a>
        <span class="sep"> | </span>
*/ ?>
        <?php
        /* translators: 1: Theme name, 2: Theme author. */
		// ToDo: remove or link to GitHub repo?
        printf( esc_html__( 'Theme: %1$s by %2$s.', 'mcinnesdev-theme' ), 'McInnes.Dev Theme', '<a href="https://mcInnes.dev/">Josh McInnes</a>' );
        ?>
    </div><?php
    wp_nav_menu( array(
        'theme_location' => 'footer',
        'menu_id'        => 'footer-menu',
        'depth'          => 1, // Only show top-level items for simplicity
    ) );
    ?>
</footer><?php wp_footer(); ?>

</body>
</html>