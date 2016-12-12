<?php
/**
 * Options class factory.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Options;
use ICaspar\Arras\Theme\Arras;

/**
 * Class OptionsFactory
 * @package ICaspar\Arras\Options
 */
class OptionsFactory {

	/**
	 * Build an Options Object.
	 *
	 * @param array $defaults
	 *
	 * @return Options
	 */
	public function build( array $defaults = [] ) {
		if ( empty( $defaults ) ) {
			$arras    = Arras::get_arras();
			$defaults = $arras['config']['defaults'];
		}

		return new Options( $defaults );
	}
}