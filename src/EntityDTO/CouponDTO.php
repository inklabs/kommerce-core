<?php
namespace inklabs\kommerce\EntityDTO;

class CouponDTO extends PromotionDTO
{
    public $code;
    public $flagFreeShipping;
    public $minOrderValue;
    public $maxOrderValue;
    public $canCombineWithOtherCoupons;
}
