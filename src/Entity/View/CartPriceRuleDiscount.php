<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleDiscount
{
    public $id;
    public $quantity;

    /* @var Product */
    public $product;

    public function __construct(Entity\CartPriceRuleDiscount $cartPriceRuleDiscount)
    {
        $this->cartPriceRuleDiscount = $cartPriceRuleDiscount;

        $this->id       = $cartPriceRuleDiscount->getId();
        $this->quantity = $cartPriceRuleDiscount->getQuantity();

        return $this;
    }

    public function export()
    {
        unset($this->cartPriceRuleDiscount);
        return $this;
    }

    public function withProduct()
    {
        $this->product = Product::factory($this->cartPriceRuleDiscount->getProduct())
            ->withTags()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }
}
