<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteCartPriceRuleHandler implements CommandHandlerInterface
{
    /** @var DeleteCartPriceRuleCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    protected $cartPriceRuleRepository;

    public function __construct(
        DeleteCartPriceRuleCommand $command,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $this->command->getCartPriceRuleId()
        );
        $this->cartPriceRuleRepository->delete($cartPriceRule);
    }
}
