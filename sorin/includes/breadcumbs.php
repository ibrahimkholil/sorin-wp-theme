<?php
/*-----------------------------------------------*
  Page breadcrumb 
/*-----------------------------------------------*/


if (!function_exists('srBreadcumbs')) {
	function srBreadcumbs($delimiter) {
		ob_start();
		$home = esc_html__('Home', 'sorin');
		global $post;
		$homeLink = home_url('/');
		if( is_home() ){
			esc_html__('Home', 'sorin');
		}else{
			echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		}
		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
			echo '<span class="current">' . esc_html__('Archive by category: ', 'sorin') . single_cat_title('', false) . '</span>';
		} elseif ( is_search() ) {
			echo '<span class="current">' . esc_html__('Search results for: ', 'sorin') . get_search_query() . '</span>';
		} elseif ( is_day() ) {
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F').' '. get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<span class="current">' . get_the_time('d') . '</span>';
		} elseif ( is_month() ) {
			echo '<span class="current">' . get_the_time('F'). ' '. get_the_time('Y') . '</span>';
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				if(get_post_type() == 'portfolio'){
					$terms = get_the_terms(get_the_ID(), 'project-type', '' , '' );
					if($terms) {
						the_terms(get_the_ID(), 'project-type', '' , ', ' );
						echo ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
					}else{
						echo '<span class="current">' . get_the_title() . '</span>';
					}
				}elseif(get_post_type() == 'team'){
					echo '<span class="current">' . get_the_title() . '</span>';
				}elseif(get_post_type() == 'testimonials'){
					echo '<span class="current">' . get_the_title() . '</span>';
				}elseif(get_post_type() == 'product'){
					$terms = get_the_terms(get_the_ID(), 'product_cat', '' , '' );
					if($terms) {
						the_terms(get_the_ID(), 'product_cat', '' , ', ' );
						echo ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
					}else{
						echo '<span class="current">' . get_the_title() . '</span>';
					}
				}else{
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					echo ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
				}
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo ''.$cats;
				echo '<span class="current">' . get_the_title() . '</span>';
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			if($post_type) echo '<span class="current">' . $post_type->labels->singular_name . '</span>';
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			echo ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
		} elseif ( is_page() && !$post->post_parent ) {
			echo '<span class="current">' . get_the_title() . '</span>';
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo ''.$breadcrumbs[$i];
				if ($i != count($breadcrumbs) - 1)
					echo ' ' . $delimiter . ' ';
			}
			echo ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
		} elseif ( is_tag() ) {
			echo '<span class="current">' . esc_html__('Posts tagged: ', 'sorin') . single_tag_title('', false) . '</span>';
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo '<span class="current">' . esc_html__('Articles posted by ', 'sorin') . $userdata->display_name . '</span>';
		} elseif ( is_404() ) {
			echo '<span class="current">' . esc_html__('Error 404', 'sorin') . '</span>';
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo ' '.esc_html__('Page', 'sorin') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		return ob_get_clean();
	}
}