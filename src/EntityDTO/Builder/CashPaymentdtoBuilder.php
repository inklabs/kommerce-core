<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\EntityDTO\CashPaymentDTO;

/**
 * @method CashPaymentDTO build()
 */
class CashPaymentDTOBuilder extends AbstractPaymentDTOBuilder
{
    public function __construct(CashPayment $payment)
    {
        $this->paymentDTO = new CashPaymentDTO;
        parent::__construct($payment);
    }
}
