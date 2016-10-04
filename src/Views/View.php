<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Views;

/**
 * Class View
 * @package ICaspar\Arras\Views
 */
class View {

	protected $request;

	public function __construct( $request ) {
		$this->request = $request;
	}

	public function render() {
		include ARRAS_TEMPLATE_DIR . $this->request . '.php';
	}
}