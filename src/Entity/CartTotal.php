<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartTotal implements ValidationInterface
{
    /** @var int */
    public $origSubtotal = 0;

    /** @var int */
    public $subtotal = 0;

    /** @var int */
    public $taxSubtotal = 0;

    /** @var int */
    public $discount = 0;

    /** @var int */
    public $shipping = 0;

    /** @var int */
    public $shippingDiscount = 0;

    /** @var int */
    public $tax = 0;

    /** @var int */
    public $total = 0;

    /** @var int */
    public $savings = 0;

    /** @var TaxRate */
    public $taxRate;

    /** @var Coupon[] */
    public $coupons = [];

    /** @var CartPriceRule[] */
    public $cartPriceRules = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $integerColumns = [
            'origSubtotal',
            'subtotal',
            'taxSubtotal',
            'discount',
            'shipping',
            'shippingDiscount',
            'tax',
            'total',
            'savings',
        ];

        foreach ($integerColumns as $columnName) {
            $metadata->addPropertyConstraint($columnName, new Assert\NotNull);
            $metadata->addPropertyConstraint($columnName, new Assert\Range([
                'min' => 0,
                'max' => 4294967295,
            ]));
        }
    }
}
