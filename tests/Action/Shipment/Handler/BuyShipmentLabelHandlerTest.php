<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Action\Shipment\Handler\BuyShipmentLabelHandler;
use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Service\OrderService;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderItemRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class BuyShipmentLabelHandlerTest extends DoctrineTestCase
{
    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var BuyShipmentLabelCommand */
    protected $command;

    /** @var FakeOrderRepository */
    protected $fakeOrderRepository;

    /** @var FakeOrderItemRepository */
    protected $fakeOrderItemRepository;

    /** @var OrderServiceInterface */
    protected $fakeOrderService;
    /** @var Order */
    protected $order;

    public function setUp()
    {
        parent::setUp();

        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->fakeOrderRepository = new FakeOrderRepository;
        $this->fakeOrderItemRepository = new FakeOrderItemRepository;
        $this->fakeOrderService = new OrderService(
            $this->fakeEventDispatcher,
            $this->fakeOrderRepository,
            $this->fakeOrderItemRepository,
            new FakeProductRepository,
            $this->fakeShipmentGateway
        );

        $this->order = $this->dummyData->getOrderFull();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 1);

        $this->command = new BuyShipmentLabelCommand(
            1,
            $orderItemQtyDTO,
            'A comment',
            'shp_xxxxxxx',
            'rate_xxxxxxx'
        );
    }

    public function testHandle()
    {
        $orderItem = $this->order->getOrderItem(0);
        $this->fakeOrderRepository->create($this->order);
        $this->fakeOrderItemRepository->create($orderItem);

        $handler = new BuyShipmentLabelHandler($this->fakeOrderService);
        $handler->handle($this->command);
    }

    public function xtestHandleThroughQueryBus()
    {
        $this->setupEntityManager([]);
        $this->getCommandBus()->execute($this->command);
    }
}
