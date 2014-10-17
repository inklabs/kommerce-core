<?php
namespace inklabs\kommerce;

class ArrTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides test data for testGet()
     *
     * @return array
     */
    public function providerGet()
    {
        return array(
            array(array('uno', 'dos', 'tress'), 1, null, 'dos'),
            array(array('we' => 'can', 'make' => 'change'), 'we', null, 'can'),

            array(array('uno', 'dos', 'tress'), 10, null, null),
            array(array('we' => 'can', 'make' => 'change'), 'he', null, null),
            array(array('we' => 'can', 'make' => 'change'), 'he', 'who', 'who'),
            array(array('we' => 'can', 'make' => 'change'), 'he', array('arrays'), array('arrays')),
        );
    }

    /**
     * Tests Arr::get()
     *
     * @test
     * @dataProvider providerGet()
     * @param array          $array      Array to look in
     * @param string|integer $key        Key to look for
     * @param mixed          $default    What to return if $key isn't set
     * @param mixed          $expected   The expected value returned
     */
    public function testGet(array $array, $key, $default, $expected)
    {
        $this->assertSame(
            $expected,
            Arr::get($array, $key, $default)
        );
    }

    /**
     * Provides test data for testRange()
     *
     * @return array
     */
    public function providerRange()
    {
        return array(
            array(1, 2),
            array(1, 100),
            array(25, 10),
        );
    }

    /**
     * Tests Arr::range()
     *
     * @dataProvider providerRange
     * @param integer $step  The step between each value in the array
     * @param integer $max   The max value of the range (inclusive)
     */
    public function testRange($step, $max)
    {
        $range = Arr::range($step, $max);

        $this->assertSame((int) floor($max / $step), count($range));

        $current = $step;

        foreach ($range as $key => $value) {
            $this->assertSame($key, $value);
            $this->assertSame($current, $key);
            $this->assertLessThanOrEqual($max, $key);
            $current += $step;
        }
    }

    public function testEmptyRange()
    {
        $this->assertSame([], Arr::range(0));
    }

    /**
     * Provides test data for testUnshift()
     *
     * @return array
     */
    public function providerUnshift()
    {
        return array(
            array(array('one' => '1', 'two' => '2',), 'zero', '0'),
            array(array('step 1', 'step 2', 'step 3'), 'step 0', 'wow')
        );
    }

    /**
     * Tests Arr::unshift()
     *
     * @test
     * @dataProvider providerUnshift
     * @param array $array
     * @param string $key
     * @param mixed $value
     */
    public function testUnshift(array $array, $key, $value)
    {
        $original = $array;

        Arr::unshift($array, $key, $value);

        $this->assertNotSame($original, $array);
        $this->assertSame(count($original) + 1, count($array));
        $this->assertArrayHasKey($key, $array);

        $this->assertSame($value, reset($array));
        $this->assertSame(key($array), $key);
    }

    /**
     * Provies test data for testOverwrite
     *
     * @return array Test Data
     */
    public function providerOverwrite()
    {
        return array(
            array(
                array('name' => 'Henry', 'mood' => 'tired', 'food' => 'waffles', 'sport' => 'checkers'),
                array('name' => 'John', 'mood' => 'bored', 'food' => 'bacon', 'sport' => 'checkers'),
                array('name' => 'Matt', 'mood' => 'tired', 'food' => 'waffles'),
                array('name' => 'Henry', 'age' => 18,),
            ),
        );
    }

    /**
     *
     * @test
     * @dataProvider providerOverwrite
     */
    public function testOverwrite($expected, $arr1, $arr2, $arr3 = array(), $arr4 = array())
    {
        $this->assertSame(
            $expected,
            Arr::overwrite($arr1, $arr2, $arr3, $arr4)
        );
    }
}
