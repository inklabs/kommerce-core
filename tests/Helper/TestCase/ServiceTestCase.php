<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\IdEntityInterface;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\Service\ServiceCRUDInterface;
use inklabs\kommerce\tests\Helper\Lib\FakeFileManager;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;
use inklabs\kommerce\tests\Helper\Service\MockService;
use Mockery\Mock;
use Mockery\MockInterface;

abstract class ServiceTestCase extends EntityRepositoryTestCase
{
    /** @var MockService */
    protected $mockService;

    /** @var LoggingEventDispatcher */
    private $loggingEventDispatcher;

    /** @var ServiceFactory */
    private $serviceFactory;

    public function setUp()
    {
        parent::setUp();
        $this->mockService = new MockService($this->dummyData);
    }

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

    /**
     * @param mixed|ServiceCRUDInterface $service
     * @param mixed|Mock $repository
     * @param EntityInterface $entity
     */
    protected function executeServiceCRUD($service, $repository, EntityInterface $entity)
    {
        $repository->shouldReceive('create')
            ->with($entity)
            ->once();

        $service->create($entity);

        $repository->shouldReceive('update')
            ->with($entity)
            ->once();

        $service->update($entity);

        if (method_exists($service, 'delete')) {
            $repository->shouldReceive('delete')
                ->with($entity)
                ->once();

            $service->delete($entity);
        }
    }

    /**
     * @param MockInterface|Mock $service
     * @param IdEntityInterface $entity
     */
    protected function serviceShouldGetOneById(MockInterface $service, IdEntityInterface $entity)
    {
        $service->shouldReceive('getOneById')
            ->with($entity->getId())
            ->andReturn($entity)
            ->once();
    }

    /**
     * @param MockInterface|Mock $service
     * @param IdEntityInterface $entity
     */
    protected function serviceShouldUpdate(MockInterface $service, IdEntityInterface $entity)
    {
        $service->shouldReceive('update')
            ->with($entity)
            ->once();
    }

    /**
     * @param MockInterface|Mock $service
     * @param IdEntityInterface $entity
     */
    protected function serviceShouldDelete(MockInterface $service, IdEntityInterface $entity)
    {
        $service->shouldReceive('delete')
            ->with($entity)
            ->once();
    }
}
