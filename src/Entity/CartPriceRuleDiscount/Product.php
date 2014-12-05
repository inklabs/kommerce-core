<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;

class Product extends Discount
{
    /* @var Entity|Product */
    protected $product;

    public function __construct(Entity\Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
