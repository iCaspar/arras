<?php
/**
 * Arras theme supports.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Support;

use ICaspar\Arras\Theme\Arras;

class ArrasThemeSupport implements ThemeSupport {

	protected $supports;

	/**
	 * Register theme supports for WP and plugins.
	 * @return void
	 */
	public function init() {
		$arras          = Arras::get_arras();
		$this->supports = $arras['config']['theme-support'];

		$this->register_supports();
	}

	/**
	 * Add theme supports to the supports array.
	 *
	 * @param array $supports Supports to be added.
	 *
	 * @return void
	 */
	public function add( array $supports ) {
		foreach ( $supports as $support => $value ) {
			$this->supports[ $support ] = $value;
		}
	}

	/**
	 * Remove a theme support from the supports array.
	 *
	 * @param $support
	 *
	 * @return void
	 */
	public function remove( $support ) {
		if ( isset( $this->supports[ $support ] ) ) {
			unset( $this->supports[ $support ] );
		}
	}

	/**
	 * Register theme supports into the theme.
	 * @return void
	 */
	protected function register_supports() {
		foreach ( $this->supports as $support => $value ) {
			if ( is_array( $value ) ) {
				add_theme_support( $support, $value );
			} else {
				add_theme_support( $support );
			}
		}
	}
}