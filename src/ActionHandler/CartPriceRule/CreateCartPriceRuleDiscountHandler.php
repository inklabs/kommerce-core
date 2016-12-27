<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleDiscountCommand;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

final class CreateCartPriceRuleDiscountHandler
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

    public function handle(CreateCartPriceRuleDiscountCommand $command)
    {
        $cartPriceRule = $this->cartPriceRuleRepository->findOneById(
            $command->getCartPriceRuleId()
        );

        $product = $this->productRepository->findOneById(
            $command->getProductId()
        );

        $cartPriceRuleDiscount = new CartPriceRuleDiscount(
            $product,
            $command->getQuantity()
        );
        $cartPriceRuleDiscount->setId($command->getCartPriceRuleDiscountId());
        $cartPriceRuleDiscount->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleRepository->create($cartPriceRuleDiscount);
    }
}
