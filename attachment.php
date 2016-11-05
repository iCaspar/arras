<?php
/**
 *    The Arras attachment page template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'attachment' );
?>

<?php get_header(); ?>

<?php arras_above_content() ?>

	<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php arras_above_post() ?>

			<div id="attachment-<?php the_ID() ?>" <?php post_class( [ 'attachment', 'group' ] ) ?>>

				<?php $arras->postheader() ?>

				<div class="entry-content single-post-attachment">

					<?php the_attachment_link( $post->ID, true ) ?>
					<div class="attachment-caption">
						<?php the_excerpt(); ?>
					</div>
					<?php $arras->link_pages(); ?>
				</div>

				<?php $arras->postfooter() ?>

				<?php if ( $arras->get_option( 'display-author-page' ) ) : ?>
					<?php include ARRAS_VIEWS_DIR . 'author-profile.php'; ?>
				<?php endif; ?>
			</div>

			<?php if ( $arras->get_option( 'show-post-nav' ) ): ?>
				<?php $arras->post_nav() ?>
			<?php endif; ?>

			<?php arras_below_post() ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile;
		else: ?>

			<?php $arras->post_notfound() ?>

		<?php endif; ?>

	</div>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>