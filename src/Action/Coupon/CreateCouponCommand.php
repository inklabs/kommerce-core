<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Uuid;

final class CreateCouponCommand extends AbstractCouponCommand
{
    public function __construct(
        string $code,
        bool $flagFreeShipping,
        ?int $minOrderValue,
        ?int $maxOrderValue,
        bool $canCombineWithOtherCoupons,
        string $name,
        string $promotionTypeSlug,
        int $value,
        bool $reducesTaxSubtotal,
        ?int $maxRedemptions,
        ?int $startAt,
        ?int $endAt
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
