<?php

add_filter( 'arras_postheader', 'arras_post_taxonomies' );


/**
 * Called to display post meta information in single posts (review scores, product information, etc.)
 * @since 1.2.2
 */
function arras_postmeta($content) {
	global $post;

	$postmeta = '';

	$custom_fields_list = arras_parse_single_custom_fields();

	if ($custom_fields_list) {
		foreach($custom_fields_list as $field_id => $field_name) {
			if ( $field_value = get_post_meta($post->ID, $field_id, true) ) {
				$postmeta .= '<div class="single-post-meta clearfix">';
				$postmeta .= '<span class="single-post-meta-field single-post-meta-' . $field_id . '">' . $field_name . '</span>';
				$postmeta .= '<span class="single-post-meta-value single-post-meta-' . $field_id . '-value">' . $field_value . '</span>';
				$postmeta .= '</div>';
			}
		}
	}

	if ( arras_get_option('single_meta_pos') == 'bottom' ) return $postmeta . $content;
	else return $content . $postmeta;
}

/**
 * Called to display custom taxonomies in single posts (review scores, product information, etc.)
 * @since 1.5
 */
function arras_post_taxonomies($content) {
	global $post;
	$postmeta = '';

	if (arras_get_option('single_custom_taxonomies') == '') return $content;

	$arr = explode( ',', arras_get_option('single_custom_taxonomies') );
	$final = array();

	if ( !is_array($arr) ) return $content;

	foreach($arr as $term) {
		$term_list = get_the_term_list($post->ID, $term, '', ', ', '');
		$term_obj = get_taxonomy($term);

		if ( !is_wp_error($term_list) && !empty($term_list) ) {
			$postmeta .= '<div class="single-post-meta clearfix">';
			$postmeta .= '<span class="single-post-meta-field single-post-meta-' . $term . '">' . $term_obj->labels->name . ':</span>';
			$postmeta .= '<span class="single-post-meta-value single-post-meta-' . $term . '-value">' . $term_list  . '</span>';
			$postmeta .= '</div>';
		}
	}

	return $content . $postmeta;
}

/**
 * Displays author information after post content. Can be turned off in theme options.
 * @since 1.4.4
 */
function arras_post_aboutauthor() {
	$id = get_the_author_meta('ID');

	$output = '
		<div class="about-author clearfix">
			<a href="' . get_author_posts_url($id) . '">' . get_avatar($id, 64) . '</a>
			<div class="author-meta">
				<h4>' . sprintf(__('About %s', 'arras'),  get_the_author_meta('display_name')) . '</h4>
			' . get_the_author_meta('description') . '
			</div>
		</div>
	';

	echo apply_filters('arras_post_aboutauthor', $output);
}

/* End of file filters.php */
/* Location: ./library/filters.php */
