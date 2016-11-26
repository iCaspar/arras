<?php
/**
 * Layout for main content with no sidebars.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

/**
 * Class NoSidebarLayout
 * @package ICaspar\Arras\Theme\Layouts
 */
class NoSidebarsLayout implements Layout {

	/**
	 * @var string Layout slug.
	 */
	protected $slug = 'no-sidebars';

	/**
	 * @var string|void Layout description.
	 */
	protected $description;

	/**
	 * NoSidebarLayout constructor.
	 *
	 * @param null|string $description A description for the layout.
	 */
	public function __construct( $description = null ) {
		$this->description = $description ?: __( 'Single column and no sidebars.', 'arras' );
	}

	/**
	 * Get the layout slug.
	 * @return string The slug.
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * Get the layout description.
	 * @return string|void The description.
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get CSS classes for a theme element's position.
	 *
	 * @param string $position The element position.
	 *
	 * @return string The space-separated CSS classes for the element.
	 */
	public function get_classes( $position ) {
		if ( 'content' == $position ) {
			$class = 'group';
		} elseif ( 'primary' == $position ) {
			$class = 'group sidebar';
		} else {
			$class = '';
		}

		return $class;
	}
}