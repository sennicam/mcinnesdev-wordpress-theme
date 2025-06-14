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
  
    // Enqueue your custom mobile stylesheet (loads after main)
    wp_enqueue_style( 'mcinnesdev-theme-mobile-style', get_template_directory_uri() . '/assets/css/mobile.css', array('mcinnesdev-theme-main-style'), MCINNESDEV_THEME_VERSION, 'screen and (max-width: 768px)' );

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

/**
 * Displays the post thumbnail (featured image).
 */
if ( ! function_exists( 'mcinnesdev_theme_post_thumbnail' ) ) :
    function mcinnesdev_theme_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail( 'full' ); // Display full size on single views ?>
            </div><?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail( 'post-thumbnail', array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) );
                ?>
            </a>
            <?php
        endif; // End is_singular().
    }
endif;

/**
 * Prints HTML with meta information for the current post-date/time.
 */
if ( ! function_exists( 'mcinnesdev_theme_posted_on' ) ) :
    function mcinnesdev_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $posted_on = sprintf(
            wp_kses(
                /* translators: %s: post date. */
                __( 'Posted on %s', 'mcinnesdev-theme' ),
                array(
                    'time' => array(
                        'class'    => true,
                        'datetime' => true,
                    ),
                )
            ),
            sprintf(
                '<a href="%1$s" rel="bookmark">%2$s</a>',
                esc_url( get_permalink() ),
                esc_html( get_the_date() )
            )
        );

        $byline = sprintf(
            wp_kses(
                /* translators: %s: post author. */
                __( ' by %s', 'mcinnesdev-theme' ), // Added space before 'by'
                array(
                    'span' => array(
                        'class' => true,
                    ),
                )
            ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

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