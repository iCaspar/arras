<?php
/**
 * This file will eventually place the codes for theme widgets that is
 * compatible with WordPress 2.8.
 */


class Arras_Featured_Stories extends WP_Widget {

	// Constructor
	function Arras_Featured_Stories() {
		$widget_args = array(
			'classname'		=> 'arras_featured_stories',
			'description'	=> __('Featured stories containing post thumbnails and the excerpt based on categories.', 'arras'),
		);
		$this->WP_Widget('arras_featured_stories', __('Featured Stories', 'arras'), $widget_args);
	}

	function widget($args, $instance) {
		global $wpdb;
		extract($args, EXTR_SKIP);

		if ($instance['no_display_in_home'] && is_home()) {
			return false;
		}

		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;
		echo $before_title . $title . $after_title;

		arras_widgets_post_loop('featured-stories', array(
			'list'				=> $instance['featured_cat'],
			'show_thumbs'		=> $instance['show_thumbs'],
			'show_excerpt'		=> $instance['show_excerpts'],
			'query'				=> array(
				'posts_per_page'	=> $instance['postcount']
			)
		) );

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['featured_cat'] = $new_instance['featured_cat'];
		$instance['postcount'] = (int)strip_tags($new_instance['postcount']);
		$instance['no_display_in_home'] = (boolean)($new_instance['no_display_in_home']);
		$instance['show_excerpts'] = (boolean)($new_instance['show_excerpts']);
		$instance['show_thumbs'] = (boolean)($new_instance['show_thumbs']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> __('Featured Stories', 'arras'),
			'featured_cat' 			=> 0,
			'postcount' 			=> 5,
			'no_display_in_home' 	=> true,
			'show_excerpts' 		=> true,
			'show_thumbs'			=> true
		) );

		if (!is_array($instance['featured_cat'])) $instance['featured_cat'] = array(0);

		?>
		<p><label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title:', 'arras') ?></label><br />
		<input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" size="33" value="<?php echo strip_tags($instance['title']) ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('featured_cat') ?>"><?php _e('Featured Categories:', 'arras') ?></label><br />
		<select multiple="multiple" style="width: 200px; height: 75px" name="<?php echo $this->get_field_name('featured_cat') ?>[]">
			<option<?php selected( in_array( 0, $instance['featured_cat'] ), true ) ?> value="0"><?php _e('All Categories', 'arras') ?></option>
		<?php
		foreach( get_categories('hide_empty=0') as $c ) {
			$selected = '';
			echo '<option' . selected( in_array($c->cat_ID, $instance['featured_cat']), true ) . ' value="' . $c->cat_ID . '">' . $c->cat_name . '</option>';
		}
		?>
		</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('postcount') ?>"><?php _e('How many items would you like to display?', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('postcount') ?>" name="<?php echo $this->get_field_name('postcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php selected($i, $instance['postcount']) ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select>
		</p>

		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('no_display_in_home') ?>" <?php checked($instance['no_display_in_home'], 1) ?> />
		<label for="<?php echo $this->get_field_id('no_display_in_home') ?>"><?php _e('Do not display in homepage', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_excerpts') ?>" <?php checked($instance['show_excerpts'], 1) ?> />
		<label for="<?php echo $this->get_field_id('show_excerpts') ?>"><?php _e('Show post excerpts', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_thumbs') ?>" <?php checked($instance['show_thumbs'], 1) ?> />
		<label for="<?php echo $this->get_field_id('show_thumbs') ?>"><?php _e('Show thumbnails', 'arras') ?></label>
		</p>
		<?php
	}

}


class Arras_Widget_Search extends WP_Widget {

	function Arras_Widget_Search() {
		$widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for your site", 'arras' ) );
		$this->WP_Widget('search', __('Search', 'arras'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);

		// Use current theme search form if it exists
		echo '<li class="widgetcontainer clearfix"><div class="widgetcontent">';
		get_search_form();
		echo '</div></li>';
	}

	function form( $instance ) {

	}

	function update( $new_instance, $old_instance ) {

	}

}

function arras_widgets_post_loop( $id, $args = array() ) {
	global $wp_query, $post;

	$_defaults = array(
		'taxonomy'			=> 'category',
		'show_thumbs'		=> true,
		'show_excerpt'		=> true,
		'query'				=> array(
			'post_type'			=> 'post',
			'posts_per_page'	=> 5,
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		)
	);

	$args['query'] = wp_parse_args($args['query'], $_defaults['query']);
	$args = wp_parse_args($args, $_defaults);

	$q = new WP_Query( arras_prep_query($args) );

	if ( $q->have_posts() ) {
		echo '<ul class="' . $id . '">';
		while( $q->have_posts() ) {
			$q->the_post();

			// hack for plugin authors who love to use $post = $wp_query->post
			$wp_query->post = $q->post;
			setup_postdata($post);

			?> <li class="group"> <?php
			if ($args['show_thumbs']) {
				echo '<a rel="bookmark" href="' . get_permalink() . '" class="widget-thumb">' . arras_get_thumbnail( 'square-thumbnail', get_the_ID() ) . '</a>';
			}
			?>
			<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
			<span class="sub"><?php printf( __( 'Posted %s', 'arras' ), arras_posted_on( false ) ); ?> |
			<a href="<?php comments_link() ?>"><?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></a>
			</span>

			<?php if ($args['show_excerpt']) : ?>
			<p class="excerpt">
			<?php echo get_the_excerpt() ?>
			</p>
			<a class="sidebar-read-more" href="<?php the_permalink() ?>"><?php _e('Read More', 'arras') ?></a>
			<?php endif ?>

			</li>
			<?php
		}
		echo '</ul>';
	} else {
		echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
	}

	wp_reset_query();
}

// Register Widgets
function arras_widgets_init() {
	unregister_widget('WP_Widget_Search');

	register_widget('Arras_Featured_Stories');
	register_widget('Arras_Widget_Search');
}

add_action('widgets_init', 'arras_widgets_init', 1);
