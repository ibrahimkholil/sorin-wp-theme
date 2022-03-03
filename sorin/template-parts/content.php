<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sorin
 */

global $themeContent;

if (!(isset($content_column_class) && '' != $content_column_class)) {
	$content_column_class = 'col-md-6';
}
?>
<div class="<?php echo esc_html($content_column_class) ?>">
    <div class="soirn-blog-item">
        <?php
        $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
        $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'sorin-post');
        $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
        if ($post_thumbnail_src) {
            ?>
            <figure>
                <div class="sorin-date">
                    <?php echo date('d M', strtotime(get_the_date())) ?>
                </div>
                <a title="<?php echo esc_html(get_the_title(get_the_ID())); ?>" href="<?php echo esc_url(get_permalink(get_the_ID())) ?>">
                    <img class="img-fluid" src="<?php echo esc_url($post_thumbnail_src) ?>" alt="">
                </a>
                <?php
                if (is_sticky(get_the_ID())) {
                    ?>
                    <a class="sorin-featured-post"><?php esc_html_e('Featured Post', $config->textDomain) ?></a>
                    <?php
                }
                ?>
            </figure>
            <?php
        }
        ?>
        <div class="sorin-blog-medium-text">
        <h5><a href="<?php echo esc_url(get_permalink(get_the_ID())) ?>"><?php echo wp_trim_words(get_the_title(get_the_ID()), 7, '...'); ?></a>
			<?php echo (is_sticky() ? '<span class="sticky-post">' . esc_html__('Featured', $config->textDomain) : '') . '</span>' ?></h5>
            <ul class="sorin-post-info ">
                <li> <i class="fa fa-user"></i> <?php the_author_posts_link(); ?> </li>
                <li> <i class="fa fa-list-alt" ></i><?php echo get_the_category_list(',');?></li>
                <li><a href="<?php comments_link(); ?>"><i class="fa fa-comment"></i><?php echo comments_number('0 Comment', '1 Comment', '% Comments'); ?></a></li>
            </ul>
        <div class="sorin-post-text">
            <?php echo esc_attr($themeContent->sorinExcerpt(30, false, false)); ?>
        </div>
        <a href="<?php echo esc_url(get_permalink(get_the_ID())) ?>" class="sorin-readmore-btn">
			<?php echo esc_html__('Read More', $config->textDomain); ?> <span></span>
        </a>
		<?php
		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__('Edit %s', $config->textDomain), the_title('<span class="screen-reader-text">"', '"</span>', false)
			), '<div class="edit-link">', '</div>'
		);
		?>
    </div>
    </div>
</div>
