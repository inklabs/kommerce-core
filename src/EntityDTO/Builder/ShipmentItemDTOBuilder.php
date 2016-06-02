<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\EntityDTO\ShipmentItemDTO;

class ShipmentItemDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var ShipmentItem */
    protected $entity;

    /** @var ShipmentItemDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(ShipmentItem $shipmentItem, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $shipmentItem;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ShipmentItemDTO;
        $this->setId();
        $this->setTime();

        $this->entityDTO->orderItem = $this->dtoBuilderFactory
            ->getOrderItemDTOBuilder($this->entity->getOrderItem())
            ->build();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
