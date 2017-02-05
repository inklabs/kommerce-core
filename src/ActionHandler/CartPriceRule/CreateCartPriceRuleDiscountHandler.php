<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleDiscountCommand;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateCartPriceRuleDiscountHandler implements CommandHandlerInterface
{
    /** @var CreateCartPriceRuleDiscountCommand */
    private $command;

    /** @var CartPriceRuleRepositoryInterface */
    private $cartPriceRuleRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        CreateCartPriceRuleDiscountCommand $command,
        CartPriceRuleRepositoryInterface $cartPriceRuleRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->command = $command;
        $this->cartPriceRuleRepository = $cartPriceRuleRepository;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
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

        $cartPriceRuleDiscount = new CartPriceRuleDiscount(
            $product,
            $this->command->getQuantity()
        );
        $cartPriceRuleDiscount->setId($this->command->getCartPriceRuleDiscountId());
        $cartPriceRuleDiscount->setCartPriceRule($cartPriceRule);

        $this->cartPriceRuleRepository->create($cartPriceRuleDiscount);
    }
}
