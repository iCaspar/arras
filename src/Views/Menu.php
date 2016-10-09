<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Views;

class Menu {

	/**
	 * @var array Menu configuration settings.
	 */
	protected $menus;

	/**
	 * @var string Current menu location.
	 */
	protected $location;

	/**
	 * Menu constructor.
	 *
	 * @param $menus
	 */
	public function __construct( $menus ) {
		$this->menus = $menus;
	}

	public function init() {
		add_action( 'after_setup_theme', array( $this, 'init_menus' ) );
	}

	/**
	 * Register menu locations.
	 *
	 * @param array $menus Menus to register.
	 *
	 * @return null
	 */
	public function register_menus( $menus ) {
		foreach ( $menus as $menu => $properties ) {
			register_nav_menu( $menu, $properties['name'] );
		}
	}

	/**
	 * Unregister menu locations.
	 *
	 * @param array $menus Menus to unregister.
	 *
	 * @return void
	 */
	public function unregister_menus( $menus ) {
		foreach ( $menus as $menu => $properties ) {
			unregister_nav_menu( $menu, $properties['name'] );
		}
	}

	/**
	 * Return whether a menu location is registered.
	 *
	 * @param $menu
	 *
	 * @return bool
	 */
	public function has_menu( $menu ) {
		return ( isset( $this->menus[ $menu ] ) );
	}

	/**
	 * A Wrapper function for wp_nav_menu() that outputs menu markup.
	 * @since 3.0
	 *
	 * @param string $location Theme location of the menu to build.
	 *
	 * @return void
	 */
	public function build( $location ) {
		$this->location = $location;

		extract( $this->menus[ $location ] );

		if ( has_nav_menu( $location ) || $fallback ) {
			wp_nav_menu( [
					'container'       => $container,
					'container_id'    => 'menu-' . $location . '-container',
					'container_class' => $class . ' menu-' . $location . '-container',
					'theme_location'  => $location,
					'menu_class'      => 'menu-' . $location,
					'depth'           => $depth,
					'fallback_cb'     => array( $this, 'fallback_main_menu' ),
				]
			);
		}
	}


	/** ----- CALLBACKS ----- */

	/**
	 * Initialize all default menus.
	 * @return void
	 */
	public function init_menus() {
		$this->register_menus( $this->menus );
	}

	public function fallback_main_menu() {
		include 'html/fallback-menu.php';
	}

}