<?php
/**
 * Arras Options.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme;

class Options {

	/**
	 * @var Default option settings.
	 */
	protected $defaults = [ ];

	public function __construct( array $defaults ) {
		$this->defaults = $defaults;
	}

	public function get( $option ) {
		$options = get_option( 'arras-options' );

		if ( isset( $options, $option ) ) {
			return $options[ $option ];
		} elseif ( isset( $this->defaults, $option ) ) {
			return $this->defaults[ $option ];
		} else {
			return null;
		}
	}
}