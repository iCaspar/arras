<?php
/**
 * AssetService.php
 */

namespace Arras;


/**
 * Class AssetService
 * @package Arras
 */
class AssetService {

	/**
	 * @var array
	 */
	private $config = [];

	/**
	 * @var string
	 */
	private $baseUrl = '';

	/**
	 * @var bool
	 */
	private $isDevEnv = false;

	/**
	 * AssetService constructor.
	 *
	 * @param array $config
	 * @param string $baseUrl
	 * @param bool $isDevEnv
	 */
	public function __construct( array $config, $baseUrl, $isDevEnv = false ) {
		$this->config  = $config;
		$this->baseUrl = $baseUrl;
		$this->isDevEnv = $isDevEnv;
	}

	/**
	 * @return string
	 */
	private function getEnvironment() {
		if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
			return 'development';
		}

		return 'production';
	}

	/**
	 * @throws \RuntimeException
	 * @return array URLs of registered styles.
	 */
	public function registerStyles() {
		if ( ! $this->hasStyles() ) {
			throw new \RuntimeException( 'Missing styles in configuration.' );
		}

		foreach ( $this->config['styles'] as $handle => $args ) {
			if ( ! isset ( $args['filename'] ) ) {
				continue;
			}

			$src      = $this->getAssetUrl( $args['filename'], 'css' );
			$result[] = wp_register_style(
				$handle,
				$src,
				isset( $args['deps'] ) ? $args['deps'] : [],
				isset( $args['version'] ) ? $args['version'] : '',
				isset( $args['media'] ) ? $args['media'] : 'all'
			) ? $src : '';
		}

		return $result;
	}

	/**
	 * @return bool
	 */
	private function hasStyles() {
		return isset( $this->config['styles'] ) && is_array( $this->config['styles'] );
	}

	/**
	 * @param string $filename
	 * @param string $filetype
	 *
	 * @return string The asset url.
	 */
	private function getAssetUrl( $filename, $filetype ) {
		if ( $this->isDevEnv ) {
			return $this->baseUrl . '/src/' . $filetype . '/' . $filename . '.' . $filetype;
		} else {
			return $this->baseUrl . '/dist/' . $filetype . '/' . $filename . '.min.' . $filetype;
		}
	}

}