<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\EntityDTO\CheckPaymentDTO;

/**
 * @method CheckPaymentDTO build()
 */
class CheckPaymentDTOBuilder extends AbstractPaymentDTOBuilder
{
    /** @var CheckPayment */
    protected $payment;

    /** @var CheckPaymentDTO */
    protected $paymentDTO;

    public function __construct(CheckPayment $payment)
    {
        $this->paymentDTO = new CheckPaymentDTO;
        parent::__construct($payment);

        $this->paymentDTO->checkNumber = $payment->getCheckNumber();
        $this->paymentDTO->memo = $payment->getMemo();
        $this->paymentDTO->checkDate = $payment->getCHeckDate();
    }
}
