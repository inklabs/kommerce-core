<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\tests\Helper\Service\MockService;

abstract class ServiceTestCase extends EntityRepositoryTestCase
{
    /** @var MockService */
    protected $mockService;

    public function setUp()
    {
        parent::setUp();
        $this->mockService = new MockService($this->dummyData);
    }

    protected function getEventDispatcher()
    {
        return new EventDispatcher;
    }

    protected function getServiceFactory(
        CartCalculatorInterface $cartCalculator = null,
        EventDispatcherInterface $eventDispatcher = null,
        PaymentGatewayInterface $paymentGateway = null
    ) {
        if ($cartCalculator === null) {
            $cartCalculator = $this->getCartCalculator();
        }

        if ($eventDispatcher === null) {
            $eventDispatcher = new EventDispatcher;
        }

        if ($paymentGateway === null) {
            $paymentGateway = $this->getPaymentGateway();
        }

        return new ServiceFactory(
            $this->getRepositoryFactory(),
            $cartCalculator,
            $eventDispatcher,
            $paymentGateway
        );
    }

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway;
    }
}
