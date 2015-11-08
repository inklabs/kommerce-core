<?php
namespace inklabs\kommerce\tests\Action\Order\Handler;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Service\OrderService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderItemRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

abstract class AbstractOrderHandlerTestCase extends DoctrineTestCase
{
    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var FakeOrderRepository */
    protected $fakeOrderRepository;

    /** @var FakeOrderItemRepository */
    protected $fakeOrderItemRepository;

    /** @var FakeProductRepository */
    protected $fakeProductRepository;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;
    /** @var OrderService */
    protected $orderService;

    public function setUp()
    {
        parent::setUp();

        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->fakeOrderRepository = new FakeOrderRepository;
        $this->fakeOrderItemRepository = new FakeOrderItemRepository;
        $this->fakeProductRepository = new FakeProductRepository;
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);

        $this->orderService = new OrderService(
            $this->fakeEventDispatcher,
            $this->fakeOrderRepository,
            $this->fakeOrderItemRepository,
            $this->fakeProductRepository,
            $this->fakeShipmentGateway
        );
    }
}
