<?php
/**
 * Arras comments template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Oops! Something went wrong.' );
}

if ( post_password_required() ) { ?>
	<div class="comments">
		<h4 class="comments-title module-title"><?php esc_html_e( 'Password Required', 'arras' ); ?></h4>
		<p class="nocomments"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'arras' ); ?></p>
	</div>
	<?php
	return;
}

$arras_comments_by_type = separate_comments( $comments );
?>


<?php if ( have_comments() ) : ?>
	<div class="comments">
		<?php if ( ! empty( $arras_comments_by_type['comment'] ) ) : ?>
			<h4 class="comments-title module-title"><?php comments_number( __( 'No Comments', 'arras' ), __( '1 Comment', 'arras' ), _n( '% Comment', '% Comments', get_comments_number(), 'arras' ) ); ?></h4>
			<ul id="commentlist" class="comment-list clearfix">
				<?php wp_list_comments( 'type=comment&callback=arras_list_comments' ); ?>
			</ul>
		<?php endif; ?>

		<div class="comments-navigation clearfix">
			<?php paginate_comments_links(); ?>
		</div>

		<?php if ( ! empty( $arras_comments_by_type['pings'] ) ) : ?>
			<h4 class="comments-title module-title"><?php esc_html_e( 'Trackbacks / Pings', 'arras' ); ?></h4>
			<ol class="pingback-list pingbacks"><?php wp_list_comments( 'type=pings&callback=arras_list_trackbacks' ); ?></ol>
		<?php endif; ?>
	</div>
<?php else : ?>
	<?php if ( 'open' === $post->comment_status ) : ?>
		<div class="comments">
			<h4 class="comments-title module-title"><?php esc_html_e( 'No Comments', 'arras' ); ?></h4>
			<div class="no-comments">
				<p class="nocomments"><?php esc_html_e( 'Start the ball rolling by posting a comment on this article!', 'arras' ); ?></p>
			</div>
		</div>
	<?php endif ?>
<?php endif; ?>

<?php
if ( 'closed' === $post->comment_status ) :
	if ( ! is_page() ) :
		?>
		<div class="comments">
			<h4 class="comments-title module-title"><?php esc_html_e( 'Comments Closed', 'arras' ); ?></h4>
			<div class="no-comments">
				<p class="nocomments"><?php esc_html_e( 'Comments are closed. You will not be able to post a comment in this post.', 'arras' ); ?></p>
			</div>
		</div>

	<?php endif; ?>

<?php else : ?>
	<?php
	$arras_req       = get_option( 'require_name_email' );
	$arras_aria_req  = ( $arras_req ? ' aria-required="true"' : '' );
	$arras_commenter = wp_get_current_commenter();

	comment_form(
		array(
			'fields'        => array(
				'author' => '<p class="comment-form-author"><label for="author">' . __( 'Name', 'arras' ) . '</label> ' . ( $arras_req ? '<span class="required">*</span>' : '' ) .
				            '<input id="author" class="required" name="author" type="text" value="' . esc_attr( $arras_commenter['comment_author'] ) . '" size="30"' . $arras_aria_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'arras' ) . '</label> ' . ( $arras_req ? '<span class="required">*</span>' : '' ) .
				            '<input id="email" class="required email" name="email" type="text" value="' . esc_attr( $arras_commenter['comment_author_email'] ) . '" size="30"' . $arras_aria_req . ' /></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'arras' ) . '</label>' .
				            '<input id="url" class="url" name="url" type="text" value="' . esc_attr( $arras_commenter['comment_author_url'] ) . '" size="30" /></p>',
			),
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'arras' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="required"></textarea></p>',
		)
	);
	?>
<?php endif ?>

