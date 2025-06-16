<?php
/**
 * The template for displaying 'technology' taxonomy archives.
 *
 * This template will be used for URLs like /technology/ and /technology/vr/
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

get_header(); // Includes your theme's header.php file
?>

    <main id="primary" class="site-main">

        <header class="page-header">
            <?php
            // Displays the archive title (e.g., "Technology: VR" or "Technologies")
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            // Displays the archive description if set in WordPress admin
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header><?php if ( have_posts() ) : ?>

            <div class="technology-archive-grid">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * This is the same 'content-preview.php' you've been working on.
                     */
                    get_template_part( 'template-parts/content', 'preview' );

                endwhile;
                ?>
            </div><?php
            // Pagination links
            the_posts_pagination( array(
                'prev_text'          => __( 'Previous', 'mcinnesdev-theme' ),
                'next_text'          => __( 'Next', 'mcinnesdev-theme' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mcinnesdev-theme' ) . ' </span>',
            ) );

        else :

            // If no posts are found, include the 'content-none.php' template part
            get_template_part( 'template-parts/content', 'none' );

        endif; ?>

    </main><?php
//get_sidebar(); // If your theme has a sidebar (remove if not)
get_footer(); // Includes your theme's footer.php file