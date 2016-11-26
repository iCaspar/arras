<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Tests\Unit;


use ICaspar\Arras\Theme\LayoutFactory;

class LayoutFactoryTest extends \PHPUnit_Framework_TestCase {

	protected $factory;

	public function setUp() {
		$this->factory = new LayoutFactory();
	}

	public function testReturnsLayoutClass() {
		$this->assertInstanceOf('ICaspar\Arras\Theme\Layout', $this->factory->build('somelayout') );
	}
}
