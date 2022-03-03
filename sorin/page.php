<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sorin
 */
    get_header();

?>
 <div class="sorin-main-content <?php if(is_front_page()){echo 'p-0';}?>">
    <div class="sorin-main-section">
		<?php
		$page_view = get_post_meta($post->ID, 'sorin_select_page_view', true);
		$page_layout = get_post_meta($post->ID, 'sorin_select_page_layout', true);
		if ($page_view != 'wide'):
        ?>
		<div class="container">
			<?php if ($page_layout == 'full'): ?>
				<div class="row">
				<div class="col-md-12">
			<?php endif; ?>
		<?php endif;

		if ($page_layout == 'right' || $page_layout == 'left') {
			$content_class = $page_layout == 'left' ? 'pull-right' : 'pull-left';
			if ($page_view != 'wide') {
				echo '<div class="row">';
			}
			echo '<div class="col-md-9 ' . sanitize_html_class($content_class) . '">';
		}

		if (is_active_sidebar('sidebar-1') && $page_layout == '') {
			echo '<div class="row">';
			echo '<div class="col-md-9">';
		}

		while (have_posts()) : the_post();

			get_template_part('template-parts/content', 'page');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		if ($page_layout == 'right' || $page_layout == 'left') {
			echo '</div>';
		}
		if (is_active_sidebar('sidebar-1') && $page_layout == '') {
			echo '</div>';
		}

		// page sidebar
		get_sidebar();

		if ($page_layout == 'right' || $page_layout == 'left') {
			if ($page_view != 'wide') {
				echo '</div>';
			}
		}
		if (is_active_sidebar('sidebar-1') && $page_layout == '') {
			echo '</div>';
		}

		if ($page_view != 'wide') {
			echo '</div>';
			if ($page_layout == 'full') {
				echo '</div>';
				echo '</div>';
			}
		}
		?>

    </div><!-- sorin-main-content -->
    </div><!-- sorin-main-section-->

<?php
get_footer();
