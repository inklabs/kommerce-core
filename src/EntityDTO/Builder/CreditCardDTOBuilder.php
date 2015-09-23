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
        $this->creditCardDTO->number          = $this->creditCard->getNumber();
        $this->creditCardDTO->expirationMonth = $this->creditCard->getExpirationMonth();
        $this->creditCardDTO->expirationYear  = $this->creditCard->getExpirationYear();
    }

    public function build()
    {
        return $this->creditCardDTO;
    }
}
