<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CartPriceRule\CreateCartPriceRuleCommand;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCartPriceRuleHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CartPriceRule::class,
    ];

    public function testHandle()
    {
        $name = 'Buy X get Y free';
        $maxRedemptions = 100;
        $reducesTaxSubtotal = true;
        $startAt = self::FAKE_TIMESTAMP;
        $endAt = self::FAKE_TIMESTAMP;
        $command = new CreateCartPriceRuleCommand(
            $name,
            $maxRedemptions,
            $reducesTaxSubtotal,
            $startAt,
            $endAt
        );
        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cartPriceRule = $this->getRepositoryFactory()->getCartPriceRuleRepository()->findOneById(
            $command->getCartPriceRuleId()
        );
        $this->assertSame($name, $cartPriceRule->getName());
        $this->assertSame($maxRedemptions, $cartPriceRule->getMaxRedemptions());
        $this->assertSame($reducesTaxSubtotal, $cartPriceRule->getReducesTaxSubtotal());
        $this->assertSame($startAt, $cartPriceRule->getStartAt());
        $this->assertSame($endAt, $cartPriceRule->getEndAt());
    }
}
