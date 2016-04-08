<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CreditCardDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $creditCard = $this->dummyData->getCreditCard();

        $creditCardDTO = $creditCard->getDTOBuilder()
            ->build();

        $this->assertTrue($creditCardDTO instanceof CreditCardDTO);
    }
}
