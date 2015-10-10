<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\tests\Helper;

class ImportPaymentServiceTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Order',
        'kommerce:AbstractPayment',
        'kommerce:User',
        'kommerce:TaxRate',
    ];

    public function testImport()
    {
        $this->setupOrdersForImport();

        $this->setCountLogger();

        $repositoryFactory = $this->repository();
        $paymentService = new ImportPaymentService(
            $repositoryFactory->getOrderRepository(),
            $repositoryFactory->getPaymentRepository()
        );

        $iterator = new CSVIterator(__DIR__ . '/ImportPaymentServiceTest.csv');
        $importResult = $paymentService->import($iterator);

        $this->assertSame(11, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame(25, $this->countSQLLogger->getTotalQueries());
    }

    private function setupOrdersForImport()
    {
        $cartTotal = $this->getDummyCartTotal();

        $order1 = $this->getDummyOrder($cartTotal);
        $order2 = $this->getDummyOrder($cartTotal);
        $order3 = $this->getDummyOrder($cartTotal);

        $order1->setExternalId('CO1102-0016');
        $order2->setExternalId('CO1103-0027');
        $order3->setExternalId('CO1104-0032');

        $this->entityManager->persist($order1);
        $this->entityManager->persist($order2);
        $this->entityManager->persist($order3);

        $this->entityManager->flush();
    }
}