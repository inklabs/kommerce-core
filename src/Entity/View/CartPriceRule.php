<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRule extends Promotion
{
    public function __construct(Entity\CartPriceRule $cartPriceRule)
    {
        parent::__construct($cartPriceRule);

        return $this;
    }

    public static function factory(Entity\CartPriceRule $cartPriceRule)
    {
        return new static($cartPriceRule);
    }

    public function withAllData()
    {
        return $this;
    }
}
