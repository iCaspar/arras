<?php
/**
 * Base template class.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

class BaseTemplate implements Template {

	public function render( Container $arras ) {
		echo 'This is the base template (index).';
	}
}