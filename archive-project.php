<?php
/**
 * The template for displaying Project archives
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
		<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title">
				<?php
				if ( is_post_type_archive() ) {
				  post_type_archive_title();
				} elseif ( is_tax() ) { // For taxonomy archives like /technology/php/
				  single_term_title();
				} else {
				  esc_html_e( 'Portfolio', 'mcinnesdev-theme' );
				}
				?>
			</h1>
			<?php
			// Optional: Display a description for the archive if set in WP Admin
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>
		<div class="projects-grid">
			<?php
			/* Start the Loop */
			while ( have_posts() ):
			  the_post();

			/*
			 * We'll reuse the content-preview template part for project previews.
			 * You might want to create 'template-parts/content-project-preview.php'
			 * if projects need a very different preview layout than posts.
			 */
			get_template_part( 'template-parts/content', 'preview' );

			endwhile;
			?>
		</div>
		<?php
		the_posts_navigation();

		else :

		  get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</main>
</div>
<?php
get_footer();
