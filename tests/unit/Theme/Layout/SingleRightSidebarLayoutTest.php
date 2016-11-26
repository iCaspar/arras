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

class SingleRightSidebarLayoutTest extends \PHPUnit_Framework_TestCase {

	protected $layout;

	public function setUp() {
		$this->layout = new SingleRightSidebarLayout();
		\WP_Mock::setUp();

	}

	public function tearDown() {
		$this->layout = null;
		\WP_Mock::tearDown();
	}

	public function testReturnsDescription() {
		\WP_Mock::wpFunction( '__', [
			'times'  => 1,
			'return' => 'Main content with a single right sidebar.'
		] );

		$this->assertSame( 'Main content with a single right sidebar.', $this->layout->get_description() );
	}

	public function testGetClasses() {
		$this->assertEquals( 'col span_2_of_3', $this->layout->get_classes( 'content' ) );
		$this->assertEquals( 'col span_1_of_3 sidebar', $this->layout->get_classes( 'primary' ) );
		$this->assertEquals( '', $this->layout->get_classes( 'anythingElse' ) );
	}
}
