<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sorin
 */


if (is_active_sidebar('sidebar-1')) {
	?>
    <aside class="col-md-3">
		<?php dynamic_sidebar('sidebar-1'); ?>
    </aside>
	<?php
}