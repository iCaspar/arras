<?php
/**
 * Output html for a post entry.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */
?>
<?php arras_above_post(); ?>
<div id="post-<?php the_ID() ?>" <?php post_class( [ 'traditional', 'group' ] ) ?>>
	<?php $this->postheader(); ?>
    <div class="entry-content">
		<?php the_content( __( 'Read the rest of this entry &raquo;', 'arras' ) ); ?>
		<?php if ( is_single() || is_page() ): ?>
			<?php $this->link_pages(); ?>
		<?php endif; ?>
    </div>
	<?php $this->postfooter(); ?>
</div>
<?php arras_below_post(); ?>

