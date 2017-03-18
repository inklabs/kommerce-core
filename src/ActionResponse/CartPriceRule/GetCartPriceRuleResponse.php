<?php
namespace inklabs\kommerce\ActionResponse\CartPriceRule;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCartPriceRuleResponse implements ResponseInterface
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
