<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Shipment implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var ShipmentTrackingNumber[] */
    protected $shipmentTrackingNumbers;

    /** @var ShipmentItem[] */
    protected $shipmentItems;

    /** @var ShipmentComment[] */
    protected $shipmentComments;

    public function __construct()
    {
        $this->shipmentTrackingNumbers = new ArrayCollection;
        $this->shipmentItems = new ArrayCollection;
        $this->shipmentComments = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('shipmentTrackingNumbers', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentItems', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentComments', new Assert\Valid);
    }

    public function addShipmentTrackingNumber(ShipmentTrackingNumber $trackingNumber)
    {
        $this->shipmentTrackingNumbers->add($trackingNumber);
    }

    public function getShipmentTrackingNumbers()
    {
        return $this->shipmentTrackingNumbers;
    }

    public function addShipmentItem(ShipmentItem $shipmentItem)
    {
        $this->shipmentItems->add($shipmentItem);
    }

    public function getShipmentItems()
    {
        return $this->shipmentItems;
    }

    public function addShipmentComment(ShipmentComment $shipmentComment)
    {
        $this->shipmentComments->add($shipmentComment);
    }

    public function getShipmentComments()
    {
        return $this->shipmentComments;
    }
}
