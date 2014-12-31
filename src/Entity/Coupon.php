<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Coupon extends Promotion
{
    protected $code;
    protected $flagFreeShipping;
    protected $minOrderValue;
    protected $maxOrderValue;
    protected $canCombineWithOtherCoupons;

    public function __construct()
    {
        parent::__construct();
        $this->flagFreeShipping = false;
        $this->canCombineWithOtherCoupons = false;
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

    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setFlagFreeShipping($flagFreeShipping)
    {
        $this->flagFreeShipping = (bool) $flagFreeShipping;
    }

    public function getFlagFreeShipping()
    {
        return $this->flagFreeShipping;
    }

    public function setMinOrderValue($minOrderValue)
    {
        $this->minOrderValue = $minOrderValue;
    }

    public function getMinOrderValue()
    {
        return $this->minOrderValue;
    }

    public function setMaxOrderValue($maxOrderValue)
    {
        $this->maxOrderValue = $maxOrderValue;
    }

    public function getMaxOrderValue()
    {
        return $this->maxOrderValue;
    }

    public function getCanCombineWithOtherCoupons()
    {
        return $this->canCombineWithOtherCoupons;
    }

    public function setCanCombineWithOtherCoupons($canCombineWithOtherCoupons)
    {
        $this->canCombineWithOtherCoupons = (bool) $canCombineWithOtherCoupons;
    }

    public function isValid(\DateTime $date, $subtotal)
    {
        return $this->isValidPromotion($date)
            and $this->isMinOrderValueValid($subtotal)
            and $this->isMaxOrderValueValid($subtotal);
    }

    public function isMinOrderValueValid($subtotal)
    {
        if ($this->minOrderValue !== null and $subtotal < $this->minOrderValue) {
            return false;
        } else {
            return true;
        }
    }

    public function isMaxOrderValueValid($subtotal)
    {
        if ($this->maxOrderValue !== null and $subtotal > $this->maxOrderValue) {
            return false;
        } else {
            return true;
        }
    }

    public function getView()
    {
        return new View\Coupon($this);
    }
}
