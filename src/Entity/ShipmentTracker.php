<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentTracker implements IdEntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var ShipmentCarrierType */
    protected $carrier;

    /** @var string */
    protected $trackingCode;

    /** @var string */
    protected $externalId;

    /** @var ShipmentRate */
    protected $shipmentRate;

    /** @var ShipmentLabel */
    protected $shipmentLabel;

    /** @var Shipment */
    protected $shipment;

    /**
     * @param Shipment $shipment
     * @param ShipmentCarrierType $carrier
     * @param string $trackingCode
     */
    public function __construct(ShipmentCarrierType $carrier, $trackingCode)
    {
        $this->setId();
        $this->setCreated();
        $this->setCarrier($carrier);
        $this->trackingCode = (string) $trackingCode;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('carrier', new Assert\Valid);

        $metadata->addPropertyConstraint('trackingCode', new Assert\NotBlank);
        $metadata->addPropertyConstraint('trackingCode', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('shipmentRate', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentLabel', new Assert\Valid);
    }

    public function setShipment(Shipment $shipment)
    {
        $this->shipment = $shipment;
        $shipment->addShipmentTracker($this);
    }

    private function setCarrier(ShipmentCarrierType $carrier)
    {
        $this->carrier = $carrier;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getShipmentRate()
    {
        return $this->shipmentRate;
    }

    public function setShipmentLabel(ShipmentLabel $shipmentLabel)
    {
        $this->shipmentLabel = $shipmentLabel;
    }

    public function getShipmentLabel()
    {
        return $this->shipmentLabel;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }
}
