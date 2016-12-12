<?php
/**
 * Arras theme assets.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Assets;

class ArrasAssets implements Assets {

	/**
	 * Load theme script assets.
	 * @return void
	 */
	public function load_scripts() {
		wp_enqueue_script( 'arras-menu-helper', ARRAS_ASSETS_URL . 'scripts/min/menu.min.js', array( 'jquery' ), ARRAS_VERSION, true );
		/*
				if ( is_home() && ! $paged && $this->config->get_option( 'enable_slideshow' ) !== false ) {
					wp_enqueue_script( 'jquery-cycle', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2-min.js', array( 'jquery' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'slideshow-settings', ARRAS_ASSETS_URL . 'scripts/slideshowsettings.js', array( 'jquery-cycle' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'jquery-cycle-caption', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.caption2.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'jquery-cycle-swipe', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.swipe.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
				}
		*/
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Load theme style assets.
	 * @return void
	 */
	public function load_styles() {
		wp_enqueue_style( 'arras-base', ARRAS_ASSETS_URL . 'styles/css/base.css', false, ARRAS_VERSION, 'all' );
		wp_enqueue_style( 'font-awesome', ARRAS_ASSETS_URL . 'styles/css/font-awesome.min.css', false, '4.6.3', 'all' );

		if ( is_child_theme() ) {
			wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), ARRAS_VERSION, 'all' );
		}
	}
}