<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Entity\PromotionType;
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

    /** @var string */
    private $promotionTypeSlug;

    /** @var int */
    private $value;

    /** @var bool */
    private $reducesTaxSubtotal;

    /** @var int */
    private $maxRedemptions;

    /** @var int */
    private $startAt;

    /** @var int */
    private $endAt;

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
        $this->couponId = Uuid::uuid4();
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
