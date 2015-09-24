<?php
namespace inklabs\kommerce\EntityDTO;

class CouponDTO extends AbstractPromotionDTO
{
    public $code;
    public $flagFreeShipping;
    public $minOrderValue;
    public $maxOrderValue;
    public $canCombineWithOtherCoupons;
}
