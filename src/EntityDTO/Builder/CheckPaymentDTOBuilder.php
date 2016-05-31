<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
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

    protected function getPaymentDTO()
    {
        return new CheckPaymentDTO();
    }

    protected function preBuild()
    {
        $this->paymentDTO->checkNumber = $this->payment->getCheckNumber();
        $this->paymentDTO->memo = $this->payment->getMemo();
        $this->paymentDTO->checkDate = $this->payment->getCHeckDate();
    }
}
