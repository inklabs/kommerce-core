<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\EntityDTO\OptionTypeDTO;

/**
 * @method OptionTypeDTO build()
 */
class OptionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var OptionType */
    protected $entity;

    /** @var OptionTypeDTO */
    protected $entityDTO;

    /**
     * @return OptionTypeDTO
     */
    protected function getEntityDTO()
    {
        return new OptionTypeDTO;
    }

    public function __construct(OptionType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isSelect = $this->entity->isSelect();
        $this->entityDTO->isRadio = $this->entity->isRadio();
        $this->entityDTO->isCheckbox = $this->entity->isCheckbox();
    }
}
