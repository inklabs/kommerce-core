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
    protected $metaDataClassNames = [];

    public function testHandle()
    {
        $request = new GetShipmentRatesRequest(
            new OrderAddressDTO(),
            new ParcelDTO()
        );
        $response = new GetShipmentRatesResponse();
        $query = new GetShipmentRatesQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
