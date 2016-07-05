<?php
namespace inklabs\kommerce\EntityDTO;

class AbstractPromotionDTO
{
    use IdDTOTrait, TimeDTOTrait, PromotionRedemptionDTOTrait, PromotionStartEndDateDTOTrait;

    /** @var string */
    public $name;

    /** @var int */
    public $value;

    /** @var int */
    public $reducesTaxSubtotal;

    /** @var PromotionTypeDTO */
    public $type;
}
