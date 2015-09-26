<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CreditCard;

class CreditCardDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $creditCard = new CreditCard;

        $creditCardDTO = $creditCard->getDTOBuilder()
            ->build();

        $this->assertTrue($creditCardDTO instanceof CreditCardDTO);
    }
}
