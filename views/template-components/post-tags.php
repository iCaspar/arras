<?php
/**
 * HTML for postfooter.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<div class="entry-meta-footer"><span class="entry-tags"><?php _e( 'Tags:', 'arras' ); ?></span><?php echo get_the_tag_list( ' ', ', ', ' ' ); ?></div>