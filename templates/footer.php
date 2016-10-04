</div><!-- #main -->

<?php arras_before_footer() ?>

<div id="footer" class="page-footer group wrap">
	<div class="footer-sidebar-container group">
		<?php
		$footer_sidebars = $this->get_option( 'footer-sidebars' );
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

	<div class="footer-message">
		<p class="floatright"><a class="arras"
		                         href="http://arrastheme.net/"><strong><?php _e( 'About Arras WordPress Theme', 'arras' ) ?></strong></a>
		</p>
		<?php // echo stripslashes( arras_get_option( 'footer_message' ) ); ?>
	</div><!-- .footer-message -->
</div>
</div><!-- #page -->
<?php
arras_footer();
wp_footer();
?>
</body>
</html>