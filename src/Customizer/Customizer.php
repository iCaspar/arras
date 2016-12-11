<?php
/**
 * Interface (contract) for Customizer classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Customizer;

/**
 * Interface Customizer
 * @package ICaspar\Arras\Theme\Customizer
 */
interface Customizer {

	/**
	 * Customize the WordPress Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize The WordPress customizer object.
	 *
	 * @return void
	 */
	public function customize( \WP_Customize_Manager $wp_customize );

	/**
	 * Enqueue JavaScript to handle customizer postMessages.
	 * @return void
	 */
	public function postmessage();
}