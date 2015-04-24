<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CreditCard implements ViewInterface
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

    public function export()
    {
        return $this;
    }
}
