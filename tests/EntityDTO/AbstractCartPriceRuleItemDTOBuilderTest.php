<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;
use inklabs\kommerce\tests\Entity\TestableCartPriceRuleItem;
use RuntimeException;

class AbstractCartPriceRuleItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage cartPriceRuleItemDTO has not been initialized
     */
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestableCartPriceRuleItemInvalid;
        $cartPriceRuleItem->getDTOBuilder();
    }
}
