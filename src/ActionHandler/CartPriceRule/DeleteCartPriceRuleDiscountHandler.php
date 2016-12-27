<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleDiscountCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

final class DeleteCartPriceRuleDiscountHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleDiscountRepository;

    public function __construct(CartPriceRuleDiscountRepositoryInterface $cartPriceRuleDiscountRepository)
    {
        $this->cartPriceRuleDiscountRepository = $cartPriceRuleDiscountRepository;
    }

    public function handle(DeleteCartPriceRuleDiscountCommand $command)
    {
        $cartPriceRuleDiscount = $this->cartPriceRuleDiscountRepository->findOneById(
            $command->getCartPriceRuleDiscountId()
        );

        $this->cartPriceRuleDiscountRepository->delete($cartPriceRuleDiscount);
    }
}
