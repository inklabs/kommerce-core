<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartTotal;

interface CartCalculatorInterface
{
    public function getTotal(Cart $cart): CartTotal;

    /**
     * @return PricingInterface|Pricing
     */
    public function getPricing();
}
