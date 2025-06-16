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
    'footer' => esc_html__( 'Footer Menu', 'mcinnesdev-theme' ),
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
    'height' => 250,
    'width' => 250,
    'flex-width' => true,
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
  wp_enqueue_style( 'mcinnesdev-theme-mobile-style', get_template_directory_uri() . '/assets/css/mobile.css', array( 'mcinnesdev-theme-main-style' ), MCINNESDEV_THEME_VERSION, 'screen and (max-width: 768px)' );

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
if ( !function_exists( 'mcinnesdev_theme_post_thumbnail' ) ):
  function mcinnesdev_theme_post_thumbnail() {
    if ( post_password_required() || is_attachment() || !has_post_thumbnail() ) {
      return;
    }

    if ( is_singular() ) :
      ?>
<div class="post-thumbnail">
	<?php the_post_thumbnail( 'full' ); // Display full size on single views ?>
</div>
<?php else : ?>
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
if ( !function_exists( 'mcinnesdev_theme_posted_on' ) ):
  function mcinnesdev_theme_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }
    
    $prefix = 'Posted on';
    if( 'project' == get_post_type() ) $prefix = 'Completed on';

    $posted_on = sprintf(
      wp_kses(
        /* translators: %s: post date. */
        __( $prefix.' %s', 'mcinnesdev-theme' ),
        array(
          'time' => array(
            'class' => true,
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

    $byline = ''; // ToDO: theme setting? Remove byline

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

  }
endif;

/**
 * Register the 'Project' Custom Post Type.
 */
function mcinnesdev_theme_register_project_cpt() {
  $labels = array(
    'name' => _x( 'Projects', 'Post Type General Name', 'mcinnesdev-theme' ),
    'singular_name' => _x( 'Project', 'Post Type Singular Name', 'mcinnesdev-theme' ),
    'menu_name' => __( 'Projects', 'mcinnesdev-theme' ),
    'name_admin_bar' => __( 'Project', 'mcinnesdev-theme' ),
    'archives' => __( 'Project Archives', 'mcinnesdev-theme' ),
    'attributes' => __( 'Project Attributes', 'mcinnesdev-theme' ),
    'parent_item_colon' => __( 'Parent Project:', 'mcinnesdev-theme' ),
    'all_items' => __( 'All Projects', 'mcinnesdev-theme' ),
    'add_new_item' => __( 'Add New Project', 'mcinnesdev-theme' ),
    'add_new' => __( 'Add New', 'mcinnesdev-theme' ),
    'new_item' => __( 'New Project', 'mcinnesdev-theme' ),
    'edit_item' => __( 'Edit Project', 'mcinnesdev-theme' ),
    'update_item' => __( 'Update Project', 'mcinnesdev-theme' ),
    'view_item' => __( 'View Project', 'mcinnesdev-theme' ),
    'view_items' => __( 'View Projects', 'mcinnesdev-theme' ),
    'search_items' => __( 'Search Project', 'mcinnesdev-theme' ),
    'not_found' => __( 'Not found', 'mcinnesdev-theme' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'mcinnesdev-theme' ),
    'featured_image' => __( 'Project Image', 'mcinnesdev-theme' ),
    'set_featured_image' => __( 'Set project image', 'mcinnesdev-theme' ),
    'remove_featured_image' => __( 'Remove project image', 'mcinnesdev-theme' ),
    'use_featured_image' => __( 'Use as project image', 'mcinnesdev-theme' ),
    'insert_into_item' => __( 'Insert into project', 'mcinnesdev-theme' ),
    'uploaded_to_this_item' => __( 'Uploaded to this project', 'mcinnesdev-theme' ),
    'items_list' => __( 'Projects list', 'mcinnesdev-theme' ),
    'items_list_navigation' => __( 'Projects list navigation', 'mcinnesdev-theme' ),
    'filter_items_list' => __( 'Filter projects list', 'mcinnesdev-theme' ),
  );
  $args = array(
    'label' => __( 'Project', 'mcinnesdev-theme' ),
    'description' => __( 'Portfolio projects for McInnes.Dev', 'mcinnesdev-theme' ),
    'labels' => $labels,
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ), // Add excerpt for previews
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5, // Just below Posts
    'menu_icon' => 'dashicons-media-code', // A suitable icon
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true, // Important for your portfolio archive page
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'show_in_rest' => true, // Enable for Gutenberg editor and REST API
  );
  register_post_type( 'project', $args );
}
add_action( 'init', 'mcinnesdev_theme_register_project_cpt', 0 );

/**
 * Register 'Technologies' Custom Taxonomy for Projects.
 */
function mcinnesdev_theme_register_technologies_taxonomy() {
  $labels = array(
    'name' => _x( 'Technologies', 'Taxonomy General Name', 'mcinnesdev-theme' ),
    'singular_name' => _x( 'Technology', 'Taxonomy Singular Name', 'mcinnesdev-theme' ),
    'menu_name' => __( 'Technologies', 'mcinnesdev-theme' ),
    'all_items' => __( 'All Technologies', 'mcinnesdev-theme' ),
    'parent_item' => __( 'Parent Technology', 'mcinnesdev-theme' ),
    'parent_item_colon' => __( 'Parent Technology:', 'mcinnesdev-theme' ),
    'new_item_name' => __( 'New Technology Name', 'mcinnesdev-theme' ),
    'add_new_item' => __( 'Add New Technology', 'mcinnesdev-theme' ),
    'edit_item' => __( 'Edit Technology', 'mcinnesdev-theme' ),
    'update_item' => __( 'Update Technology', 'mcinnesdev-theme' ),
    'view_item' => __( 'View Technology', 'mcinnesdev-theme' ),
    'separate_items_with_commas' => __( 'Separate technologies with commas', 'mcinnesdev-theme' ),
    'add_or_remove_items' => __( 'Add or remove technologies', 'mcinnesdev-theme' ),
    'choose_from_most_used' => __( 'Choose from the most used', 'mcinnesdev-theme' ),
    'popular_items' => __( 'Popular Technologies', 'mcinnesdev-theme' ),
    'search_items' => __( 'Search Technologies', 'mcinnesdev-theme' ),
    'not_found' => __( 'Not Found', 'mcinnesdev-theme' ),
    'no_terms' => __( 'No technologies', 'mcinnesdev-theme' ),
    'items_list' => __( 'Technologies list', 'mcinnesdev-theme' ),
    'items_list_navigation' => __( 'Technologies list navigation', 'mcinnesdev-theme' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => false, // Like tags, not categories
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => false,
    'show_in_rest' => true, // For Gutenberg
  );
  register_taxonomy( 'technology', array( 'project' ), $args ); // Associate with 'project' CPT
}
add_action( 'init', 'mcinnesdev_theme_register_technologies_taxonomy', 0 );

/**
 * Sets the number of posts per page for the 'technology' taxonomy archive.
 */
function mcinnesdev_theme_set_technology_archive_posts_per_page( $query ) {
  // Ensure we are modifying the main query on the front end,
  // and specifically for the 'technology' taxonomy archive.
  if ( $query->is_main_query() && !is_admin() && $query->is_tax( 'technology' ) ) {
    $query->set( 'posts_per_page', 9 ); // 3 columns * 3 rows = 9 posts
  }
}
add_action( 'pre_get_posts', 'mcinnesdev_theme_set_technology_archive_posts_per_page' );
