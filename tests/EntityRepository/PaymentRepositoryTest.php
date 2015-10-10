<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\tests\Helper;

class PaymentRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Order',
        'kommerce:User',
        'kommerce:TaxRate',
        'kommerce:AbstractPayment',
    ];

    /** @var PaymentRepositoryInterface */
    protected $paymentRepository;

    public function setUp()
    {
        $this->paymentRepository = $this->repository()->getPaymentRepository();
    }

    public function setupPayment()
    {
        $payment = $this->getDummyCashPayment();
        $cartTotal = $this->getDummyCartTotal();
        $order = $this->getDummyOrder($cartTotal);
        $order->addPayment($payment);

        $this->entityManager->persist($order);

        $this->paymentRepository->create($payment);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $payment;
    }

    public function testCRUD()
    {
        $payment = $this->setupPayment();

        $payment->setAmount(200);
        $this->assertSame(null, $payment->getUpdated());
        $this->paymentRepository->save($payment);
        $this->assertTrue($payment->getUpdated() instanceof DateTime);

        $this->paymentRepository->persist($payment);
        $this->assertTrue($payment->getUpdated() instanceof DateTime);

        $this->paymentRepository->remove($payment);
        $this->assertSame(null, $payment->getId());
    }

    public function testFind()
    {
        $this->setupPayment();

        $this->setCountLogger();

        $payment = $this->paymentRepository->find(1);

        $payment->getOrder()->getCreated();

        $this->assertTrue($payment instanceof CashPayment);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }
}
