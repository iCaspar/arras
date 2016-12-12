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
use ICaspar\Arras\Customizer\ArrasCustomizer;
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
	static protected $arras;

	/**
	 * Arras constructor.
	 *
	 * @param Configuration $config Theme configuration manager.
	 */
	public function __construct( Configuration $config ) {
		self::$arras           = new Container();
		self::$arras['config'] = $config;
	}

	/**
	 * Initialize the theme.
	 *
	 * Sets the hooks for WP to call theme components.
	 *
	 * @return void
	 */
	public function init() {
		$this->init_service_providers();
		$this->init_options();
		$this->init_hooks();
	}

	/**
	 * Get the theme service container.
	 * @return Container
	 */
	static public function get_arras() {
		return self::$arras;
	}

	/**
	 * Initialize theme services.
	 *
	 * These classes provide all the services the theme will need for setup, render and admin.
	 * @return void
	 */
	protected function init_service_providers() {
		$providers = self::$arras['config']['service-providers'];

		foreach ( $providers as $provider => $service ) {
			self::$arras[ $provider ] = function () use ( $service ) {
				return new $service();
			};
		}
	}

	protected function init_options() {
		self::$arras['options']    = function ( $arras ) {
			return $arras['optionsFactory']->build( $arras['config']['defaults'] );
		};
		self::$arras['customizer'] = function ( $arras ) {
			return new ArrasCustomizer( $arras['options'] );
		};
	}

	/**
	 * Initialize theme actions and filters.
	 * @return void
	 */
	protected function init_hooks() {
		add_action( 'after_setup_theme', [ self::$arras['language'], 'init' ] );
		add_action( 'after_setup_theme', [ self::$arras['themeSupport'], 'init' ] );
		add_action( 'after_setup_theme', [ self::$arras['menuController'], 'init' ] );
		add_action( 'widgets_init', [ self::$arras['sidebars'], 'init' ] );
		add_action( 'wp_enqueue_scripts', [ self::$arras['assets'], 'load_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ self::$arras['assets'], 'load_styles' ] );
		add_action( 'customize_register', [ self::$arras['customizer'], 'customizer' ] );
		add_action( 'customize_preview_init', [ self::$arras['customizer'], 'postmessage' ] );

		add_action( 'arras', [ $this, 'render' ] );

		add_filter( 'arras_inject', [ $this, 'inject_resource' ] );
	}

	/** ----- CALLBACKS ----- */

	/**
	 * Render a web page.
	 */
	public function render() {
		$template = self::$arras['templateLoader']->get_template( self::$arras );
		$template->render();
	}

	/**
	 * Inject an arras theme resource into a template.
	 *
	 * @param string $resource Resource to be injected
	 *
	 * @return mixed
	 */
	public function inject_resource( $resource ) {
		if ( isset( self::$arras[ $resource ] ) ) {
			return self::$arras[ $resource ];
		} else {
			return null;
		}
	}
}