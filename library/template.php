<?php
/**
 * template.php
 *
 * Functions for various template elements
 *
 * @package Arras
 * @author Melvin Lee (2009-2013)
 * @author Caspar Green <caspar@iCasparWebDevelopment.com>
 *
 * Latest Update: 1.6.2
 *
 */

/** ===== Header support functions ===== */

add_action( 'wp_head', 'arras_favicons' );
/**
 * Outputs available favicons
 * @return null Outputs favicon html for use in <head>
 */
function arras_favicons() {
	$color = '#123456';
	$type = 'image/png';
	$favicon = esc_url( arras_get_option( 'favicon' ) );
	$apple_icon = esc_url( arras_get_option( 'appleicon' ) );
	$ms_tile_color = esc_attr( $color );
	$ms_tile_image = esc_url( arras_get_option( 'mstileimage' ) );

	if ( ! $favicon ) {
		$type = 'image/x-icon';
		if ( ! file_exists( ABSPATH . 'favicon.ico' ) ) {
			$favicon = get_stylesheet_directory_uri() . '/images/favicon.ico';
		} else {
			$favicon = get_site_url( 'favicon.ico' );
		}
	}
	echo '<link rel="icon" type="' . $type . '" href="' . $favicon . '" />';
	if ( '' != $apple_icon ) {
		echo '<link rel="apple-touch-icon-precomposed" href="' . $apple_icon . '" />';
	}
	if ( '' != $ms_tile_color ) {
		echo '<meta name="msapplication-TileColor" content="' . $ms_tile_color . '" />';
	}
	if ( '' != $ms_tile_image ) {
		echo '<meta name="msapplication-TileImage" content="' . $ms_tile_image . '" />';
	}
} // end arras_favicons()

/**
 * Generates HTML for custom logo, if one is set
 * @return null
 */
function arras_add_custom_logo() {
	$arras_logo = arras_get_option( 'site_logo' );
	if ( $arras_logo ) {
		echo '<img src="' . esc_url( $arras_logo ) .
			'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .
			' - ' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '" />';
	}
}

/** ===== Page Structure support functions ===== */



/**
 * Displays html for widget area(s) below content if they're active
 * @return null
 */
function arras_main_column_widgets() {
	if ( is_active_sidebar( 'below-content-1' ) || is_active_sidebar( 'below-content-2' ) ):
		if ( is_active_sidebar ('below-content-1' ) && is_active_sidebar( 'below-content-2' ) ) {
			$n = '1';
		} else {
			$n = '2';
		} ?>
		<div id="below-content" class="group">
			<?php if ( is_active_sidebar( 'below-content-1' ) ): ?>
			<div class="below-content-widgets col span_<?php echo $n;?>_of_2">
				<ul class="group xoxo">
					<?php dynamic_sidebar( 'below-content-1' ); ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'below-content-2' ) ): ?>
			<div class="below-content-widgets col span_<?php echo $n;?>_of_2">
				<ul class="group xoxo">
					<?php dynamic_sidebar( 'below-content-2' ); ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	<?php endif;
}

function arras_get_page_no() {
	if ( get_query_var('paged') ) print ' | Page ' . get_query_var('paged');
}



/**
 * Based on Thematic's thematic_tag_query()
 */
function arras_tag_query() {
	$nice_tag_query = get_query_var('tag'); // tags in current query
	$nice_tag_query = str_replace(' ', '+', $nice_tag_query); // get_query_var returns ' ' for AND, replace by +
	$tag_slugs = preg_split('%[,+]%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of tag slugs
	$tag_ops = preg_split('%[^,+]*%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of operators

	$tag_ops_counter = 0;
	$nice_tag_query = '';

	foreach ($tag_slugs as $tag_slug) {
		$tag = get_term_by('slug', $tag_slug ,'post_tag');
		// prettify tag operator, if any
		if ( isset($tag_ops[$tag_ops_counter]) && $tag_ops[$tag_ops_counter] == ',') {
			$tag_ops[$tag_ops_counter] = ', ';
		} elseif ( isset($tag_ops[$tag_ops_counter]) && $tag_ops[$tag_ops_counter] == '+') {
			$tag_ops[$tag_ops_counter] = ' + ';
		} else {
			$tag_ops[$tag_ops_counter] = '';
		}
		// concatenate display name and prettified operators
		$nice_tag_query = $nice_tag_query.$tag->name.$tag_ops[$tag_ops_counter];
		$tag_ops_counter += 1;
	}
	 return $nice_tag_query;
}

/**
 * Generates semantic classes for BODY element.
 * Sandbox's version was removed from 1.4 onwards.
 */
function arras_body_class($classes) {
	if ( function_exists('body_class') ) {
		$classes[] = 'layout-' . arras_get_option( 'layout' );

		if ( ! defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
			$classes[] = 'style-' . arras_get_option('style');
		}
		return $classes;
	}
}
add_filter( 'body_class', 'arras_body_class' );

/**
 * Use arras_featured_loop() for front page loops.
 */
function arras_render_posts($args = null, $display_type = 'default', $taxonomy = 'category') {
	global $post, $wp_query, $arras_tapestries;

	if (!$args) {
		$query = $wp_query;
	} else {
		$query = new WP_Query($args);
	}

	if ($query->have_posts()) {
		arras_get_tapestry_callback($display_type, $query, $taxonomy);
	}

	wp_reset_query();
}

function arras_featured_loop( $display_type = 'default', $arras_args = array(), $query_posts = false ) {
	global $wp_query;

	if ($query_posts) {
		$q = $wp_query;
	} else {
		$arras_args = arras_prep_query($arras_args);
		$q = new WP_Query($arras_args);
	}

	if ($q->have_posts()) {
		if ( !isset($arras_args['taxonomy']) ) $arras_args['taxonomy'] = 'category';
		arras_get_tapestry_callback($display_type, $q, $arras_args['taxonomy']);
	}

	wp_reset_query();
}

/**
 * This function replaces arras_parse_query() starting from 1.5.1.
 */
function arras_prep_query( $args = array() ) {
	global $post;
	$ignore_taxonomy = false;
	$_defaults = array(
		'list'				=> array(),
		'taxonomy'			=> 'category',

		'query'				=> array(
			'exclude'			=> array(),
			'post_type'			=> 'post',
			'posts_per_page'	=> get_option( 'posts_per_page' ),
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		)
	);

	$args['query'] = wp_parse_args($args['query'], $_defaults['query']);
	$args = wp_parse_args($args, $_defaults);

	// Check whether we have categories/terms specified, and if so make sure they're in an array
	if ( ! $args['list'] ) {
		$ignore_taxonomy = true;
	}
	if ( ! is_array( $args['list'] ) ) {
		$args['list'] = array($args['list']);
	}

	// sticky posts
	if ( in_array('-5', $args['list']) ) {
		$stickies = get_option('sticky_posts');
		rsort($stickies);
		if ( count($stickies) > 0 ) {
			$args['query']['post__in'] = $stickies;
		} else {
			// if no sticky posts are available, return empty value
			return false;
		}

		$key = array_search('-5', $args['list']);
		if ( $args['list'][0] == null ) array_shift( $args['list'] );
		unset($args['list'][$key]);
	}

	// Check whether our current post type has taxonomies
	if ( ! $taxonomies = get_object_taxonomies( $args['query']['post_type'], 'objects' ) ) $ignore_taxonomy = true;

	if ( ! $ignore_taxonomy ) {
		switch( $args['taxonomy'] ) {
			case 'category':

				$zero_key = array_search('0', $args['list']);
				if (is_numeric($zero_key)) unset($args['list'][$zero_key]);

				$args['query']['category__in'] = $args['list'];
				break;

			case 'post_tag':
				$args['query']['tag__in'] = $args['list'];
				break;

			default:
				$taxonomy_obj = get_taxonomy($args['taxonomy']);

				$args['list'] = implode($args['list'], ',');
				$args['query'][$taxonomy_obj->query_var] = $args['list'];
		}
	}


	if (is_home() && arras_get_option('hide_duplicates')) {
		$args['query']['post__not_in'] = array_unique($args['query']['exclude']);
	}

	if ($args['query']['post_type'] == 'attachment') {
		$args['query']['post_status'] = 'inherit';
	}

	//arras_debug($args['query']);
	return $args['query'];
}

function arras_list_trackbacks($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID() ?>">
		<div id="trackback-<?php comment_ID(); ?>">
		<?php echo get_comment_author_link() ?>
		</div>
<?php
}

function arras_list_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="comment-node" id="comment-<?php comment_ID(); ?>">
			<div class="comment-controls">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<div class="comment-author vcard">
			<?php echo get_avatar($comment, $size = 32) ?>
			<cite class="fn"><?php echo get_comment_author_link() ?></cite>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="comment-moderation"><?php _e('Your comment is awaiting moderation.', 'arras') ?></span>
			<?php endif; ?>
			<div class="comment-meta commentmetadata">
				<?php printf( __('Posted %1$s at %2$s', 'arras'), '<abbr class="comment-datetime" title="' . get_comment_time( __('c', 'arras') ) . '">' . get_comment_time( __('F j, Y', 'arras') ), get_comment_time( __('g:i A', 'arras') ) . '</abbr>' ); ?>
			</div>
			<div class="comment-content"><?php comment_text() ?></div>
		</div>
<?php
}


function arras_parse_single_custom_fields() {
	if (arras_get_option('single_custom_fields') == '') return false;

	$arr = explode( ',', arras_get_option('single_custom_fields') );
	$final = array();

	if ( !is_array($arr) ) return false;

	foreach ( $arr as $val ) {
		$field_arr = explode(':', $val);
		$final[ $field_arr[1] ] = $field_arr[0];
	}

	return $final;
}

function arras_excerpt_more($excerpt) {
	return str_replace(' [...]', '...', $excerpt);
}
add_filter('excerpt_more', 'arras_excerpt_more');

function arras_excerpt_length($length) {
	if (!arras_get_option('excerpt_limit')) $limit = 30;
	else $limit = arras_get_option('excerpt_limit');

	return $limit;
}
add_filter('excerpt_length', 'arras_excerpt_length');


function arras_social_nav() {
?>
	<ul class="quick-nav col span_1_of_4">
		<?php if ( arras_get_option( 'show_rss' ) ): ?>
			<li><a class="rss" title="<?php printf( __( '%s RSS Feed', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Feed', 'arras') ?></a></li>
		<?php endif; ?>
		<?php $facebook_profile = arras_get_option( 'facebook' ); ?>
		<?php if ($facebook_profile != '') : ?>
			<li><a class="facebook" title="<?php printf( __( '%s Facebook', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $facebook_profile ?>" target="_blank"><?php _e('Facebook', 'arras') ?></a></li>
		<?php endif ?>

		<?php $flickr_profile = arras_get_option('flickr'); ?>
		<?php if ($flickr_profile != '') : ?>
			<li><a class="flickr" title="<?php printf( __( '%s Flickr', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $flickr_profile ?>" target="_blank"><?php _e('Flickr', 'arras') ?></a></li>
		<?php endif ?>

		<?php $gplus_profile = arras_get_option('google'); ?>
		<?php if ($gplus_profile != '') : ?>
			<li><a class="gplus" title="<?php printf( __( '%s Google+', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $gplus_profile ?>" target="_blank"><?php _e('Google+', 'arras') ?></a></li>
		<?php endif ?>

		<?php $twitter_username = arras_get_option('twitter'); ?>
		<?php if ($twitter_username != '') : ?>
			<li><a class="twitter" title="<?php printf( __( '%s Twitter', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $twitter_username ?>/" target="_blank"><?php _e('Twitter', 'arras') ?></a></li>
		<?php endif ?>

		<?php $youtube_profile = arras_get_option('youtube'); ?>
		<?php if ($youtube_profile != '') : ?>
			<li><a class="youtube" title="<?php printf( __( '%s YouTube', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $youtube_profile ?>" target="_blank"><?php _e('YouTube', 'arras') ?></a></li>
		<?php endif ?>

		<?php do_action('arras_quick_nav'); // hook to include additional social icons, etc. ?>
	</ul>
<?php
}

function arras_add_searchbar() {
	?><div id="searchbar"><?php get_search_form() ?></div><?php
}

function arras_blacklist_duplicates() {
	global $post, $post_blacklist;
	if (is_home() && arras_get_option('hide_duplicates')) {
		$post_blacklist[] = $post->ID;
	}
}

function arras_nav_fallback_cb() {
	echo '<ul class="sf-menu menu clearfix">';
	wp_list_categories('hierarchical=1&orderby=id&hide_empty=1&title_li=');
	echo '</ul>';
}

function arras_debug($exp) {
	//if (current_user_can('manage_options')) {
		echo '<pre><code style="max-height: 200px; overflow: scroll">' . htmlentities( print_r($exp, true) ) . '</code></pre>';
	//}
}
