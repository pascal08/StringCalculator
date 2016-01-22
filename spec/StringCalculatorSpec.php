<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringCalculatorSpec extends ObjectBehavior
{
    function it_translates_an_empty_string_into_zero()
    {
        $this->sum('')->shouldReturn(0);
    }

    function it_calculates_the_sum_for_multiple_numbers()
    {
        $this->sum('1,2,3,4')->shouldReturn(10);
    }

    function it_calculates_the_product_for_multiple_numbers()
    {
        $this->product('1,2,3,4')->shouldReturn(24);
    }

    function it_ignores_numbers_greater_than_one_thousand()
    {
        $this->sum('1,2,3,1000')->shouldReturn(6);
    }

    function it_disallows_negative_numbers_by_default()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('sum', ['1,2,3,-1']);
    }

    function it_allows_negative_numbers_on_request()
    {
        $this->allowNegativeNumbers();

        $this->sum('1,2,3,4,-1')->shouldReturn(9);
    }

    function it_allows_custom_delimiters()
    {
        $this->setDelimiters('/');

        $this->sum('1/2/3/4')->shouldReturn(10);
    }

    function it_allows_multiple_delimiters()
    {
        $this->setDelimiters(['/', ',']);

        $this->sum('1,2,3/4')->shouldReturn(10);
    }

    function it_allows_newline_as_a_delimiter()
    {
        $this->setDelimiters('\n');

        $this->sum('1\n2\n3\n4')->shouldReturn(10);
    }

    function it_ignores_non_integers()
    {
        $this->sum('1,a,3,4,b')->shouldReturn(8);
    }
}
