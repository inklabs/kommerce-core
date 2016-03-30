<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
use inklabs\kommerce\Exception\InvalidArgumentException;

abstract class AbstractPaymentDTOBuilder
{
    /** @var AbstractPayment */
    protected $payment;

    /** @var AbstractPaymentDTO */
    protected $paymentDTO;

    public function __construct(AbstractPayment $payment)
    {
        if ($this->paymentDTO === null) {
            throw new InvalidArgumentException('paymentDTO has not been initialized');
        }
        $this->payment = $payment;

        $this->paymentDTO->id      = $this->payment->getId();
        $this->paymentDTO->amount  = $this->payment->getAmount();
        $this->paymentDTO->created = $this->payment->getCreated();
        $this->paymentDTO->updated = $this->payment->getUpdated();
    }

    public function build()
    {
        return $this->paymentDTO;
    }
}
