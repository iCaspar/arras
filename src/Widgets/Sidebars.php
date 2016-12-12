<?php
/**
 * Interface (contract) for widget handler classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Widgets;

interface Sidebars {

	/**
	 * Initialize widgetized theme areas.
	 * @return mixed
	 */
	public function init();

	/**
	 * Add sidebars to the theme's widgetized areas.
	 *
	 * @param array $sidebars Sidebars to add.
	 *
	 * @return void
	 */
	public function add( array $sidebars );

	/**
	 * Remove a sidebar from the theme's widgetized areas.
	 *
	 * @param $sidebar_id Sidebar to remove.
	 *
	 * @return void
	 */
	public function remove( $sidebar_id );

	}