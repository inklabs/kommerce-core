<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Action\Shipment\Handler\BuyShipmentLabelHandler;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Service\OrderService;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class BuyShipmentLabelHandlerTest extends DoctrineTestCase
{
    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var BuyShipmentLabelCommand */
    protected $command;

    /** @var FakeOrderRepository */
    protected $fakeOrderRepository;

    /** @var OrderServiceInterface */
    protected $fakeOrderService;

    public function setUp()
    {
        parent::setUp();

        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->fakeOrderRepository = new FakeOrderRepository;
        $this->fakeOrderService = new OrderService(
            $this->fakeOrderRepository,
            new FakeProductRepository
        );
        $this->command = new BuyShipmentLabelCommand(
            1,
            'shp_xxxxxxx',
            'rate_xxxxxxx'
        );
    }

    public function testHandle()
    {
        $this->fakeOrderRepository->create(new Order);
        $handler = new BuyShipmentLabelHandler($this->fakeShipmentGateway, $this->fakeOrderService);
        $handler->handle($this->command);
    }

    public function xtestHandleThroughQueryBus()
    {
        $this->setupEntityManager([]);
        $this->getCommandBus()->execute($this->command);
    }
}
