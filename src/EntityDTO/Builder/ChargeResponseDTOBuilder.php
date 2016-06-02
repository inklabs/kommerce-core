<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\EntityDTO\ChargeResponseDTO;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class ChargeResponseDTOBuilder implements DTOBuilderInterface
{
    /** @var ChargeResponse */
    protected $entity;

    /** @var ChargeResponseDTO */
    protected $entityDTO;

    public function __construct(ChargeResponse $chargeResponse)
    {
        $this->entity = $chargeResponse;

        $this->entityDTO = new ChargeResponseDTO;
        $this->entityDTO->externalId  = $this->entity->getExternalId();
        $this->entityDTO->amount      = $this->entity->getAmount();
        $this->entityDTO->last4       = $this->entity->getLast4();
        $this->entityDTO->brand       = $this->entity->getBrand();
        $this->entityDTO->currency    = $this->entity->getCurrency();
        $this->entityDTO->description = $this->entity->getDescription();
        $this->entityDTO->created     = $this->entity->getCreated();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
