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
        $importedCount = $userService->import($iterator);

        $this->assertSame(3, $importedCount);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
