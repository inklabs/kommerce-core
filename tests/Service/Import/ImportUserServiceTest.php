<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\tests\Helper;

class ImportUserServiceTest extends Helper\TestCase\ServiceTestCase
{
    protected $metaDataClassNames = [
        User::class,
    ];

    public function testImport()
    {
        $this->setCountLogger();

        $userService = new ImportUserService($this->getRepositoryFactory()->getUserRepository());

        $iterator = new CSVIterator(__DIR__ . '/ImportUserServiceTest.csv');
        $importResult = $userService->import($iterator);

        $this->assertTrue($importResult instanceof ImportResult);
        $this->assertSame(3, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame(9, $this->getTotalQueries());
    }
}
