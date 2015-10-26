<?php
namespace inklabs\kommerce\Action\Shipment;

use inklabs\kommerce\Lib\Command\CommandInterface;

class BuyShipmentLabelCommand implements CommandInterface
{
    /** @var int */
    private $orderId;

    /** @var string */
    private $shipmentExternalId;

    /** @var string */
    private $rateExternalId;

    /**
     * @param int $orderId
     * @param string $shipmentExternalId
     * @param string $rateExternalId
     */
    public function __construct($orderId, $shipmentExternalId, $rateExternalId)
    {
        $this->orderId = $orderId;
        $this->shipmentExternalId = $shipmentExternalId;
        $this->rateExternalId = $rateExternalId;
    }

    public function getOrderId()
    {
        return $this->orderId;
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
