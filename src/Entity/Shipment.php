<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\EntityDTO\Builder\ShipmentDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Shipment implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var ShipmentTracker[]|ArrayCollection */
    protected $shipmentTrackers;

    /** @var ShipmentItem[]|ArrayCollection */
    protected $shipmentItems;

    /** @var ShipmentComment[]|ArrayCollection */
    protected $shipmentComments;

    /** @var Order */
    protected $order;

    public function __construct()
    {
        $this->setCreated();
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
        $shipmentTracker->setShipment($this);
        $this->shipmentTrackers->add($shipmentTracker);
    }

    public function getShipmentTrackers()
    {
        return $this->shipmentTrackers;
    }

    public function addShipmentItem(ShipmentItem $shipmentItem)
    {
        $shipmentItem->setShipment($this);
        $this->shipmentItems->add($shipmentItem);
    }

    public function getShipmentItems()
    {
        return $this->shipmentItems;
    }

    public function addShipmentComment(ShipmentComment $shipmentComment)
    {
        $shipmentComment->setShipment($this);
        $this->shipmentComments->add($shipmentComment);
    }

    public function getShipmentComments()
    {
        return $this->shipmentComments;
    }

    public function getDTOBuilder()
    {
        return new ShipmentDTOBuilder($this);
    }
}
