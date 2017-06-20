<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Shipment implements IdEntityInterface
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
        $this->setId();
        $this->setCreated();
        $this->shipmentTrackers = new ArrayCollection;
        $this->shipmentItems = new ArrayCollection;
        $this->shipmentComments = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('shipmentTrackers', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentItems', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentComments', new Assert\Valid);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function addShipmentTracker(ShipmentTracker $shipmentTracker)
    {
        $this->shipmentTrackers->add($shipmentTracker);
    }

    /**
     * @return ShipmentTracker[]
     */
    public function getShipmentTrackers()
    {
        return $this->shipmentTrackers;
    }

    public function addShipmentItem(ShipmentItem $shipmentItem)
    {
        $this->shipmentItems->add($shipmentItem);
    }

    /**
     * @return ShipmentItem[]
     */
    public function getShipmentItems()
    {
        return $this->shipmentItems;
    }

    public function addShipmentComment(ShipmentComment $shipmentComment)
    {
        $this->shipmentComments->add($shipmentComment);
    }

    /**
     * @return ShipmentComment[]
     */
    public function getShipmentComments()
    {
        return $this->shipmentComments;
    }

    /**
     * @param OrderItem $orderItem
     * @return ShipmentItem|null
     */
    public function getShipmentItemForOrderItem(OrderItem $orderItem)
    {
        foreach ($this->shipmentItems as $shipmentItem) {
            if ($shipmentItem->getOrderItem()->getId() === $orderItem->getId()) {
                return $shipmentItem;
            }
        }

        return null;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
