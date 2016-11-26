<?php
/**
 * Arras theme configuration.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Config;

use ArrayObject;
use InvalidArgumentException;
use RuntimeException;

class ArrasConfiguration extends ArrayObject implements Configuration {

	/**
	 * @var array Configuration parameters.
	 */
	protected $config;

	/**
	 * Create a new configuration repository.
	 */
	public function __construct( $config, $defaults = null ) {
		$this->config = $this->resolve_to_array( $config );
		$this->init_defaults( $defaults );

		parent::__construct( $this->config, ArrayObject::ARRAY_AS_PROPS );
	}

	/**
	 * Return all configuration parameters.
	 * @return array The whole enchilada.
	 */
	public function all() {
		return $this->config;
	}

	/**
	 * Checks if a parameter is set.
	 *
	 * @param string $key Parameter to check.
	 *
	 * @return bool
	 */
	public function has( $key ) {
		return array_key_exists( $key, $this->config );
	}

	/**
	 * Get a parameter or return a default if one is given.
	 *
	 * @param $key Parameter to get.
	 * @param null $default Optional. A value to return if the parameter is not set.
	 *
	 * @return mixed|null
	 */
	public function get( $key, $default = null ) {
		if ( $this->has( $key ) ) {
			return $this->config[ $key ];
		} else {
			return $default;
		}
	}


	/**
	 * Add a parameter with its value to the configuration.
	 *
	 * @param string $key Parameter name.
	 * @param mixed $value Parameter value.
	 *
	 * @return void
	 */
	public function push( $key, $value ) {
		$this->config[ $key ] = $value;
		$this->offsetSet( $key, $value );
	}

	/**
	 * Merge an array into current configuration.
	 *
	 * @param array $array_to_merge Merge this.
	 *
	 * @return void
	 */
	public function merge( array $array_to_merge ) {
		$this->config = array_merge( $this->config, $array_to_merge );
		array_walk( $this->config, function ( $value, $key ) {
			$this->offsetSet( $key, $value );
		} );
	}

	/**
	 * Remove a parameter from the configuration.
	 *
	 * @param string $key Name of parameter to remove.
	 *
	 * @return void
	 */
	public function remove( $key ) {
		if ( array_key_exists( $key, $this->config ) ) {
			unset( $this->config[ $key ] );
			$this->offsetUnset( $key );
		}
	}

	/* -----------------
	 * Protected methods
	 * ----------------- */

	/**
	 * Validate that a file is readable.
	 *
	 * @param string $file Fully qualified filename.
	 *
	 * @throws \InvalidArgumentException
	 * @throws \RuntimeException
	 *
	 * @return bool Is readable.
	 */
	protected function validate_file( $file ) {
		if ( ! $file ) {
			throw new InvalidArgumentException( __( 'Must provide a config filename.', 'arras' ) );
		}

		if ( ! is_readable( $file ) ) {
			throw new RuntimeException(
				sprintf( '%s %s', __( 'The following configuration file is unreadable:', 'arras' ), $file ) );
		}

		return true;
	}

	/**
	 * Load a file.
	 *
	 * @param $file Fully qualified name of file to load.
	 *
	 * @return mixed Contents of file.
	 */
	protected function load_file( $file ) {
		if ( $this->validate_file( $file ) ) {
			return include $file;
		}
	}

	/**
	 * Resolve whether to use an array as is or to load a file.
	 *
	 * @param $file_or_array An array or name of a file containing an array.
	 *
	 * @throws InvalidArgumentException
	 *
	 * @return array The array or the array contents of a file.
	 */
	protected function resolve_to_array( $file_or_array ) {
		if ( is_array( $file_or_array ) ) {
			return $file_or_array;
		}

		$contents = $this->load_file( $file_or_array );

		if ( ! is_array( $contents ) ) {
			throw new InvalidArgumentException(
				sprintf( '%s %s', __( 'Contents of this must be an array:', 'arras' ), $file_or_array ) );
		}

		return $contents;
	}

	/**
	 * Initialize defaults if we have any.
	 *
	 * @param $defaults Defaults or name of file with defaults.
	 *
	 * @return void
	 */
	protected function init_defaults( $defaults ) {
		if ( ! $defaults ) {
			return;
		}

		$defaults = $this->resolve_to_array( $defaults );
		$this->merge_defaults( $defaults );
	}

	/**
	 * Merge defaults into configuration.
	 *
	 * @param array $defaults Defaults to be merged into configuration
	 *
	 * @return void
	 */
	protected function merge_defaults( array $defaults ) {
		$this->config = array_replace_recursive( $defaults, $this->config );
	}
}