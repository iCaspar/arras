<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( __( 'Please do not load this page directly. Thanks!', 'arras' ) );
}

if ( post_password_required() ) { ?>
	<div class="comments">
		<h4 class="comments-title module-title"><?php _e( 'Password Required', 'arras' ) ?></h4>
		<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'arras' ); ?></p>
	</div>
	<?php return;
}


$comments_by_type = separate_comments( $comments ); ?>

<div class="comments">

	<?php if ( have_comments() ) : ?>
		<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>
			<h4 class="comments-title module-title"><?php comments_number( __( 'No Comments', 'arras' ), __( '1 Comment', 'arras' ), _n( '% Comment', '% Comments', get_comments_number(), 'arras' ) ); ?></h4>
			<ul id="commentlist" class="comment-list clearfix">
				<?php wp_list_comments( 'type=comment&callback=arras_list_comments' ); ?>
			</ul>
		<?php endif; ?>

		<div class="comments-navigation clearfix">
			<?php echo str_replace( '\\n', '', paginate_comments_links( [ 'echo' => false ] ) ); ?>
		</div>

		<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
			<h4 class="comments-title module-title"><?php _e( 'Trackbacks / Pings', 'arras' ) ?></h4>
			<ul class="pingback-list pingbacks"><?php wp_list_comments( 'type=pings&callback=arras_list_trackbacks' ); ?></ul>
		<?php endif; ?>

	<?php else: ?>

		<?php if ( 'open' == $post->comment_status ) : ?>
			<h4 class="comments-title module-title"><?php _e( 'No Comments', 'arras' ) ?></h4>
			<p class="nocomments"><?php _e( 'Start the ball rolling by posting a comment on this article!', 'arras' ) ?></p>
		<?php endif ?>

	<?php endif; ?>

	<?php if ( 'closed' == $post->comment_status ) : if ( ! is_page() ) : ?>
		<h4 class="comments-title module-title"><?php _e( 'Comments Closed', 'arras' ) ?></h4>
		<p class="nocomments"><?php _e( 'Comments are closed. You will not be able to post a comment in this post.', 'arras' ) ?></p>
	<?php endif; ?>

	<?php else: ?>

		<?php
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? ' aria-required="true"' : '' );
		$commenter = wp_get_current_commenter();

		comment_form(
			array(
				'fields'        => array(
					'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'arras' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					            '<input id="author" class="required" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
					'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'arras' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					            '<input id="email" class="required email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
					'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'arras' ) . '</label>' .
					            '<input id="url" class="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
				),
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'arras' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="required"></textarea></p>'
			)
		);
		?>
	<?php endif ?>
</div>
