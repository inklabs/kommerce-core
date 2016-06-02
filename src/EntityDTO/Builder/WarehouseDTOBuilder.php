<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\WarehouseDTO;

class WarehouseDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Warehouse */
    protected $entity;

    /** @var WarehouseDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Warehouse $warehouse, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $warehouse;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new WarehouseDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name    = $this->entity->getName();

        $this->entityDTO->address = $this->dtoBuilderFactory
            ->getAddressDTOBuilder($this->entity->getAddress())
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
