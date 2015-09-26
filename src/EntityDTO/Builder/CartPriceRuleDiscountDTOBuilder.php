<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\EntityDTO\CartPriceRuleDiscountDTO;

class CartPriceRuleDiscountDTOBuilder
{
    /** @var CartPriceRuleDiscount */
    protected $cartPriceRuleDiscount;

    /** @var CartPriceRuleDiscountDTO */
    protected $cartPriceRuleDiscountDTO;

    public function __construct(CartPriceRuleDiscount $cartPriceRuleDiscount)
    {
        $this->cartPriceRuleDiscount = $cartPriceRuleDiscount;

        $this->cartPriceRuleDiscountDTO = new CartPriceRuleDiscountDTO;
        $this->cartPriceRuleDiscountDTO->id       = $this->cartPriceRuleDiscount->getId();
        $this->cartPriceRuleDiscountDTO->quantity = $this->cartPriceRuleDiscount->getQuantity();
        $this->cartPriceRuleDiscountDTO->created  = $this->cartPriceRuleDiscount->getCreated();
        $this->cartPriceRuleDiscountDTO->updated  = $this->cartPriceRuleDiscount->getUpdated();
    }

    public function withProduct()
    {
        $this->cartPriceRuleDiscountDTO->product = $this->cartPriceRuleDiscount->getProduct()->getDTOBuilder()
            ->withTags()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }

    public function build()
    {
        return $this->cartPriceRuleDiscountDTO;
    }
}
