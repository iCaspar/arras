<?php
/**
 * Arras footer template.
 *
 * @package Arras
 *
 * @since 1.0.0
 */

use Arras\Components\Footer;

?>

</div>
<?php arras_before_footer(); ?>

<div id="footer" class="site-footer">
	<div class="footer-sidebar-container">
		<?php Footer::do_footer_widgets(); ?>
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
