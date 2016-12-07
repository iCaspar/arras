<?php
/**
 * Where Arras begins.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras\Theme;

use ICaspar\Arras\Config\Configuration;
use ICaspar\Arras\Options\Options;
use Pimple\Container;

/**
 * Class Arras
 * @package ICaspar\Arras\Model
 * @since 4.0.0
 */
class Arras {

	/**
	 * Container for theme configuration and services.
	 *
	 * @var Container
	 */
	protected $arras;

	/**
	 * Arras constructor.
	 *
	 * @param Configuration $config Theme configuration manager.
	 */
	public function __construct( Configuration $config ) {
		$this->arras           = new Container();
		$this->arras['config'] = $config;
	}

	/**
	 * Initialize the theme.
	 *
	 * Sets the hooks for WP to call theme components.
	 *
	 * @return void
	 */
	public function init() {
		$this->init_options();
		$this->init_service_providers();
		$this->init_hooks();
	}

	/**
	 * Initialize theme options.
	 *
	 * These need to be loaded first so we can use them to configure services.
	 * @return void
	 */
	protected function init_options() {
		$defaults = $this->arras['config']['defaults'];

		$this->arras['options'] = function () use ( $defaults ) {
			return new Options( $defaults );
		};
	}

	/**
	 * Initialize theme services.
	 *
	 * These classes provide all the services the theme will need for setup, render and admin.
	 * @return void
	 */
	protected function init_service_providers() {
		$providers = $this->arras['config']['service-providers'];

		foreach ( $providers as $provider => $service ) {
			$this->arras[ $provider ] = function ( $arras ) use ( $service ) {
				if ( is_array( $service ) ) {
					$args = null;
					if ( 'option' == $service['source'] ) {
						( $service['class'] );
						$args = $this->arras['options']->get( $service['parameter'] );
					}

					if ( 'config' == $service['source'] ) {
						$args = $this->arras['config'][ $service['parameter'] ];
					}

					return new $service['class']( $args );
				} else {
					return new $service();
				}
			};
		}
	}

	/**
	 * Initialize theme actions and filters.
	 * @return void
	 */
	protected function init_hooks() {
		add_action( 'after_setup_theme', array( $this, 'i18n' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'after_setup_theme', array( $this, 'menus' ) );
		add_action( 'widgets_init', array( $this, 'sidebars' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_styles' ) );

		// Todo: Refactor Customizer
		//add_action( 'customize_register', array( $this->config, 'customizer' ) );
		//add_action( 'customize_preview_init', array( $this->config, 'postmessage' ) );

		add_action( 'arras', array( $this, 'render' ) );

		add_filter( 'arras_inject', array( $this, 'inject_resource' ) );
	}

	/** ----- CALLBACKS ----- */

	/**
	 * Inject a specific theme resource into a template.
	 *
	 * @param string $resource The resource to inject
	 *
	 * @return mixed The resource or null if not available.
	 */
	public function inject_resource( $resource ) {
		return ( isset( $this->arras[ $resource ] ) ) ? $this->arras[ $resource ] : null;
	}

	/**
	 * Make Arras translatable.
	 * @return void
	 */
	public function i18n() {
		load_theme_textdomain( 'arras', get_template_directory() . '/languages' );
	}

	/**
	 * Register theme supports for WP and plugins.
	 * @return void
	 */
	public function theme_support() {
		$supports = $this->arras['config']['theme-support'];

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
	 * @return  void
	 */
	public function sidebars() {
		$sidebars = $this->arras['config']['sidebars'];

		$sidebar_defaults = [
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		];

		$footer_sidebars = $this->arras['options']->get( 'footer-sidebars' ) ?: 1;

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
	 * Register menus.
	 * @return void
	 */
	public function menus() {
		$this->arras['menus']->register_menus();
	}

	/**
	 * Enqueue theme scripts.
	 * @return void
	 */
	public function load_scripts() {

		wp_enqueue_script( 'arras-menu-helper', ARRAS_ASSETS_URL . 'scripts/min/menu.min.js', array( 'jquery' ), ARRAS_VERSION, true );
		/*
				if ( is_home() && ! $paged && $this->config->get_option( 'enable_slideshow' ) !== false ) {
					wp_enqueue_script( 'jquery-cycle', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2-min.js', array( 'jquery' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'slideshow-settings', ARRAS_ASSETS_URL . 'scripts/slideshowsettings.js', array( 'jquery-cycle' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'jquery-cycle-caption', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.caption2.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
					wp_enqueue_script( 'jquery-cycle-swipe', ARRAS_ASSETS_URL . 'scripts/jquery.cycle2.swipe.min.js', array( 'slideshow-settings' ), ARRAS_VERSION, true );
				}
		*/
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Load theme styles.
	 * @return void
	 */
	public function load_styles() {
		wp_enqueue_style( 'arras-base', ARRAS_ASSETS_URL . 'styles/css/base.css', false, ARRAS_VERSION, 'all' );
		wp_enqueue_style( 'font-awesome', ARRAS_ASSETS_URL . 'styles/css/font-awesome.min.css', false, '4.6.3', 'all' );

		if ( is_child_theme() ) {
			wp_enqueue_style( 'arras-child', get_stylesheet_uri(), array( 'arras-base' ), ARRAS_VERSION, 'all' );
		}
	}

	/**
	 * Render the web page.
	 */
	public function render() {
		$template = $this->arras['templateLoader']->get_template( $this->arras );
		$template->render();
	}

}