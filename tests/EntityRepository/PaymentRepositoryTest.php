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
        $this->paymentRepository = $this->getRepositoryFactory()->getPaymentRepository();
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

        return $payment;
    }

    public function testCRUD()
    {
        $payment = $this->setupPayment();
        $this->assertSame(1, $payment->getId());

        $payment->setAmount(200);
        $this->assertSame(null, $payment->getUpdated());

        $this->paymentRepository->update($payment);
        $this->assertTrue($payment->getUpdated() instanceof DateTime);

        $this->paymentRepository->delete($payment);
        $this->assertSame(null, $payment->getId());
    }

    public function testFind()
    {
        $this->setupPayment();
        $this->entityManager->clear();

        $this->setCountLogger();

        $payment = $this->paymentRepository->findOneById(1);

        $payment->getOrder()->getCreated();

        $this->assertTrue($payment instanceof CashPayment);
        $this->assertSame(2, $this->getTotalQueries());
    }
}
