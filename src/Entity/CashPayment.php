<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

class CashPayment extends AbstractPayment
{
    public function __construct(int $amount)
    {
        parent::__construct();
        $this->amount = $amount;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        parent::loadValidatorMetadata($metadata);
    }
}
