<?php
namespace inklabs\kommerce\Action\Coupon;

use DateTime;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCouponCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $couponId;

    /** @var string */
    private $code;

    /** @var bool */
    private $flagFreeShipping;

    /** @var int */
    private $minOrderValue;

    /** @var int */
    private $maxOrderValue;

    /** @var bool */
    private $canCombineWithOtherCoupons;

    /** @var string */
    private $name;

    /** @var int */
    private $promotionTypeId;

    /** @var int */
    private $value;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int */
    private $maxRedemptions;

    /** @var DateTime */
    private $startDate;

    /** @var DateTime */
    private $endDate;

    /**
     * CreateCouponCommand constructor.
     * @param string $code
     * @param bool $flagFreeShipping
     * @param int $minOrderValue
     * @param int $maxOrderValue
     * @param bool $canCombineWithOtherCoupons
     * @param string $name
     * @param int $promotionTypeId
     * @param int $value
     * @param bool $reducesTaxSubtotal
     * @param int $maxRedemptions
     * @param DateTime $startDate
     * @param DateTime $endDate
     */
    public function __construct(
        $code,
        $flagFreeShipping,
        $minOrderValue,
        $maxOrderValue,
        $canCombineWithOtherCoupons,
        $name,
        $promotionTypeId,
        $value,
        $reducesTaxSubtotal,
        $maxRedemptions,
        $startDate,
        $endDate
    ) {
        $this->couponId = Uuid::uuid4();
        $this->code = $code;
        $this->flagFreeShipping = $flagFreeShipping;
        $this->minOrderValue = $minOrderValue;
        $this->maxOrderValue = $maxOrderValue;
        $this->canCombineWithOtherCoupons = $canCombineWithOtherCoupons;
        $this->name = $name;
        $this->promotionTypeId = $promotionTypeId;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCouponId()
    {
        return $this->couponId;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function isFlagFreeShipping()
    {
        return $this->flagFreeShipping;
    }

    public function getMinOrderValue()
    {
        return $this->minOrderValue;
    }

    public function getMaxOrderValue()
    {
        return $this->maxOrderValue;
    }

    public function isCanCombineWithOtherCoupons()
    {
        return $this->canCombineWithOtherCoupons;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPromotionTypeId()
    {
        return $this->promotionTypeId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getReducesTaxSubtotal()
    {
        return $this->reducesTaxSubtotal;
    }

    public function getMaxRedemptions()
    {
        return $this->maxRedemptions;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }
}
