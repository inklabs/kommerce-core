<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleTagItemCommand;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartPriceRuleTagItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
        AbstractCartPriceRuleItem::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear([
            $cartPriceRule,
            $tag
        ]);
        $quantity = 1;
        $command = new CreateCartPriceRuleTagItemCommand(
            $cartPriceRule->getId()->getHex(),
            $tag->getId()->getHex(),
            $quantity
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cartPriceRuleProductItem = $this->getRepositoryFactory()->getCartPriceRuleItemRepository()->findOneById(
            $command->getCartPriceRuleTagItemId()
        );
        $this->assertEntitiesEqual($tag, $cartPriceRuleProductItem->getTag());
        $this->assertSame($quantity, $cartPriceRuleProductItem->getQuantity());
    }
}
