<?php
/**
 * McInnes.Dev Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

// Define theme version for cache busting
define( 'MCINNESDEV_THEME_VERSION', '1.0.0' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such as indicating support for post thumbnails.
 */
function mcinnesdev_theme_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'mcinnesdev-theme', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'mcinnesdev-theme' ),
        'footer'  => esc_html__( 'Footer Menu', 'mcinnesdev-theme' ),
    ) );

    // Switch default core markup for search form, comment form, and comments
    // to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
}
add_action( 'after_setup_theme', 'mcinnesdev_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function mcinnesdev_theme_scripts() {
    // Enqueue Google Fonts (Roboto)
    wp_enqueue_style( 'mcinnesdev-theme-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', array(), null );

    // Enqueue your custom main stylesheet
    wp_enqueue_style( 'mcinnesdev-theme-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), MCINNESDEV_THEME_VERSION );

    // Enqueue your custom mobile stylesheet
    wp_enqueue_style( 'mcinnesdev-theme-mobile-style', get_template_directory_uri() . '/assets/css/mobile.css', array(), MCINNESDEV_THEME_VERSION );

    // Enqueue your custom main JavaScript
    // Set true for the last argument to load in the footer
    wp_enqueue_script( 'mcinnesdev-theme-main-script', get_template_directory_uri() . '/assets/js/main.js', array(), MCINNESDEV_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'mcinnesdev_theme_scripts' );

/**
 * Enqueue print specific styles.
 * We'll add a separate print.css for this purpose.
 */
function mcinnesdev_theme_print_styles() {
    wp_enqueue_style( 'mcinnesdev-theme-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), MCINNESDEV_THEME_VERSION, 'print' );
}
add_action( 'wp_enqueue_scripts', 'mcinnesdev_theme_print_styles' );

// Placeholder for Custom Post Types, Taxonomies, etc.
// function mcinnesdev_theme_custom_features() {
//     // Register your 'Projects' custom post type here later
//     // register_post_type( 'project', ... );
// }
// add_action( 'init', 'mcinnesdev_theme_custom_features' );

// Placeholder for custom template tags or helper functions
// function mcinnesdev_theme_posted_on() {
//     // Your post meta display function here
// }

// Additional security hardening for your theme (good for your GitHub repo)
// For example, disable XML-RPC if not needed:
// add_filter('xmlrpc_enabled', '__return_false');