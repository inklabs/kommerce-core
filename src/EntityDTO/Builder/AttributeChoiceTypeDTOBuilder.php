<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AttributeChoiceType;
use inklabs\kommerce\EntityDTO\AttributeChoiceTypeDTO;

/**
 * @method AttributeChoiceTypeDTO build()
 */
class AttributeChoiceTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var AttributeChoiceType */
    protected $entity;

    /** @var AttributeChoiceTypeDTO */
    protected $entityDTO;

    /**
     * @return AttributeChoiceTypeDTO
     */
    protected function getEntityDTO()
    {
        return new AttributeChoiceTypeDTO;
    }

    public function __construct(AttributeChoiceType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isSelect = $this->entity->isSelect();
        $this->entityDTO->isImageLink = $this->entity->isImageLink();
    }
}
