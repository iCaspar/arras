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
	protected $options;

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

		$options = get_option( 'arras-options' ) ?: [ ];

		if ( ! is_array( $options ) ) {
			// Todo: Offer an attempted fix. (For now just throw an exception.)
			throw new \Exception( 'Arras Config are unusable.' );
		}

		if ( isset( $config['options'] ) && is_array( $config['options'] ) ) {
			$this->options = array_merge_recursive( $config['options'], $options );
		} else {
			$this->options = $options;
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
	 * @param string|array|null $requested_options
	 *          String to request a single option value,
	 *          Array to request multiple option values at once,
	 *          Null to request all current options.
	 *
	 * @param null|array $options For tests: a sample option array.
	 *
	 * @return mixed
	 *          Request for all options returns an array.
	 *          Request for a single option returns it's value, or null if not set.
	 *          Request for multiple values returns an array: [ 'option' => value ], where value will be null
	 *              for unset options,
	 */
	public function get_options( $requested_options = null ) {
		if ( ! isset( $requested_options ) ) {
			return $this->options;
		}

		if ( is_array( $requested_options ) ) {
			foreach ( $requested_options as $option ) {
				$options_array[ $option ] = array_key_exists( $option, $this->options ) ? $this->options[ $option ] : null;
			}

			return $options_array;
		}

		if ( is_string( $requested_options ) ) {
			return array_key_exists( $requested_options, $this->options ) ? $this->options[ $requested_options ] : null;
		}

		return null;
	}

}