<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleTagItemCommand;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

final class CreateCartPriceRuleTagItemHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->tagRepository = $tagRepository;
    }

    public function handle(CreateCartPriceRuleTagItemCommand $command)
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $command->getCartPriceRuleId()
        );

        $tag = $this->tagRepository->findOneById(
            $command->getTagId()
        );

        $cartPriceRuleTagItem = new CartPriceRuleTagItem(
            $tag,
            $command->getQuantity()
        );
        $cartPriceRuleTagItem->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleRepository->create($cartPriceRuleTagItem);
    }
}
