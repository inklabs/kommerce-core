<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CheckPaymentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $checkPayment = $this->dummyData->getCheckPayment();

        $checkPaymentDTO = $checkPayment->getDTOBuilder()
            ->build();

        $this->assertTrue($checkPaymentDTO instanceof CheckPaymentDTO);
        $this->assertTrue($checkPaymentDTO->checkDate instanceof DateTime);
    }
}
