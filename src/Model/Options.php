<?php

/**
 * Theme Options Model.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

/**
 * Class Options
 * @package ICaspar\Arras\Model
 */
class Options {

	/**
	 * @var array All the currently active settings and options.
	 */
	protected $config;

	/**
	 * Options constructor.
	 *
	 * @param array $config Default configuration.
	 *
	 * @throws \Exception
	 */
	public function __construct( array $config = [ ] ) {

		$options = get_option( 'arras-options' ) ?: [ ];

		if ( ! is_array( $options ) ) {
			// Todo: Offer an attempted fix. (For now just throw an exception.)

			throw new \Exception( 'Arras Options are unusable.' );
		}

		if ( isset( $config['options'] ) && is_array( $config['options'] ) ) {
			$config['options'] = array_merge_recursive( $config['options'], $options );
		} else {
			$config['options'] = $options;
		}

		$this->config = $config;
	}

	/**
	 * A generic getter.
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	public function get( $item ) {
		return $this->config[ $item ];
	}

	/**
	 * Get the requested option(s).
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
	public function get_options( $requested_options = null, $options = null ) {
		if ( ! $options ) {
			$options = $this->config['options'];
		}

		if ( ! isset( $requested_options ) ) {
			return $options;
		}

		if ( is_array( $requested_options ) ) {
			foreach ( $requested_options as $option ) {
				$options_array[ $option ] = array_key_exists( $option, $options ) ? $options[ $option ] : null;
			}

			return $options_array;
		}

		if ( is_string( $requested_options ) ) {
			return array_key_exists( $requested_options, $options ) ? $options[ $requested_options ] : null;
		}

		return null;
	}

}