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
    protected $type;

    /** @var PromotionTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new PromotionTypeDTO;
    }

    public function __construct(PromotionType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isFixed = $this->type->isFixed();
        $this->typeDTO->isPercent = $this->type->isPercent();
        $this->typeDTO->isExact = $this->type->isExact();
    }
}
