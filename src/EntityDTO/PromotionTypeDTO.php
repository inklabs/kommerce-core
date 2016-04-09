<?php
namespace inklabs\kommerce\EntityDTO;

class PromotionTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isFixed;

    /** @var bool */
    public $isPercent;

    /** @var bool */
    public $isExact;
}
