<?php
/**
 * AssetServiceTest.php
 */

namespace Arras;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;


class AssetServiceTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test__construct(): void {
		self::assertInstanceOf( 'Arras\AssetService', new AssetService( [], '' ) );
	}

	public function testRegisterStylesFailNoConfig(): void {
		self::expectException( 'RuntimeException' );
		$service = new AssetService( [], '' );

		$service->registerStyles();
	}

	public function testRegisterProdStyles(): void {
		Functions\when( 'wp_register_style' )->justReturn( true );
		$service = $this->getSampleService();

		$result = $service->registerStyles();

		self::assertEquals( [
			'https://example.com/wp-content/themes/arras/assets/dist/css/style.min.css',
		], $result );
	}

	public function testRegisterDevStyles(): void {
		Functions\when( 'wp_register_style' )->justReturn( true );
		$service = $this->getSampleService( true );

		$result = $service->registerStyles();

		self::assertEquals( [
			'https://example.com/wp-content/themes/arras/assets/src/css/style.css',
		], $result );
	}

	private function getSampleService( bool $isDevEnv = false ): AssetService {
		return new AssetService( [
			'styles' => [
				'test-styles' => [
					'filename' => 'style',
					'deps'     => [],
					'version'  => '1.2.3',
					'media'    => 'all'
				]
			],
		], 'https://example.com/wp-content/themes/arras/assets', $isDevEnv );
	}
}
