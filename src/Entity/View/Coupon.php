<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Coupon extends Promotion
{
    public $code;
    public $flagFreeShipping;
    public $minOrderValue;
    public $maxOrderValue;
    public $canCombineWithOtherCoupons;

    public function __construct(Entity\Coupon $coupon)
    {
        parent::__construct($coupon);

        $this->code             = $coupon->getCode();
        $this->flagFreeShipping = $coupon->getFlagFreeShipping();
        $this->minOrderValue    = $coupon->getMinOrderValue();
        $this->maxOrderValue    = $coupon->getMaxOrderValue();
        $this->canCombineWithOtherCoupons = $coupon->getCanCombineWithOtherCoupons();
    }
}
