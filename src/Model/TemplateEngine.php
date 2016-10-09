<?php
/**
 * The theme's template rendering engine.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

use ICaspar\Arras\Views\Menu;

/**
 * Class TemplateEngine
 * @package ICaspar\Arras\Views
 * @since 4.0.0
 */
class TemplateEngine {

	protected $config;

	protected $menus;

	protected $template;

	/**
	 * TemplateEngine constructor.
	 *
	 * @param Config $config Theme configuration.
	 * @param string $template Current template context.
	 */
	public function __construct( Config $config, Menu $menus, $template ) {
		$this->config   = $config;
		$this->menus = $menus;
		$this->template = $template;
	}

	public function get_option( $option ) {
		return $this->config->get_option( $option );
	}

	public function do_menu( $location ) {
		if ( ! $this->menus->has_menu( $location ) ) {
			return;
		}

		$this->menus->build( $location );
	}


	//* ----- NEEDS REVIEW ----- */

	function get_layouts() {
		$arras_layouts = array(
			'1c'    => __( '1 Column - No Sidebars', 'arras' ),
			'2c-r'  => __( '2 Columns - Sidebar on Right', 'arras' ),
			'2c-l'  => __( '2 Columns - Sidebar on Left', 'arras' ),
			'3c-lr' => __( '3 Columns - Left / Right Sidebars', 'arras' ),
			'3c-2r' => __( '3 Columns - 2 Right Sidebars', 'arras' ),
		);

		return apply_filters( 'arras_layouts', $arras_layouts );
	}


	function layout_columns( $coltype ) {
		$coltypes = array( 'content', 'primary', 'secondary', 'wrap' );
		if ( ! in_array( $coltype, $coltypes ) ) {
			return;
		} // if we haven't got a column type we know about, bail

		$layout = $this->get_option( 'layout' );
		switch ( $layout ) {
			case '1c':
				if ( $coltype == 'content' ) {
					$class = 'group';
				} else {
					$class = 'group sidebar';
				}
				break;
			case '2c-l':
				if ( $coltype == 'content' ) {
					$class = 'col-alt span_2_of_3';
				} else {
					$class = 'col-alt span_1_of_3 sidebar';
				}
				break;
			case '3c-2r':
				if ( $coltype == 'content' ) {
					$class = 'col span_1_of_2';
				} else {
					$class = 'col span_1_of_4 sidebar';
				}
				break;
			case '3c-lr':
				if ( $coltype == 'content' ) {
					$class = 'col-split-center';
				} elseif ( $coltype == 'primary' ) {
					$class = 'col-split-left sidebar';
				} else {
					$class = 'col-split-right sidebar';
				}
				break;
			default:
				if ( $coltype == 'content' ) {
					$class = 'col span_2_of_3';
				} else {
					$class = 'col span_1_of_3 sidebar';
				}
				break;

		} // end switch

		return $class;
	} // end arras_layout_columns()

}