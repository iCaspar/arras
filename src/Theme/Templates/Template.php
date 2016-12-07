<?php
/**
 * Interface (contract) for a theme template.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

/**
 * Interface Template
 * @package ICaspar\Arras\Theme\Templates
 */
interface Template {

	/**
	 * Render a WordPress page.
	 *
	 * @return mixed
	 */
	public function render();
}
