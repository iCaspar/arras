<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Tests\Unit\Theme\Layouts;

use ICaspar\Arras\Theme\Layouts\NoSidebarsLayout;

class NoSidebarsLayoutTest extends \PHPUnit_Framework_TestCase {

	protected $layout;

	public function setUp() {
		\WP_Mock::setUp();
		\WP_Mock::wpFunction( '__', [
			'times'  => 1,
			'return' => 'Single column and no sidebars.'
		] );

		$this->layout = new NoSidebarsLayout();
	}

	public function tearDown() {
		$this->layout = null;
		\WP_Mock::tearDown();
	}

	public function testReturnsDescription() {
		$this->assertEquals( 'Single column and no sidebars.', $this->layout->get_description() );
	}

	public function testReturnsSlug() {
		$this->assertEquals( 'no-sidebars', $this->layout->get_slug() );
	}

	public function testGetClassesForContent() {
		$this->assertEquals( 'group', $this->layout->get_classes( 'content' ) );
	}

	public function testGetClassesForPrimarySidebar() {
		$this->assertEquals( 'group sidebar', $this->layout->get_classes( 'primary' ) );
	}

	public function testReturnEmptyForAllOther() {
		$this->assertEquals( '', $this->layout->get_classes( 'anythingElse' ) );
	}
}
