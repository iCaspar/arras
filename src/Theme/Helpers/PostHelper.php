<?php
/**
 * Post Helper Class
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Helpers;

/**
 * Class PostHelper
 * @package ICaspar\Arras\Theme\Helpers
 */
class PostHelper {

	/**
	 * Customize a post class.
	 *
	 * @param array $classes Default Post classes.
	 *
	 * @return array Custom classes.
	 */
	public function post_class( $classes ) {
		if ( is_page() ) {
			$classes = array_diff( $classes, [ 'hentry' ] );
		}

		return $classes;
	}
}