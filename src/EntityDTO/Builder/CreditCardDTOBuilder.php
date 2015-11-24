<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\EntityDTO\CreditCardDTO;

class CreditCardDTOBuilder
{
    /** @var CreditCard */
    protected $creditCard;

    /** @var CreditCardDTO */
    protected $creditCardDTO;

    public function __construct(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;

        $this->creditCardDTO = new CreditCardDTO;
        $this->creditCardDTO->name            = $this->creditCard->getName();
        $this->creditCardDTO->zip5            = $this->creditCard->getZip5();
        $this->creditCardDTO->number          = $this->creditCard->getNumber();
        $this->creditCardDTO->cvc             = $this->creditCard->getCvc();
        $this->creditCardDTO->expirationMonth = $this->creditCard->getExpirationMonth();
        $this->creditCardDTO->expirationYear  = $this->creditCard->getExpirationYear();
    }

    public static function createFromDTO(CreditCardDTO $creditCardDTO)
    {
        $creditCard = new CreditCard;
        $creditCard->setName($creditCardDTO->name);
        $creditCard->setZip5($creditCardDTO->zip5);
        $creditCard->setNumber($creditCardDTO->number);
        $creditCard->setCvc($creditCardDTO->cvc);
        $creditCard->setExpirationMonth($creditCardDTO->expirationMonth);
        $creditCard->setExpirationYear($creditCardDTO->expirationYear);

        return $creditCard;
    }

    public function build()
    {
        return $this->creditCardDTO;
    }
}
