<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\CSVIterator;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ImportPaymentServiceTest extends ServiceTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        AbstractPayment::class,
        User::class,
        TaxRate::class,
    ];

    public function testImport()
    {
        $this->setupOrdersForImport();

        $this->setCountLogger();

        $repositoryFactory = $this->getRepositoryFactory();
        $paymentService = new ImportPaymentService(
            $repositoryFactory->getOrderRepository(),
            $repositoryFactory->getPaymentRepository()
        );

        $iterator = new CSVIterator(__DIR__ . '/ImportPaymentServiceTest.csv');
        $importResult = $paymentService->import($iterator);

        $this->assertSame(11, $importResult->getSuccessCount());
        $this->assertSame(1, $importResult->getFailedCount());
        $this->assertSame(25, $this->getTotalQueries());

        $paymentTypes = $this->getPaymentTypeTotals($repositoryFactory);

        $this->assertSame(4, $paymentTypes[CashPayment::class]);
        $this->assertSame(7, $paymentTypes[CheckPayment::class]);
    }

    private function setupOrdersForImport()
    {
        $cartTotal = $this->dummyData->getCartTotal();

        $order1 = $this->dummyData->getOrder($cartTotal);
        $order2 = $this->dummyData->getOrder($cartTotal);
        $order3 = $this->dummyData->getOrder($cartTotal);

        $order1->setExternalId('CO1102-0016');
        $order2->setExternalId('CO1103-0027');
        $order3->setExternalId('CO1104-0032');

        $this->entityManager->persist($order1);
        $this->entityManager->persist($order2);
        $this->entityManager->persist($order3);

        $this->entityManager->flush();
    }

    /**
     * @param RepositoryFactory $repositoryFactory
     * @return array
     */
    private function getPaymentTypeTotals(RepositoryFactory $repositoryFactory)
    {
        $paymentTypes = [];
        foreach ($repositoryFactory->getPaymentRepository()->findAll() as $payment) {
            $paymentClassName = get_class($payment);

            if (! isset($paymentTypes[$paymentClassName])) {
                $paymentTypes[$paymentClassName] = 0;
            }

            $paymentTypes[$paymentClassName]++;
        }
        return $paymentTypes;
    }
}
