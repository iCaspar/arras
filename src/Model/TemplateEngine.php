<?php
/**
 * The theme's template rendering engine.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

use ICaspar\Arras\Views\Menu;

/**
 * Class TemplateEngine
 * @package ICaspar\Arras\Views
 * @since 4.0.0
 */
class TemplateEngine {

	protected $config;

	protected $menus;

	protected $template;

	/**
	 * TemplateEngine constructor.
	 *
	 * @param Config $config Theme configuration.
	 * @param string $template Current template context.
	 */
	public function __construct( Config $config, Menu $menus, $template ) {
		$this->config   = $config;
		$this->menus = $menus;
		$this->template = $template;

		$this->hooks();
	}

	/**
	 * Set template hooks.
	 * @return void
	 */
	private function hooks() {
		add_filter( 'post_class', array( $this, 'post_class' ) );
	}

	/**
	 * Get an option from the config options.
	 *
	 * @param $option
	 *
	 * @return mixed
	 */
	public function get_option( $option ) {
		return $this->config->get_option( $option );
	}

	/**
	 * Render a menu.
	 *
	 * @param $location
	 *
	 * @return void
	 */
	public function do_menu( $location ) {
		if ( ! $this->menus->has_menu( $location ) ) {
			return;
		}

		$this->menus->build( $location );
	}

	public function link_pages() {
		wp_link_pages( [
			'before' => '<p><span class="link-pages">' . __( 'Pages:' ) . '</span>',
		]);
	}


	//* ----- CALLBACKS ----- */

	/**
	 * Customize a post class.
	 *
	 * @param array $classes Default Post classes.
	 *
	 * @return array Custom classes.
	 */
	public function post_class( $classes ) {
		if ( is_page() ) {
			$classes = array_diff( $classes, ['hentry'] );
		}
		return $classes;
	}


	//* ----- NEEDS REVIEW ----- */

	function get_layouts() {
		$arras_layouts = array(
			'1c'    => __( '1 Column - No Sidebars', 'arras' ),
			'2c-r'  => __( '2 Columns - Sidebar on Right', 'arras' ),
			'2c-l'  => __( '2 Columns - Sidebar on Left', 'arras' ),
			'3c-lr' => __( '3 Columns - Left / Right Sidebars', 'arras' ),
			'3c-2r' => __( '3 Columns - 2 Right Sidebars', 'arras' ),
		);

		return apply_filters( 'arras_layouts', $arras_layouts );
	}


	function layout_columns( $coltype ) {
		$coltypes = array( 'content', 'primary', 'secondary', 'wrap' );
		if ( ! in_array( $coltype, $coltypes ) ) {
			return;
		} // if we haven't got a column type we know about, bail

		$layout = $this->get_option( 'layout' );
		switch ( $layout ) {
			case '1c':
				if ( $coltype == 'content' ) {
					$class = 'group';
				} else {
					$class = 'group sidebar';
				}
				break;
			case '2c-l':
				if ( $coltype == 'content' ) {
					$class = 'col-alt span_2_of_3';
				} else {
					$class = 'col-alt span_1_of_3 sidebar';
				}
				break;
			case '3c-2r':
				if ( $coltype == 'content' ) {
					$class = 'col span_1_of_2';
				} else {
					$class = 'col span_1_of_4 sidebar';
				}
				break;
			case '3c-lr':
				if ( $coltype == 'content' ) {
					$class = 'col-split-center';
				} elseif ( $coltype == 'primary' ) {
					$class = 'col-split-left sidebar';
				} else {
					$class = 'col-split-right sidebar';
				}
				break;
			default:
				if ( $coltype == 'content' ) {
					$class = 'col span_2_of_3';
				} else {
					$class = 'col span_1_of_3 sidebar';
				}
				break;

		} // end switch

		return $class;
	} // end arras_layout_columns()

	/**
	 * Called to display post heading for news in single posts
	 * @since 1.2.2
	 */
	function postheader() {
		global $post, $id;

		$postheader = '';

		if ( is_single() || is_page() ) {

			if ( is_attachment() ) {
				$postheader .= '<h1 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h1>';
			} else {
				$postheader .= '<h1 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h1>';
			}

		} else {

			if ( is_attachment() ) {
				$postheader .= '<h2 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h2>';
			} else {
				if ( ! is_page() && ! is_front_page() ) $postheader .= '<a class="entry-comments" href="' . get_comments_link() . '">' . get_comments_number() . '</a>';
				$postheader .= '<h2 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h2>';
			}
		}

		if ( ! is_page() ) {
			$postheader .= '<div class="entry-info">';

			if ( $this->get_option('post_author') ) {
				$postheader .= sprintf( __('<div class="entry-author">By %s</div>', 'arras'), '<address class="author vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta('ID') ) . '" rel="author" title="' . esc_attr(get_the_author()) . '">' . get_the_author() . '</a></address>' );
			}

			if ( $this->get_option('post_date') ) {
				$postheader .= ' &ndash; <abbr class="published" title="' . get_the_time('c') . '">' . sprintf( __('Posted %s', 'arras'), $this->posted_on( false ) ) . '</abbr>';
			}

			if (current_user_can('edit_post', $id)) {
				$postheader .= '<a class="post-edit-link" href="' . get_edit_post_link($id) . '" title="' . __('Edit Post', 'arras') . '">' . __('(Edit Post)', 'arras') . '</a>';
			}

			if ( !is_attachment() && $this->get_option('post_cats') ) {
				$post_cats = array();
				$cats = get_the_category();
				foreach ($cats as $c) $post_cats[] = '<a href="' . get_category_link($c->cat_ID) . '">' . $c->cat_name . '</a>';

				$postheader .= sprintf( __('<span class="entry-cat"><strong>Posted in: </strong>%s</span>', 'arras'), implode(', ', $post_cats) );
			}

			$postheader .= '</div>';
		}

		if ( $this->get_option('single_thumbs') && has_post_thumbnail($post->ID) ) {
			$postheader .= '<div class="entry-photo">' . get_the_post_thumbnail() . '</div>';
		}

		echo apply_filters('arras_postheader', $postheader);
	}

	/**
	 * Called to display post footer for news in single posts
	 * @since 1.2.2
	 */
	function postfooter() {
		global $id, $post;

		$postfooter = '';

		if ( $this->get_option('post_tags') && !is_attachment() && is_array(get_the_tags()) )
			$postfooter .= '<div class="tags"><strong>' . __('Tags:', 'arras') . '</strong>' . get_the_tag_list(' ', ', ', ' ') . '</div>';

		echo apply_filters('arras_postfooter', $postfooter);
	}

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	function post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation clearfix" role="navigation">
			<!-- <h1 class="screen-reader-text"><?php// _e( 'Post navigation', 'arras' ); ?></h1>-->
			<div class="nav-links">
				<?php if ( $previous ) {?>
					<div class="floatleft"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'arras' ) ); ?></div>
				<?php }
				if ( $next ) {?>
					<div class="floatright"><?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'arras' ) ); ?></div>
				<?php }?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}

	/**
	 * Displays when the specified post/archive requested by the user is not found.
	 * @since	1.2.2
	 */
	function post_notfound() {
		$postcontent = '<div class="single-post">';
		$postcontent .= '<h1 class="entry-title">' . __('That \'something\' you are looking for isn\'t here!', 'arras') . '</h1>';
		$postcontent .= '<div class="entry-content"><p>' . __('<strong>We\'re very sorry, but the page that you are looking for doesn\'t exist or has been moved.</strong>', 'arras') . '</p>';


		$postcontent .= '<form method="get" class="clearfix" action="' . home_url() . '">
	' . __('Perhaps searching for it might help?', 'arras') . '<br />
	<input type="text" value="" name="s" class="s" size="30" onfocus="this.value=\'\'" />
	<input type="submit" class="searchsubmit" value="' . __('Search', 'arras') . '" title="' . sprintf( __('Search %s', 'arras'), esc_html( get_bloginfo('name'), 1 ) ) . '" />
	</form>';

		$postcontent .= '<h3>' . __( 'Latest Posts', 'arras' ) . '</h3>';
		$postcontent .= '<ul>';
		$postcontent .= wp_get_archives('type=postbypost&limit=10&format=custom&before=<li>&after=</li>&echo=0');
		$postcontent .= '</ul>';
		$postcontent .= '</div></div>';

		echo apply_filters('arras_post_notfound', $postcontent);
	}

	/**
	 * Function adapted from http://graveyard.maniacalrage.net/etc/relative/.
	 * @since 1.6
	 */
	function posted_on( $echo = 1 ) {
		if ( ! $this->get_option( 'relative_postdates' ) ) {
			$result = sprintf( __( 'on %s', 'arras' ), get_the_time( get_option( 'date_format' ) ) );
		} else {
			$diff = current_time( 'timestamp' ) - get_the_time( 'U' );

			$months = floor( $diff / 2592000 );
			$diff -= $months * 2419200;

			$weeks = floor( $diff / 604800 );
			$diff -= $weeks * 604800;

			$days = floor( $diff / 86400 );
			$diff -= $days * 86400;

			$hours = floor( $diff / 3600 );
			$diff -= $hours * 3600;

			$minutes = floor( $diff / 60 );
			$diff -= $minutes * 60;

			if ( $months > 0 || $months < 0 ) {
				// over a month old, just show date
				$result = sprintf( __( 'on %s', 'arras' ), get_the_time( get_option( 'date_format' ) ) );
			} else {
				if ( $weeks > 0 ) {
					// weeks
					if ( $weeks > 1 )
						$result = sprintf( __( '%s weeks ago', 'arras' ), number_format_i18n( $weeks ) );
					else
						$result = __( '1 week ago', 'arras' );
				} elseif ( $days > 0 ) {
					// days
					if ( $days > 1 )
						$result = sprintf( __( '%s days ago', 'arras' ), number_format_i18n( $days ) );
					else
						$result = __( '1 day ago', 'arras' );
				} elseif ( $hours > 0 ) {
					// hours
					if ( $hours > 1 )
						$result = sprintf( __( '%s hours ago', 'arras' ), number_format_i18n( $hours ) );
					else
						$result = __( '1 hour ago', 'arras' );
				} elseif ( $minutes > 0 ) {
					// minutes
					if ( $minutes > 1 )
						$result = sprintf( __( '%s minutes ago', 'arras' ), number_format_i18n( $minutes ) );
					else
						$result = __( '1 minute ago', 'arras' );
				} else {
					// seconds
					$result = __( 'less than a minute ago', 'arras' );
				}
			}

		}

		if ( $echo ) echo $result;
		return $result;
	}


}