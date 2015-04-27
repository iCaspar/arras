<?php

function arras_add_slideshow() {
	global $post_blacklist, $paged;

	if ( !is_home() || $paged ) return false; // if we're not on the first page of the homepage, quit
	if ( arras_get_option( 'enable_slideshow' ) == false ) return false; // if the slideshow option is disabled, quit

	$slideshow_cat = arras_get_option('slideshow_cat');

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
		<div id="controls" class="slide-controls">
			<div class="cycle-prev"><?php _e('Prev', 'arras') ?></div>
			<div class="cycle-next"><?php _e('Next', 'arras') ?></div>
		</div>
		<div class="cycle-slideshow"
				data-cycle-swipe=true
				data-cycle-swipe-fx=scrollHorz
				data-cycle-speed=1000
				data-cycle-prev=".cycle-prev"
				data-cycle-next=".cycle-next"
				data-cycle-auto-height="16:9"
				data-cycle-caption-plugin="caption2"
				data-cycle-overlay-template="<h3 class=entry-title>{{title}}</h3><div class=entry-summary>{{excerpt}}</div>">
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
	$slide = substr_replace( $slide, $slide_data, strpos( $slide, ' />' ), 0 );
	return $slide;
}
