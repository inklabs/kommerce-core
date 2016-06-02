<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\EntityDTO\MoneyDTO;

class MoneyDTOBuilder implements DTOBuilderInterface
{
    /** @var Money */
    protected $entity;

    /** @var MoneyDTO */
    protected $entityDTO;

    public function __construct(Money $money)
    {
        $this->entity = $money;

        $this->entityDTO = new MoneyDTO;
        $this->entityDTO->amount = $this->entity->getAmount();
        $this->entityDTO->currency = $this->entity->getCurrency();
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
