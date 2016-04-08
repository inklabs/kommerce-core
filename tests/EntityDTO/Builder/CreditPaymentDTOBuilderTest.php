<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class CreditPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $chargeResponse = new ChargeResponse;
        $creditPayment = new CreditPayment($chargeResponse);

        $creditPaymentDTO = $creditPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($creditPaymentDTO instanceof CreditPaymentDTO);
        $this->assertTrue($creditPaymentDTO->chargeResponse instanceof ChargeResponseDTO);
    }
}
