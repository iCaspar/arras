<?php
/**
 * The Arras comment template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'comments' );

if ( post_password_required() ) {
	return;
}


if ( have_comments() ) : ?>
	<?php arras_above_comments();
	$comments_by_type = separate_comments( $comments );
	?>

	<a name="comments"></a>

	<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>
		<div class="module comments">
			<h3 class="module-title">
				<?php comments_number( __( 'No Comments', 'arras' ), __( '1 Comment', 'arras' ), _n( '% Comment', '% Comments', get_comments_number(), 'arras' ) ); ?>
				<?php if ( ! empty( $comments_by_type['pings'] ) ): ?>
					&nbsp;(Including Trackbacks and Pings)
				<?php endif; ?>
			</h3>
			<ol id="comment-list" class="comment-list group">
				<?php wp_list_comments( [
					'type'     => 'comment',
					'callback' => array( $arras, 'list_comments' ),
				] ); ?>
				<?php $arras->comments_page_links(); ?>
			</ol>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
		<div class="module pingback-list">
			<h3 class="module-title">
				<?php _e( 'Trackbacks / Pings', 'arras' ) ?></h3>
			<ol class="pingbacks"><?php wp_list_comments( [
					'type'     => 'pings',
					'callback' => array( $arras, 'list_trackbacks' ),
				] ); ?>
				<?php $arras->comments_page_links(); ?>
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

	<?php if ( 'closed' == $post->comment_status ) : ?>
		<?php if ( ! is_page() ) : ?>
			<div class="module no-comments">
				<h3 class="module module-title"><?php _e( 'Comments Closed', 'arras' ) ?></h3>
				<p class="nocomments"><?php _e( 'Comments are closed.', 'arras' ) ?></p>
			</div>
		<?php endif; ?>
	<?php endif; ?>

<?php comment_form( [ 'title_reply_before' => '<h3 id="reply-title" class="module-title comment-reply-title">' ] ); ?>

<?php if ( have_comments() ): ?>
	<?php arras_below_comments(); ?>
<?php endif; ?>