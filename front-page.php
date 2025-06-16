<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
      // Check if there's a page assigned as the static front page
      if ( have_posts() ) :
        while ( have_posts() ) :
          the_post(); // Load the content of the assigned "Front Page"

          // This will display the content of the page you set as "Front Page" in Settings > Reading
          the_content();

          // Display recent blog posts AND projects
          $recent_posts = new WP_Query( array(
            'posts_per_page' => 3, // Still display 3 items
            'post_type'      => array( 'post', 'project' ), // <-- IMPORTANT CHANGE: Include 'post' and 'project'
            'order'          => 'DESC', // Order by date, newest first
            'orderby'        => 'date',
          ) );
          // display recent blog posts here
//          $recent_posts = new WP_Query( array( 'posts_per_page' => 3 ) );
          if ( $recent_posts->have_posts() ) {
            echo '<section class="recent-posts"><h2>Recent Insights</h2>';
            echo '<div class="posts-grid">';
            while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
              get_template_part( 'template-parts/content', 'preview' );
            endwhile;
            echo '</div></section>';
            wp_reset_postdata();
          }
        endwhile; // End of the loop.
      else :
        get_template_part( 'template-parts/content', 'none' );
      endif;
        ?>

    </main></div><?php
get_footer();