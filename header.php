<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mcinnesdev-theme' ); ?></a>

<header id="masthead" class="site-header">
    <div class="site-branding">
        <?php
        the_custom_logo(); // Displays the custom logo if set in Customizer
        if ( is_front_page() && is_home() ) :
            ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php
        else :
            ?>
            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
        endif;
        $mcinnesdev_theme_description = get_bloginfo( 'description', 'display' );
      /*
        if ( $mcinnesdev_theme_description || is_customize_preview() ) :
            ?>
            <p class="site-description"><?php echo $mcinnesdev_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
        <?php endif; */?>
    </div><nav id="site-navigation" class="main-navigation">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'mcinnesdev-theme' ); ?></button>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'depth'          => 1, // Only show top-level items for simplicity, adjust as needed.
        ) );
        ?>
    </nav>
  </header>
  <div id="content" class="site-content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">