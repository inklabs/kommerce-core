<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleTagItemCommand;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\EntityRepository\CartPriceRuleItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCartPriceRuleTagItemHandler implements CommandHandlerInterface
{
    /** @var CreateCartPriceRuleTagItemCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var CartPriceRuleItemRepositoryInterface */
    private $cartPriceRuleItemRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        CreateCartPriceRuleTagItemCommand $command,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        CartPriceRuleItemRepositoryInterface $cartPriceRuleItemRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->cartPriceRuleItemRepository = $cartPriceRuleItemRepository;
        $this->tagRepository = $tagRepository;
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

        $tag = $this->tagRepository->findOneById(
            $this->command->getTagId()
        );

        $cartPriceRuleTagItem = new CartPriceRuleTagItem(
            $tag,
            $this->command->getQuantity(),
            $this->command->getCartPriceRuleTagItemId()
        );
        $cartPriceRuleTagItem->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleItemRepository->create($cartPriceRuleTagItem);
    }
}
