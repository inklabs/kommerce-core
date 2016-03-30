<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\Exception\InvalidArgumentException;

class AbstractPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFails()
    {
        $cartPriceRuleItem = new TestablePaymentInvalid;

        $this->setExpectedException(
            InvalidArgumentException::class,
            'paymentDTO has not been initialized'
        );

        $cartPriceRuleItem->getDTOBuilder();
    }
}
