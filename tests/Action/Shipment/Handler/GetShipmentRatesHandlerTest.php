<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Handler\GetShipmentRatesHandler;
use inklabs\kommerce\Action\Shipment\Response\GetShipmentRatesResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class GetShipmentRatesHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $shipmentGateway = Mockery::mock(ShipmentGatewayInterface::class);
        $shipmentGateway->shouldReceive('getRates')
            ->once()
            ->andReturn([
                $this->dummyData->getShipmentRate(225)
            ]);
        /** @var ShipmentGatewayInterface $shipmentGateway */

        $request = new GetShipmentRatesRequest(
            new OrderAddressDTO,
            new ParcelDTO
        );
        $response = new GetShipmentRatesResponse;

        $handler = new GetShipmentRatesHandler($shipmentGateway);
        $handler->handle($request, $response);
        $this->assertTrue($response->getShipmentRatesDTO()[0] instanceof ShipmentRateDTO);
    }
}
