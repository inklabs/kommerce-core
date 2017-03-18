<?php
namespace inklabs\kommerce\ActionResponse\CartPriceRule;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;

class GetCartPriceRuleResponse
{
    /** @var CartPriceRuleDTOBuilder */
    protected $cartPriceRuleDTOBuilder;

    public function getCartPriceRuleDTO()
    {
        return $this->cartPriceRuleDTOBuilder
            ->build();
    }

    public function getCartPriceRuleDTOWithAllData()
    {
        return $this->cartPriceRuleDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setCartPriceRuleDTOBuilder(CartPriceRuleDTOBuilder $cartPriceRuleDTOBuilder)
    {
        $this->cartPriceRuleDTOBuilder = $cartPriceRuleDTOBuilder;
    }
}
