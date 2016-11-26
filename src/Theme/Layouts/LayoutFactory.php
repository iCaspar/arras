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
	 * @var string The interface (contract) for a Layout Class.
	 */
	protected $contract = 'ICaspar\\Arras\\Theme\\Layouts\\Layout';

	/**
	 * @var string The layout class to build.
	 */
	protected $layoutClass;

	/**
	 * LayoutFactory constructor.
	 *
	 * @param string $layout_type The layout to build.
	 */
	public function __construct( $layout_type ) {
		$fullyQualifiedClassname = __NAMESPACE__ . '\\' . $layout_type . 'Layout';

		if ( ! class_exists( $fullyQualifiedClassname ) ) {
			throw new \InvalidArgumentException( sprintf( '%s must be an existing class.', $fullyQualifiedClassname ) );
		}

		$interfaces = class_implements( $fullyQualifiedClassname );

		if ( $interfaces && ! in_array( $this->contract, $interfaces ) ) {
			throw new \InvalidArgumentException( sprintf( '%s must satisfy the Layout contract.', $fullyQualifiedClassname ) );
		}

		$this->layoutClass = $fullyQualifiedClassname;
	}

	/**
	 * Build a Layout object.
	 * @return Layout The layout.
	 */
	public function build() {
		return new $this->layoutClass;
	}
}