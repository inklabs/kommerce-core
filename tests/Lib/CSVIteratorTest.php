<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\KommerceTestCase;

class CSVIteratorTest extends KommerceTestCase
{
    public function testCreate()
    {
        $iterator = new CSVIterator(self::THREE_USERS_CSV_FILENAME);

        $count = 0;
        foreach ($iterator as $k => $row) {
            $count++;
        }

        $this->assertSame(4, $count);
    }

    public function testCreateWithMultipleIterations()
    {
        $iterator = new CSVIterator(self::THREE_USERS_CSV_FILENAME);

        $count = 0;
        foreach ($iterator as $k => $row) {
            $count++;
        }

        foreach ($iterator as $k => $row) {
            $count++;
        }

        $this->assertSame(8, $count);
    }

    public function testCreateMissingFile()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            '/missing.csv'
        );

        $iterator = new CSVIterator(__DIR__ . '/missing.csv');
    }
}
