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
<div class="sorin-single-post">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="single-post-thumb">
	        <?php
	        $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
	        $post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'sorin-large');
	        $post_thumbnail_src = isset($post_thumbnail_image[0]) && esc_url($post_thumbnail_image[0]) != '' ? $post_thumbnail_image[0] : '';
	        if ($post_thumbnail_src) {
		        ?>
                <figure>
                    <div class="sorin-date">
				        <?php echo date('d M', strtotime(get_the_date())) ?>
                    </div>
                    <img class="img-fluid" src="<?php echo esc_url($post_thumbnail_src) ?>" alt="">
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
        <ul class="sorin-post-info py-3">
            <li> <i class="fa fa-user"></i> <?php the_author_posts_link(); ?> </li>
           <li> <i class="fa fa-list-alt" ></i><?php echo get_the_category_list(',');?></li>
            <li><a href="<?php comments_link(); ?>"><i class="fa fa-comment"></i><?php echo comments_number('0 Comment', '1 Comment', '% Comments'); ?></a></li>
        </ul>
		<?php if(!is_front_page()):?>
            <header class="sorin-single-entry-header">
				<?php
				if ( is_sticky() && is_home() && ! is_paged() ) {
					printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', $config->textDomain ) );
				}
				if ( is_singular()) :
					the_title( '<h1 class="entry-title single">', '</h1>' );
				else :
					the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				endif;
				?>
            </header><!-- .entry-header -->
		<?php endif;?>
        <div class="entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', $config->textDomain),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', $config->textDomain ),
					'after'  => '</div>',
				)
			);
			?>
        </div><!-- .entry-content -->
        <div class="sorin-post-footer">

	                <?php
	                // tags list
	                $tags_list = get_the_term_list(get_the_ID(), 'post_tag', '<div class="sorin-tags float-left"><span><i class="fa fa-tags"></i>' . esc_html__('Tags:', $config->textDomain) . '</span>', ', ', '</div>');
	                if ($tags_list) {
		                printf('%1$s', $tags_list);
	                }
	                ?>
	                <?php
	                //social share
	                get_template_part( 'template-parts/content','share' );
	                ?>


        </div>
        <div class="post-navigation">
            <?php sorin_next_prev_custom_links();?>
        </div>

    </article><!-- #post-${ID} -->
</div><!-- single post -->
