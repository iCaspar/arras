<?php

namespace spec\ICaspar\Arras\Model;

use ICaspar\Arras\Model\Options;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OptionsSpec extends ObjectBehavior {
	function let() {
		\WP_Mock::setUp();
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

		$this->shouldHaveType( Options::class );
	}

	function it_throws_exception_if_options_are_not_array() {
		\WP_Mock::wpFunction( 'get_option', array(
			'args'    => 'arras-options',
			'returns' => 'a string',
		) );

		$this->shouldThrow( '\Exception' );
	}

	function it_returns_the_right_options() {
		$sample = [
			'footer-sidebars' => 3,
			'some-option'     => 'option value',
			'another-option'  => 'another option value',
		];

		// Test for returning the whole option set.
		$this->get_options( null, $sample )->shouldBe( $sample );

		// Test for returning an array of requested options, all present.
		$this->get_options( [
			'footer-sidebars',
			'some-option',
		], $sample )->shouldBe( [
			'footer-sidebars' => 3,
			'some-option'     => 'option value',
		] );

		// Test for returning an array of requested options, missing options return null.
		$this->get_options( [
			'footer-sidebars',
			'some-opt',
		], $sample )->shouldBe( [
			'footer-sidebars' => 3,
			'some-opt'     => null,
		] );

		// Test for returning a single option when matched.
		$this->get_options( 'another-option', $sample )->shouldBe( 'another option value' );

		// Test for returning null for single option unmatched.
		$this->get_options( 'bogus', $sample )->shouldBe( null );

		// Test for returning null for something screwy.
		$this->get_options( new \stdClass(), $sample )->shouldBe( null );
	}
}
