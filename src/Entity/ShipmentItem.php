<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ShipmentItemDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentItem implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var OrderItem */
    protected $orderItem;

    /** @var int */
    protected $quantityToShip;

    /** @var Shipment */
    protected $shipment;

    public function __construct(OrderItem $orderItem, $quantityToShip)
    {
        $this->setCreated();
        $this->orderItem = $orderItem;
        $this->quantityToShip = (int) $quantityToShip;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantityToShip', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantityToShip', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function getOrderItem()
    {
        return $this->orderItem;
    }

    public function getQuantityToShip()
    {
        return $this->quantityToShip;
    }

    public function setShipment(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function getDTOBuilder()
    {
        return new ShipmentItemDTOBuilder($this);
    }
}
