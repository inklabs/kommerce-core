<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\EntityDTO\InventoryTransactionDTO;

class InventoryTransactionDTOBuilder
{
    /** @var InventoryTransaction */
    protected $inventoryTransaction;

    /** @var InventoryTransactionDTO */
    protected $inventoryTransactionDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        InventoryTransaction $inventoryTransaction,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->inventoryTransaction = $inventoryTransaction;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->inventoryTransactionDTO = new InventoryTransactionDTO;
        $this->inventoryTransactionDTO->id             = $this->inventoryTransaction->getId();
        $this->inventoryTransactionDTO->debitQuantity  = $this->inventoryTransaction->getDebitQuantity();
        $this->inventoryTransactionDTO->creditQuantity = $this->inventoryTransaction->getCreditQuantity();
        $this->inventoryTransactionDTO->memo           = $this->inventoryTransaction->getMemo();

        $this->inventoryTransactionDTO->type = $this->dtoBuilderFactory
            ->getInventoryTransactionTypeDTOBuilder($this->inventoryTransaction->getType())
            ->build();

        $this->inventoryTransactionDTO->inventoryLocation = $this->dtoBuilderFactory
            ->getInventoryLocationDTOBuilder($this->inventoryTransaction->getInventoryLocation())
            ->build();
    }

    public function withProduct()
    {
        $product = $this->inventoryTransaction->getProduct();
        if (! empty($product)) {
            $this->inventoryTransactionDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
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
