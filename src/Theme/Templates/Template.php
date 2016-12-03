<?php
/**
 * Interface (contract) for a theme template.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

interface Template {

	/**
	 * Renders a theme template.
	 *
	 * @param Container $arras The Arras Theme container.
	 *
	 * @return mixed
	 */
	public function render( Container $arras );
}
