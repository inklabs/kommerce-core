<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\AbstractCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

abstract class AbstractCartPriceRuleHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    protected $cartPriceRuleRepository;

    public function __construct(CartPriceRuleRepositoryInterface $cartPriceRuleRepository)
    {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    public function updateCartPriceRuleFromCommand(CartPriceRule $cartPriceRule, AbstractCartPriceRuleCommand $command)
    {
        $cartPriceRule->setName($command->getName());
        $cartPriceRule->setMaxRedemptions($command->getMaxRedemptions());
        $cartPriceRule->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $cartPriceRule->setStartAt($command->getStartAt());
        $cartPriceRule->setEndAt($command->getEndAt());
    }
}
