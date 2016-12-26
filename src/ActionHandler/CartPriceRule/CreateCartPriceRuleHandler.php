<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Service\CartPriceRuleServiceInterface;

final class CreateCartPriceRuleHandler
{
    /** @var CartPriceRuleServiceInterface */
    protected $cartPriceRuleService;

    public function __construct(CartPriceRuleServiceInterface $cartPriceRuleService)
    {
        $this->cartPriceRuleService = $cartPriceRuleService;
    }

    public function handle(CreateCartPriceRuleCommand $command)
    {
        $cartPriceRule = new CartPriceRule($command->getCartPriceRuleId());
        $cartPriceRule->setName($command->getName());
        $cartPriceRule->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $cartPriceRule->setMaxRedemptions($command->getMaxRedemptions());
        $cartPriceRule->setStart($command->getStartDate());
        $cartPriceRule->setEnd($command->getEndDate());

        $this->cartPriceRuleService->create($cartPriceRule);
    }
}
