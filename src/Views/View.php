<?php
/**
 * The theme's template rendering engine.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Views;

use ICaspar\Arras\Model\Config;

/**
 * Class View
 * @package ICaspar\Arras\Views
 * @since 4.0.0
 */
class View {

	protected $config;

	protected $template;

	public function __construct( Config $config, $template ) {
		$this->config = $config;
		$this->template = $template;
	}

	public function get_option( $option ) {
		return $this->config->get_options( $option );
	}

	function get_layouts() {
		$arras_layouts = array(
			'1c'	=> __('1 Column - No Sidebars', 'arras'),
			'2c-r'	=> __('2 Columns - Sidebar on Right', 'arras'),
			'2c-l'	=> __('2 Columns - Sidebar on Left', 'arras'),
			'3c-lr'	=> __('3 Columns - Left / Right Sidebars', 'arras'),
			'3c-2r'	=> __('3 Columns - 2 Right Sidebars', 'arras'),
		);

		return apply_filters( 'arras_layouts', $arras_layouts );
	}

	function layout_columns( $coltype ) {
		$coltypes = array( 'content', 'primary', 'secondary', 'wrap' );
		if ( ! in_array( $coltype, $coltypes ) ) return; // if we haven't got a column type we know about, bail



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