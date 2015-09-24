<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CashPayment extends AbstractPayment
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
        return new View\CashPayment($this);
    }
}
