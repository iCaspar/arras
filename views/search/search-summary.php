<?php
/**
 * Html output for search summary.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<h1 class="search-results-title"><?php _e( 'Search Results', 'arras' ) ?></h1>
<div class="search-results-content">
	<p>
		<?php printf(
			__( 'Search Results for: %s', 'arras' ),
			'<span class="search-terms">' . esc_html( get_search_query() ) . '</span>'
		); ?>
	</p>
	<?php get_search_form(); ?>
</div>
