<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\UpdateCartPriceRuleCommand;

final class UpdateCartPriceRuleHandler extends AbstractCartPriceRuleHandler
{
    public function handle(UpdateCartPriceRuleCommand $command)
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $command->getCartPriceRuleId()
        );

        $this->updateCartPriceRuleFromCommand($cartPriceRule, $command);

        $this->cartPriceRuleRepository->update($cartPriceRule);
    }
}
