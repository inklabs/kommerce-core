<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleDiscount
{
    public $id;
    public $quantity;
    public $created;
    public $updated;

    /* @var Product */
    public $product;

    public function __construct(Entity\CartPriceRuleDiscount $cartPriceRuleDiscount)
    {
        $this->cartPriceRuleDiscount = $cartPriceRuleDiscount;

        $this->id       = $cartPriceRuleDiscount->getId();
        $this->quantity = $cartPriceRuleDiscount->getQuantity();
        $this->created  = $cartPriceRuleDiscount->getCreated();
        $this->updated  = $cartPriceRuleDiscount->getUpdated();
    }

    public function export()
    {
        unset($this->cartPriceRuleDiscount);
        return $this;
    }

    public function withProduct()
    {
        $this->product = $this->cartPriceRuleDiscount->getProduct()->getView()
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
