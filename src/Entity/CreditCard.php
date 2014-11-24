<?php
namespace inklabs\kommerce\Entity;

class CreditCard
{
    protected $number;
    protected $expirationMonth;
    protected $expirationYear;

    public function __construct($number, $expirationMonth, $expirationYear)
    {
        $this->number = $number;
        $this->expirationMonth = $expirationMonth;
        $this->expirationYear = $expirationYear;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    public function getExpirationYear()
    {
        return $this->expirationYear;
    }
}
