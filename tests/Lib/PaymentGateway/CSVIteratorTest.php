<?php
namespace inklabs\kommerce\Lib;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $iterator = new CSVIterator(__DIR__ . '/CSVIteratorTest.csv');

        $count = 0;
        foreach ($iterator as $k => $row) {
            $count++;
        }

        $this->assertSame(4, $count);
    }

    public function testCreateWithMultipleIterations()
    {
        $iterator = new CSVIterator(__DIR__ . '/CSVIteratorTest.csv');

        $count = 0;
        foreach ($iterator as $k => $row) {
            $count++;
        }

        foreach ($iterator as $k => $row) {
            $count++;
        }

        $this->assertSame(8, $count);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateMissingFile()
    {
        $iterator = new CSVIterator(__DIR__ . '/missing.csv');
    }
}
