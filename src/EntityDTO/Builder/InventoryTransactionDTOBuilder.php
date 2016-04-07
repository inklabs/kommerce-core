<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\EntityDTO\InventoryTransactionDTO;
use inklabs\kommerce\Lib\BaseConvert;

class InventoryTransactionDTOBuilder
{
    /** @var InventoryTransaction */
    protected $inventoryTransaction;

    /** @var InventoryTransactionDTO */
    protected $inventoryTransactionDTO;

    public function __construct(InventoryTransaction $inventoryTransaction)
    {
        $this->inventoryTransaction = $inventoryTransaction;

        $this->inventoryTransactionDTO = new InventoryTransactionDTO;
        $this->inventoryTransactionDTO->id             = $this->inventoryTransaction->getId();
        $this->inventoryTransactionDTO->encodedId      = BaseConvert::encode($this->inventoryTransaction->getId());
        $this->inventoryTransactionDTO->debitQuantity  = $this->inventoryTransaction->getDebitQuantity();
        $this->inventoryTransactionDTO->creditQuantity = $this->inventoryTransaction->getCreditQuantity();
        $this->inventoryTransactionDTO->memo           = $this->inventoryTransaction->getMemo();

        $this->inventoryTransactionDTO->type = $this->inventoryTransaction->getType()->getDTOBuilder()
            ->build();

        $this->inventoryTransactionDTO->inventoryLocation = $this->inventoryTransaction->getInventoryLocation()
            ->getDTOBuilder()
            ->build();
    }

    public function withProduct()
    {
        $product = $this->inventoryTransaction->getProduct();
        if (! empty($product)) {
            $this->inventoryTransactionDTO->product = $product->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }

    public function build()
    {
        return $this->inventoryTransactionDTO;
    }
}
