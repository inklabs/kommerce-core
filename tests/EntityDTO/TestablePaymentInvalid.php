<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\Entity\AbstractPayment;

class TestablePaymentInvalid extends AbstractPayment
{
    /**
     * @return TestablePaymentInvalidDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new TestablePaymentInvalidDTOBuilder($this);
    }
}
