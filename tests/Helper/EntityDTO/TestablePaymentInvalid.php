<?php
namespace inklabs\kommerce\tests\Helper\EntityDTO;

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
