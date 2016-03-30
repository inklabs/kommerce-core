<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\tests\Helper;

class ImportOrderServiceTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        User::class,
        Cart::class,
    ];

    public function testImport()
    {
        $this->setupUsersForImport();

        $this->setCountLogger();

        $repositoryFactory = $this->getRepositoryFactory();
        $orderService = new ImportOrderService(
            $repositoryFactory->getOrderRepository(),
            $repositoryFactory->getUserRepository()
        );

        $iterator = new CSVIterator(__DIR__ . '/ImportOrderServiceTest.csv');
        $importResult = $orderService->import($iterator);

        $this->assertSame(3, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame(13, $this->getTotalQueries());
    }

    private function setupUsersForImport()
    {
        $user19 = $this->dummyData->getUser(19);
        $user42 = $this->dummyData->getUser(42);
        $user52 = $this->dummyData->getUser(52);

        $this->entityManager->persist($user19);
        $this->entityManager->persist($user42);
        $this->entityManager->persist($user52);
        $this->entityManager->flush();
    }
}
