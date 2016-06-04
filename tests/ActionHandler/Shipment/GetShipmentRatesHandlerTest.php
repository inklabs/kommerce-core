<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesQuery;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesRequest;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentRatesResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetShipmentRatesHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $shipmentGateway = $this->mockService->getShipmentGateway();
        $dtoBuilderFactoryInterface = $this->getDTOBuilderFactory();

        $request = new GetShipmentRatesRequest(
            new OrderAddressDTO,
            new ParcelDTO
        );
        $response = new GetShipmentRatesResponse;

        $handler = new GetShipmentRatesHandler($shipmentGateway, $dtoBuilderFactoryInterface);
        $handler->handle(new GetShipmentRatesQuery($request, $response));

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
