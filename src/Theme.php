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

	private $config = [];

	public function __construct( array $config ) {
		$this->config = $config;
	}

	public function init() {
		if ( isset( $this->config['assets'] ) && is_array( $this->config['assets'] ) ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'initAssets' ] );
		}
	}

	public function initAssets() {
		$isDevEnv = defined( 'SCRIPT_DEBUG' ) && true == SCRIPT_DEBUG;
		$assets   = new AssetService( $this->config['assets'], ARRAS_ASSET_URL, $isDevEnv );
		try {
			$result = $assets->registerStyles();
		} catch ( \RuntimeException $e ) {
			die( $e->getMessage() );
		}
	}
}