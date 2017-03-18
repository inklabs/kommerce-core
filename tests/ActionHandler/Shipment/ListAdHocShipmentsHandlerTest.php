<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\ListAdHocShipmentsQuery;
use inklabs\kommerce\ActionResponse\Shipment\ListAdHocShipmentsResponse;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListAdHocShipmentsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        ShipmentTracker::class,
    ];

    public function testHandle()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();
        $this->persistEntityAndFlushClear($shipmentTracker);

        $queryString = 'UPS';
        $query = new ListAdHocShipmentsQuery($queryString, new PaginationDTO());

        /** @var ListAdHocShipmentsResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentTrackerDTOs()[0] instanceof ShipmentTrackerDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
