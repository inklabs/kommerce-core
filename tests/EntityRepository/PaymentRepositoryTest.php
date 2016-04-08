<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class PaymentRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        User::class,
        TaxRate::class,
        AbstractPayment::class,
    ];

    /** @var PaymentRepositoryInterface */
    protected $paymentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->paymentRepository = $this->getRepositoryFactory()->getPaymentRepository();
    }

    public function setupPayment()
    {
        $payment = $this->dummyData->getCashPayment();
        $cartTotal = $this->dummyData->getCartTotal();
        $order = $this->dummyData->getOrder($cartTotal);
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
