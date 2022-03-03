<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sorin
 */

if ( ! function_exists( 'sorin_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sorin_posted_on() {
	?>
	<ul class="sorin-post-meta-options">
        <li>
            <i aria-hidden="true" class="fa fa-calendar"></i>
            <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())) ?>"><?php echo get_the_date() ?></time>
        </li>
        <li>
            <?php esc_html_e('by', 'sorin') ?>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php echo get_the_author() ?></a>
        </li>
        <?php
		$categories_list = get_the_term_list(get_the_ID(), 'category', '<li>' . esc_html__('in ', 'sorin'), ', ', '</li>');
		if ($categories_list) {
			printf('%1$s', $categories_list);
		}
		?>
    </ul>
    <?php
}
endif;

if ( ! function_exists( 'sorin_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function sorin_entry_footer($tags = true) {
	// Hide category and tag text for pages.
	echo '<footer class="sorin-post-footer">';
	
	if ( true === $tags ) {
		if ( 'post' === get_post_type() ) {
			
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'sorin' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sorin' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
				comments_popup_link('<i class="fa fa-comments"></i> ' . get_comments_number(), '<i class="fa fa-comments"></i> ' . get_comments_number(), '<i class="fa fa-comments"></i> ' . get_comments_number(), 'sorin-colorhover');
			echo '</span>';
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'sorin' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
	
	echo '</footer>';
}
endif;


if (!function_exists('sorin_next_prev_custom_links')) {

	/**
	 * Next previous links for detail pages
	 * @return links
	 */
	function sorin_next_prev_custom_links($post_type = 'post') {
		global $post;
		$previd = $nextid = '';
		$post_type = get_post_type($post->ID);
		$count_posts = wp_count_posts("$post_type")->publish;
		$sorin_postlist_args = array(
			'posts_per_page' => -1,
			'order' => 'ASC',
			'post_type' => "$post_type",
		);
		$sorin_postlist = get_posts($sorin_postlist_args);
		$ids = array();
		foreach ($sorin_postlist as $sorin_thepost) {
			$ids[] = $sorin_thepost->ID;
		}
		$thisindex = array_search($post->ID, $ids);
		if (isset($ids[$thisindex - 1])) {
			$previd = $ids[$thisindex - 1];
		}
		if (isset($ids[$thisindex + 1])) {
			$nextid = $ids[$thisindex + 1];
		}

		if (!empty($previd) || !empty($nextid)) {

			if ((isset($previd) && !empty($previd)) || (isset($nextid) && !empty($nextid))) {
				?>
                <div class="sorin-prenxt-post">
                    <ul>
						<?php
						if (isset($previd) && !empty($previd)) {
							?>
                            <li>
                                <div class="sorin-prev-post">
                                    <span></span>
                                    <h3 class="text-right"><a href="<?php echo esc_url(get_permalink($previd)) ?>"><?php echo wp_trim_words(get_the_title($previd), 6, '...') ?></a></h3>
                                    <a class="d-block text-right sorin-post-arrow" href="<?php echo esc_url(get_permalink($previd)) ?>" class="sorin-post-arrow"><i class="fa fa-angle-double-left"></i> <?php echo esc_html__('Previous Post', 'sorin'); ?></a>
                                </div>
                            </li>
							<?php
						}

						if (isset($nextid) && !empty($nextid)) {
							?>
                            <li>
                                <div class="sorin-next-post">
                                    <span></span>
                                    <h3><a href="<?php echo esc_url(get_permalink($nextid)) ?>"><?php echo wp_trim_words(get_the_title($nextid), 6, '...') ?></a></h3>
                                    <a href="<?php echo esc_url(get_permalink($nextid)) ?>" class="sorin-post-arrow d-block"><i class="fa fa-angle-double-right"></i> <?php echo esc_html__('Next Post', 'sorin'); ?></a>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>
                </div>
				<?php
			}
		}
	}

}