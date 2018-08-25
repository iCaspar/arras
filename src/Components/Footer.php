<?php
/**
 * Footer class.
 *
 * @package Arras\Components
 *
 * @since 4.0.0
 */

namespace Arras\Components;


/**
 * Class Footer
 *
 * @package Arras\Components
 *
 * @since 4.0.0
 */
class Footer {

	public static function do_footer_widgets() {
		$footer_sidebars = arras_get_option( 'footer_sidebars' );

		if ( ! $footer_sidebars ) {
			$footer_sidebars = 1;
		}

		for ( $sidebar_count = 1; $sidebar_count < $footer_sidebars + 1; $sidebar_count ++ ) {
			?>
			<div id="footer-sidebar-<?php echo esc_attr( $sidebar_count ); ?>" class="footer-sidebar clearfix xoxo">
				<?php if ( ! dynamic_sidebar( 'Footer Sidebar #' . $sidebar_count ) ) : ?>
					<li></li>
				<?php endif; ?>
			</div>
		<?php
		}
	}

}
