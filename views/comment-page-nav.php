<?php
/**
 * HTML for comment page navigation links
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */
?>

<li class="comments-navigation-container">
	<div class="comments-navigation">
		<?php paginate_comments_links( [
			'prev_text' => '<i class="fa fa-arrow-circle-left"></i> ' . _x( 'Previous', 'previous comments link', 'arras' ),
			'next_text' => _x( 'Next', 'next comments link', 'arras' ) . ' <i class="fa fa-arrow-circle-right"></i>',
		] ); ?>
	</div>
</li>