<?php
/**
 * HTML for post navigation links.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */
?>

<nav class="post-navigation" role="navigation">
	<?php if ( $previous ) {?>
		<div class="post-nav"><?php previous_post_link( '%link', _x( '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> %title', 'Previous post link', 'arras' ) ); ?></div>
	<?php }
	if ( $next ) {?>
		<div class="post-nav"><?php next_post_link( '%link', _x( '%title <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', 'Next post link', 'arras' ) ); ?></div>
	<?php }?>
</nav>
