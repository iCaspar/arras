<?php
/**
 * Contract for Layout Classes.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

/**
 * Interface Layout
 * @package ICaspar\Arras\Theme\Layouts
 */
interface Layout {

	/**
	 * Layout constructor.
	 *
	 * @param null|string $description A description for the layout.
	 */
	public function __construct( $description = null );

		/**
	 * Get the layout slug.
	 * @return string The slug.
	 */
	public function get_slug();

		/**
	 * Get the layout description.
	 * @return string The description.
	 */
	public function get_description();

	/**
	 * Get CSS classses for a theme element's position.
	 *
	 * @param string $position The element position.
	 *
	 * @return string The space-separated CSS classes for the element.
	 */
	public function get_classes( $position );
}