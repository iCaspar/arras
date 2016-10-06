<?php
/**
 * The theme's template rendering engine.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Views;

use ICaspar\Arras\Model\Config;

/**
 * Class View
 * @package ICaspar\Arras\Views
 * @since 4.0.0
 */
class View {

	protected $config;

	protected $template;

	public function __construct( Config $config, $template ) {
		$this->config = $config;
		$this->template = $template;
	}

	public function get_option( $option ) {
		return $this->config->get_options( $option );
	}

}