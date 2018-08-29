<?php
/**
 * Arras Theme class.
 *
 * @package Arras
 *
 * @since 1.8
 */

namespace Arras;

/**
 * Class Theme
 *
 * @package Arras
 *
 * @since 1.8
 */
class Theme {

	/**
	 * Theme configuration.
	 *
	 * @var array
	 */
	private $config = [];

	/**
	 * The Arras theme object.
	 *
	 * @var Theme
	 */
	private static $arras;

	/**
	 * Theme assets.
	 *
	 * @var AssetService
	 */
	public $assets;

	/**
	 * Theme constructor.
	 *
	 * @param array $config Theme configuration.
	 */
	public function __construct( array $config ) {
		$this->config = $config;
		self::$arras  = $this;
	}

	/**
	 * Initialize the theme.
	 *
	 * @since 1.8
	 *
	 * @return void
	 */
	public function init() {
		$this->init_assets();
		$this->register_layouts();
	}

	/**
	 * Initialize theme assets.
	 *
	 * @since 1.8
	 *
	 * @return void
	 */
	private function init_assets() {
		$config       = isset( $this->config['assets'] ) ? $this->config['assets'] : [];
		$is_dev_env   = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG;
		$this->assets = new AssetService( $config, ARRAS_ASSET_URL, $is_dev_env );
		$this->assets->init();
	}

	/**
	 * Register theme layouts.
	 *
	 * @since 1.8
	 *
	 * @return void
	 */
	private function register_layouts() {
		$config = isset( $this->config['layouts'] ) ? $this->config['layouts'] : [];
		$style  = arras_get_option( 'style' );

		foreach ( $config as $slug => $layout ) {
			if ( 'arras-nova' === $style && 'nova' === $layout[1] ) {
				register_alternate_layout( $slug, $layout[0] );
			} elseif ( 'arras-nova' !== $style && 'legacy' === $layout[1] ) {
				register_alternate_layout( $slug, $layout[0] );
			}
		}
	}

	/**
	 * Get the Arras theme object.
	 *
	 * @since 1.8
	 *
	 * @return Theme The Arras Main Theme Object.
	 */
	public static function get_arras() {
		return self::$arras;
	}
}
