<?php
/**
 * HTML to show post comment count bubble.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<a class="entry-comments-number" href="<?php echo get_comments_link(); ?>">
	<i class="fa fa-commenting-o" aria-hidden="true"></i>&nbsp;<?php echo get_comments_number(); ?></a>
