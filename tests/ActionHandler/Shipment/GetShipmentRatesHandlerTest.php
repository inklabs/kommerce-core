<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentRatesQuery;
use inklabs\kommerce\ActionResponse\Shipment\GetShipmentRatesResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetShipmentRatesHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [];

    public function testHandle()
    {
        $query = new GetShipmentRatesQuery(
            new OrderAddressDTO(),
            new ParcelDTO()
        );

        /** @var GetShipmentRatesResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
