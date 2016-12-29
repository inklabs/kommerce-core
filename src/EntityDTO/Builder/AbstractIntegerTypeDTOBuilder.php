<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractIntegerType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;

abstract class AbstractIntegerTypeDTOBuilder implements DTOBuilderInterface
{
    /** @var AbstractIntegerType */
    protected $entity;

    /** @var AbstractIntegerTypeDTO */
    protected $entityDTO;

    /**
     * @return AbstractIntegerTypeDTO
     */
    abstract protected function getEntityDTO();

    public function __construct(AbstractIntegerType $type)
    {
        $this->entity = $type;

        $this->entityDTO = $this->getEntityDTO();
        $this->entityDTO->id = $this->entity->getId();
        $this->entityDTO->name = $this->entity->getName();
        $this->entityDTO->slug = $this->entity->getSlug();
        $this->entityDTO->nameMap = $this->entity->getNameMap();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
