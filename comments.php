<?php
/**
 * The Arras comment template.
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( __( 'Please do not load this page directly. Thanks!', 'arras' ) );
}
/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'comments' );

if ( post_password_required() ) {
	?> <h4 class="module-title"><?php _e( 'Password Required', 'arras' ) ?></h4> <?php
	_e( '<p class="nocomments">This post is password protected. Enter the password to view comments.</p>', 'arras' );

	return;
}

$comments_by_type = separate_comments( $comments );

if ( have_comments() ) : ?>

	<?php arras_above_comments(); ?>

	<a name="comments"></a>

	<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>
		<div class="module comments">
			<h3 class="module-title comments-title"><?php comments_number( __( 'No Comments', 'arras' ), __( '1 Comment', 'arras' ), _n( '% Comment', '% Comments', get_comments_number(), 'arras' ) ); ?></h3>

			<ol id="comment-list" class="comment-list group">
				<?php wp_list_comments( [
					'type'     => 'comment',
					'callback' => array( $arras, 'list_comments' ),
				] ); ?>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<li class="comments-navigation-container">
						<div class="comments-navigation">
							<?php paginate_comments_links( [
								'prev_text' => '<i class="fa fa-arrow-circle-left"></i> ' . _x( 'Previous', 'previous comments link', 'arras' ),
								'next_text' => _x( 'Next', 'next comments link', 'arras' ) . ' <i class="fa fa-arrow-circle-right"></i>',
							] ); ?>
						</div>
					</li>
				<?php endif; ?>
			</ol>
		</div>
	<?php endif; ?>


	<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
		<div class="module pingback-list">
			<h3 class="module-title"><?php _e( 'Trackbacks / Pings', 'arras' ) ?></h3>
			<ol class="pingbacks"><?php wp_list_comments( [
					'type'     => 'pings',
					'callback' => array( $arras, 'list_trackbacks' ),
				] ); ?>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<li class="comments-navigation-container">
						<div class="comments-navigation">
							<?php paginate_comments_links( [
								'prev_text' => '<i class="fa fa-arrow-circle-left"></i> ' . _x( 'Previous', 'previous comments link', 'arras' ),
								'next_text' => _x( 'Next', 'next comments link', 'arras' ) . ' <i class="fa fa-arrow-circle-right"></i>',
							] ); ?>
						</div>
					</li>
				<?php endif; ?>
			</ol>
		</div>
	<?php endif; ?>

<?php else: ?>
	<?php if ( 'open' == $post->comment_status ) : ?>
		<div class="module no-comments">
			<h3 class="module-title"><?php _e( 'No Comments', 'arras' ) ?></h3>
			<p class="nocomments"><?php _e( 'Start the ball rolling by posting a comment on this article!', 'arras' ) ?></p>
		</div>
	<?php endif ?>
<?php endif; ?>

<?php if ( 'closed' == $post->comment_status ) : if ( ! is_page() ) : ?>
	<div class="module no-comments">
		<h3 class="module module-title"><?php _e( 'Comments Closed', 'arras' ) ?></h3>
		<p class="nocomments"><?php _e( 'Comments are closed. You will not be able to post a comment in this post.', 'arras' ) ?></p>
	</div>
<?php endif;
else: ?>

	<?php
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );
	$commenter = wp_get_current_commenter();

	comment_form(
		array(
			'title_reply_before' => '<h3 id="reply-title" class="module-title comment-reply-title">',
			'fields'             => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'arras' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
				            '<input id="author" class="required" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'arras' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
				            '<input id="email" class="required email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'arras' ) . '</label>' .
				            '<input id="url" class="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
			),
			'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'arras' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="required"></textarea></p>'
		)
	);
	?>

	<?php arras_below_comments(); ?>

<?php endif ?>