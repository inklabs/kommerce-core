<?php
namespace inklabs\kommerce\Entity;

class Coupon extends Promotion
{
    protected $code;
    protected $flagFreeShipping;
    protected $minOrderValue;
    protected $maxOrderValue;

    public function __construct()
    {
        $this->flagFreeShipping = false;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setFlagFreeShipping($flagFreeShipping)
    {
        $this->flagFreeShipping = $flagFreeShipping;
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
}
