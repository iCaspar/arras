<?php
/**
 * Arras footer template.
 */

/**
 * @hooked ICaspar\Arras\Model\Arras::render(), priority 10
 */
$arras = apply_filters( 'arras_template', 'footer' );
?>

</div>

<?php arras_before_footer() ?>

<div id="page-footer" class="page-footer wrap group">
	<div class="footer-sidebar-container group">
		<?php
		$footer_sidebars = $arras['options']->get( 'footer-sidebars' );
		if ( $footer_sidebars == '' ) {
			$footer_sidebars = 1;
		}

		for ( $i = 1; $i < $footer_sidebars + 1; $i ++ ) : ?>
			<aside id="<?php echo 'footer-sidebar-' . $i; ?>"
			       class="footer-sidebar col span_1_of_<?php echo (int) $footer_sidebars; ?>" role="complementary">
				<?php if ( is_active_sidebar( 'footer-sidebar-' . $i ) ): ?>
					<?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?>
				<?php else: ?>
					<?php echo '&nbsp'; ?>
				<?php endif; ?>
			</aside>
		<?php endfor; ?>
	</div>

	<div class="coda">
		<div class="footer-message">
			<?php echo esc_attr( $arras['options']->get( 'footer-message' ) ); ?>
		</div>
		<div class="arras-info">
			<a href="http://arrastheme.net/">Arras v<?php echo ARRAS_VERSION;?></a>
		</div>
	</div>
</div>
</div>
</div>

<?php arras_footer(); ?>

<?php wp_footer(); ?>

</body>
</html>