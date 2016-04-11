<?php
namespace inklabs\kommerce\EntityDTO;

class ShipmentTrackerDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $trackingCode;

    /** @var string */
    public $externalId;

    /** @var ShipmentCarrierTypeDTO */
    public $carrier;

    /** @var ShipmentRateDTO */
    public $shipmentRate;

    /** @var ShipmentLabelDTO */
    public $shipmentLabel;
}
