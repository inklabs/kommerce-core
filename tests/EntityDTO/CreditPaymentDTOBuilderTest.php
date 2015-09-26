<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\StripeFake;

class CreditPaymentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $chargeRequest = new ChargeRequest;
        $chargeRequest->setCreditCard(new CreditCard);

        $creditPayment = new CreditPayment($chargeRequest, new StripeFake);

        $creditPaymentDTO = $creditPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($creditPaymentDTO instanceof CreditPaymentDTO);
        $this->assertTrue($creditPaymentDTO->chargeResponse instanceof ChargeResponseDTO);
    }
}
