<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class PaymentRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Order::class,
        User::class,
        Cart::class,
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

    public function setupPayment(AbstractPayment & $payment)
    {
        $cartTotal = $this->dummyData->getCartTotal();
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder($cartTotal);
        $order->setUser($user);
        $order->addPayment($payment);

        $this->entityManager->persist($user);
        $this->entityManager->persist($order);

        $this->paymentRepository->create($payment);

        $this->entityManager->flush();
    }

    public function testCRUD()
    {
        $order = $this->setupOrder();

        $cashPayment = $this->dummyData->getCashPayment();
        $order->addPayment($cashPayment);

        $this->executeRepositoryCRUD(
            $this->paymentRepository,
            $cashPayment
        );
    }

    public function setupOrder()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $order->setUser($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function testFindCashPayment()
    {
        $originalPayment = $this->dummyData->getCashPayment();
        $this->setupPayment($originalPayment);
        $this->entityManager->clear();

        $this->setCountLogger();

        $payment = $this->paymentRepository->findOneById(
            $originalPayment->getId()
        );

        $payment->getOrder()->getCreated();

        $this->assertEquals($originalPayment->getId(), $payment->getId());
        $this->assertSame(100, $payment->getAmount());
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testFindCheckPayment()
    {
        $originalPayment = $this->dummyData->getCheckPayment();
        $this->setupPayment($originalPayment);
        $this->entityManager->clear();

        $this->setCountLogger();

        $payment = $this->paymentRepository->findOneById(
            $originalPayment->getId()
        );

        $payment->getOrder()->getCreated();

        $this->assertEquals($originalPayment->getId(), $payment->getId());
        $this->assertSame(100, $payment->getAmount());
        $this->assertSame('0001234', $payment->getCheckNumber());
        $this->assertSame('memo area', $payment->getMemo());
        $this->assertEquals(new DateTime('4/13/2016'), $payment->getCheckDate());
        $this->assertSame(3, $this->getTotalQueries());
    }

    public function testFindCreditPayment()
    {
        // TODO: test CreditPayment
    }
}
