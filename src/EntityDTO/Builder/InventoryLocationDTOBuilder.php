<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\EntityDTO\InventoryLocationDTO;
use inklabs\kommerce\Lib\BaseConvert;

class InventoryLocationDTOBuilder
{
    /** @var InventoryLocation */
    protected $inventoryTransaction;

    /** @var InventoryLocationDTO */
    protected $inventoryTransactionDTO;

    public function __construct(InventoryLocation $inventoryTransaction)
    {
        $this->inventoryTransaction = $inventoryTransaction;

        $this->inventoryTransactionDTO = new InventoryLocationDTO;
        $this->inventoryTransactionDTO->id        = $this->inventoryTransaction->getId();
        $this->inventoryTransactionDTO->encodedId = BaseConvert::encode($this->inventoryTransaction->getId());
        $this->inventoryTransactionDTO->name      = $this->inventoryTransaction->getName();
        $this->inventoryTransactionDTO->code      = $this->inventoryTransaction->getCode();
    }

    public function withWarehouse()
    {
        $this->inventoryTransactionDTO->warehouse = $this->inventoryTransaction->getWarehouse()
            ->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withWarehouse();
    }

    public function build()
    {
        return $this->inventoryTransactionDTO;
    }
}
