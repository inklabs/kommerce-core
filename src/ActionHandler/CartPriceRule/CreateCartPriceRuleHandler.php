<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCartPriceRuleHandler implements CommandHandlerInterface
{
    /** @var CreateCartPriceRuleCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    protected $cartPriceRuleRepository;

    public function __construct(
        CreateCartPriceRuleCommand $command,
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
        $cartPriceRule = new CartPriceRule($this->command->getCartPriceRuleId());
        $cartPriceRule->setName($this->command->getName());
        $cartPriceRule->setReducesTaxSubtotal($this->command->getReducesTaxSubtotal());
        $cartPriceRule->setMaxRedemptions($this->command->getMaxRedemptions());
        $cartPriceRule->setStartAt($this->command->getStartAt());
        $cartPriceRule->setEndAt($this->command->getEndAt());

        $this->cartPriceRuleRepository->create($cartPriceRule);
    }
}
