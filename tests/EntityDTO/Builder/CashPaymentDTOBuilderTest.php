<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CashPayment;

class CashPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cashPayment = new CashPayment(2000);

        $cashPaymentDTO = $cashPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($cashPaymentDTO instanceof CashPaymentDTO);
    }
}
