<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Uuid;

final class CreateCouponCommand extends AbstractCouponCommand
{
    /**
     * @param string $code
     * @param bool $flagFreeShipping
     * @param int $minOrderValue
     * @param int $maxOrderValue
     * @param bool $canCombineWithOtherCoupons
     * @param string $name
     * @param string $promotionTypeSlug
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param int $startAt
     * @param int $endAt
     */
    public function __construct(
        $code,
        $flagFreeShipping,
        $minOrderValue,
        $maxOrderValue,
        $canCombineWithOtherCoupons,
        $name,
        $promotionTypeSlug,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startAt,
        $endAt
    ) {
        return parent::__construct(
            $code,
            $flagFreeShipping,
            $minOrderValue,
            $maxOrderValue,
            $canCombineWithOtherCoupons,
            $name,
            $promotionTypeSlug,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startAt,
            $endAt,
            Uuid::uuid4()
        );
    }
}
