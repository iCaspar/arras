<?php
/**
 * Arras 404 page template
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', '404' );
?>

<?php get_header(); ?>

<?php arras_above_content() ?>

	<div id="content" class="<?php echo $arras->layout_columns( 'content' ); ?>">

		<div id="four-o-four" class="<?php post_class( [ 'group' ] ); ?>">
			<h3 class="entry-title"><?php _e( 'Error 404 - Not Found', 'arras' ) ?></h3>
			<div class="entry-content">
				<p><strong><?php _e( "Oh Snap! That page doesn't exist or has been moved.", 'arras' ) ?></strong></p>
				<p><?php _e( 'Please make sure you have the right URL.', 'arras' ) ?></p>
				<p><?php _e( "... or try searching here:", 'arras' ) ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>

	</div><!-- #content -->
<?php arras_below_content() ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>