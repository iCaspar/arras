<?php
/**
 * Test Case for the integration tests.
 *
 * @package Arras\Tests\Integration
 *
 * @since   4.0.0
 */

namespace Arras\Tests\Integration;

//use function Beans\Framework\Tests\reset_beans;
use Arras\Tests\TestCaseTrait;
use Brain\Monkey;
use WP_UnitTestCase;

/**
 * Abstract Class Test_Case
 *
 * @package Arras\Tests\Integration
 */
abstract class ArrasIntegrationTestCase extends WP_UnitTestCase {

	use TestCaseTrait;

	/**
	 * Set up the test before we run the test setups.
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		set_current_screen( 'front' );
	}

	/**
	 * Prepares the test environment before each test.
	 */
	public function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Cleans up the test environment after each test.
	 */
	public function tearDown() {
		//reset_beans();

		Monkey\tearDown();
		parent::tearDown();
	}
}
