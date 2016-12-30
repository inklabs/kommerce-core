<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;

final class CreateCartPriceRuleHandler extends AbstractCartPriceRuleHandler
{
    public function handle(CreateCartPriceRuleCommand $command)
    {
        $cartPriceRule = new CartPriceRule($command->getCartPriceRuleId());
        $cartPriceRule->setName($command->getName());
        $cartPriceRule->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $cartPriceRule->setMaxRedemptions($command->getMaxRedemptions());
        $cartPriceRule->setStartAt($command->getStartAt());
        $cartPriceRule->setEndAt($command->getEndAt());

        $this->cartPriceRuleRepository->create($cartPriceRule);
    }
}
