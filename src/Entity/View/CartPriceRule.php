<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRule extends Promotion
{
    /* @var CartPriceRuleItem[] */
    public $cartPriceRuleItems;

    /* @var CartPriceRuleDiscount[] */
    public $cartPriceRuleDiscounts;

    public function __construct(Entity\CartPriceRule $cartPriceRule)
    {
        parent::__construct($cartPriceRule);
    }

    public function withCartPriceRuleItems()
    {
        foreach ($this->promotion->getCartPriceRuleItems() as $cartPriceRuleItem) {
            $this->cartPriceRuleItems[] = $cartPriceRuleItem->getView()
                ->export();
        }

        return $this;
    }

    public function withCartPriceRuleDiscounts()
    {
        foreach ($this->promotion->getCartPriceRuleDiscounts() as $cartPriceRuleDiscount) {
            $this->cartPriceRuleDiscounts[] = $cartPriceRuleDiscount->getView()
                ->export();
        }

        return $this;
    }


    public function withAllData()
    {
        return $this
            ->withCartPriceRuleItems()
            ->withCartPriceRuleDiscounts()
            ->export();
    }
}
