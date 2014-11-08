<?php
namespace inklabs\kommerce\Lib;

class BaseConvertTest extends \PHPUnit_Framework_TestCase
{
    public function providerBase()
    {
        return [
            [null, null],
            ['1', 1],
            ['A', 10],
            ['10', 36],
            ['1A', 46],
            ['111', 1333],
            ['ZZZ', 46655],
        ];
    }

    /**
     * @dataProvider providerBase()
     */
    public function testEncode($expected, $input)
    {
        $this->assertSame($expected, BaseConvert::encode($input));
    }

    /**
     * @dataProvider providerBase()
     */
    public function testDecode($input, $expected)
    {
        $this->assertSame($expected, BaseConvert::decode($input));
    }
}
