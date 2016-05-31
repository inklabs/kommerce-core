<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractIntegerType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;

abstract class AbstractIntegerTypeDTOBuilder
{
    /** @var AbstractIntegerType */
    protected $type;

    /** @var AbstractIntegerTypeDTO */
    protected $typeDTO;

    /**
     * @return AbstractIntegerTypeDTO
     */
    abstract protected function getTypeDTO();

    public function __construct(AbstractIntegerType $type)
    {
        $this->type = $type;

        $this->typeDTO = $this->getTypeDTO();
        $this->typeDTO->id = $this->type->getId();
        $this->typeDTO->name = $this->type->getName();
        $this->typeDTO->nameMap = $this->type->getNameMap();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->typeDTO;
    }
}
