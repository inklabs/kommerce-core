<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Lib\Command\CommandInterface;

class BuyShipmentLabelCommand implements CommandInterface
{
    /** @var string */
    private $shipmentExternalId;

    /** @var string */
    private $rateExternalId;

    /**
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     */
    public function __construct($shipmentExternalId, $rateExternalId)
    {
        $this->shipmentExternalId = $shipmentExternalId;
        $this->rateExternalId = $rateExternalId;
    }

    public function getShipmentExternalId()
    {
        return $this->shipmentExternalId;
    }

    public function getRateExternalId()
    {
        return $this->rateExternalId;
    }
}
