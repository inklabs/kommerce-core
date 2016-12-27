<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleProductItemCommand;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

final class CreateCartPriceRuleProductItemHandler
{
    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->productRepository = $productRepository;
    }

    public function handle(CreateCartPriceRuleProductItemCommand $command)
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $command->getCartPriceRuleId()
        );

        $product = $this->productRepository->findOneById(
            $command->getProductId()
        );

        $cartPriceRuleProductItem = new CartPriceRuleProductItem(
            $product,
            $command->getQuantity()
        );
        $cartPriceRuleProductItem->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleRepository->create($cartPriceRuleProductItem);
    }
}
