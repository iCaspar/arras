<?php

/**
 * Theme Configuration Handler.
 *
 * Here's where all the settings and options happen.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

/**
 * Class Config
 * @package ICaspar\Arras\Model
 * @since 4.0.0
 */
class Config {

	/**
	 * @var array Theme default settings.
	 */
	protected $settings;

	/**
	 * @var array Theme options.
	 */
	protected $defaults = [ ];

	/**
	 * Config constructor.
	 *
	 * @param array $config Default configuration.
	 *
	 * @throws \Exception
	 */
	public function __construct( array $config = [ ] ) {
		if ( isset( $config['settings'] ) && is_array( $config['settings'] ) ) {
			$this->settings = $config['settings'];
		} else {
			throw new \Exception( 'Arras Settings are unusable.' );
		}

		if ( isset( $config['option_defaults'] ) && is_array( $config['option_defaults'] ) ) {
			$this->defaults = $config['option_defaults'];
		}
	}

	/**
	 * Get a theme setting.
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	public function getSetting( $item ) {
		return $this->settings[ $item ];
	}

	/**
	 * Get theme option(s).
	 *
	 * @param string $requested_option Option to return.
	 *
	 * @return mixed Option value or default.
	 */
	public function option( $requested_option ) {
		$options = get_option( 'arras-options' );

		if ( is_array( $options ) ) {
			$option = array_key_exists( $requested_option, $options ) ? $options[ $requested_option ] : '';
		}

		if ( ! $option ) {
			$option = array_key_exists( $requested_option, $this->defaults )
				? $this->defaults[ $requested_option ] : null;
		}

		return $option;
	}

	/**
	 * Customize the WP customizer.
	 *
	 * @param $wp_customize The WP Customizer object
	 *
	 * @return void
	 */
	public function customizer( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->add_setting( 'arras-options[footer-message]', array(
			'default'           => $this->defaults['footer-message'],
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