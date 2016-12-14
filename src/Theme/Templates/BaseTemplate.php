<?php
/**
 * Base template class.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use ICaspar\Arras\Theme\Layouts\Layout;
use Pimple\Container;

/**
 * Class BaseTemplate
 * @package ICaspar\Arras\Theme\Templates
 */
abstract class BaseTemplate implements Template {

	/**
	 * The Arras service container.
	 *
	 * @var Container
	 */
	protected $arras;

	/**
	 * The layout class.
	 *
	 * @var Layout
	 */
	protected $layout;

	/**
	 * A flag we can set when we need a post to ignore the tapestry.
	 *
	 * @var bool
	 */
	protected $ignore_tapestry = false;

	/**
	 * BaseTemplate constructor.
	 *
	 * @param Container $arras The theme service container.
	 */
	public function __construct( Container $arras ) {
		$this->arras = $arras;
		$this->get_layout();
		$this->init_filters();
	}

	/**
	 * Render a WordPress page.
	 * @return mixed
	 */
	abstract public function render();

	/**
	 * Get a layout object for the template.
	 * @return void
	 */
	protected function get_layout() {
		$layoutFactory = $this->arras['layoutFactory'];
		$layoutFactory->set( $this->arras['options']->get( 'layout' ) );
		$this->layout = $layoutFactory->build();
	}

	/**
	 * Set filters for template callbacks.
	 * @return void
	 */
	protected function init_filters() {
		add_filter( 'post_class', [ $this, 'post_classes' ] );
	}

	/**
	 * Render HTML before main template content.
	 * @return void
	 */
	protected function beforeContent() {
		include( $this->arras['templateLoader']->get_header() );
		arras_above_content();
		include ARRAS_VIEWS_DIR . 'template-components/before-content.php';
	}

	/**
	 * Render HTML after main template content.
	 * @return void
	 */
	protected function afterContent() {
		echo '</div>';
		arras_below_content();
		include( $this->arras['templateLoader']->get_sidebar() );
		include( $this->arras['templateLoader']->get_footer() );
	}

	/**
	 * Render entry content header HTML.
	 * @return void
	 */
	protected function postheader() {
		global $post, $id;

		ob_start();

		if ( is_single() || is_page() || is_attachment() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
			if ( is_attachment() ) {
				include ARRAS_VIEWS_DIR . 'template-components/post-parent-link.php';
			}
		} else {
			include ARRAS_VIEWS_DIR . 'template-components/linked-title.php';
		}

		if ( ! is_page() && ! is_front_page() && ! is_single() ) {
			include ARRAS_VIEWS_DIR . 'template-components/comment-count.php';
		}

		if ( ! is_page() || is_front_page() ) {
			echo '<div class="entry-meta">';

			if ( $this->arras['options']->get( 'post-author-meta' ) ) {
				include ARRAS_VIEWS_DIR . 'template-components/post-author-meta.php';
			}

			if ( $this->arras['options']->get( 'post-date' ) ) {
				include ARRAS_VIEWS_DIR . 'template-components/date-meta.php';
			}

			if ( current_user_can( 'edit_post', $id ) ) {
				include ARRAS_VIEWS_DIR . 'template-components/edit-post-link.php';
			}

			if ( ! is_attachment() && $this->arras['options']->get( 'post-cats' ) ) {
				$this->the_categories();
			}

			echo '</div>';
		}

		if ( $this->arras['options']->get( 'single-thumbs' ) && has_post_thumbnail( $post->ID ) ) {
			echo '<div class="entry-image" > ' . the_post_thumbnail() . '</div >';
		}

		$postheader = ob_get_clean();
		echo apply_filters( 'arras_postheader', $postheader );
	}

	/**
	 * Render entry content footer HTML.
	 * @return void
	 */
	protected function postfooter() {
		ob_start();

		if ( $this->arras['options']->get( 'post-tags' ) && ! is_attachment() && is_array( get_the_tags() ) ) {
			include ARRAS_VIEWS_DIR . 'template-components/post-tags.php';
		}

		if ( is_page() && $this->arras['options']->get( 'display-author-page' ) ||
		     is_single() && $this->arras['options']->get( 'display-author-post' )
		) {
			include ARRAS_VIEWS_DIR . 'author-profile.php';
		}

		if ( is_single() || is_attachment() && $this->arras['options']->get( 'show-post-nav' ) ) {
			$this->post_nav();
		}

		$postfooter = ob_get_clean();

		echo apply_filters( 'arras_postfooter', $postfooter );
	}

	/**
	 * Generate the "posted on" meta for an entry.
	 * @return string
	 */
	protected function posted_on() {
		return sprintf( __( 'on %s', 'arras' ), get_the_time( get_option( 'date_format' ) ) );
	}

	/**
	 * Render HTML for templates where no content is returned from the query.
	 * @return void
	 */
	protected function no_posts() {
		ob_start();

		include ARRAS_VIEWS_DIR . 'no-posts.php';

		$no_posts_found = ob_get_clean();
		echo apply_filters( 'arras_post_notfound', $no_posts_found );
	}

	/**
	 * Customize link pages links.
	 * @return void
	 */
	public function link_pages() {
		wp_link_pages( [
			'before' => '<p><span class="link-pages">' . __( 'Pages:' ) . '</span>',
		] );
	}

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	protected function post_nav() {
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		include ARRAS_VIEWS_DIR . 'post-nav.php';
	}

	/***** CALLBACKS *****/

	/**
	 * Customize a post class.
	 *
	 * @param array $classes Default Post classes.
	 *
	 * @return array Custom classes.
	 */
	public function post_classes(
		array $classes
	) {
		$classes[] = 'group';

		if ( is_attachment() ) {
			$classes[] = 'attachment';
		}

		if ( is_page() && ! is_archive() ) {
			$classes = array_diff( $classes, [ 'hentry' ] );
		}

		if ( is_front_page() || ! is_page() && ! is_single() && ! $this->ignore_tapestry ) {
			$classes[] = 'traditional';
		}

		if ( is_author() ) {
			$classes[] = 'profile';
		}

		return $classes;
	}

	/**
	 * Get post category list and optionally echo it.
	 *
	 * @param bool $echo (Optional) Whether to echo the list.
	 *
	 * @return string|void
	 */
	protected function the_categories( $echo = true ) {
		$post_categories = array();
		$categories      = get_the_category();
		foreach ( $categories as $category ) {
			$post_categories[] = '<a href="' . get_category_link( $category->cat_ID ) . '">' . $category->cat_name . '</a>';
		}
		$post_categories = implode( ',', $post_categories );

		$categoryList = '<span class="entry-cat"><strong>' .
		                _x( 'Posted in: ', 'Category list introduction', 'arras' ) .
		                '</strong>' .
		                $post_categories .
		                '</span>';

		if ( $echo ) {
			echo $categoryList;
		} else {
			return $categoryList;
		}
	}
}