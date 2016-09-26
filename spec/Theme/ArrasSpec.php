<?php

namespace spec\ICaspar\Arras\Theme;

use ICaspar\Arras\Theme\Arras;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrasSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Arras::class);
    }
}
