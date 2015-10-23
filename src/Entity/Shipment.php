<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Shipment implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var ShipmentTracker[] */
    protected $shipmentTrackers;

    /** @var ShipmentItem[] */
    protected $shipmentItems;

    /** @var ShipmentComment[] */
    protected $shipmentComments;

    /** @var Order */
    protected $order;

    public function __construct()
    {
        $this->shipmentTrackers = new ArrayCollection;
        $this->shipmentItems = new ArrayCollection;
        $this->shipmentComments = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('shipmentTrackers', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentItems', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentComments', new Assert\Valid);
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function addShipmentTracker(ShipmentTracker $shipmentTracker)
    {
        $this->shipmentTrackers->add($shipmentTracker);
    }

    public function getShipmentTrackers()
    {
        return $this->shipmentTrackers;
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
