<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

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
