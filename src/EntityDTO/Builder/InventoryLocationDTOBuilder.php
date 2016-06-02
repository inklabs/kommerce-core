<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\EntityDTO\InventoryLocationDTO;

class InventoryLocationDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var InventoryLocation */
    protected $entity;

    /** @var InventoryLocationDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(InventoryLocation $inventoryTransaction, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $inventoryTransaction;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new InventoryLocationDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name = $this->entity->getName();
        $this->entityDTO->code = $this->entity->getCode();
    }

    public function withWarehouse()
    {
        $this->entityDTO->warehouse = $this->dtoBuilderFactory
            ->getWarehouseDTOBuilder($this->entity->getWarehouse())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withWarehouse();
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
