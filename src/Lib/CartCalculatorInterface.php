<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartTotal;

interface CartCalculatorInterface
{
    /**
     * @param Cart $cart
     * @return CartTotal
     */
    public function getTotal(Cart $cart);

    /**
     * @return PricingInterface
     */
    public function getPricing();
}
