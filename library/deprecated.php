<?php
/**
 * @deprecated 1.5.1 Use arras_prep_query().
 */
function arras_parse_query($list, $count, $exclude = null, $post_type = '', $taxonomy = '') {
	$query = array();
	
	if ($post_type == '') $post_type = 'post';
	if ($taxonomy == '') $taxonomy = 'category';
	
	if ($list != false) {
		if ((array)$list !== $list) {
			$list = array($list);
		}
		
		if ( in_array('-5', $list) ) {
			$stickies = get_option('sticky_posts');
			rsort($stickies);
			if (count($stickies) > 0) {
				$query['post__in'] = $stickies;
			} else {
				// if no sticky posts are available, return empty value
				return false;
			}
		
			$key = array_search('-5', $list);
			unset($list[$key]);
		}
	
		switch($taxonomy) {
			case 'category':
				if ( ($zero_cat = array_search('0', $list)) === true )
					unset($list[$zero_cat]);
					
				$query['category__in'] = $list;
				break;
				
			case 'post_tag':
				$query['tag__in'] = $list;
				break;
				
			default:
				$taxonomy_obj = get_taxonomy($taxonomy);
				
				$list = implode($list, ',');
				$query[$taxonomy_obj->query_var] = $list;
		}

	}

	$query['post_type'] = $post_type;
	$query['posts_per_page'] = $count;
	
	if (is_home() && arras_get_option('hide_duplicates')) {
		$query['post__not_in'] = $exclude;
	}
	
	if ($post_type == 'attachment') {
		$query['post_status'] = 'inherit';
	}

	//print_r($query);
	
	return $query;
}


/**
 * @deprecated 1.5.1 Use arras_render_posts().
 */
function arras_get_posts($page_type, $query = null) {
	global $post, $wp_query;
	
	if (!$query) $query = $wp_query;
	if ( $query->have_posts() ) : ?>

<?php if (arras_get_option($page_type . '_display') == 'traditional') : ?>
	<div class="traditional hfeed">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<div <?php arras_single_post_class() ?>>
        <?php arras_postheader() ?>
		<div class="entry-content clearfix"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
		<?php arras_postfooter() ?>
    </div>
	<?php endwhile; ?>
	</div><!-- .traditional -->
<?php elseif (arras_get_option($page_type . '_display') == 'line') : ?>
	<ul class="hfeed posts-line clearfix">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<li <?php arras_post_class() ?>>
	
		<?php if(!is_archive()) : ?>
		<span class="entry-cat">
			<?php $cats = get_the_category(); 
			if (arras_get_option('news_cat')) echo $cats[1]->cat_name;
			else echo $cats[0]->cat_name; ?>
		</span>
		<?php endif ?>
		
		<h3 class="entry-title"><a rel="bookmark" href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>"><?php the_title() ?></a></h3>
		<span class="entry-comments"><?php comments_number() ?></span>
	</li>
	<?php endwhile; ?>
	</ul>
<?php else : ?>
	<ul class="hfeed posts-<?php echo arras_get_option($page_type . '_display') ?> clearfix">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<li <?php arras_post_class() ?>>
		
		<?php // arras_newsheader($page_type) ?>
		<div class="entry-summary">
			<?php 
			if ( arras_get_option($page_type . '_display') == 'default' ) {
				//echo arras_strip_content(get_the_excerpt(), 20);
				echo get_the_excerpt();
			} else {
				echo get_the_excerpt();
				?>
				<p class="quick-read-more"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>">
				<?php _e('Read More', 'arras') ?>
				</a></p>
				<?php
			}
			?>
		</div>
		<?php // arras_newsfooter($page_type) ?>
	</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

<?php endif; ?>

<?php
}

/**
 * @deprecated 1.5.1 Use esc_html( get_the_excerpt() ).
 */
function arras_strip_content($content, $limit) {
	$content = apply_filters('the_content', $content);
	
	$content = strip_tags($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	
	$words = explode(' ', $content, ($limit + 1));
	if(count($words) > $limit) {
		array_pop($words);
		//add a ... at last article when more than limit word count
		return implode(' ', $words) . '...'; 
	} else {
		//otherwise
		return implode(' ', $words); 
	}
}

/**
 * @deprecated 1.8 SEO descriptions should be handled by a plugin.
 */
function arras_document_description() {
	if ( class_exists('All_in_One_SEO_Pack') || class_exists('Platinum_SEO_Pack') ) return false;

	if ( is_single() || is_page() ) {
		if ( have_posts() ) {
			while( have_posts() ) {
				the_post();
				echo '<meta name="description" content="' . esc_attr( get_the_excerpt() ) . '" />';
			}
		}
	} else {
		echo '<meta name="description" content="' . esc_attr( get_bloginfo('description') ) . '" />';
	}
}

/**
 * @deprecated 1.8 OpenGraph meta should be handled by a plugin.
 */
function arras_add_facebook_share_meta() {
	global $post;
	if ( is_single() ) {
		if ( has_post_thumbnail( $post->ID ) )
			$thumb_id = get_post_thumbnail_id( $post->ID );
        elseif ( arras_get_option( 'auto_thumbs' ) )
			$thumb_id = arras_get_first_post_image_id();

		if ( !$thumb_id ) return false;

		$image = wp_get_attachment_image_src( $thumb_id );
		$src = $image[0];
		?>
        <meta property="og:title" content="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>" />
        <meta property="og:description" content="<?php echo esc_attr( get_the_excerpt() ); ?>" />
        <meta property="og:image" content="<?php echo esc_attr( $image[0] ); ?>" />
		<?php
	}
}