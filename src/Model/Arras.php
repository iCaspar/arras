<?php
/**
 * Where Arras begins.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

use ICaspar\Arras\Controller\Router;
use ICaspar\Arras\Views\View;

/**
 * Class Arras
 * @package ICaspar\Arras\Model
 * @since 4.0.0
 */
class Arras {

	/**
	 * @var Config The theme configuration object.
	 */
	protected $config;

	/**
	 * Arras constructor.
	 *
	 * @param Config $config Theme configuration manager.
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
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );

		add_filter( 'arras_template', array( $this, 'render' ) );
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

		foreach ( $supports as $support => $value ) {
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
		$sidebars         = $this->config->getSetting( 'sidebars' );
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

	/**
	 * Enqueue theme scripts.
	 * @return void
	 */
	public function load_scripts() {
		global $paged;

		if ( is_home() && ! $paged && $this->config->get_options( 'enable_slideshow' ) !== false ) {
			wp_enqueue_script( 'jquery-cycle', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2-min.js', array( 'jquery' ), ARRAS_VERSION, true );
			wp_enqueue_script( 'slideshow-settings', ARRAS_ASSETS_URL . 'scripts/slideshowsettings.js', array( 'jquery-cycle' ), ARRAS_VERSION, true );
			wp_enqueue_script( 'jquery-cycle-caption', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.caption2.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
			wp_enqueue_script( 'jquery-cycle-swipe', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.swipe.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
		}

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function load_styles() {
		wp_enqueue_style( 'arras-base', ARRAS_ASSETS_URL . 'styles/base.css', false, ARRAS_VERSION, 'all' );

		if ( is_child_theme() ) {
			wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), false, ARRAS_VERSION, 'all' );
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
	public function render( $template_type ) {
		return new View( $this->config, $template_type );
	}

}