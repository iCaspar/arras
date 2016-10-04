<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Views;
use ICaspar\Arras\Model\Config;

/**
 * Class View
 * @package ICaspar\Arras\Views
 */
class View {

	protected $options;
	protected $request;

	public function __construct( Config $options ) {
		$this->options = $options;
	}

	public function render( $request ) {
		include ARRAS_TEMPLATE_DIR . $request . '.php';
	}

	protected function get_option( $option ) {
		return $this->options->get_options( $option );
	}

}