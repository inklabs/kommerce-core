<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\EntityDTO\TestableCartPriceRuleItemInvalid;

class AbstractCartPriceRuleItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestableCartPriceRuleItemInvalid;

        $this->setExpectedException(
            InvalidArgumentException::class,
            'cartPriceRuleItemDTO has not been initialized'
        );

        $cartPriceRuleItem->getDTOBuilder();
    }
}
