<?php
/**
 * Templet for a WP Author page.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

/**
 * Class AuthorTemplate
 * @package ICaspar\Arras\Theme\Templates
 */
class AuthorTemplate extends BaseTemplate implements Template {

	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

	/**
	 * Render an author page.
	 * @return void
	 */
	public function render() {
		$this->beforeContent();

		if ( have_posts() ) {
			the_post();
			$this->ignore_tapestry = true;
			include ARRAS_VIEWS_DIR . 'author/author-info.php';
			$this->ignore_tapestry = false;
			rewind_posts();

			while ( have_posts() ) {
				the_post();
				include ARRAS_VIEWS_DIR . 'entry.php';
			}

			the_posts_navigation( [
				'prev_text' => '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' . _x( 'Older Posts', 'Previous post link', 'arras' ),
				'next_text' => _x( 'Newer Posts', 'Next post link', 'arras' ) . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
			] );
		} else {
			$this->no_posts();
		}

		$this->afterContent();
	}
}
