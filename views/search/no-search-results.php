<?php
/**
 * Html for no search results.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<div class="search-results-no-content">
	<p>
		<?php printf(
			__( 'Oh snap! Nothing found for: %s', 'arras' ),
			'<span class="search-terms">' . esc_html( get_search_query() ) . '</span>'
		); ?>
	</p>
</div>
