<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
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

    /** @var DTOBuilderFactory */
    private $dtoBuilderFactory;

    public function __construct(CreditPayment $payment, DTOBuilderFactory $dtoBuilderFactory)
    {
        parent::__construct($payment);
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    protected function getPaymentDTO()
    {
        return new CreditPaymentDTO;
    }

    protected function preBuild()
    {
        $this->paymentDTO->chargeResponse = $this->dtoBuilderFactory
            ->getChargeResponseDTOBuilder($this->payment->getChargeResponse())
            ->build();
    }
}
