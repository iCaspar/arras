<?php

/**
 * Arras Main Controller
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Controller;

use ICaspar\Arras\Model\Options;
use ICaspar\Arras\Views\View;

/**
 * Class Controller
 *
 * Parses requests coming from index.php and hands off to the appropriate view.
 *
 * @package ICaspar\Arras\Controller
 */
class Controller {

	/**
	 * @var Options Theme Options.
	 */
	protected $options;

	/**
	 * Controller constructor.
	 *
	 * @param Options $options
	 */
	public function __construct( Options $options ) {
		$this->options = $options;
	}

	public function parse_request() {
		return 'index';
	}
}