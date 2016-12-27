<?php
namespace inklabs\kommerce\Action\CartPriceRule\Query;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;

class GetCartPriceRuleResponse implements GetCartPriceRuleResponseInterface
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
