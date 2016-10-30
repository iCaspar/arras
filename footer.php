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
		$footer_sidebars = $arras->get_option( 'footer-sidebars' );
		if ( $footer_sidebars == '' ) {
			$footer_sidebars = 1;
		}

		for ( $i = 1; $i < $footer_sidebars + 1; $i ++ ) :
			?>
			<ul id="footer-sidebar-<?php echo $i ?>"
			    class="footer-sidebar xoxo col span_1_of_<?php echo $footer_sidebars; ?>">
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Footer Sidebar #' . $i ) ) : ?>
					<li></li>
				<?php endif; ?>
			</ul>
		<?php endfor; ?>
	</div>

	<div class="coda">
		<div class="footer-message">
			<?php echo stripslashes( $arras->get_option( 'footer-message' ) ); ?>
		</div>
		<div class="arras-info">
			<a href="http://arrastheme.net/"><?php _e( 'About Arras WordPress Theme', 'arras' ) ?></a>
		</div>
	</div>
</div><!-- #container -->
</div><!-- #body -->
</div><!-- #page -->
<?php
arras_footer();
wp_footer();
?>
</body>
</html>