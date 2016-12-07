<?php
/**
 * Arras Options.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Options;

/**
 * Class Options
 * @package ICaspar\Arras\Options
 */
class Options {

	/**
	 * Default option settings.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Options constructor.
	 *
	 * @param array $defaults
	 */
	public function __construct( array $defaults ) {
		$this->defaults = $defaults;
	}

	/**
	 * Get a requested option.
	 *
	 * Check for an option in the database first.
	 * If no saved option is available, find a default option if available.
	 * Otherwise return null.
	 *
	 * @param $option
	 *
	 * @return mixed|null
	 */
	public function get( $option ) {
		$options = get_option( 'arras-options' );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		} elseif ( isset( $this->defaults[ $option ] ) ) {
			return $this->defaults[ $option ];
		} else {
			return null;
		}
	}
}