<?php
/**
 * Arras PHPUnit Test Suite common functionality.
 *
 * @package Arras\Tests\Phpunit
 *
 * @since   4.0.0
 */

namespace Arras\Tests;

/**
 * Initialize the test suite.
 *
 * @since 4.0.0
 *
 * @param string $test_suite Directory name of the test suite.
 *
 * @return void
 */
function init_test_suite( string $test_suite ): void {
	check_readiness();

	init_constants( $test_suite );

	// Load the files.
	$arras_root_dir = rtrim( ARRAS_THEME_DIR, DIRECTORY_SEPARATOR );
	require_once $arras_root_dir . '/vendor/autoload.php';
	require_once __DIR__ . '/TestCaseTrait.php';

	// Load Patchwork before everything else in order to allow us to redefine WordPress and Arras functions.
	require_once $arras_root_dir . '/vendor/brain/monkey/inc/patchwork-loader.php';
}

/**
 * Check the system's readiness to run the tests.
 *
 * @since 4.0.0
 *
 * @return void
 */
function check_readiness() {

	if ( version_compare( phpversion(), '7.1', '<' ) ) {
		trigger_error( 'Beans Unit Tests require PHP 7.1 or higher.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
	}

	if ( ! file_exists( dirname( dirname( __DIR__ ) ) . '/vendor/autoload.php' ) ) {
		trigger_error( 'Whoops, we need Composer before we start running tests.  Please type: `composer install`.  When done, try running `phpunit` again.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
	}
}

/**
 * Initialize the test constants.
 *
 * @since 4.0.0
 *
 * @param string $test_suite_folder Directory name of the test suite.
 *
 * @return void
 */
function init_constants( string $test_suite_folder ): void {
	define( 'ARRAS_TESTS_DIR', __DIR__ . DIRECTORY_SEPARATOR . $test_suite_folder );

	$arras_root_dir = dirname( dirname( __DIR__ ) );

	if ( 'unit' === $test_suite_folder ) {
		$arras_root_dir .= DIRECTORY_SEPARATOR;
	}

	define( 'ARRAS_THEME_DIR', $arras_root_dir );
}
