<?php
/**
 * AssetServiceTest.php
 */

namespace Arras\Services;

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
		self::assertInstanceOf( 'Arras\Services\AssetService', new AssetService( [], '' ) );
	}

	public function testRegisterStylesFailNoConfig(): void {
		self::expectException( 'RuntimeException' );
		$service = new AssetService( [], '' );

		$service->registerStyles();
	}

	public function testRegisterStyleFailsBadConfig(): void {
		Functions\when( 'wp_register_style' )->justReturn( false );
		$service = $this->getSampleService();

		$result = $service->registerStyles();

		self::assertEquals( [ '' ], $result );
	}

	public function testRegisterNoStyles(): void {
		Functions\when( 'wp_register_style' )->justReturn( false );
		$service = new AssetService( [ 'styles' => [ 'test-style' => [] ] ], 'http://example.com' );

		self::assertEquals( [], $service->registerStyles() );
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

	public function testBuildStyleSchemeChooser(): void {
		Functions\when( 'wp_register_style' )->justReturn( true );
		Functions\when( 'arras_get_option' )->justReturn( true );
		Functions\when( 'arras_form_dropdown' )->returnArg( 2 );

		$service    = new AssetService( [
			'styles' => [
				'arras'      => [
					'filename' => 'default',
					'version'  => '',
					'scheme'   => true,
				],
				'arras-blue' => [
					'filename' => 'blue',
					'version'  => '',
					'scheme'   => true,
				],
				'arras-rtl'  => [
					'filename' => 'rtl',
					'version'  => '',
				],
			],
		], '' );

		$expectedStyleSchemeArray = [ 'default' => 'Default', 'blue' => 'Blue' ];

		$service->registerStyles();
		self::assertEquals( $expectedStyleSchemeArray, $service->buildStyleSchemeChooser() );
	}

	private function getSampleService( bool $isDevEnv = false ): AssetService {
		return new AssetService( [
			'styles' => [
				'test-styles' => [
					'filename' => 'style',
					'deps'     => [],
					'version'  => '1.2.3',
					'media'    => 'all',
					'scheme'   => true,
				]
			],
		], 'https://example.com/wp-content/themes/arras/assets', $isDevEnv );
	}
}
