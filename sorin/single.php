<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Sorin
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
			                get_template_part('template-parts/content', 'single');

			                // If comments are open or we have at least one comment, load up the comment template.
			                if (comments_open() || get_comments_number()) :
				                comments_template();
			                endif;
		                }

	                } else {

		                // If no content, include the "No posts found" template.
		                get_template_part( 'template-parts/content', 'none' );

	                }

	                ?>
                </div>
            </div>

		</div>
	</div>
<?php
get_footer();
