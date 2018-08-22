<?php

/**
 * Container for storing tapestries and their hook to render them.
 * @since 1.4.3
 */
$arras_tapestries = array();

/**
 * Function to add posts views into the system.
 * @since 1.4.3
 */
function arras_add_tapestry( $id, $name, $callback, $args = array() ) {
	global $arras_tapestries;
	
	if ( !is_callable($callback) ) return false;
	
	$defaults = array(
		'before' => '<div class="hfeed clearfix">',
		'after' => '</div>',
		'allow_duplicates' => true,
		'taxonomy' => 'category'
	);
	$args = wp_parse_args($args, $defaults);
	
	$args['name'] = $name;
	$args['callback'] = $callback;
	
	$arras_tapestries[$id] = (object) $args;
}

/**
 * Function to remove posts views from the system.
 * @since 1.4.3
 */
function arras_remove_tapestry($id) {
	global $arras_tapestries;
	
	unset($arras_tapestries[$id]);
} 

/**
 * Removes all posts display types from the system.
 * @since 1.4.3
 */
function arras_remove_all_tapestries() {
	global $arras_tapestries;
	
	$arras_tapestries = array();
}

/**
 * Gets tapestry callback function
 * @since 1.4.4
 */
function arras_get_tapestry_callback($type, $query, $taxonomy = 'category') {
	global $arras_tapestries, $wp_query, $post;
	
	if ( count($arras_tapestries) == 0 ) return false;
	
	if ( $arras_tapestries[$type] ) {
		$tapestry = $arras_tapestries[$type];
	} else {
		$arr = array_values($arras_tapestries);
		$tapestry = $arr[0];
	}
	
	echo $tapestry->before;
	if ( $type == 'default' ) {
		$tapestry_settings = get_option( 'arras_tapestry_default' );
		
		if ( !isset( $tapestry_settings['nodes'] ) || $tapestry_settings['nodes'] <= 0 )
			$tapestry_settings['nodes'] = 3;
		
		$c = 0;

		for ( $c; $query->have_posts(); $c++ ) {
			$query->the_post();
			if ( $c % $tapestry_settings['nodes'] == 0 ) 
				echo '<div class="clearfix">';
			
			// hack for plugin authors who love to use $post = $wp_query->post
			$wp_query->post = $query->post;
			setup_postdata($post);

			call_user_func_array( $tapestry->callback, array($dep = '', $taxonomy) );
			if ($tapestry->allow_duplicates) arras_blacklist_duplicates();
			
			if ( $c % $tapestry_settings['nodes'] == ( $tapestry_settings['nodes'] - 1 ) ) 
				echo '</div>';
		}
		
		if ( $c % $tapestry_settings['nodes'] != 0 )
			echo '</div>';
		
	} else {
		while ($query->have_posts()) {
			$query->the_post();

			// hack for plugin authors who love to use $post = $wp_query->post
			$wp_query->post = $query->post;
			setup_postdata($post);

			call_user_func_array( $tapestry->callback, array($dep = '', $taxonomy) );
			if ($tapestry->allow_duplicates) arras_blacklist_duplicates();
		}
	}
	echo $tapestry->after;
}

/**
 * Traditional tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_traditional')) {
	function arras_tapestry_traditional($dep = '', $taxonomy) {
		?>
		<div class="entry traditional-entry clearfix">
			<?php arras_postheader() ?>
			<div class="entry-content clearfix"><?php the_excerpt(); ?></div>
			<?php arras_postfooter() ?>
		</div>
		<?php
	}
	arras_add_tapestry( 'traditional', __('Traditional', 'arras'), 'arras_tapestry_traditional', array(
		'before' => '<div class="traditional hfeed">',
		'after' => '</div><!-- traditional -->'
	) );
}

/**
 * Per Line tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_line')) {
	function arras_tapestry_line($dep = '', $taxonomy) {
		?>
		<li <?php arras_post_class() ?>>
		
			<span class="entry-cat">
				<?php 
				$terms = get_the_terms( get_the_ID(), $taxonomy );
				if ( $terms != '' && !is_wp_error($terms) ) {
					$terms = array_values($terms);
					if (arras_get_option('news_cat') && isset($terms[1])) echo $terms[1]->name;
					else echo $terms[0]->name;
				}
				?>
			</span>
			
			<h3 class="entry-title"><a rel="bookmark" href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>"><?php the_title() ?></a></h3>
			<a class="entry-comments" href="<?php comments_link() ?>"><?php comments_number() ?></a>
		</li>
		<?php
	}
	arras_add_tapestry( 'line', __('Per Line', 'arras'), 'arras_tapestry_line', array(
		'before' => '<ul class="hfeed posts-line clearfix">',
		'after' => '</ul><!-- .posts-line -->'
	) );
}

/**
 * Node Based tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_default')) {
	function arras_tapestry_default($dep = '', $taxonomy) {
		$tapestry_settings = get_option('arras_tapestry_default');
		if (!is_array($tapestry_settings) ) {
			$tapestry_settings = arras_defaults_tapestry_default();
		}
		?>
		<div <?php arras_post_class() ?>>
			<?php echo apply_filters('arras_tapestry_default_postheader', arras_generic_postheader('node-based', true) ) ?>
			<?php if ( isset($tapestry_settings['excerpt']) && $tapestry_settings['excerpt'] ) : ?>
			<div class="entry-summary">
				<?php the_excerpt() ?>
			</div>
			<?php endif ?>
		</div>
		<?php
	}
	arras_add_tapestry( 'default', __('Node Based', 'arras'), 'arras_tapestry_default', array(
		'before' => '<div class="node- hfeed posts-default clearfix">',
		'after' => '</div><!-- .posts-default -->'
	) );
	
	add_action('arras_add_default_thumbnails', 'arras_add_tapestry_default_thumbs');
	add_action('arras_admin_settings-layout', 'arras_admin_tapestry_default');
	add_action('arras_admin_save', 'arras_save_tapestry_default');
	add_action('arras_options_defaults', 'arras_defaults_tapestry_default');
}

function arras_add_tapestry_default_thumbs() {
	$layout = arras_get_option('layout');
	
	if ( strpos($layout, '1c') !== false ) {
		$size = array(215, 120);
	} else if ( strpos($layout, '3c') !== false ) {
		$size = array(230, 130);
	} else {
		$size = array(195, 110);
	}
	
	arras_add_image_size( 'node-based-thumb', __('Tapestry: Node-Based', 'arras'), $size[0], $size[1] );
}

function arras_admin_tapestry_default() {
	$tapestry_settings = get_option('arras_tapestry_default');
	if (!is_array($tapestry_settings) ) {
		$tapestry_settings = arras_defaults_tapestry_default();
	}
	?>
	<h3><?php _e('Tapestry: Node Based', 'arras') ?></h3>
	<table class="form-table">

	<tr valign="top">
	<th scope="row"><label for="arras-tapestry-default-excerpt"><?php _e('Show Excerpt?', 'arras') ?></label></th>
	<td>
	<?php echo arras_form_checkbox('arras-tapestry-default-excerpt', 'show', $tapestry_settings['excerpt'], 'id="arras-tapestry-default-excerpt"') ?>
	</td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="arras-tapestry-default-height"><?php _e('Nodes per Row', 'arras') ?></label></th>
	<td>
	<?php echo arras_form_input(array('name' => 'arras-tapestry-default-nodes', 'id' => 'arras-tapestry-default-nodes', 'size' => '3', 'value' => $tapestry_settings['nodes'], 'maxlength' => 1 )) ?>
	</td>
	</tr>
	
	</table>
	<?php
}

function arras_save_tapestry_default() {
	$_tapestry_default_settings = array(
		'nodes' => (int)$_POST['arras-tapestry-default-nodes'],
		'excerpt' => isset( $_POST['arras-tapestry-default-excerpt'] )
	);

	update_option('arras_tapestry_default', $_tapestry_default_settings);
}

function arras_defaults_tapestry_default() {
	$_tapestry_default_settings = array(
		'height' => 225,
		'nodes'	=> 3,
        'excerpt' => false,
	);
	add_option('arras_tapestry_default', $_tapestry_default_settings, '', 'yes');
	
	return $_tapestry_default_settings;
}

add_action( 'wp_enqueue_scripts', 'arras_style_tapestry_default' );
function arras_style_tapestry_default() {
	$arras           = Arras\Theme::getArras();
	$node_based_size = arras_get_image_size( 'node-based-thumb' );
	$innerWidth      = $node_based_size['w'];
	$outerWidth      = $node_based_size['w'] + 10;
	$innerHeight     = $node_based_size['h'];
	$outerHeight     = $node_based_size['h'] + 10;

	$css = '.posts-default .entry{ width:' . $outerWidth . 'px;}.posts-default img,.posts-default .entry-thumbnails-link{width:'
	       . $innerWidth . 'px;height:' . $innerHeight . 'px; }.posts-default .entry-meta{ width:'
	       . $innerWidth . 'px;}.posts-default .entry-thumbnails{ width:' . $outerWidth . 'px; height:'
	       . $outerHeight . 'px;}';

	$arras->assets->addInlineStyle( $css );
}

/**
 * Quick Preview tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_quick')) {
	function arras_tapestry_quick($dep = '', $taxonomy) {
		?>
		<li <?php arras_post_class() ?>>
			<?php echo apply_filters('arras_tapestry_quick_postheader', arras_generic_postheader('quick-preview') ) ?>
			<div class="entry-summary">
				<div class="entry-info">
					<abbr class="published" title="<?php the_time('c') ?>"><?php printf( __('Posted %s', 'arras'), arras_posted_on( false ) ) ?></abbr> | <a href="<?php comments_link() ?>"><?php comments_number() ?></a>
				</div>
				<?php echo get_the_excerpt() ?>
				<p class="quick-read-more"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>">
				<?php _e('Continue Reading...', 'arras') ?>
				</a></p>
			</div>	
		</li>
		<?php
	}
	arras_add_tapestry( 'quick', __('Quick Preview', 'arras'), 'arras_tapestry_quick', array(
		'before' => '<ul class="hfeed posts-quick clearfix">',
		'after' => '</ul><!-- .posts-quick -->'		
	) );
	
	function arras_add_tapestry_quick_thumbs() {
		arras_add_image_size( 'quick-preview-thumb', __('Tapestry: Quick Preview', 'arras'), 115, 115 );
	}
	add_action('arras_add_default_thumbnails', 'arras_add_tapestry_quick_thumbs');

	add_action( 'wp_enqueue_scripts', 'arras_style_tapestry_quick' );
	function arras_style_tapestry_quick() {
		$arras              = \Arras\Theme::getArras();
		$quick_preview_size = arras_get_image_size( 'quick-preview-thumb' );
		$quick_preview_w    = $quick_preview_size['w'];
		$quick_preview_h    = $quick_preview_size['h'];

		$css = '.posts-quick .entry-thumbnails img{width:' . $quick_preview_w . 'px;height:'
		       . $quick_preview_h . 'px;}.posts-quick .entry-meta{ width:' . $quick_preview_w . 'px;}';

		$arras->assets->addInlineStyle( $css );
	}
}

/**
 * Helper function to display headers for certain tapestries.
 * @since 1.4.3
 */
function arras_generic_postheader($tapestry, $show_meta = false) {
	global $post;
	
	$postheader = '<div class="entry-thumbnails">';
	$postheader .= '<a class="entry-thumbnails-link" href="' . get_permalink() . '">';
	$postheader .= arras_get_thumbnail($tapestry . '-thumb');
	
	if ($show_meta) {	
		$postheader .= '<span class="entry-meta"><span class="entry-comments">' . get_comments_number() . '</span>';
		$postheader .= '<abbr class="published" title="' . get_the_time('c') . '">' . get_the_time( get_option('date_format') ) . '</abbr></span>';
	}
	
	$postheader .= '</a>';

	$postheader .= '</div>';
	
	$postheader .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
	
	return $postheader;
}

/* End of file tapestries.php */
/* Location: ./library/tapestries.php */