<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetLowestShipmentRatesByDeliveryMethodQuery;
use inklabs\kommerce\Action\Shipment\Query\GetLowestShipmentRatesByDeliveryMethodRequest;
use inklabs\kommerce\Action\Shipment\Query\GetLowestShipmentRatesByDeliveryMethodResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetLowestShipmentRatesByDeliveryMethodHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();
        $dtoBuilderFactoryInterface = $this->getDTOBuilderFactory();
        $shipmentGateway = $this->mockService->getShipmentGateway();
        $shipmentGateway->shouldReceive('getTrimmedRates')
            ->andReturn([$shipmentRate])
            ->once();

        $request = new GetLowestShipmentRatesByDeliveryMethodRequest(
            new OrderAddressDTO,
            new ParcelDTO
        );
        $response = new GetLowestShipmentRatesByDeliveryMethodResponse;

        $handler = new GetLowestShipmentRatesByDeliveryMethodHandler($shipmentGateway, $dtoBuilderFactoryInterface);
        $handler->handle(new GetLowestShipmentRatesByDeliveryMethodQuery($request, $response));

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
