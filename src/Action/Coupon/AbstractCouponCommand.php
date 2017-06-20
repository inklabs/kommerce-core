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

    /** @var int|null */
    protected $minOrderValue;

    /** @var int|null */
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
        int $maxRedemptions,
        int $startAt,
        int $endAt,
        string $couponId
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

    public function getCouponId(): UuidInterface
    {
        return $this->couponId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getFlagFreeShipping(): bool
    {
        return $this->flagFreeShipping;
    }

    public function getMinOrderValue(): ?int
    {
        return $this->minOrderValue;
    }

    public function getMaxOrderValue(): ?int
    {
        return $this->maxOrderValue;
    }

    public function canCombineWithOtherCoupons(): bool
    {
        return $this->canCombineWithOtherCoupons;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPromotionType(): PromotionType
    {
        return PromotionType::createBySlug($this->promotionTypeSlug);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getReducesTaxSubtotal(): bool
    {
        return $this->reducesTaxSubtotal;
    }

    public function getMaxRedemptions(): int
    {
        return $this->maxRedemptions;
    }

    public function getStartAt(): int
    {
        return $this->startAt;
    }

    public function getEndAt(): int
    {
        return $this->endAt;
    }
}
