<?php
namespace inklabs\kommerce\Entity\Payment;

use inklabs\kommerce\Entity as Entity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Cash extends Payment
{
    public function __construct($amount)
    {
        $this->setCreated();
        $this->amount = $amount;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function getView()
    {
        return new Entity\View\Payment\Cash($this);
    }
}
