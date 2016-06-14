<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\EntityDTO\CreditCardDTO;

class CreditCardDTOBuilder implements DTOBuilderInterface
{
    /** @var CreditCard */
    protected $entity;

    /** @var CreditCardDTO */
    protected $entityDTO;

    public function __construct(CreditCard $creditCard)
    {
        $this->entity = $creditCard;

        $this->entityDTO = new CreditCardDTO;
        $this->entityDTO->name            = $this->entity->getName();
        $this->entityDTO->zip5            = $this->entity->getZip5();
        $this->entityDTO->number          = $this->entity->getNumber();
        $this->entityDTO->cvc             = $this->entity->getCvc();
        $this->entityDTO->expirationMonth = $this->entity->getExpirationMonth();
        $this->entityDTO->expirationYear  = $this->entity->getExpirationYear();
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
