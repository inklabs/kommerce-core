<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreditCardDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $creditCard = $this->dummyData->getCreditCard();

        $creditCardDTO = $creditCard->getDTOBuilder()
            ->build();

        $this->assertTrue($creditCardDTO instanceof CreditCardDTO);
    }
}
