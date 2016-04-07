<?php
namespace inklabs\kommerce\EntityDTO;

class CouponDTO extends AbstractPromotionDTO
{
    /** @var string */
    public $code;

    /** @var bool */
    public $flagFreeShipping;

    /** @var int */
    public $minOrderValue;

    /** @var int */
    public $maxOrderValue;

    /** @var bool */
    public $canCombineWithOtherCoupons;
}
