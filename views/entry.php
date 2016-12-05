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
<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
	<?php $this->postheader(); ?>
	<?php if ( ! is_attachment() ): ?>
    <div class="entry-content">
		<?php the_content( __( 'Read the rest of this entry &raquo;', 'arras' ) ); ?>

	<?php else: ?>
    <div class="entry-content single-post-attachment">
		<?php the_attachment_link( $post->ID, true ) ?>
        <div class="attachment-caption">
			<?php the_excerpt(); ?>
        </div>
	<?php endif; ?>
		<?php if ( is_single() || is_page() || is_attachment() ): ?>
			<?php $this->link_pages(); ?>
		<?php endif; ?>
    </div>
		<?php $this->postfooter(); ?>
</div>
<?php arras_below_post(); ?>

