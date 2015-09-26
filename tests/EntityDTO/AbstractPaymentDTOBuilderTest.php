<?php
namespace inklabs\kommerce\tests\EntityDTO;

use RuntimeException;

class AbstractPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage paymentDTO has not been initialized
     */
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestablePaymentInvalid;
        $cartPriceRuleItem->getDTOBuilder();
    }
}
