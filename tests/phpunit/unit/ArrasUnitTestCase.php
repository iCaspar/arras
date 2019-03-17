<?php
/**
 * Test Case for the unit tests.
 *
 * @package Arras\Tests\Unit
 *
 * @since   4.0.0
 */

namespace Arras\Tests\Unit;

use Arras\Tests\TestCaseTrait;
use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

/**
 * Abstract Class Test_Case
 *
 * @package Arras\Tests\Unit
 */
abstract class ArrasUnitTestCase extends TestCase {

	use TestCaseTrait;

	/**
	 * @var bool When true, return the given path when doing wp_normalize_path().
	 *
	 * @since 4.0.0
	 */
	protected $just_return_path = false;

	/**
	 * Prepares the test environment before each test.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();

		Functions\when( 'wp_normalize_path' )->alias( function( $path ) {

			if ( true === $this->just_return_path ) {
				return $path;
			}

			$path = str_replace( '\\', '/', $path );
			$path = preg_replace( '|(?<=.)/+|', '/', $path );

			if ( ':' === substr( $path, 1, 1 ) ) {
				$path = ucfirst( $path );
			}

			return $path;
		} );

		Functions\when( 'wp_json_encode' )->alias( function( $array ) {
			return json_encode( $array ); // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode -- Required as part of our mock.
		} );
	}

	/**
	 * Set up the stubs for the common WordPress escaping and internationalization functions.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	protected function setup_common_wp_stubs(): void {
		// Common escaping functions.
		Monkey\Functions\stubs( array(
			'esc_attr',
			'esc_html',
			'esc_textarea',
			'esc_url',
			'wp_kses_post',
		) );

		// Common internationalization functions.
		Monkey\Functions\stubs( array(
			'__',
			'esc_html__',
			'esc_html_x',
			'esc_attr_x',
		) );

		foreach ( array( 'esc_attr_e', 'esc_html_e', '_e' ) as $wp_function ) {
			Monkey\Functions\when( $wp_function )->echoArg();
		}
	}

	/**
	 * Cleans up the test environment after each test.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}
}
