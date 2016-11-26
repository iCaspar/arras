<?php
/**
 * Layout for main content with a single right sidebar.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

class SingleRightSidebarLayout implements Layout {

	public function __construct() {
	}

	public function get_description() {
		return __( 'Main content with a single right sidebar.', 'arras' );
	}

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