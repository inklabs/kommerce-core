<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleItemCommand;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartPriceRuleItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        AbstractCartPriceRuleItem::class,
        Product::class,
    ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $product = $this->dummyData->getProduct();
        $cartPriceRuleItem = $this->dummyData->getCartPriceRuleProductItem($product, 1);
        $cartPriceRuleItem->setCartPriceRule($cartPriceRule);
        $this->persistEntityAndFlushClear([
            $cartPriceRule,
            $product,
            $cartPriceRuleItem,
        ]);
        $command = new DeleteCartPriceRuleItemCommand(
            $cartPriceRuleItem->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCartPriceRuleItemRepository()->findOneById(
            $command->getCartPriceRuleItemId()
        );
    }
}
