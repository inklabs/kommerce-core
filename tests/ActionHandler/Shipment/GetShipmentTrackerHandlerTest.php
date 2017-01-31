<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentTrackerQuery;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentTrackerRequest;
use inklabs\kommerce\Action\Shipment\Query\GetShipmentTrackerResponse;
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
        $request = new GetShipmentTrackerRequest($shipmentTracker->getId()->getHex());
        $response = new GetShipmentTrackerResponse();

        $this->dispatchQuery(new GetShipmentTrackerQuery($request, $response));

        $this->assertTrue($response->getShipmentTrackerDTO() instanceof ShipmentTrackerDTO);
    }
}
