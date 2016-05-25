<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ShipmentItemDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentItem implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    use TempUuidTrait;
    private $shipment_uuid;

    /** @var OrderItem */
    protected $orderItem;

    /** @var int */
    protected $quantityToShip;

    /** @var Shipment */
    protected $shipment;

    public function __construct(Shipment $shipment, OrderItem $orderItem, $quantityToShip)
    {
        $this->setUuid();
        $this->setCreated();
        $this->orderItem = $orderItem;
        $this->quantityToShip = (int) $quantityToShip;

        $shipment->addShipmentItem($this);
        $this->shipment = $shipment;
        $this->shipment_uuid = $shipment->getUuid();
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

    public function getDTOBuilder()
    {
        return new ShipmentItemDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setShipmentUuid(UuidInterface $uuid)
    {
        $this->shipment_uuid = $uuid;
    }
}
