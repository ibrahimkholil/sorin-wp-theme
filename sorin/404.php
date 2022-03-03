<?php
/**
 * 404 page
 * @package sorin
 * @since 1.0.0
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
	?>

	<div class="page-404 text-center">
		<h1 class="secondary-txt">404</h1>
		<h5 class="secondary-txt-highlight">Looks Like you're Lost</h5>
		<p>We can't seems to find the page you're looking for</p>
		<div class="btn primary tabby-block-btn">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?> ">Back to Home</a>
		</div>
	</div>
	<?php
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
