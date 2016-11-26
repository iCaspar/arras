<?php
/**
 * Tests for Layout Factory Class.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Tests\Unit\Theme\Layouts;

use ICaspar\Arras\Theme\Layouts\Layout;
use ICaspar\Arras\Theme\Layouts\LayoutFactory;

/**
 * Class LayoutFactoryTest
 * @package ICaspar\Arras\Tests\Unit
 */
class LayoutFactoryTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		\WP_Mock::setUp();
		\WP_Mock::wpFunction( '__', [
		] );
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function testThrowsInvalidArgumentException() {
		$this->expectException( \InvalidArgumentException::class );
		$layoutFactory = new LayoutFactory( 'someClassName' );
	}

	public function testReturnsLayoutClass() {
		$layoutFactory = new LayoutFactory( 'NoSidebars' );
		$this->assertInstanceOf( 'ICaspar\\Arras\\Theme\\Layouts\\Layout', $layoutFactory->build() );
	}

}
