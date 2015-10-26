<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Handler\GetShipmentRatesHandler;
use inklabs\kommerce\Action\Shipment\Response\GetShipmentRatesResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class GetShipmentRatesHandlerTest extends DoctrineTestCase
{
    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var GetShipmentRatesRequest */
    protected $request;

    /** @var GetShipmentRatesResponse */
    protected $response;

    public function setUp()
    {
        parent::setUp();

        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->request = new GetShipmentRatesRequest(
            new OrderAddressDTO,
            new ParcelDTO
        );
        $this->response = new GetShipmentRatesResponse;
    }

    public function testHandle()
    {
        $handler = new GetShipmentRatesHandler($this->fakeShipmentGateway);
        $handler->handle($this->request, $this->response);
        $this->assertTrue($this->response->getShipmentRatesDTO()[0] instanceof ShipmentRateDTO);
    }

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager([]);
        $this->getQueryBus()->execute($this->request, $this->response);
        $this->assertTrue($this->response->getShipmentRatesDTO()[0] instanceof ShipmentRateDTO);
    }
}
