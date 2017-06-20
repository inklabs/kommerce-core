<?php
namespace inklabs\kommerce\ActionResponse\CartPriceRule;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCartPriceRuleResponse implements ResponseInterface
{
    /** @var CartPriceRuleDTOBuilder */
    protected $cartPriceRuleDTOBuilder;

    public function getCartPriceRuleDTO(): CartPriceRuleDTO
    {
        return $this->cartPriceRuleDTOBuilder
            ->build();
    }

    public function getCartPriceRuleDTOWithAllData(): CartPriceRuleDTO
    {
        return $this->cartPriceRuleDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setCartPriceRuleDTOBuilder(CartPriceRuleDTOBuilder $cartPriceRuleDTOBuilder): void
    {
        $this->cartPriceRuleDTOBuilder = $cartPriceRuleDTOBuilder;
    }
}
