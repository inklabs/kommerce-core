<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleCommand;
use inklabs\kommerce\Service\CartPriceRuleServiceInterface;

final class DeleteCartPriceRuleHandler
{
    /** @var CartPriceRuleServiceInterface */
    protected $cartPriceRuleService;

    public function __construct(CartPriceRuleServiceInterface $cartPriceRuleService)
    {
        $this->cartPriceRuleService = $cartPriceRuleService;
    }

    public function handle(DeleteCartPriceRuleCommand $command)
    {
        $cartPriceRule = $this->cartPriceRuleService->findOneById($command->getCartPriceRuleId());
        $this->cartPriceRuleService->delete($cartPriceRule);
    }
}
