<?php

/**
 * Template part for displaying social share.
 * Available sites are gmail,facebook,twitter,g-plus,linkedin,pinterest
 * 
 * @package Sorin
 */
 
	if( has_post_thumbnail() ){
		$share_image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
		$share_image= $share_image[0];
		$share_image_portrait= wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
		$share_image_portrait= $share_image_portrait[0];
	}else{
		$share_image= '';
		$share_image_portrait= '';
	}
	$share_excerpt = strip_tags( get_the_excerpt(), '<b><i><strong><a>' );

?>

	<div class="social-follow-wrap float-right">
        <span><i class="fa fa-share-alt"></i>Share:</span>
		<ul class="social-follow post">
			<li class="share-post">
				<a title="<?php _e( 'Email', $config->textDomain  ); ?>" class="post-email" href="mailto:?subject=<?php echo ( rawurlencode( get_the_title() ) ); ?>&amp;body=<?php echo ( rawurlencode ( $share_excerpt . ' ' . get_the_permalink() ) ); ?>">
				<i class="fa fa-envelope"></i></a>
			</li>
			
			<li class="share-post">
				<a title="<?php _e( 'Facebook', $config->textDomain  ); ?>" class="popup-share facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo( rawurlencode( get_the_permalink() ) ); ?>">
				<i class="fab fa-facebook-f"></i></a>
			</li>
			
			<li class="share-post">
				<a title="<?php _e( 'Twitter', $config->textDomain  ); ?>" class="popup-share twitter" target="_blank"  href="http://twitter.com/intent/tweet?text=<?php echo( rawurlencode( get_the_title() ) ); ?>&amp;url=<?php echo( rawurlencode( get_the_permalink() ) ); ?>">
				<i class="fab fa-twitter"></i></a>
			</li>
			
			<li class="share-post">
				<a title="<?php _e( 'Pinterest', $config->textDomain  ); ?>" class="popup-share pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo( rawurlencode( get_the_permalink() ) ); ?>&amp;media=<?php echo ( rawurlencode( $share_image_portrait ) ); ?>&amp;description=<?php echo( rawurlencode( get_the_title() ) ); ?>">
				<i class="fab fa-pinterest-p"></i></a>
			</li>
			
			<li class="share-post">
				<a title="<?php _e( 'Google+', $config->textDomain  ); ?>" class="popup-share google-plus" target="_blank" href="https://plus.google.com/share?url=<?php echo( rawurlencode( get_the_permalink() ) ); ?>">
				<i class="fab fa-google-plus-g"></i></a>
			</li>
			
			<li class="share-post">
				<a title="<?php _e( 'LinkedIn', $config->textDomain  ); ?>" class="popup-share linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo( rawurlencode( get_the_permalink() ) ); ?>&amp;title=<?php echo( rawurlencode( get_the_title() ) ); ?>&amp;summary=<?php echo ( rawurlencode ( $share_excerpt ) );?>&amp;source=<?php echo ( rawurlencode( get_bloginfo('name') ) );?>">
				<i class="fab fa-linkedin-in"></i></a>
			</li>

			<li class="share-post">
				<a title="<?php _e( 'Tumblr', $config->textDomain  ); ?>" class="popup-share Tumblr" target="_blank" href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo( rawurlencode( get_the_permalink() ) ); ?>&amp;title=<?php echo( rawurlencode( get_the_title() ) ); ?>&amp;caption=<?php echo ( rawurlencode ( $share_excerpt ) );?>&amp;source=<?php echo ( rawurlencode( get_bloginfo('name') ) );?>">
				<i class="fab fa-tumblr"></i></a>
			</li>
		</ul>
	</div>
	
