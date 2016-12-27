<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleDiscountCommand;
use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleDiscountCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartPriceRuleDiscountHandlerTest extends ActionTestCase
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
        $cartPriceRuleDiscount = $this->dummyData->getCartPriceRuleDiscount($product, 1);
        $cartPriceRuleDiscount->setCartPriceRule($cartPriceRule);
        $this->persistEntityAndFlushClear([
            $cartPriceRule,
            $product,
            $cartPriceRuleDiscount,
        ]);

        $command = new DeleteCartPriceRuleDiscountCommand(
            $cartPriceRuleDiscount->getId()->getHex()
        );

        $repositoryFactory = $this->getRepositoryFactory();
        $handler = new DeleteCartPriceRuleDiscountHandler(
            $repositoryFactory->getCartPriceRuleDiscountRepository()
        );
        $handler->handle($command);
        $this->entityManager->clear();

        $this->expectException(EntityNotFoundException::class);

        $cartPriceRuleDiscount = $repositoryFactory->getCartPriceRuleDiscountRepository()
            ->findOneById($command->getCartPriceRuleDiscountId());
    }
}
