<?php
/**
 * AssetServiceTest.php
 */

namespace Arras;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

class AssetServiceTest extends TestCase {

	public function test__construct() {
		try {
			self::assertInstanceOf( 'Arras\AssetService', new AssetService( [] ) );
		} catch ( Exception $e ) {
		}
	}
}
