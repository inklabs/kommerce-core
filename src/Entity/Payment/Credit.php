<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib\PaymentGateway\GatewayInterface;
use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Credit extends AbstractPayment
{
    /** @var ChargeResponse */
    protected $chargeResponse;

    public function __construct(ChargeRequest $chargeRequest, GatewayInterface $gateway)
    {
        $this->setCreated();
        $this->amount = $chargeRequest->getAmount();
        $this->setCharge($gateway->getCharge($chargeRequest));
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('chargeResponse', new Assert\Valid);
    }

    private function setCharge(ChargeResponse $chargeResponse)
    {
        $this->chargeResponse = $chargeResponse;
    }

    public function getChargeResponse()
    {
        return $this->chargeResponse;
    }

    public function getView()
    {
        return new View\Payment\Credit($this);
    }
}
