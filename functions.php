<?php
/**
 * Define theme constants and launch.
 *
 * @author Caspar Green <https://caspar.green>
 * @package Arras
 * @version: 4.0.0
 */

namespace ICaspar\Arras;


use ICaspar\Arras\Model\Arras;
use ICaspar\Arras\Model\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry. This address is not accessible.' );
}

if ( ! defined( 'ARRAS_VERSION' ) ) {
	define( 'ARRAS_VERSION', '4.0.0' );
}

if ( ! defined( 'ARRAS_THEME_DIR' ) ) {
	define( 'ARRAS_THEME_DIR', get_template_directory() );
}

if ( ! defined( 'ARRAS_CONFIG_DIR' ) ) {
	define( 'ARRAS_CONFIG_DIR', ARRAS_THEME_DIR . '/config/' );
}

if ( ! defined( 'ARRAS_TEMPLATE_DIR' ) ) {
	define( 'ARRAS_TEMPLATE_DIR', ARRAS_THEME_DIR . '/templates/' );
}

if ( ! defined( 'ARRAS_THEME_URL' ) ) {
	define( 'ARRAS_THEME_URL', get_template_directory_uri() );
}

if ( ! defined( 'ARRAS_ASSETS_URL' ) ) {
	define( 'ARRAS_ASSETS_URL', ARRAS_THEME_URL . '/assets/' );
}

if ( version_compare( $GLOBALS['wp_version'], '4.6', '>' ) ) {
	launch();
}

/**
 * Launch the theme.
 *
 * @since 1.0.0
 *
 * @return void
 */

function launch() {
	require_once( __DIR__ . '/vendor/autoload.php' );

	$config = apply_filters( 'arras_settings', include ARRAS_CONFIG_DIR . 'main-config.php' );

	try {
		$arras = new Arras( new Options( ( $config ) ) );
		$arras->init();
	} catch ( \Exception $e ) {
		die( $e->getMessage() );
	}
}
