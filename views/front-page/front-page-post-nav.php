<?php
/**
 * Html for front page post navigation
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>
<div class="navigation post-navigation" role="navigation">
    <h2 class="screen-reader-text">Posts navigation</h2>
    <div class="nav-links">
		<?php if ( $next_link = get_next_posts_link( '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' . _x( 'Older Posts', 'Previous post link', 'arras' ), $query->max_num_pages ) ): ?>
            <div class="nav-previous">
				<?php echo $next_link; ?>
            </div>
		<?php endif; ?>
		<?php if ( $prev_link = get_previous_posts_link( _x( 'Newer Posts', 'Next post link', 'arras' ) . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>' ) ): ?>
            <div class="nav-next">
				<?php echo $prev_link; ?>
            </div>
		<?php endif; ?>
    </div>
</div>

