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
    protected $metaDataClassNames = [];

    public function testHandle()
    {
        $request = new GetLowestShipmentRatesByDeliveryMethodRequest(
            new OrderAddressDTO(),
            new ParcelDTO()
        );
        $response = new GetLowestShipmentRatesByDeliveryMethodResponse();
        $query =new GetLowestShipmentRatesByDeliveryMethodQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
