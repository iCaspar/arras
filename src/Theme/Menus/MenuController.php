<?php
/**
 * Menu Controller.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Menus;

use ICaspar\Arras\Theme\Arras;

/**
 * Class MenuController
 * @package ICaspar\Arras\Theme\Menus
 */
class MenuController {
	/**
	 * Menu configurations.
	 *
	 * @var array
	 */
	protected $menus;

	/**
	 * Default menu parameters.
	 *
	 * @var array
	 */
	protected $defaults = [
		'container'       => 'nav',
		'container_class' => 'wrap',
	];

	/**
	 * MenuController constructor.
	 *
	 * @param array $menus Menu configurations.
	 */
	public function __construct( array $menus = [] ) {
		if ( ! empty( $menus ) ) {
			$this->add = $menus;
		}
	}

	/**
	 * Add or update menu configurations.
	 *
	 * @param array $menus Menus to add as [ theme-location => [properties] ]
	 *
	 * @return void
	 */
	public function add( array $menus ) {
		foreach ( $menus as $menu => $properties ) {
			$this->menus[ $menu ] = $properties;
		}
	}

	/**
	 * Remove a menu configuration.
	 *
	 * @param string $menu The menu to be removed.
	 *
	 * @return void
	 */
	public function remove( $menu ) {
		if ( $this->has_menu( $menu ) ) {
			unset( $this->menus[ $menu ] );
		}
	}

	/**
	 * Return whether a menu is configured.
	 *
	 * @param string $menu Menu configuration to check.
	 *
	 * @return bool
	 */
	public function has_menu( $menu ) {
		return ( isset( $this->menus[ $menu ] ) );
	}

	/**
	 * Register menus into the theme.
	 *
	 * @return void
	 */
	public function register_menus() {
		foreach ( $this->menus as $menu => $properties ) {
			register_nav_menu( $menu, $properties['name'] );
		}
	}

	/**
	 * Unregister menus from the theme.
	 *
	 * @param array $menus Menus to unregister.
	 *
	 * @return void
	 */
	public function unregister_menus( $menus ) {
		foreach ( $menus as $menu ) {
			unregister_nav_menu( $menu );
		}
	}

	/**
	 * A Wrapper function for wp_nav_menu() that outputs menu markup.
	 *
	 * @param string $location Theme location of the menu to build.
	 *
	 * @return void
	 * @since 3.0
	 */
	public function build( $location ) {
		if ( ! $this->has_menu( $location ) ) {
			return;
		}

		if ( has_nav_menu( $location ) ) {
			$args                   = wp_parse_args( $this->menus[ $location ], $this->defaults );
			$args['theme_location'] = $location;
			$args['menu_class']     = 'menu-' . $location;
			wp_nav_menu( $args );
		}
	}

	/***** CALLBACKS *****/

	/**
	 * Initialize the menus.
	 *
	 * @return void
	 */
	public function init() {
		$arras = Arras::get_arras();
		$this->add( $arras['config']['menus'] );
		$this->register_menus();
	}
}