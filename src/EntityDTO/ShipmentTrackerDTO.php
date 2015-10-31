<?php
namespace inklabs\kommerce\EntityDTO;

class ShipmentTrackerDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $carrier;

    /** @var string */
    public $carrierText;

    /** @var string */
    public $trackingCode;

    /** @var string */
    public $externalId;

    /** @var ShipmentRateDTO */
    public $shipmentRate;

    /** @var ShipmentLabelDTO */
    public $shipmentLabel;
}
