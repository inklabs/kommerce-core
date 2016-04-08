<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityDTO\PromotionTypeDTO;

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
}
