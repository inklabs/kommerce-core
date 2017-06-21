<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentTracker implements IdEntityInterface
{
    use IdTrait, TimeTrait;

    /** @var ShipmentCarrierType */
    protected $carrier;

    /** @var string */
    protected $trackingCode;

    /** @var string|null */
    protected $externalId;

    /** @var ShipmentRate */
    protected $shipmentRate;

    /** @var ShipmentLabel */
    protected $shipmentLabel;

    /** @var Shipment|null */
    protected $shipment;

    public function __construct(ShipmentCarrierType $carrier, string $trackingCode, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->setCarrier($carrier);
        $this->trackingCode = $trackingCode;
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

    public function getCarrier(): ShipmentCarrierType
    {
        return $this->carrier;
    }

    public function getTrackingCode(): string
    {
        return $this->trackingCode;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getShipmentRate(): ShipmentRate
    {
        return $this->shipmentRate;
    }

    public function setShipmentLabel(ShipmentLabel $shipmentLabel)
    {
        $this->shipmentLabel = $shipmentLabel;
    }

    public function getShipmentLabel(): ShipmentLabel
    {
        return $this->shipmentLabel;
    }

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }
}
