<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractCouponCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $couponId;

    /** @var string */
    protected $code;

    /** @var bool */
    protected $flagFreeShipping;

    /** @var int */
    protected $minOrderValue;

    /** @var int */
    protected $maxOrderValue;

    /** @var bool */
    protected $canCombineWithOtherCoupons;

    /** @var string */
    protected $name;

    /** @var string */
    protected $promotionTypeSlug;

    /** @var int */
    protected $value;

    /** @var bool */
    protected $reducesTaxSubtotal;

    /** @var int */
    protected $maxRedemptions;

    /** @var int */
    protected $startAt;

    /** @var int */
    protected $endAt;

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
     * @param string $couponId
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
        $endAt,
        $couponId
    ) {
        $this->couponId = Uuid::fromString($couponId);
        $this->code = $code;
        $this->flagFreeShipping = $flagFreeShipping;
        $this->minOrderValue = $minOrderValue;
        $this->maxOrderValue = $maxOrderValue;
        $this->canCombineWithOtherCoupons = $canCombineWithOtherCoupons;
        $this->name = $name;
        $this->promotionTypeSlug = $promotionTypeSlug;
        $this->value = $value;
        $this->reducesTaxSubtotal = $reducesTaxSubtotal;
        $this->maxRedemptions = $maxRedemptions;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function getCouponId()
    {
        return $this->couponId;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getFlagFreeShipping()
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

    public function canCombineWithOtherCoupons()
    {
        return $this->canCombineWithOtherCoupons;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return PromotionType
     */
    public function getPromotionType()
    {
        return PromotionType::createBySlug($this->promotionTypeSlug);
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

    public function getStartAt()
    {
        return $this->startAt;
    }

    public function getEndAt()
    {
        return $this->endAt;
    }
}
