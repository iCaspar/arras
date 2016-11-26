<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Tests\Unit\Theme\Layouts;

use ICaspar\Arras\Theme\Layouts\SingleRightSidebarLayout;

/**
 * Class SingleRightSidebarLayoutTest
 * @package ICaspar\Arras\Tests\Unit\Theme\Layouts
 */
class SingleRightSidebarLayoutTest extends \PHPUnit_Framework_TestCase {

	protected $layout;

	public function setUp() {
		\WP_Mock::setUp();
		\WP_Mock::wpFunction( '__', [
			'times'  => 1,
			'return' => 'Main content with a single right sidebar.'
		] );

		$this->layout = new SingleRightSidebarLayout();
	}

	public function tearDown() {
		$this->layout = null;
		\WP_Mock::tearDown();
	}

	public function testReturnsDescription() {
		$this->assertSame( 'Main content with a single right sidebar.', $this->layout->get_description() );
	}

	public function testReturnsSlug() {
		$this->assertEquals( 'single-right', $this->layout->get_slug() );
	}

	public function testGetClassesForContent() {
		$this->assertEquals( 'col span_2_of_3', $this->layout->get_classes( 'content' ) );
	}

	public function testGetClassesForPrimarySidebar() {
		$this->assertEquals( 'col span_1_of_3 sidebar', $this->layout->get_classes( 'primary' ) );
	}

	public function testReturnEmptyForAllOther() {
		$this->assertEquals( '', $this->layout->get_classes( 'anythingElse' ) );
	}
}
