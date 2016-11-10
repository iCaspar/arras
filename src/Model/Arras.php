<?php
/**
 * Where Arras begins.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Model;

use ICaspar\Arras\Views\Menu;
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
	 * @var Menu Theme menus.
	 */
	protected $menus;

	/**
	 * @var The Template engine.
	 */
	protected $template_engine;

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

		$this->menus = new Menu( $this->config->getSetting( 'menus' ) );
		$this->menus->init();

		$this->template_engine = new TemplateEngine( $this->config, $this->menus );

		add_action( 'after_setup_theme', array( $this, 'i18n' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
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
	 * Register widgetized areas.
	 * @return  null
	 */
	public function sidebars() {
		$sidebars         = $this->config->getSetting( 'sidebars' );
		$sidebar_defaults = [
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		];

		$footer_sidebars = $this->config->get_option( 'footer-sidebars' ) ?: 1;

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

		wp_enqueue_script( 'arras-menu-helper', ARRAS_ASSETS_URL . 'scripts/dist/menu.min.js', array( 'jquery' ), ARRAS_VERSION, true );

		if ( is_home() && ! $paged && $this->config->get_option( 'enable_slideshow' ) !== false ) {
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
		wp_enqueue_style( 'arras-base', ARRAS_ASSETS_URL . 'styles/css/base.css', false, ARRAS_VERSION, 'all' );
		wp_enqueue_style( 'font-awesome', ARRAS_ASSETS_URL . 'styles/css/font-awesome.min.css', '4.6.3', ARRAS_VERSION, 'all' );

		if ( is_child_theme() ) {
			wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), false, ARRAS_VERSION, 'all' );
		}
	}

	/* Todo: Load and instantiate color scheme controller class */

	/**
	 * Return the template engine with the appropriate template type.
	 *
	 * This is hooked to the 'arras_templates' action and called from template files.
	 *
	 * @param string $template_type Template type to set.
	 *
	 * @return TemplateEngine
	 */
	public function render( $template_type ) {
		$sub_template = in_array( $template_type, [ 'header', 'comments', 'sidebar', 'footer' ] );

		$this->template_engine->set_template( $template_type, $sub_template );

		return $this->template_engine;
	}

}