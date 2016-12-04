<?php
/**
 * Base template class.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

abstract class BaseTemplate implements Template {

	protected $arras;

	protected $layout;

	public function __construct( Container $arras ) {
		$this->arras = $arras;
		$this->get_layout();
	}

	public function render() {
		$this->beforeContent();

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
			$this->no_posts();
		}

		$this->afterContent();
	}

	protected function get_layout() {
	    $this->layout = $this->arras['layout']->build();
    }

	protected function beforeContent() {
		include( $this->arras['templateLoader']->get_header() );
		arras_above_content(); ?>
    <div id="content" class="<?php echo $this->layout->get_classes( 'content' ); ?>">
		<?php
	}

	protected function afterContent() {
		echo '</div>';
		arras_below_content();
		include( $this->arras['templateLoader']->get_sidebar() );
		include( $this->arras['templateLoader']->get_footer() );
	}

	protected function postheader() {
		global $post, $id;

		$postheader = '';

		if ( is_single() || is_page() ) {

			if ( is_attachment() ) {
				$postheader .= '<h1 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink( $post->post_parent ) . '" rel="attachment">' . get_the_title( $post->post_parent ) . '</a>]</h1>';
			} else {
				$postheader .= '<h1 class="entry-title">' . get_the_title() . '</h1>';
			}

		} else {

			if ( is_attachment() ) {
				$postheader .= '<h3 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink( $post->post_parent ) . '" rel="attachment">' . get_the_title( $post->post_parent ) . '</a>]</h3>';
			} else {
				$postheader .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
				if ( ! is_page() && ! is_front_page() ) {
					$postheader .= '<a class="entry-comments-number" href="' . get_comments_link() . '"><i class="fa fa-commenting-o" aria-hidden="true"></i>&nbsp;' . get_comments_number() . '</a>';
				}
			}
		}

		if ( ! is_page() ) {
			$postheader .= '<div class="entry-meta">';

			if ( $this->arras['options']->get( 'post_author' ) ) {
				$postheader .= sprintf( __( '<div class="entry-author">By %s</div>', 'arras' ), '<address class="author vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" title="' . esc_attr( get_the_author() ) . '">' . get_the_author() . '</a></address>' );
			}

			if ( $this->arras['options']->get( 'post_date' ) ) {
				$postheader .= ' &ndash; <span class="published" title="' . get_the_time( 'c' ) . '">' . sprintf( __( 'Posted %s', 'arras' ), $this->posted_on() ) . '</span>';
			}

			if ( current_user_can( 'edit_post', $id ) ) {
				$postheader .= '<a class="post-edit-link" href="' . get_edit_post_link( $id ) . '" title="' . __( 'Edit Post', 'arras' ) . '">' . __( '(Edit Post)', 'arras' ) . '</a>';
			}

			if ( ! is_attachment() && $this->arras['options']->get( 'post_cats' ) ) {
				$post_cats = array();
				$cats      = get_the_category();
				foreach ( $cats as $c ) {
					$post_cats[] = '<a href="' . get_category_link( $c->cat_ID ) . '">' . $c->cat_name . '</a>';
				}

				$postheader .= sprintf( __( '<span class="entry-cat"><strong>Posted in: </strong>%s</span>', 'arras' ), implode( ', ', $post_cats ) );
			}

			$postheader .= '</div>';
		}

		if ( $this->arras['options']->get( 'single-thumbs' ) && has_post_thumbnail( $post->ID ) ) {
			$postheader .= '<div class="entry-image">' . get_the_post_thumbnail() . '</div>';
		}

		echo apply_filters( 'arras_postheader', $postheader );
	}

	protected function postfooter() {
		global $id, $post;

		if ( $this->arras['options']->get( 'post_tags' ) && ! is_attachment() && is_array( get_the_tags() ) ) {
			$postfooter = '<div class="entry-meta-footer"><span class="entry-tags">' . __( 'Tags:', 'arras' ) . '</span>' . get_the_tag_list( ' ', ', ', ' ' ) . '</div>';
		}

		if ( is_page() && $this->arras['options']->get( 'display-author-page' ) ) {
			include ARRAS_VIEWS_DIR . 'author-profile.php';
		}

		if ( is_single() && $this->arras['options']->get( 'display-author-post' ) ) {
			include ARRAS_VIEWS_DIR . 'author-profile.php';
		}

		if ( is_single() && $this->arras['options']->get( 'show-post-nav' ) ) {
			$this->post_nav();
		}

		echo apply_filters( 'arras_postfooter', $postfooter );
	}

	protected function posted_on() {
		return sprintf( __( 'on %s', 'arras' ), get_the_time( get_option( 'date_format' ) ) );
	}

	protected function no_posts() {
		$postcontent = '<div class="single-post">';
		$postcontent .= '<h1 class="entry-title">' . __( 'That \'something\' you are looking for isn\'t here!', 'arras' ) . '</h1>';
		$postcontent .= '<div class="entry-content"><p>' . __( '<strong>We\'re very sorry, but the page that you are looking for doesn\'t exist or has been moved.</strong>', 'arras' ) . '</p>';


		$postcontent .= '<form method="get" class="clearfix" action="' . home_url() . '">
	' . __( 'Perhaps searching for it might help?', 'arras' ) . '<br />
	<input type="text" value="" name="s" class="s" size="30" onfocus="this.value=\'\'" />
	<input type="submit" class="searchsubmit" value="' . __( 'Search', 'arras' ) . '" title="' . sprintf( __( 'Search %s', 'arras' ), esc_html( get_bloginfo( 'name' ), 1 ) ) . '" />
	</form>';

		$postcontent .= '<h3>' . __( 'Latest Posts', 'arras' ) . '</h3>';
		$postcontent .= '<ul>';
		$postcontent .= wp_get_archives( 'type=postbypost&limit=10&format=custom&before=<li>&after=</li>&echo=0' );
		$postcontent .= '</ul>';
		$postcontent .= '</div></div>';

		echo apply_filters( 'arras_post_notfound', $postcontent );
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
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		include ARRAS_VIEWS_DIR . 'post-nav.php';
	}


}