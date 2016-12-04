<?php
/**
 * List comments html.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div class="comment-node" id="comment-<?php comment_ID(); ?>">
		<div class="comment-controls">
			<?php comment_reply_link( array_merge( $args, array(
				'depth'     => $depth,
				'max_depth' => $args['max_depth']
			) ) ) ?>
		</div>
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, $size = 40 ) ?>
			<div class="fn comment-author-name"><?php echo get_comment_author_link() ?></div>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<span class="comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'arras' ) ?></span>
		<?php endif; ?>
		<div class="comment-meta commentmetadata">
			<?php printf( __( 'Posted %1$s at %2$s', 'arras' ), '<abbr class="comment-datetime" title="' . get_comment_time( __( 'c', 'arras' ) ) . '">' . get_comment_time( __( 'F j, Y', 'arras' ) ), get_comment_time( __( 'g:i A', 'arras' ) ) . '</abbr>' ); ?>
		</div>
		<div class="comment-content"><?php comment_text() ?></div>
	</div>