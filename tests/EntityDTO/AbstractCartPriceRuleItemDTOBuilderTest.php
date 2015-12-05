<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;
use inklabs\kommerce\tests\Entity\TestableCartPriceRuleItem;
use RuntimeException;

class AbstractCartPriceRuleItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestableCartPriceRuleItemInvalid;

        $this->setExpectedException(
            RuntimeException::class,
            'cartPriceRuleItemDTO has not been initialized'
        );

        $cartPriceRuleItem->getDTOBuilder();
    }
}
