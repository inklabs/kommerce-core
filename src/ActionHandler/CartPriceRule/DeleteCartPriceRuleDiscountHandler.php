<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleDiscountCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteCartPriceRuleDiscountHandler implements CommandHandlerInterface
{
    /** @var DeleteCartPriceRuleDiscountCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleDiscountRepository;

    public function __construct(
        DeleteCartPriceRuleDiscountCommand $command,
        CartPriceRuleDiscountRepositoryInterface $cartPriceRuleDiscountRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleDiscountRepository = $cartPriceRuleDiscountRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $cartPriceRuleDiscount = $this->cartPriceRuleDiscountRepository->findOneById(
            $this->command->getCartPriceRuleDiscountId()
        );

        $this->cartPriceRuleDiscountRepository->delete($cartPriceRuleDiscount);
    }
}
