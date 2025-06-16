<?php
/**
 * Template part for displaying post previews in lists (e.g., Recent Posts section).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package McInnesDev_Theme
 * @since 1.0.0
 */

$post_type_obj = get_post_type_object( get_post_type() );
$post_type_name = $post_type_obj ? $post_type_obj->labels->singular_name : 'Content';

// --- Start Tag/Category Display Logic ---
$post_id = get_the_ID();
$terms_output = '';
$terms_to_collect = array();

// Get all *publicly queryable* taxonomies associated with the current post type
// We get the 'objects' to check properties like 'public' and 'show_ui'
$taxonomies = get_object_taxonomies( get_post_type(), 'objects' );

foreach ( $taxonomies as $taxonomy_obj ) {
  // Skip internal, format, or private taxonomies
  if ( $taxonomy_obj->name === 'post_format' || !$taxonomy_obj->public || !$taxonomy_obj->show_ui ) {
    continue;
  }

  $terms = get_the_terms( $post_id, $taxonomy_obj->name );
  if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
      if($term->name !== 'Uncategorized') {
        // Add term name, preventing duplicates by using array_unique later
        $terms_to_collect[] = $term;
      }
    }
  }
}

$prefix = esc_html( $post_type_obj ? strtoupper( $post_type_obj->labels->singular_name ) : 'CONTENT' );

if ( !empty( $terms_to_collect ) ) {
	// Remove duplicates and sort for consistent output (e.g., [Unity] [VR] instead of [VR] [Unity])
//  $terms_to_collect = array_unique( $terms_to_collect );
//  sort( $terms_to_collect );

  $prefix .= ' > ';

  // Format each term with square brackets
  $formatted_terms = array_map( function ( $term ) {
    $link = esc_url( get_term_link( $term->term_id, $term->taxonomy ) );
    $name = esc_html($term->name);
    return '<a href="'.$link.'" class="post-preview-tag">'.$name.'</a>';
  }, $terms_to_collect );

}
// Combine prefix and formatted terms
$terms_output = $prefix . (isset($formatted_terms) && is_array($formatted_terms) ? implode( ' ', $formatted_terms ) : '');
// --- End Tag/Category Display Logic ---
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-preview' ); ?>>
	<?php
	if ( 'post3' !== get_post_type() ) { // Intentionally changed to show posts again... ToDo: remove this?
	  ?>
	<span class="post-type-tag"> <?php echo $terms_output; ?> </span>
	<?php
	} // endif
	?>
	<header class="entry-header">
		<?php
		// Always use an H3 for the title in a preview list context
		the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

//		if ( 'post' === get_post_type() ):
		  ?>
		<div class="entry-meta">
			<?php
			// Display post meta (date, author, etc.)
			// We'll create a helper function for this in functions.php shortly
			mcinnesdev_theme_posted_on();
			?>
		</div>
		<?php //endif; ?>
	</header>
  
	<?php mcinnesdev_theme_post_thumbnail(); ?>
	<div class="entry-summary">
		<?php
		// Display the post excerpt (short summary)
		the_excerpt();
		?>
	</div>
	<footer class="entry-footer"> <a href="<?php the_permalink(); ?>" class="read-more-link">
		<?php esc_html_e( 'Read More &raquo;', 'mcinnesdev-theme' ); ?>
		</a>
		<?php
		// Optional: display categories/tags here if desired
		// mcinnesdev_theme_entry_footer();
		?>
	</footer>
</article>
