<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\UpdateCartPriceRuleCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateCartPriceRuleHandler implements CommandHandlerInterface
{
    /** @var UpdateCartPriceRuleCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    public function __construct(
        UpdateCartPriceRuleCommand $command,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $this->command->getCartPriceRuleId()
        );
        $cartPriceRule->setName($this->command->getName());
        $cartPriceRule->setReducesTaxSubtotal($this->command->getReducesTaxSubtotal());
        $cartPriceRule->setMaxRedemptions($this->command->getMaxRedemptions());
        $cartPriceRule->setStartAt($this->command->getStartAt());
        $cartPriceRule->setEndAt($this->command->getEndAt());

        $this->cartPriceRuleRepository->update($cartPriceRule);
    }
}
