<?php
/**
 * Arras customizations of the WordPress customizer.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Customizer;

use ICaspar\Arras\Options\Options;

/**
 * Class ArrasCustomizer
 * @package ICaspar\Arras\Customizer
 */
class ArrasCustomizer {

	/**
	 * Theme options.
	 *
	 * var Options
	 */
	protected $options;

	/**
	 * ArrasCustomizer constructor.
	 *
	 * @param Options $options Theme options.
	 */
	public function __construct( Options $options ) {
		$this->options = $options;
	}

	/***** CALLBACKS *****/

	/**
	 * Customize the WordPress Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize The WordPress customizer object.
	 *
	 * @return void
	 */
	public function customizer( \WP_Customize_Manager $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->add_setting( 'arras-options[footer-message]', array(
			'default'           => $this->options->get( 'footer-message' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'footer-message', array(
			'label'    => __( 'Footer Message', 'arras' ),
			'section'  => 'title_tagline',
			'settings' => 'arras-options[footer-message]',
		) );
	}

	/**
	 * Enqueue JavaScript to handle customizer postMessages.
	 * @return void
	 */
	public function postmessage() {
		wp_enqueue_script( 'arras-postmessage-handler',
			ARRAS_ASSETS_URL . 'scripts/min/customizer-postmessages.min.js',
			array( 'customize-preview', 'jquery' ),
			ARRAS_VERSION
		);
	}

}