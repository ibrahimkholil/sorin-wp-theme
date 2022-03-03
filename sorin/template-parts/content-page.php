<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage sorin
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sorin'),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->
    <footer class="entry-footer">
	    <?php
	    edit_post_link(
		    sprintf(
		    /* translators: %s: Name of current post */
			    esc_html__( 'Edit %s', 'sorin' ),
			    the_title( '<span class="screen-reader-text">"', '"</span>', false )
		    ),
		    '<span class="edit-link">',
		    '</span>'
	    );
	    ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-${ID} -->
