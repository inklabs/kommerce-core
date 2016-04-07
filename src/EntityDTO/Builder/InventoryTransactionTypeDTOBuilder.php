<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\EntityDTO\InventoryTransactionTypeDTO;

class InventoryTransactionTypeDTOBuilder
{
    /** @var InventoryTransactionType */
    protected $orderStatusType;

    /** @var InventoryTransactionTypeDTO */
    protected $orderStatusTypeDTO;

    public function __construct(InventoryTransactionType $orderStatusType)
    {
        $this->orderStatusType = $orderStatusType;

        $this->orderStatusTypeDTO = new InventoryTransactionTypeDTO;
        $this->orderStatusTypeDTO->id = $this->orderStatusType->getId();
        $this->orderStatusTypeDTO->name = $this->orderStatusType->getName();
        $this->orderStatusTypeDTO->nameMap = $this->orderStatusType->getNameMap();
    }

    public function build()
    {
        return $this->orderStatusTypeDTO;
    }
}
