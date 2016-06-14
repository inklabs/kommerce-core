<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\CreditCardDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CreditCardDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $creditCard = $this->dummyData->getCreditCard();

        $creditCardDTO = $this->getDTOBuilderFactory()
            ->getCreditCardDTOBuilder($creditCard)
            ->build();

        $this->assertTrue($creditCardDTO instanceof CreditCardDTO);
    }
}
