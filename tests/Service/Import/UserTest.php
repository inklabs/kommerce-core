<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class UserTest extends Helper\DoctrineTestCase
{
    public function testImport()
    {
        $this->setCountLogger();

        $userService = new User($this->entityManager);

        $iterator = new Lib\CSVIterator(__DIR__ . '/UserTest.csv');
        $importedCount = $userService->import($iterator);

        $this->assertSame(3, $importedCount);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
