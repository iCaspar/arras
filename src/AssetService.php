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

	private $config = [];

	private $env = 'production';

	public function __construct( array $config ) {
		$this->config = $config;
		$this->env    = $this->getEnvironment();
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

}