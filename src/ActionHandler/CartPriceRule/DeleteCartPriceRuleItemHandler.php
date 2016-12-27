<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleItemCommand;
use inklabs\kommerce\EntityRepository\CartPriceRuleItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

final class DeleteCartPriceRuleItemHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleItemRepository;

    public function __construct(CartPriceRuleItemRepositoryInterface $cartPriceRuleItemRepository)
    {
        $this->cartPriceRuleItemRepository = $cartPriceRuleItemRepository;
    }

    public function handle(DeleteCartPriceRuleItemCommand $command)
    {
        $cartPriceRuleItem = $this->cartPriceRuleItemRepository->findOneById(
            $command->getCartPriceRuleItemId()
        );

        $this->cartPriceRuleItemRepository->delete($cartPriceRuleItem);
    }
}
