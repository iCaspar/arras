<?php

namespace spec\ICaspar\Arras\Config;

use ICaspar\Arras\Config\ArrasConfiguration;
use ICaspar\Arras\Config\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrasConfigurationSpec extends ObjectBehavior {

	function let() {
		$config = [
			'parameter1' => 'parameter1value',
			'parameter2' => 'parameter2value',
			'parameter3' => 'parameter3value',
		];
		$this->beConstructedWith( $config );
	}

	function it_is_initializable() {
		$this->shouldHaveType( ArrasConfiguration::class );
	}

	function it_has_Configuration_type() {
		$this->shouldHaveType( Configuration::class );
	}

	function it_has_ArrayObject_type() {
		$this->shouldHaveType( \ArrayObject::class );
	}

	function it_returns_all_config_parameters() {
		$result = [
			'parameter1' => 'parameter1value',
			'parameter2' => 'parameter2value',
			'parameter3' => 'parameter3value',
		];

		$this->all()->shouldBe( $result );
	}

	function it_checks_whether_a_parameter_is_set() {
		$this->has( 'parameter1' );
		$this->has( 'unsetParameter' )->shouldBe( false );
	}

	function it_gets_a_value_for_a_requested_parameter() {
		$this->get( 'parameter1', 'defaultValuePassedIn' )->shouldBe( 'parameter1value' );
	}

	function it_returns_default_value_or_null_for_an_unset_parameter() {
		$this->get( 'unsetParam', 'defaultValuePassedIn' )->shouldBe( 'defaultValuePassedIn' );
		$this->get( 'unsetParam' )->shouldBe( null );
	}

	function it_adds_a_parameter_to_the_configuration() {
		$this->push( 'newParam', 'newValue' );
		$this->all()->shouldHaveCount( 4 );
		$this->all()->shouldHaveKeyWithValue( 'newParam', 'newValue' );
	}

	function it_merges_an_array_into_the_configuration() {
		$newArray = [ 'parameter1' => 'newParam1Val' ];

		$this->merge( $newArray );
		$this->all()->shouldHaveCount( 3 );
		$this->all()->shouldHaveKeyWithValue( 'parameter1', 'newParam1Val' );
	}

	function it_removes_a_specified_parameter() {
		$result = [
			'parameter1' => 'parameter1value',
			'parameter3' => 'parameter3value',
		];

		$this->remove( 'parameter2' );
		$this->all()->shouldBe( $result );
	}
}
