<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\EntityDTO\InventoryTransactionDTO;

class InventoryTransactionDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var InventoryTransaction */
    protected $entity;

    /** @var InventoryTransactionDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        InventoryTransaction $inventoryTransaction,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $inventoryTransaction;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new InventoryTransactionDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->debitQuantity  = $this->entity->getDebitQuantity();
        $this->entityDTO->creditQuantity = $this->entity->getCreditQuantity();
        $this->entityDTO->memo           = $this->entity->getMemo();

        $this->entityDTO->type = $this->dtoBuilderFactory
            ->getInventoryTransactionTypeDTOBuilder($this->entity->getType())
            ->build();

        $this->entityDTO->inventoryLocation = $this->dtoBuilderFactory
            ->getInventoryLocationDTOBuilder($this->entity->getInventoryLocation())
            ->build();
    }

    public function withProduct()
    {
        $product = $this->entity->getProduct();
        if (! empty($product)) {
            $this->entityDTO->product = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
