<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

interface CartCalculatorInterface
{
    /**
     * @param Entity\Cart $cart
     * @return Entity\CartTotal
     */
    public function getTotal(Entity\Cart $cart);

    /**
     * @return PricingInterface
     */
    public function getPricing();
}
