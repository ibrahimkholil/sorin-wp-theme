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

if (!(isset($content_column_class) && '' != $content_column_class)) {
	$content_column_class = 'col-md-6';
}
?>
<div class="<?php echo esc_html($content_column_class); ?>">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if(!is_front_page()):?>
	<header class="entry-header">
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
	<?php
      the_post_thumbnail(array('medium'));
    ?>

	<div class="entry-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->

</article><!-- #post-${ID} -->
</div>