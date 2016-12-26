<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\UpdateCartPriceRuleCommand;
use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
use inklabs\kommerce\Service\CartPriceRuleServiceInterface;

final class UpdateCartPriceRuleHandler
{
    /** @var CartPriceRuleServiceInterface */
    protected $cartPriceRuleService;

    public function __construct(CartPriceRuleServiceInterface $cartPriceRuleService)
    {
        $this->cartPriceRuleService = $cartPriceRuleService;
    }

    public function handle(UpdateCartPriceRuleCommand $command)
    {
        $cartPriceRuleDTO = $command->getCartPriceRuleDTO();
        $cartPriceRule = $this->cartPriceRuleService->findOneById($cartPriceRuleDTO->id);
        CartPriceRuleDTOBuilder::setFromDTO($cartPriceRule, $cartPriceRuleDTO);

        $this->cartPriceRuleService->update($cartPriceRule);
    }
}
