<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

/**
 * Class SearchTemplate
 * @package ICaspar\Arras\Theme\Templates
 */
class SearchTemplate extends BaseTemplate implements Template {

	/**
	 * SearchTemplate constructor.
	 *
	 * @param Container $arras
	 */
	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

	/**
	 * Render a WordPress search page.
	 * @return void
	 */
	public function render() {
		$this->beforeContent();

		include ARRAS_VIEWS_DIR . 'search/search-summary.php';

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				include ARRAS_VIEWS_DIR . 'entry.php';
			}
			the_posts_navigation( [
				'prev_text' => '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' . _x( 'Older Posts', 'Previous post link', 'arras' ),
				'next_text' => _x( 'Newer Posts', 'Next post link', 'arras' ) . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
			] );
		} else {
			include ARRAS_VIEWS_DIR . 'search/no-search-results.php';
		}

		$this->afterContent();
	}
}