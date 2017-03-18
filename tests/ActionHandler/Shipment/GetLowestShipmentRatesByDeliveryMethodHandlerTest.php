<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetLowestShipmentRatesByDeliveryMethodQuery;
use inklabs\kommerce\ActionResponse\Shipment\GetLowestShipmentRatesByDeliveryMethodResponse;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityDTO\ParcelDTO;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetLowestShipmentRatesByDeliveryMethodHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [];

    public function testHandle()
    {
        $query =new GetLowestShipmentRatesByDeliveryMethodQuery(
            new OrderAddressDTO(),
            new ParcelDTO()
        );

        /** @var GetLowestShipmentRatesByDeliveryMethodResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentRateDTOs()[0] instanceof ShipmentRateDTO);
    }
}
