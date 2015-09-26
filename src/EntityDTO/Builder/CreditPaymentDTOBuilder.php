<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\EntityDTO\CreditPaymentDTO;

/**
 * @method CreditPaymentDTO build()
 */
class CreditPaymentDTOBuilder extends AbstractPaymentDTOBuilder
{
    /** @var CreditPayment */
    protected $payment;

    /** @var CreditPaymentDTO */
    protected $paymentDTO;

    public function __construct(CreditPayment $payment)
    {
        $this->paymentDTO = new CreditPaymentDTO;

        parent::__construct($payment);

        $this->paymentDTO->chargeResponse = $payment->getChargeResponse()->getDTOBuilder()
            ->build();
    }
}
