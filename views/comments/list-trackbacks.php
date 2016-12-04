<?php
/**
 * List trackbacks html.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>

<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID() ?>">
<div id="trackback-<?php comment_ID(); ?>">
	<?php echo get_comment_author_link() ?>
</div>
