<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CreditCard
{
    public $number;
    public $expirationMonth;
    public $expirationYear;

    public function __construct(Entity\CreditCard $creditCard)
    {
        $this->number          = $creditCard->getNumber();
        $this->expirationMonth = $creditCard->getExpirationMonth();
        $this->expirationYear  = $creditCard->getExpirationYear();
    }
}
