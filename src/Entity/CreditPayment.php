<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CreditPaymentDTOBuilder;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CreditPayment extends AbstractPayment
{
    /** @var ChargeResponse */
    protected $chargeResponse;

    public function __construct(ChargeResponse $chargeResponse)
    {
        parent::__construct();
        $this->amount = $chargeResponse->getAmount();
        $this->chargeResponse = $chargeResponse;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('chargeResponse', new Assert\Valid);
    }

    public function getChargeResponse()
    {
        return $this->chargeResponse;
    }
}
