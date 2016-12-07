<?php
/**
 * Layout for main content with a single right sidebar.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

/**
 * Class SingleRightSidebarLayout
 * @package ICaspar\Arras\Theme\Layouts
 */
class SingleRightSidebarLayout implements Layout {

	/**
	 * @var string Layout slug.
	 */
	protected $slug = 'single-right';

	/**
	 * @var string|void Layout description.
	 */
	protected $description;

	/**
	 * SingleRightSidebarLayout constructor.
	 *
	 * @param null|string $description A description for the layout.
	 */
	public function __construct( $description = null ) {
		$this->description = $description ?: __( 'Main content with a single right sidebar.', 'arras' );
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
	 * @return string The description.
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get CSS classses for a theme element's position.
	 *
	 * @param string $position The element position.
	 *
	 * @return string The space-separated CSS classes for the element.
	 */
	public function get_classes( $position ) {
		if ( 'content' == $position ) {
			$class = 'col span_2_of_3';
		} elseif ( 'primary' == $position ) {
			$class = 'col span_1_of_3 sidebar';
		} else {
			$class = '';
		}

		return $class;
	}
}