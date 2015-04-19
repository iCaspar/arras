<?php

function arras_add_slideshow() {
	global $post_blacklist, $paged;
	if ( !is_home() || $paged ) return false;

	$slideshow_cat = arras_get_option('slideshow_cat');

	if (arras_get_option('enable_slideshow') == false) return false;

	$query = arras_prep_query( array(
		'list'				=> $slideshow_cat,
		'taxonomy'			=> arras_get_option('slideshow_tax'),
		'query'				=> array(
			'posts_per_page'	=> arras_get_option('slideshow_count'),
			'exclude'			=> $post_blacklist,
			'post_type'			=> arras_get_option('slideshow_posttype'),
			'paged'				=> $paged
		)
	) );

	$q = new WP_Query( apply_filters('arras_slideshow_query', $query) );
	if ($q->have_posts()) :
	?>
	<!-- Featured Slideshow -->
	<div class="featured group">
		<?php if ($q->post_count > 1) : ?>
		<div id="controls">
			<div class="cycle-prev"><?php _e('Prev', 'arras') ?></div>
			<div class="cycle-next"><?php _e('Next', 'arras') ?></div>
		</div>
		<div class="cycle-slideshow"
				data-cycle-prev=".cycle-prev"
				data-cycle-next=".cycle-next"
				data-cycle-auto-height="16:9"
				data-cycle-overlay-template="<div class=entry-title>{{title}}</div><div class=entry-summary>{{excerpt}}</div>">
			<?php $count = 0; ?>
			<div class="cycle-overlay custom"></div>
			<?php while ($q->have_posts()) : $q->the_post(); ?>
				<?php echo arras_make_slide('featured-slideshow-thumb'); ?>
			<?php arras_blacklist_duplicates(); // required for duplicate posts function to work. ?>
			<?php $count++; endwhile; ?>
		</div>
		<?php endif ?>
	</div>
	<?php endif;
}
add_action('arras_above_content', 'arras_add_slideshow');

function arras_make_slide() {
	global $post;
	$slide = arras_get_thumbnail('featured-slideshow-thumb');
	$slide_data = ' data-title="' . get_the_title() . '" data-cycle-excerpt="' . get_the_excerpt() . '"';
	$slide = substr_replace( $slide, $slide_data, strpos( $slide, '>' ), 0 );
	return $slide;
}

function arras_add_slideshow_js() {
	wp_register_script( 'slideshow-settings', get_template_directory_uri() . '/js/slideshowsettings.js', array( 'jquery-cycle' ), null, true );
	$slideshow_size = arras_get_image_size('featured-slideshow-thumb');
	wp_localize_script( 'slideshow-settings', 'show_size', $slideshow_size );
	if (is_home() || is_front_page()) {
		wp_enqueue_script( 'slideshow-settings' );
	}
}
add_action( 'wp_enqueue_scripts', 'arras_add_slideshow_js' );

function arras_load_slideshow_scripts() {
	if ( ( arras_get_option('enable_slideshow') ) && is_home() || is_front_page() ) {
		wp_enqueue_script('jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle2-min.js', array( 'jquery' ), null, true );
	}
}
add_action('wp_enqueue_scripts', 'arras_load_slideshow_scripts' );

function arras_add_slideshow_thumb_size() {
	$layout = arras_get_option('layout');

	if ( strpos($layout, '1c') !== false ) {
		$size = array(950, 450);
	} else if ( preg_match('/3c/', $layout) ) {
		$size = array(490, 225);
	} else {
		$size = array(640, 300);
	}

	$size = apply_filters('arras_slideshow_thumb_size', $size);
	arras_add_image_size( 'featured-slideshow-thumb', __('Featured Slideshow', 'arras'), $size[0], $size[1]);
}
add_action('arras_add_default_thumbnails', 'arras_add_slideshow_thumb_size', 5);


/* End of file slideshow.php */
/* Location: ./library/slideshow.php */