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
		self::$arras  = $this;
	}

	/**
	 * @return void
	 */
	public function init() {
		$this->initAssets();
	}

	/**
	 * @return void
	 */
	public function initAssets() {
		$config = isset( $this->config['assets'] ) ? $this->config['assets'] : [];
		$isDevEnv     = defined( 'SCRIPT_DEBUG' ) && true == SCRIPT_DEBUG;
		$this->assets = new AssetService( $config, ARRAS_ASSET_URL, $isDevEnv );
		$this->assets->init();
	}

	/**
	 * @return Theme The Arras Main Theme Object.
	 */
	public static function getArras() {
		return self::$arras;
	}
}