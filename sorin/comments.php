 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * sorin_comments() which is located at functions/comments-callback.php
 *
 * @package Sorin
 */
 function sorin_comments( $comment, $args, $depth ) {
				global $post;
				$author_id = $post->post_author;
				$GLOBALS['comment'] = $comment;
				switch ( $comment->comment_type ) :
					case 'pingback' :
					case 'trackback' :
						// Display trackbacks differently than normal comments. ?>
	 <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		 <div class="pingback-entry">
             <span class="pingback-heading">
                 <?php esc_html_e( 'Pingback:', 'sorin' ); ?></span>
             <?php comment_author_link(); ?></div>
		 <?php
		 break;
		 default :
		 // Proceed with normal comments. ?>
	 <li id="li-comment-<?php comment_ID(); ?>">
		 <article id="comment-<?php comment_ID(); ?>" <?php comment_class('clr'); ?>>
             <div class="media  author-photo-wrapper">
                 <div class="comment-author vcard mr-3">
                     <?php echo get_avatar( $comment, 100 ); ?>
                 </div><!-- .comment-author -->
                 <div class="media-body">
                     <div class="comment-details clr">

                         <?php if ( '0' == $comment->comment_approved ) : ?>
                             <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'sorin' ); ?></p>
                         <?php endif; ?>
                         <div class="comment-content entry clr">
                             <header class="comment-meta pl-0 pb-0 d-flex align-items-center ">
                                 <h6 class="fn m-0"><?php comment_author(); ?></h6>
                                 <span class="reply-comment ml-auto">
                                 <?php comment_reply_link( array_merge( $args, array(
                                         'reply_text' => '<i class="fa fa-reply-all"></i> Reply',
                                         'depth'      => $depth,
                                         'max_depth'	 => $args['max_depth'] )
                                 ) ); ?>
                        </span>
                             </header><!-- .comment-meta -->

                             <div class="comment-footer">
                         <span class="comment-date">
                                <?php printf( '<time datetime="%2$s">%3$s</time>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    sprintf( _x( '%1$s', '1: date', 'sorin' ), get_comment_date() )
                                ); ?> <?php esc_html_e( 'at', 'sorin' ); ?> <?php comment_time(); ?>
                        </span><!-- .comment-date -->

                             </div>
                         </div><!-- .comment-content -->


                     </div><!-- .comment-details -->

                     <div class="comment-text pt-2">
                         <?php comment_text(); ?>
                     </div>
                 </div>
             </div>


		 </article><!-- #comment-## -->
		 <?php
		 break;
		 endswitch; // End comment_type check.
		 }
// Return if password is required
if ( post_password_required() ) {
	return;
}

// Add classes to the comments main wrapper
$classes = 'comments-area clr';

if ( get_comments_number() != 0 ) {
	$classes .= ' has-comments';
}

if ( ! comments_open() && get_comments_number() < 1 ) {
	$classes .= ' empty-closed-comments';
	return;
}

?>


<section id="comments" class="comment comment-form paa-30 bg-white mat-30 <?php echo esc_attr( $classes ); ?>">
  <div class="comments-wrap">
	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) :

		// Get comments title
		$comments_number = number_format_i18n( get_comments_number() );
		if ( '1' == $comments_number ) {
			$comments_title = esc_html__( 'Comment', 'sorin' );
		} else {
			$comments_title = sprintf( esc_html__( ' %s Comments', 'sorin' ), $comments_number );
		}
		?>

		<h3 class="theme-heading comments-title pb-4">
			<span class="text"><?php echo esc_html( $comments_title ); ?></span>
		</h3>

		<ol class="comment-list">
			<?php
			// List comments
			wp_list_comments( array(
				'callback' 	=> 'sorin_comments',
				'style'     => 'ol',
				'avatar_size'=>64,
				'format'    => 'html5',
			) ); ?>
		</ol><!-- .comment-list -->

		<?php
		// Display comment navigation - WP 4.4.0
		if ( function_exists( 'the_comments_navigation' ) ) :

			the_comments_navigation( array(
				'prev_text' => '<i class="fa fa-angle-left"></i>'. esc_html__( 'Previous', 'sorin' ),
				'next_text' => esc_html__( 'Next', 'sorin' ) .'<i class="fa fa-angle-right"></i>',
			) );

		elseif ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<div class="comment-navigation clr">
				<?php paginate_comments_links( array(
					'prev_text' => '<i class="fa fa-angle-left"></i>'. esc_html__( 'Previous', 'sorin' ),
					'next_text' => esc_html__( 'Next', 'sorin' ) .'<i class="fa fa-angle-right"></i>',
				) ); ?>
			</div>

		<?php endif; ?>

		<?php
		// Display comments closed message
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'sorin' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
</div>
<div class="comment-form-wrap">
	<?php
    function comment_form_hidden_fields()
    {
        comment_id_fields();
        if ( current_user_can( 'unfiltered_html' ) )
        {
            wp_nonce_field( 'unfiltered-html-comment_' . get_the_ID(), '_wp_unfiltered_html_comment', false );
        }
    }
?>

    <div class="title">
        <h3>Leave a comment</h3>
    </div>
    <div class="comment-form-inner" >
     <?php if(comments_open()):?>
      <form id="commentform" class="comment-form" action="<?php echo site_url('/wp-comments-post.php') ?>" method="post">
        <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span></p>
			<div class="form-collection">
				<?php if ( is_user_logged_in() ) : ?>
					<p>
						<span class="field-hint">Logged in as <?php echo get_user_option('user_nicename') ?></span>
					</p>
				<?php else : ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="author" id="author" required placeholder="<?php echo esc_html__(' Name', 'sorin');?>">
                            </div>
                            <div class="col">
                                <input type="email" class="form-control"   name="email" id="email" required  placeholder="<?php echo esc_html__(' Email', 'sorin');?>">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control"   name="url" id="rul" required placeholder="<?php echo esc_html__(' Website', 'sorin');?>" >
                            </div>
                        </div>
                    </div>
				<?php endif ?>
                <div class="form-group pt-2">
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control w-100" required  placeholder="<?php echo esc_html__('Message', 'sorin');?>"></textarea>
                </div>
                <div class="form-group pat-15 m-0">
                    <button type="submit" name="submit" class="btn btn-primary submit">Post Comment</button>
                    <?php comment_form_hidden_fields() ?>
                </div>
			</div>
</form>
     <?php endif;?>
    </div>

</div>
</section><!-- #comments -->