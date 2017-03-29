<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

class CashPayment extends AbstractPayment
{
    /**
     * @param int $amount
     */
    public function __construct($amount)
    {
        parent::__construct();
        $this->amount = (int) $amount;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }
}
