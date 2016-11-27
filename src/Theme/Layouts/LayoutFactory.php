<?php
/**
 * Class to create layout objects.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Layouts;

/**
 * Class LayoutFactory
 * @package ICaspar\Arras\Theme\Layouts
 */
class LayoutFactory {

	/**
	 * The interface (contract) for a Layout Class.
	 *
	 * @var string
	 */
	protected $contract = 'ICaspar\Arras\Theme\Layouts\Layout';

	/**
	 * Layout class to be built.
	 *
	 * @var string
	 */
	protected $layoutClass;
	/**
	 * LayoutFactory constructor.
	 *
	 * @param string $layout_type Name of the layout to build.
	 */
	public function __construct( $layout_type) {
		$layoutClass = $this->get_classname( $layout_type );
		$this->validate_classname( $layoutClass );
		$this->layoutClass = $layoutClass;
	}

	/**
	 * Build a Layout object.
	 *
	 * @return Layout The layout.
	 */
	public function build() {
		return new $this->layoutClass;
	}

	/**
	 * Get the fully qualified classname.
	 *
	 * @return string Fully qualified classname.
	 */
	protected function get_classname( $layout_type ) {
		$fullyQualifiedClassname = __NAMESPACE__ . '\\' . $layout_type . 'Layout';

		return $fullyQualifiedClassname;
	}

	/**
	 * Validate a Layout Classname.
	 *
	 * Todo:
	 * It's possible that a corrupted value for this could be stored in the Database.
	 * Rather than throw an exception, we should offer an authorized user to reset to the default layout,
	 * or just use the default layout for anyone else.
	 *
	 * @param $fullyQualifiedClassname
	 *
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	protected function validate_classname( $fullyQualifiedClassname ) {
		if ( ! class_exists( $fullyQualifiedClassname ) ) {
			throw new \InvalidArgumentException( sprintf( '%s must be an existing class.', $fullyQualifiedClassname ) );
		}

		$interfaces = class_implements( $fullyQualifiedClassname );

		if ( $interfaces && ! in_array( $this->contract, $interfaces ) ) {
			throw new \InvalidArgumentException( sprintf( '%s must satisfy the Layout contract.', $fullyQualifiedClassname ) );
		}

		return true;
	}
}