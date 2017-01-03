<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyAdHocShipmentLabelCommand;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class BuyAdHocShipmentLabelHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        ShipmentTracker::class,
    ];

    public function testHandle()
    {
        $shipmentExternalId = self::SHIPMENT_EXTERNAL_ID;
        $shipmentRateExternalId = self::SHIPMENT_RATE_EXTERNAL_ID;
        $command = new BuyAdHocShipmentLabelCommand(
            $shipmentExternalId,
            $shipmentRateExternalId
        );

        $this->dispatchCommand($command);

        $shipmentTracker = $this->getRepositoryFactory()->getShipmentTrackerRepository()->findOneById(
            $command->getShipmentTrackerId()
        );

        $this->assertSame($shipmentExternalId, $shipmentTracker->getShipmentLabel()->getExternalId());
        $this->assertSame($shipmentRateExternalId, $shipmentTracker->getShipmentRate()->getExternalId());
    }
}
