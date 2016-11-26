<?php
/**
 * Contract for Layout Classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

interface Layout {

	/**
	 * Get the description for the layout.
	 * @return mixed
	 */
	public function get_description();

	/**
	 * Get CSS Classes for layout at theme position.
	 */
	public function get_classes( $position );

}