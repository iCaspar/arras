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

class SearchTemplate extends BaseTemplate implements Template {

	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

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