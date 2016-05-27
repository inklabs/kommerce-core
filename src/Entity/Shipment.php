<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\EntityDTO\Builder\ShipmentDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Shipment implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    use TempUuidTrait;
    private $order_uuid;

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
        $this->setUuid();
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

    public function getOrder()
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

    public function getDTOBuilder()
    {
        return new ShipmentDTOBuilder($this);
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
        $this->setOrderUuid($order->getUuid());
    }

    // TODO: Remove after uuid_migration
    public function setOrderUuid(UuidInterface $uuid)
    {
        $this->order_uuid = $uuid;
    }
}
