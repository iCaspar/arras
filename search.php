<?php
/**
 *    The Arras theme index.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'search' );
?>

<?php get_header(); ?>

<?php arras_above_content() ?>

<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

	<h1 class="search-results-title"><?php _e( 'Search Results', 'arras' ) ?></h1>
	<div class="search-results-content">
		<p>
			<?php printf(
				__( 'Search Results for: %s', 'arras' ),
				'<span class="search-terms">' . esc_html( get_search_query() ) . '</span>'
			); ?>
		</p>
		<?php get_search_form(); ?>
	</div>

	<?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

			<div id="post-<?php the_ID() ?>" <?php post_class( [ 'traditional', 'group' ] ) ?>>
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

		<?php //arras_render_posts( null, ( arras_get_option( 'default_tapestry' ) ) ? arras_get_option( 'default_tapestry' ) : 'quick' ); ?>

	<?php else: ?>

		<div class="search-results-no-content">
			<p>
			<?php printf(
				__( 'Oh snap! Nothing found for: %s', 'arras' ),
				'<span class="search-terms">' . esc_html( get_search_query() ) . '</span>'
			); ?>
			</p>
		</div>


	<?php endif; ?>

</div>

<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
