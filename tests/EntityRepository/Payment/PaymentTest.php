<?php
namespace inklabs\kommerce\EntityRepository\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class PaymentTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Order',
        'kommerce:User',
        'kommerce:TaxRate',
        'kommerce:Payment\Payment',
    ];

    /** @var PaymentInterface */
    protected $paymentRepository;

    public function setUp()
    {
        $this->paymentRepository = $this->repository()->getPayment();
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

    public function testFind()
    {
        $this->setupPayment();

        $this->setCountLogger();

        $payment = $this->paymentRepository->find(1);

        $payment->getOrder()->getCreated();

        $this->assertTrue($payment instanceof Entity\Payment\Cash);
        $this->assertSame(2, $this->countSQLLogger->getTotalQueries());
    }

    public function testSave()
    {
        $payment = $this->setupPayment();

        $payment->setAmount(200);
        $this->assertSame(null, $payment->getUpdated());
        $this->paymentRepository->save($payment);
        $this->assertTrue($payment->getUpdated() instanceof \DateTime);
    }
}
