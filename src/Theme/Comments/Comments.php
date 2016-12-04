<?php
/**
 * Interface (contract) for comments classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Comments;

interface Comments {

	/**
	 * Output the current comment.
	 *
	 * @param \WP_Comment $comment The current comment.
	 * @param array $args The current comment walker's arguments.
	 * @param int $depth The current comment's depth in the comment hierarchy.
	 *
	 * @return void
	 */
	public function list_comments( $comment, $args, $depth );

	/**
	 * Output the current trackback.
	 *
	 * @param \WP_Comment $comment The current comment.
	 * @param array $args The current comment walker's arguments.
	 * @param int $depth The current comment's depth in the comment hierarchy.
	 *
	 * @return void
	 */
	public function list_trackbacks( $comment, $args, $depth );

	/**
	 * Output the comments page links.
	 * @return void
	 */
	public function comments_page_links();
}