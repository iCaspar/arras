<?php
/**
 * Template for the Arras front page.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use ICaspar\Arras\Queries\ArrasQuery;
use Pimple\Container;

class FrontPageTemplate extends BaseTemplate implements Template {

	/**
	 * Theme Query handler.
	 *
	 * @var ArrasQuery
	 */
	protected $queryController;

	public function __construct( Container $arras ) {
		parent::__construct( $arras );
		$this->queryController = $this->arras['queryController'];
	}

	public function render() {
		global $paged;
		$paged = get_query_var( 'page' );

		$this->beforeContent();

		if ( ! $paged ) {
			// Featured sections
			if ( $this->arras['options']->get( 'enable-featured-1' ) ) {
				arras_above_index_featured1_post();
			}

			if ( $this->arras['options']->get( 'enable-featured-2' ) ) {
				arras_above_index_featured2_post();
				// etc.
			}

			if ( $this->arras['options']->get( 'enable-news' ) ) {
				$this->news_loop( $paged );
			}
		} else {
			$this->news_loop( $paged );
		}

		$this->afterContent();
	}

	protected function news_loop( $paged ) {
		$section_header_title = $this->arras['options']->get( 'news-title' ) ?: 'Latest Headlines';

		arras_above_index_news_post();

		$this->queryController->set( [
			'post_type'           => 'post',
			'paged'               => $paged ?: 1,
			'ignore_sticky_posts' => true,
		] );

		$query = $this->queryController->run();

		if ( $query->have_posts() ) {
			include ARRAS_VIEWS_DIR . 'front-page/section-header.php';

			while ( $query->have_posts() ) {
				$query->the_post();
				include ARRAS_VIEWS_DIR . 'entry.php';
			}

			if ( $query->max_num_pages > 1 ) {
				include ARRAS_VIEWS_DIR . 'front-page/front-page-post-nav.php';
            }

		} else {
			$this->no_posts();
		}

		$this->queryController->end();

		arras_below_index_news_post();
	}
}