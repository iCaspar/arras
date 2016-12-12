<?php
/**
 * Arras theme assets.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Assets;

interface Assets {

	/**
	 * Load theme script assets.
	 * @return mixed
	 */
	public function load_scripts();

	/**
	 * Load theme style assets.
	 * @return mixed
	 */
	public function load_styles();
}