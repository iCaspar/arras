<?php
/**
 * Theme sidebars (widgetized areas).
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Widgets;

use ICaspar\Arras\Theme\Arras;

class ArrasSidebars implements Sidebars {

	/**
	 * Default Sidebar parameters.
	 * @var array
	 */
	protected $sidebar_defaults = [
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];

	/**
	 * Widgetized areas.
	 * @var array
	 */
	protected $sidebars;

	/**
	 * Arras theme service container.
	 * @var Container
	 */
	protected $arras;

	public function __construct() {
		$this->arras = Arras::get_arras();
	}

	/**
	 * Register widgetized areas.
	 * @return  void
	 */
	public function init() {
		$this->sidebars = $this->arras['config']['sidebars'];

		$this->get_footer_sidebars();
		$this->register_sidebars();
	}

	/**
	 * Add sidebars to the theme's widgetized areas.
	 *
	 * @param array $sidebars Sidebars to add.
	 *
	 * @return void
	 */
	public function add( array $sidebar ) {
		$this->sidebars[] = $sidebar;
	}

	/**
	 * Remove a sidebar from the theme's widgetized areas.
	 *
	 * @param $sidebar_id Sidebar to remove.
	 *
	 * @return void
	 */
	public function remove( $sidebar_id ) {
		foreach ( $this->sidebars as $sidebar ) {
			if ( in_array( $sidebar_id, $sidebar ) ) {
				unset( $sidebar );
			}
		}
	}

	/**
	 * Get the footer sidebars.
	 *
	 * @return array
	 */
	protected function get_footer_sidebars() {
		$footer_sidebars = $this->arras['options']->get( 'footer-sidebars' ) ?: 1;

		for ( $i = 1; $i <= $footer_sidebars; $i ++ ) {
			$sidebar = [
				'name'        => sprintf( '%s', _x( 'Footer Sidebar #', 'Footer sidebar name', 'arras' ) ) . $i,
				'id'          => 'footer-sidebar-' . $i,
				'description' => __( 'A footer widget area' ),
			];
			$this->add( $sidebar );
		}
	}

	/**
	 * Register widgetized areas into theme.
	 *
	 * @return void
	 */
	protected function register_sidebars() {
		foreach ( $this->sidebars as $sidebar ) {
			$args = array_merge( $this->sidebar_defaults, $sidebar );

			register_sidebar( $args );
		}
	}
}