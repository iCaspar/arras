<?php
/**
 * Interface (contract) for theme language classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Languages;

interface Language {

	/**
	 * Initialize theme language.
	 * @return mixed
	 */
	public function init();

}