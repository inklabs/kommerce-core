<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;

class UserTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
    ];

    public function testImport()
    {
        $this->setCountLogger();

        $userService = new User($this->repository()->getUser());

        $iterator = new Lib\CSVIterator(__DIR__ . '/UserTest.csv');
        $importResult = $userService->import($iterator);

        $this->assertTrue($importResult instanceof ImportResult);
        $this->assertSame(3, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame(1, count($importResult->getFailedRows()));
        $this->assertSame(12, $this->countSQLLogger->getTotalQueries());
    }
}
