<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\EntityDTO\TestablePaymentInvalid;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class AbstractPaymentDTOBuilderTest extends EntityDTOBuilderTestCase
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
