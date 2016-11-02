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

	protected $subtemplate;

	/**
	 * TemplateEngine constructor.
	 *
	 * @param Config $config Theme configuration.
	 * @param string $template Current template context.
	 */
	public function __construct( Config $config, Menu $menus ) {
		$this->config = $config;
		$this->menus  = $menus;

		$this->hooks();
	}

	/**
	 * Set the current template type.
	 *
	 * @param string $template Current template.
	 *
	 * @param bool $sub_template Template is the main template.
	 */
	public function set_template( $template, $is_sub_template = false ) {
		if ( $is_sub_template ) {
			$this->subtemplate = $template;
		} else {
			$this->template = $template;
		}
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
	 * Customize comment paging links.
	 * @return void
	 */
	public function comments_page_links() {
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
			include ARRAS_VIEWS_DIR . 'comment-page-nav.php';
		}
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
			$classes = array_diff( $classes, [ 'hentry' ] );
		}

		return $classes;
	}


	/*
	 * Todo: From here down, from old: needs review & refactor.
	 */

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
				$postheader .= '<h1 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink( $post->post_parent ) . '" rev="attachment">' . get_the_title( $post->post_parent ) . '</a>]</h1>';
			} else {
				$postheader .= '<h1 class="entry-title">' . get_the_title() . '</h1>';
			}

		} else {

			if ( is_attachment() ) {
				$postheader .= '<h2 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink( $post->post_parent ) . '" rev="attachment">' . get_the_title( $post->post_parent ) . '</a>]</h2>';
			} else {
				$postheader .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
				if ( ! is_page() && ! is_front_page() ) {
					$postheader .= '<a class="entry-comments-number" href="' . get_comments_link() . '"><i class="fa fa-commenting-o" aria-hidden="true"></i>&nbsp;' . get_comments_number() . '</a>';
				}
			}
		}

		if ( ! is_page() ) {
			$postheader .= '<div class="entry-meta">';

			if ( $this->get_option( 'post_author' ) ) {
				$postheader .= sprintf( __( '<div class="entry-author">By %s</div>', 'arras' ), '<address class="author vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" title="' . esc_attr( get_the_author() ) . '">' . get_the_author() . '</a></address>' );
			}

			if ( $this->get_option( 'post_date' ) ) {
				$postheader .= ' &ndash; <span class="published" title="' . get_the_time( 'c' ) . '">' . sprintf( __( 'Posted %s', 'arras' ), $this->posted_on( false ) ) . '</span>';
			}

			if ( current_user_can( 'edit_post', $id ) ) {
				$postheader .= '<a class="post-edit-link" href="' . get_edit_post_link( $id ) . '" title="' . __( 'Edit Post', 'arras' ) . '">' . __( '(Edit Post)', 'arras' ) . '</a>';
			}

			if ( ! is_attachment() && $this->get_option( 'post_cats' ) ) {
				$post_cats = array();
				$cats      = get_the_category();
				foreach ( $cats as $c ) {
					$post_cats[] = '<a href="' . get_category_link( $c->cat_ID ) . '">' . $c->cat_name . '</a>';
				}

				$postheader .= sprintf( __( '<span class="entry-cat"><strong>Posted in: </strong>%s</span>', 'arras' ), implode( ', ', $post_cats ) );
			}

			$postheader .= '</div>';
		}

		if ( $this->get_option( 'single_thumbs' ) && has_post_thumbnail( $post->ID ) ) {
			$postheader .= '<div class="entry-photo">' . get_the_post_thumbnail() . '</div>';
		}

		echo apply_filters( 'arras_postheader', $postheader );
	}

	/**
	 * Called to display post footer for news in single posts
	 * @since 1.2.2
	 */
	function postfooter() {
		global $id, $post;

		$postfooter = '';

		if ( $this->get_option( 'post_tags' ) && ! is_attachment() && is_array( get_the_tags() ) ) {
			$postfooter .= '<div class="entry-meta-footer"><span class="entry-tags">' . __( 'Tags:', 'arras' ) . '</span>' . get_the_tag_list( ' ', ', ', ' ' ) . '</div>';
		}

		echo apply_filters( 'arras_postfooter', $postfooter );
	}

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	function post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		include ARRAS_VIEWS_DIR . 'post-nav.php';
	}

	/**
	 * Displays when the specified post/archive requested by the user is not found.
	 * @since    1.2.2
	 */
	function post_notfound() {
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
					if ( $weeks > 1 ) {
						$result = sprintf( __( '%s weeks ago', 'arras' ), number_format_i18n( $weeks ) );
					} else {
						$result = __( '1 week ago', 'arras' );
					}
				} elseif ( $days > 0 ) {
					// days
					if ( $days > 1 ) {
						$result = sprintf( __( '%s days ago', 'arras' ), number_format_i18n( $days ) );
					} else {
						$result = __( '1 day ago', 'arras' );
					}
				} elseif ( $hours > 0 ) {
					// hours
					if ( $hours > 1 ) {
						$result = sprintf( __( '%s hours ago', 'arras' ), number_format_i18n( $hours ) );
					} else {
						$result = __( '1 hour ago', 'arras' );
					}
				} elseif ( $minutes > 0 ) {
					// minutes
					if ( $minutes > 1 ) {
						$result = sprintf( __( '%s minutes ago', 'arras' ), number_format_i18n( $minutes ) );
					} else {
						$result = __( '1 minute ago', 'arras' );
					}
				} else {
					// seconds
					$result = __( 'less than a minute ago', 'arras' );
				}
			}

		}

		if ( $echo ) {
			echo $result;
		}

		return $result;
	}

	function list_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="comment-node" id="comment-<?php comment_ID(); ?>">
			<div class="comment-controls">
				<?php comment_reply_link( array_merge( $args, array( 'depth'     => $depth,
				                                                     'max_depth' => $args['max_depth']
				) ) ) ?>
			</div>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $size = 40 ) ?>
				<div class="fn comment-author-name"><?php echo get_comment_author_link() ?></div>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'arras' ) ?></span>
			<?php endif; ?>
			<div class="comment-meta commentmetadata">
				<?php printf( __( 'Posted %1$s at %2$s', 'arras' ), '<abbr class="comment-datetime" title="' . get_comment_time( __( 'c', 'arras' ) ) . '">' . get_comment_time( __( 'F j, Y', 'arras' ) ), get_comment_time( __( 'g:i A', 'arras' ) ) . '</abbr>' ); ?>
			</div>
			<div class="comment-content"><?php comment_text() ?></div>
		</div>
		<?php
	}

	function list_trackbacks( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
	<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID() ?>">
		<div id="trackback-<?php comment_ID(); ?>">
			<?php echo get_comment_author_link() ?>
		</div>
		<?php
	}

}