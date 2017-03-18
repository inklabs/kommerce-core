<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentTrackerQuery;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentTrackerRequest;
use inklabs\kommerce\ActionResponse\Shipment\GetShipmentTrackerResponse;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetShipmentTrackerHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        ShipmentTracker::class,
    ];

    public function testHandle()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();
        $this->persistEntityAndFlushClear($shipmentTracker);
        $query = new GetShipmentTrackerQuery($shipmentTracker->getId()->getHex());

        /** @var GetShipmentTrackerResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertTrue($response->getShipmentTrackerDTO() instanceof ShipmentTrackerDTO);
    }
}
