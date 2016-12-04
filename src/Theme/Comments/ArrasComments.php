<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Theme\Comments;

class ArrasComments implements Comments {

	/**
	 * Output the current comment.
	 *
	 * @param \WP_Comment $comment The current comment.
	 * @param array $args The current comment walker's arguments.
	 * @param int $depth The current comment's depth in the comment hierarchy.
	 *
	 * @return void
	 */
	public function list_comments( $comment, $args, $depth ) {
		include ARRAS_VIEWS_DIR . 'comments/list-comments.php';
	}

	/**
	 * Output the current trackback.
	 *
	 * @param \WP_Comment $comment The current comment.
	 * @param array $args The current comment walker's arguments.
	 * @param int $depth The current comment's depth in the comment hierarchy.
	 *
	 * @return void
	 */
	public function list_trackbacks( $comment, $args, $depth ) {
        include  ARRAS_VIEWS_DIR . 'comments/list-trackbacks.php';
	}

	/**
	 * Output the comments page links.
	 * @return void
	 */
	public function comments_page_links() {
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
			include ARRAS_VIEWS_DIR . 'comments/comment-page-nav.php';
		}
	}
}