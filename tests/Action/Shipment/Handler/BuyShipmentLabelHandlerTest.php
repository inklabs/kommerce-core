<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Action\Shipment\Handler\BuyShipmentLabelHandler;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class BuyShipmentLabelHandlerTest extends DoctrineTestCase
{
    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var BuyShipmentLabelCommand */
    protected $command;

    public function setUp()
    {
        parent::setUp();

        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->command = new BuyShipmentLabelCommand(
            'shp_xxxxxxx',
            'rate_xxxxxxx'
        );
    }

    public function testHandle()
    {
        $handler = new BuyShipmentLabelHandler($this->fakeShipmentGateway);
        $handler->handle($this->command);
    }

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager([]);
        $this->getCommandBus()->execute($this->command);
    }
}
