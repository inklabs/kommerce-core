<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\EntityDTO\MoneyDTO;

class MoneyDTOBuilder
{
    /** @var Money */
    private $money;

    /** @var MoneyDTO */
    protected $moneyDTO;

    public function __construct(Money $money)
    {
        $this->money = $money;

        $this->moneyDTO = new MoneyDTO;
        $this->moneyDTO->amount = $this->money->getAmount();
        $this->moneyDTO->currency = $this->money->getCurrency();
    }

    public function build()
    {
        return $this->moneyDTO;
    }
}
