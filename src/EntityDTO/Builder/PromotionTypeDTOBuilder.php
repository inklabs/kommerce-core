<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityDTO\PromotionTypeDTO;

/**
 * @method PromotionTypeDTO build()
 */
class PromotionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var PromotionType */
    protected $entity;

    /** @var PromotionTypeDTO */
    protected $entityDTO;

    /**
     * @return PromotionTypeDTO
     */
    protected function getEntityDTO()
    {
        return new PromotionTypeDTO;
    }

    public function __construct(PromotionType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isFixed = $this->entity->isFixed();
        $this->entityDTO->isPercent = $this->entity->isPercent();
        $this->entityDTO->isExact = $this->entity->isExact();
    }
}
