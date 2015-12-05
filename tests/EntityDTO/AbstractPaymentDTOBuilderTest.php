<?php
namespace inklabs\kommerce\tests\EntityDTO;

use RuntimeException;

class AbstractPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestablePaymentInvalid;

        $this->setExpectedException(
            RuntimeException::class,
            'paymentDTO has not been initialized'
        );

        $cartPriceRuleItem->getDTOBuilder();
    }
}
