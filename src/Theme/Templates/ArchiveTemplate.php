<?php
/**
 * Template for an archive WordPress page.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

class ArchiveTemplate extends BaseTemplate implements Template {

	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

	public function render() {
		$this->beforeContent();

	}
}