<?php
/**
 * The template for displaying all single 'Project' posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		while ( have_posts() ):
		  the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>
			<?php mcinnesdev_theme_post_thumbnail(); ?>
			<div class="entry-content">
				<?php
				// Display the main content of the project (your detailed description)
				the_content(
				  sprintf(
				    wp_kses(
				      /* translators: %s: Name of current post. Only visible to screen readers */
				      __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mcinnesdev-theme' ),
				      array(
				        'span' => array(
				          'class' => array(),
				        ),
				      )
				    ),
				    wp_kses_post( get_the_title() )
				  )
				);

				// Display 'Technologies' taxonomy terms
				$terms = get_the_terms( get_the_ID(), 'technology' );
				if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
				  echo '<div class="project-technologies">';
				  echo '<h3>' . esc_html__( 'Technologies Used:', 'mcinnesdev-theme' ) . '</h3>';
				  echo '<ul class="technology-list">';
				  foreach ( $terms as $term ) {
				    echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
				  }
				  echo '</ul>';
				  echo '</div>';
				}

				// Placeholder for custom fields (e.g., project URL, GitHub link, role)
				// You'll want to add ACF fields here later if you don't use the default custom fields.
				// Example: if ( get_field( 'project_url' ) ) { ... }
				?>
			</div>
			<footer class="entry-footer">
				<?php
				// You can add navigation to next/previous project here
				the_post_navigation(
				  array(
				    'next_text' => '<span class="meta-nav">' . esc_html__( 'Next Project', 'mcinnesdev-theme' ) . '</span> ' .
				    '<span class="post-title">%title</span>',
				    'prev_text' => '<span class="meta-nav">' . esc_html__( 'Previous Project', 'mcinnesdev-theme' ) . '</span> ' .
				    '<span class="post-title">%title</span>',
				  )
				);
				?>
			</footer>
		</article>
		<?php
		endwhile; // End of the loop.
		?>
	</main>
</div>
<?php
get_footer();
