<?php
/**
 * Contract for a configuration object.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Config;

/**
 * Interface Configuration
 * @package ICaspar\Arras\Config
 */
interface Configuration {
	/**
	 * Get all configuration parameters.
	 * @return array The whole enchilada.
	 */
	public function all();

	/**
	 * Check if a parameter is set.
	 *
	 * @param string $key Name of the parameter to check.
	 *
	 * @return bool Whether it's set.
	 */
	public function has( $key );

	/**
	 * Get a specific configuration parameter's value or return a default value.
	 *
	 * @param string $key
	 * @param null $default
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null );

	/**
	 * Add a configuration parameter to the configuration.
	 *
	 * @param string $key Parameter name.
	 * @param mixed $value Parameter value.
	 *
	 * @return null
	 */
	public function push( $key, $value );

	/**
	 * Merge an array into the current configuration.
	 *
	 * @param array $array_to_merge Array that will be merged with current configuration.
	 *
	 * @return null
	 */
	public function merge( array $array_to_merge );

	/**
	 * Remove a parameter from the configuration.
	 *
	 * @param string $key Name of parameter to be removed.
	 *
	 * @return mixed
	 */
	public function remove( $key );
}