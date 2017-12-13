<?php
/**
 * Theme.php
 */

namespace Arras;


/**
 * Class Theme
 * @package Arras
 */
class Theme {

	/**
	 * @var array
	 */
	private $config = [];

	/**
	 * @var Theme
	 */
	private static $arras;

	/**
	 * @var AssetService
	 */
	public $assets;

	/**
	 * Theme constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config ) {
		$this->config = $config;
		self::$arras = $this;
	}

	/**
	 * @return void
	 */
	public function init() {
		if ( isset( $this->config['assets'] ) && is_array( $this->config['assets'] ) ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'initAssets' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'initAssets' ] );
		}

		add_filter( 'arras_theme', [ $this, 'getTheme' ] );
	}

	/**
	 * @return void
	 */
	public function initAssets() {
		if ( ! isset( $this->config['assets'] ) ) {
			return;
		}

		$isDevEnv     = defined( 'SCRIPT_DEBUG' ) && true == SCRIPT_DEBUG;
		$this->assets = new AssetService( $this->config['assets'], ARRAS_ASSET_URL, $isDevEnv );

		try {
			$result = $this->assets->registerStyles();
		} catch ( \RuntimeException $e ) {
			die( $e->getMessage() );
		}
	}

	/**
	 * @return Theme The Arras Main Theme Object.
	 */
	public static function getArras() {
		return self::$arras;
	}
}