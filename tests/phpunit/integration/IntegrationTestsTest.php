<?php
/**
 * IntegrationTestsTest class
 *
 * @package Arras\Tests\Integration
 *
 * @since 4.0.0
 */

namespace Arras\Tests\Integration;

class IntegrationTestsTest extends ArrasIntegrationTestCase {

	/**
	 * Test that integration tests are working.
	 *
	 * @since 4.0.0
	 *
	 * @throws \PHPUnit_Framework_AssertionFailedError
	 * @return void
	 */
	public function test_integration_tests_are_working() {

		$this->assertFalse( has_nav_menu( 'bogus_location' ) );
	}
}
