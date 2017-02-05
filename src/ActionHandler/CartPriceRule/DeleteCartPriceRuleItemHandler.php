<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleItemCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteCartPriceRuleItemHandler implements CommandHandlerInterface
{
    /** @var DeleteCartPriceRuleItemCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleItemRepository;

    public function __construct(
        DeleteCartPriceRuleItemCommand $command,
        CartPriceRuleItemRepositoryInterface $cartPriceRuleItemRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleItemRepository = $cartPriceRuleItemRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRuleItem = $this->cartPriceRuleItemRepository->findOneById(
            $this->command->getCartPriceRuleItemId()
        );

        $this->cartPriceRuleItemRepository->delete($cartPriceRuleItem);
    }
}
