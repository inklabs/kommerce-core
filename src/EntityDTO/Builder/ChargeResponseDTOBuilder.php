<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\EntityDTO\ChargeResponseDTO;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class ChargeResponseDTOBuilder
{
    /** @var ChargeResponse */
    protected $chargeResponse;

    /** @var ChargeResponseDTO */
    protected $chargeResponseDTO;

    public function __construct(ChargeResponse $chargeResponse)
    {
        $this->chargeResponse = $chargeResponse;

        $this->chargeResponseDTO = new ChargeResponseDTO;
        $this->chargeResponseDTO->externalId  = $this->chargeResponse->getExternalId();
        $this->chargeResponseDTO->amount      = $this->chargeResponse->getAmount();
        $this->chargeResponseDTO->last4       = $this->chargeResponse->getLast4();
        $this->chargeResponseDTO->brand       = $this->chargeResponse->getBrand();
        $this->chargeResponseDTO->currency    = $this->chargeResponse->getCurrency();
        $this->chargeResponseDTO->fee         = $this->chargeResponse->getFee();
        $this->chargeResponseDTO->description = $this->chargeResponse->getDescription();
        $this->chargeResponseDTO->created     = $this->chargeResponse->getCreated();
    }

    public function build()
    {
        return $this->chargeResponseDTO;
    }
}
