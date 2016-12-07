<?php
/**
 * Template for a 404 page.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

/**
 * Class NotFoundTemplate
 * @package ICaspar\Arras\Theme\Templates
 */
class NotFoundTemplate extends BaseTemplate implements Template {

	/**
	 * NotFoundTemplate constructor.
	 *
	 * @param Container $arras
	 */
	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

	/**
	 * Render a WordPress 404 page.
	 * @return void
	 */
	public function render() {
		$this->beforeContent();

		include ARRAS_VIEWS_DIR . '404.php';

		$this->afterContent();
	}
}