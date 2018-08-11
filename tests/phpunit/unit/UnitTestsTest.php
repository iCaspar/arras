<?php
/**
 * SampleTest class
 *
 * @package Arras\Tests\Unit
 *
 * @since 4.0.0
 */

namespace Arras\Tests\Unit;

class UnitTestsTest extends ArrasUnitTestCase {

	/**
	 * Test that unit tests are working.
	 *
	 * @since 4.0.0
	 *
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @return void
	 */
	public function test_unit_tests_are_working() {
		$this->assertTrue( $this->return_true() );
	}

	/**
	 * Return true.
	 *
	 * @since 4.0.0
	 *
	 * @return bool
	 */
	protected function return_true(): bool {
		return true;
	}
}
