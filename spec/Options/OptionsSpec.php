<?php

namespace spec\ICaspar\Arras\Options;

use ICaspar\Arras\Options\Options;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OptionsSpec extends ObjectBehavior {


	function let() {
		\WP_Mock::setUp();
		$this->beConstructedWith( [ 'some_key' => 'some_value', 'another_key' => 'another_value' ] );
	}


	function it_is_initializable() {
		\WP_Mock::wpFunction  ( 'get_option', array(
			'args'  => 'arras-options',
		) );

		$this->shouldHaveType( Options::class );
	}

	function it_returns_all_data_requested_data_or_null() {
		$this->get_option()->shouldReturn( [ 'some_key' => 'some_value', 'another_key' => 'another_value' ] );
		$this->get_option( 'some_key' )->shouldReturn( 'some_value' );
		$this->get_option( 'missing_key' )->shouldReturn( null );
	}

	function letGo() {
		\WP_Mock::tearDown();
	}
}
