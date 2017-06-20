<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleProductItemCommand;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\EntityRepository\CartPriceRuleItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCartPriceRuleProductItemHandler implements CommandHandlerInterface
{
    /** @var CreateCartPriceRuleProductItemCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var CartPriceRuleItemRepositoryInterface */
    private $cartPriceRuleItemRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        CreateCartPriceRuleProductItemCommand $command,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        CartPriceRuleItemRepositoryInterface $cartPriceRuleItemRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->cartPriceRuleItemRepository = $cartPriceRuleItemRepository;
        $this->productRepository = $productRepository;
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

        $product = $this->productRepository->findOneById(
            $this->command->getProductId()
        );

        $cartPriceRuleProductItem = new CartPriceRuleProductItem(
            $product,
            $this->command->getQuantity(),
            $this->command->getCartPriceRuleProductItemId()
        );
        $cartPriceRuleProductItem->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleItemRepository->create($cartPriceRuleProductItem);
    }
}
