<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleDiscountCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartPriceRuleDiscountHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        CartPriceRuleDiscount::class,
        Product::class,
    ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear([
            $cartPriceRule,
            $product,
        ]);

        $quantity = 1;
        $command = new CreateCartPriceRuleDiscountCommand(
            $cartPriceRule->getId()->getHex(),
            $product->getId()->getHex(),
            $quantity
        );

        $repositoryFactory = $this->getRepositoryFactory();
        $handler = new CreateCartPriceRuleDiscountHandler(
            $repositoryFactory->getCartPriceRuleRepository(),
            $repositoryFactory->getProductRepository()
        );
        $handler->handle($command);

        $this->entityManager->clear();
        $cartPriceRuleDiscount = $repositoryFactory->getCartPriceRuleDiscountRepository()
            ->findOneById($command->getCartPriceRuleDiscountId());

        $this->assertEntitiesEqual($product, $cartPriceRuleDiscount->getProduct());
        $this->assertSame($quantity, $cartPriceRuleDiscount->getQuantity());
    }
}
