<?php
/**
 * Arras footer template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

?>

</div>
<?php arras_before_footer(); ?>

<div id="footer" class="site-footer">
	<div class="footer-sidebar-container">
		<?php
		$arras_footer_sidebars = arras_get_option( 'footer_sidebars' );

		if ( ! $arras_footer_sidebars ) {
			$arras_footer_sidebars = 1;
		}

		for ( $arras_footer_sidebar_count = 1; $arras_footer_sidebar_count < $arras_footer_sidebars + 1; $arras_footer_sidebar_count ++ ) :
			?>
			<ul id="footer-sidebar-<?php echo esc_attr( $arras_footer_sidebar_count ); ?>" class="footer-sidebar clearfix xoxo">
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Footer Sidebar #' . $arras_footer_sidebar_count ) ) : ?>
					<li></li>
				<?php endif; ?>
			</ul>
		<?php endfor; ?>
	</div>

	<div class="footer-message">
		<p class="floatright"><a class="arras" href="<?php echo esc_url( ARRAS_URL ); ?>">
				<strong><?php esc_attr_e( 'About Arras WordPress Theme', 'arras' ); ?></strong>
			</a>
		</p>
		<?php echo wp_kses_post( arras_get_option( 'footer_message' ) ); ?>
	</div>
</div>
</div>

<?php
arras_footer();
wp_footer();
?>

</body>
</html>
