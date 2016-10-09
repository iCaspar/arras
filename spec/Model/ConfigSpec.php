<?php

namespace spec\ICaspar\Arras\Model;

use ICaspar\Arras\Model\Config;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigSpec extends ObjectBehavior {
	function let() {
		\WP_Mock::setUp();

		$sample = [
			'settings' => [
				'theme-supports' => 'some supports',
				'menus'          => 'some menus',
				'sidebars'       => 'some sidebars',
			],
			'options'  => [
				'footer-sidebars' => 3,
				'some-option'     => 'option value',
				'another-option'  => 'another option value',
			]
		];

		$this->beConstructedWith( $sample );
	}

	function letGo() {
		\WP_Mock::tearDown();
	}

	function it_is_initializable() {
		\WP_Mock::wpFunction( 'get_option', array(
			'args'    => 'arras-options',
			'returns' => [ ],
			'times'   => 1
		) );

		$this->shouldHaveType( Config::class );
	}

	function it_throws_exception_if_options_are_not_array() {
		\WP_Mock::wpFunction( 'get_option', array(
			'args'    => 'arras-options',
			'returns' => 'a string',
		) );

		$this->shouldThrow( '\Exception' );
	}

	function it_returns_the_right_options() {
		$options = [
			'footer-sidebars' => 3,
			'some-option'     => 'option value',
			'another-option'  => 'another option value',
		];

		// Test for returning the whole option set.
		$this->get_option( null )->shouldBe( $options );

		// Test for returning an array of requested options, all present.
		$this->get_option( [
			'footer-sidebars',
			'some-option',
		] )->shouldBe( [
			'footer-sidebars' => 3,
			'some-option'     => 'option value',
		] );

		// Test for returning an array of requested options, missing options return null.
		$this->get_option( [
			'footer-sidebars',
			'some-opt',
		] )->shouldBe( [
			'footer-sidebars' => 3,
			'some-opt'        => null,
		] );

		// Test for returning a single option when matched.
		$this->get_option( 'another-option' )->shouldBe( 'another option value' );

		// Test for returning null for single option unmatched.
		$this->get_option( 'bogus' )->shouldBe( null );

		// Test for returning null for something screwy.
		$this->get_option( new \stdClass() )->shouldBe( null );
	}
}
