<?php
/**
 *    The Arras theme index.
 *    (Where the wild things are.)
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'index' );
?>

<?php get_header(); ?>

<?php arras_above_content(); ?>

<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

	<?php if ( have_posts() ): ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div <?php post_class( [ 'traditional', 'group' ] ) ?>>
				<?php $arras->postheader() ?>
				<div
					class="entry-content"><?php the_content( __( 'Read the rest of this entry &raquo;', 'arras' ) ); ?>
				</div>
				<?php $arras->postfooter() ?>
			</div>

		<?php endwhile; ?>

		<?php the_posts_navigation( [
			'prev_text' => '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' . _x( 'Older Posts', 'Previous post link', 'arras' ),
			'next_text' => _x( 'Newer Posts', 'Next post link', 'arras' ) . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
		] ); ?>

	<?php else: ?>
		<?php $arras->post_notfound() ?>

	<?php endif; ?>

</div>


<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
