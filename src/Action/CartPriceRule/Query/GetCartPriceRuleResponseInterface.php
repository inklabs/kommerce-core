<?php
namespace inklabs\kommerce\Action\CartPriceRule\Query;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;

interface GetCartPriceRuleResponseInterface
{
    public function setCartPriceRuleDTOBuilder(CartPriceRuleDTOBuilder $cartPriceRuleDTOBuilder);
}
