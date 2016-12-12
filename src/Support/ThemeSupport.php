<?php
/**
 * Interface (contract) for theme support classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Support;

interface ThemeSupport {

	/**
	 * Initialize theme supports
	 * @return mixed
	 */
	public function init();

	/**
	 * Add a theme support.
	 *
	 * @param array $supports Supports to add.
	 *
	 * @return mixed
	 */
	public function add( array $supports );

	/**
	 * Remove theme support.
	 *
	 * @param string $support Support to remove.
	 *
	 * @return mixed
	 */
	public function remove( $support );
}