<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Coupon extends AbstractPromotion
{
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

    public function __construct(string $code, UuidInterface $id = null)
    {
        parent::__construct($id);
        $this->flagFreeShipping = false;
        $this->canCombineWithOtherCoupons = false;
        $this->setCode($code);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
        $metadata->addPropertyConstraint('code', new Assert\Length([
            'max' => 16,
        ]));

        $metadata->addPropertyConstraint('minOrderValue', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('maxOrderValue', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setFlagFreeShipping(bool $flagFreeShipping)
    {
        $this->flagFreeShipping = $flagFreeShipping;
    }

    public function getFlagFreeShipping(): bool
    {
        return $this->flagFreeShipping;
    }

    public function setMinOrderValue(?int $minOrderValue)
    {
        $this->minOrderValue = $minOrderValue;
    }

    public function getMinOrderValue(): ?int
    {
        return $this->minOrderValue;
    }

    public function setMaxOrderValue(?int $maxOrderValue)
    {
        $this->maxOrderValue = $maxOrderValue;
    }

    public function getMaxOrderValue(): ?int
    {
        return $this->maxOrderValue;
    }

    public function getCanCombineWithOtherCoupons(): bool
    {
        return $this->canCombineWithOtherCoupons;
    }

    public function setCanCombineWithOtherCoupons(bool $canCombineWithOtherCoupons)
    {
        $this->canCombineWithOtherCoupons = $canCombineWithOtherCoupons;
    }

    public function isValid(DateTime $date, int $subtotal): bool
    {
        return $this->isValidPromotion($date)
            and $this->isMinOrderValueValid($subtotal)
            and $this->isMaxOrderValueValid($subtotal);
    }

    public function isMinOrderValueValid(int $subtotal): bool
    {
        if ($this->minOrderValue !== null and $subtotal < $this->minOrderValue) {
            return false;
        } else {
            return true;
        }
    }

    public function isMaxOrderValueValid(int $subtotal): bool
    {
        if ($this->maxOrderValue !== null and $subtotal > $this->maxOrderValue) {
            return false;
        } else {
            return true;
        }
    }
}
