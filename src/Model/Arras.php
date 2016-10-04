<?php
/**
 * Where Arras begins.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

use ICaspar\Arras\Controller\Controller;
use ICaspar\Arras\Views\View;

/**
 * Class Arras
 * @package ICaspar\Arras\Model
 * @since 4.0.0
 */
class Arras {

	/**
	 * @var Config The options object.
	 */
	protected $config;

	/**
	 * Arras constructor.
	 *
	 * @param Config $options Theme options.
	 */
	public function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Initialize the theme.
	 *
	 * Sets the hooks for WP to call theme components.
	 *
	 * @return void
	 */
	public function init() {

		add_action( 'after_setup_theme', array( $this, 'i18n' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'after_setup_theme', array( $this, 'menus' ) );
		add_action( 'widgets_init', array( $this, 'sidebars' ) );

		add_action( 'arras_template', array( $this, 'render' ) );
	}


	/** ----- CALLBACKS ----- */

	/**
	 * Make Arras translatable.
	 * @return null
	 */
	public function i18n() {
		load_theme_textdomain( 'arras', get_template_directory() . '/languages' );
	}

	/**
	 * Register theme supports for WP and plugins.
	 * @return null
	 */
	public function theme_support() {
		$supports = $this->config->getSetting( 'theme-support' );

		foreach ( $supports as $support => $value) {
			if ( is_array( $value ) ) {
				add_theme_support( $support, $value );
			} else {
				add_theme_support( $support );
			}
		}
	}

	/**
	 * Register menu locations.
	 * @return null
	 */
	public function menus() {
		$menus = $this->config->getSetting( 'menus' );

		register_nav_menus( $menus );
	}

	/**
	 * Register widgetized areas.
	 * @return  null
	 */
	public function sidebars() {
		$sidebars = $this->config->getSetting( 'sidebars' );
		$sidebar_defaults = [
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		];

		$footer_sidebars = $this->config->get_options( 'footer-sidebars' ) ?: 1;

		for ( $i = 1; $i <= $footer_sidebars; $i ++ ) {
			$sidebars[] = [
				'name'        => sprintf( '%s', _x( 'Footer Sidebar #', 'Footer sidebar name', 'arras' ) ) . $i,
				'id'          => 'footer-sidebar-' . $i,
				'description' => __( 'A footer widget area' ),
			];
		}

		foreach ( $sidebars as $sidebar => $args ) {
			$args = array_merge( $sidebar_defaults, $args );

			register_sidebar( $args );
		}
	}

	/* Todo: Load and instantiate color scheme controller class */

	/**
	 * Fire the Controller to initiate page rendering.
	 *
	 * This is hooked to the 'arras_templates' action and called from the index.php file.
	 *
	 * @return void
	 */
	public function render() {
		$controller = new Controller( $this->config );
		$request = $controller->parse_request();

		$view = new View( $this->config );
		$view->render( $request );
	}


}