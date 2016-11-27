<?php
/**
 * Arras theme sidebar template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$theme = apply_filters( 'arras_template', 'sidebar' );
$arras = $theme[0];
$layout = $theme[1];
?>

<?php if ( 'NoSidebars' !== $layout->get_slug() ): // don't show sidebars on single column layout ?>

	<?php arras_above_sidebar() ?>

	<?php if ( is_active_sidebar( 'primary-sidebar' ) ): ?>
		<aside id="primary-sidebar" class="<?php echo $arras->layout_columns( 'primary' ); ?>" role="complementary">
			<?php dynamic_sidebar( 'primary-sidebar' ); ?>
		</aside>
	<?php endif; ?>



	<?php if ( false !== strpos( $arras->get_option( 'layout' ), '3c' ) ): ?>
		<div id="secondary-sidebar" class="<?php echo arras_layout_columns( 'secondary' ); ?>">
			<ul class="xoxo">
				<!-- Widgetized sidebar, if you have the plugin installed.  -->
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Secondary Sidebar' ) ) : ?>
					<li></li>
				<?php endif; ?>
			</ul>
			<?php arras_below_sidebar() ?>
		</div><!-- #secondary -->
	<?php endif; // end check for 2-column layout ?>
<?php endif; // end check for single column layout ?>
