<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\tests\Helper\Lib\FakeFileManager;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

abstract class ServiceTestCase extends EntityRepositoryTestCase
{
    /** @var LoggingEventDispatcher */
    private $loggingEventDispatcher;

    /** @var ServiceFactory */
    private $serviceFactory;

    protected function getServiceFactory()
    {
        if ($this->serviceFactory === null) {
            $fromAddress = new OrderAddressDTO;
            $fromAddress->company = 'Acme Co.';
            $fromAddress->address1 = '123 Any St';
            $fromAddress->address2 = 'Ste 3';
            $fromAddress->city = 'Santa Monica';
            $fromAddress->state = 'CA';
            $fromAddress->zip5 = '90401';
            $fromAddress->phone = '555-123-4567';

            $this->serviceFactory = new ServiceFactory(
                $this->getRepositoryFactory(),
                $this->getCartCalculator(),
                $this->getEventDispatcher(),
                $this->getPaymentGateway(),
                new FakeShipmentGateway($fromAddress),
                $this->getFileManager()
            );
        }

        return $this->serviceFactory;
    }

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway();
    }

    private function getFileManager()
    {
        return new FakeFileManager();
    }

    protected function getEventDispatcher()
    {
        if ($this->loggingEventDispatcher === null) {
            $this->loggingEventDispatcher = new LoggingEventDispatcher(
                new EventDispatcher()
            );
        }
        return $this->loggingEventDispatcher;
    }

    protected function getDispatchedEvents()
    {
        return $this->getEventDispatcher()->getDispatchedEvents();
    }
}
