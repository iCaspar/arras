<?php
/**
 * Html output for 404 page Content
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<h3 class="entry-title"><?php _e( 'Error 404 - Not Found', 'arras' ) ?></h3>
<div class="entry-content">
	<p><strong><?php _e( "Oh Snap! That page doesn't exist or has been moved.", 'arras' ) ?></strong></p>
	<p><?php _e( 'Please make sure you have the right URL.', 'arras' ) ?></p>
	<p><?php _e( "... or try searching here:", 'arras' ) ?></p>
	<?php get_search_form(); ?>
</div>
