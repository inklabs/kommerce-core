<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Coupon extends AbstractPromotion
{
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

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        parent::__construct();
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

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param bool $flagFreeShipping
     */
    public function setFlagFreeShipping($flagFreeShipping)
    {
        $this->flagFreeShipping = (bool) $flagFreeShipping;
    }

    public function getFlagFreeShipping()
    {
        return $this->flagFreeShipping;
    }

    /**
     * @param int $minOrderValue
     */
    public function setMinOrderValue($minOrderValue)
    {
        $this->minOrderValue = (int) $minOrderValue;
    }

    public function getMinOrderValue()
    {
        return $this->minOrderValue;
    }

    /**
     * @param int $maxOrderValue
     */
    public function setMaxOrderValue($maxOrderValue)
    {
        $this->maxOrderValue = (int) $maxOrderValue;
    }

    public function getMaxOrderValue()
    {
        return $this->maxOrderValue;
    }

    public function getCanCombineWithOtherCoupons()
    {
        return $this->canCombineWithOtherCoupons;
    }

    /**
     * @param bool $canCombineWithOtherCoupons
     */
    public function setCanCombineWithOtherCoupons($canCombineWithOtherCoupons)
    {
        $this->canCombineWithOtherCoupons = (bool) $canCombineWithOtherCoupons;
    }

    /**
     * @param DateTime $date
     * @param int $subtotal
     * @return bool
     */
    public function isValid(DateTime $date, $subtotal)
    {
        return $this->isValidPromotion($date)
            and $this->isMinOrderValueValid($subtotal)
            and $this->isMaxOrderValueValid($subtotal);
    }

    /**
     * @param int $subtotal
     * @return bool
     */
    public function isMinOrderValueValid($subtotal)
    {
        if ($this->minOrderValue !== null and $subtotal < $this->minOrderValue) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param int $subtotal
     * @return bool
     */
    public function isMaxOrderValueValid($subtotal)
    {
        if ($this->maxOrderValue !== null and $subtotal > $this->maxOrderValue) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return CouponDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new CouponDTOBuilder($this);
    }
}
