<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\DeleteCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartPriceRuleHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
    ];

    public function testHandle()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $this->persistEntityAndFlushClear($cartPriceRule);
        $command = new DeleteCartPriceRuleCommand($cartPriceRule->getId()->getHex());

        $this->dispatchCommand($command);

        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCartPriceRuleRepository()->findOneById(
            $command->getCartPriceRuleId()
        );
    }
}
