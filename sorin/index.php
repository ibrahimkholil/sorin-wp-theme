<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage sorin
 * @since 1.0.0
 */

get_header();
?>
<div class="sorin-main-content">
	<div class="sorin-main-section">
        <div class="container">
            <div class="row">
	            <?php
	            if ( have_posts() ) {

		            // Load posts loop.
		            while ( have_posts() ) {
			            the_post();
			            get_template_part( 'template-parts/content' );
		            }
	            } else {

		            // If no content, include the "No posts found" template.
		            get_template_part( 'template-parts/content', 'none' );

	            }

	            ?>
            </div>
            <div class="row">
                <div class="col-12">
			        <?php  $srpaginations->srPaginations();?>
                </div>
            </div>
        </div>
	</div>
</div>

<?php
get_footer();
