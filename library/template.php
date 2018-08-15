<?php

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
function arras_body_class() {
	if ( function_exists('body_class') ) {
		$body_class = array('layout-' . arras_get_option('layout'), 'no-js');
		
			$body_class[] = 'style-' . arras_get_option('style');

		body_class( apply_filters('arras_body_class', $body_class) );
	}
}

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

function arras_featured_loop( $display_type = 'default', $arras_args = array() ) {

		$arras_args = arras_prep_query($arras_args);
		$q = new WP_Query($arras_args);

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
	$_defaults = array(
		'list'				=> array(),
		'taxonomy'			=> 'category',

		'query'				=> array(
			'exclude'			=> array(),
			'post_type'			=> 'post',
			'posts_per_page'	=> 10,
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		)
	);
	
	$args['query'] = wp_parse_args($args['query'], $_defaults['query']);
	$args = wp_parse_args($args, $_defaults);

	if ( !is_array($args['list']) ) {
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
		unset($args['list'][$key]);
	}
	
	// taxonomies
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

function arras_post_class() {
	post_class( apply_filters('arras_post_class', array( 'entry', 'clearfix' ) ) );
}

function arras_single_post_class() {
	post_class( apply_filters('arras_single_post_class', array( 'singular', 'clearfix', 'single-post')) );
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

/**
 * @todo
 * Function adapted from http://graveyard.maniacalrage.net/etc/relative/.
 * @since 1.6
 */
function arras_posted_on( $echo = 1 ) {
	$result = '';
	
	if ( !arras_get_option( 'relative_postdates' ) ) {
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

function arras_social_nav() {
?>
	<ul class="quick-icons quick-nav clearfix">
		<?php $facebook_profile = arras_get_option('facebook_profile'); ?>
		<?php if ($facebook_profile != '') : ?>
			<li><a class="facebook" title="<?php printf( __( '%s Facebook', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $facebook_profile ?>" target="_blank"><?php _e('Facebook', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php $flickr_profile = arras_get_option('flickr_profile'); ?>
		<?php if ($flickr_profile != '') : ?>
			<li><a class="flickr" title="<?php printf( __( '%s Flickr', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $flickr_profile ?>" target="_blank"><?php _e('Flickr', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php $gplus_profile = arras_get_option('gplus_profile'); ?>
		<?php if ($gplus_profile != '') : ?>
			<li><a class="gplus" title="<?php printf( __( '%s Google+', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $gplus_profile ?>" target="_blank"><?php _e('Google+', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php $twitter_username = arras_get_option('twitter_username'); ?>
		<?php if ($twitter_username != '') : ?>
			<li><a class="twitter" title="<?php printf( __( '%s Twitter', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="http://www.twitter.com/<?php echo $twitter_username ?>/" target="_blank"><?php _e('Twitter', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php $youtube_profile = arras_get_option('youtube_profile'); ?>
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

add_action( 'wp_enqueue_scripts', 'arras_constrain_footer_sidebars' );
function arras_constrain_footer_sidebars() {
	$arras           = Arras\Theme::getArras();
	$footer_sidebars = arras_get_option( 'footer_sidebars' );

	if ( $footer_sidebars == '' ) {
		$footer_sidebars = 1;
	}

	$width = ceil( 920 / $footer_sidebars );
	$css   = '.footer-sidebar{width:' . $width . 'px;}';

	$arras->assets->addInlineStyle( $css );
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

function arras_add_sidebars() {
	register_sidebar( array(
		'name'          => 'Primary Sidebar',
		'id'            => 'primary',
		'before_widget' => '<div id="%1$s" class="%2$s widget-container widgetcontainer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title widgettitle">',
		'after_title'   => '</h5>'
	) );
	register_sidebar( array(
		'name'          => 'Secondary Sidebar',
		'id'            => 'secondary',
		'before_widget' => '<div id="%1$s" class="%2$s widget-container widgetcontainer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title widgettitle">',
		'after_title'   => '</h5>'
	) );
	register_sidebar( array(
		'name'          => 'Bottom Content #1',
		'id'            => 'bottom-1',
		'before_widget' => '<div id="%1$s" class="%2$s widget-container widgetcontainer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title widgettitle">',
		'after_title'   => '</h5>'
	) );
	register_sidebar( array(
		'name'          => 'Bottom Content #2',
		'id'            => 'bottom-2',
		'before_widget' => '<div id="%1$s" class="%2$s widgetcontainer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title widgettitle">',
		'after_title'   => '</h5>'
	) );

	$footer_sidebars = arras_get_option( 'footer_sidebars' );
	if ( $footer_sidebars == '' ) {
		$footer_sidebars = 1;
	}

	for ( $i = 1; $i < $footer_sidebars + 1; $i ++ ) {
		register_sidebar( array(
			'name'          => 'Footer Sidebar #' . $i,
			'id'            => 'footer-' . $i,
			'before_widget' => '<div id="%1$s" class="%2$s widget-container widgetcontainer clearfix">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title widgettitle">',
			'after_title'   => '</h5>'
		) );
	}
}

function register_alternate_layout( $id, $name ) {
	global $arras_registered_alt_layouts;
	$arras_registered_alt_layouts[ $id ] = $name;
}