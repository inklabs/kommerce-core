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

    /**
     * @return AbstractPaymentDTO
     */
    abstract protected function getPaymentDTO();

    public function __construct(AbstractPayment $payment)
    {
        $this->payment = $payment;

        $this->paymentDTO = $this->getPaymentDTO();
        $this->paymentDTO->id      = $this->payment->getId();
        $this->paymentDTO->amount  = $this->payment->getAmount();
        $this->paymentDTO->created = $this->payment->getCreated();
        $this->paymentDTO->updated = $this->payment->getUpdated();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->paymentDTO;
    }
}
