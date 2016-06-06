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
    protected $entity;

    /** @var CreditPaymentDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactory */
    protected $dtoBuilderFactory;

    public function __construct(CreditPayment $payment, DTOBuilderFactory $dtoBuilderFactory)
    {
        parent::__construct($payment);
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    protected function getEntityDTO()
    {
        return new CreditPaymentDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->chargeResponse = $this->dtoBuilderFactory
            ->getChargeResponseDTOBuilder($this->entity->getChargeResponse())
            ->build();
    }
}
