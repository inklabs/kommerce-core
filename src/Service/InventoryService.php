<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;

class InventoryService implements InventoryServiceInterface
{
    use EntityValidationTrait;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocationRepository;

    /** @var InventoryTransactionRepositoryInterface */
    private $inventoryTransactionRepository;

    public function __construct(
        InventoryLocationRepositoryInterface $inventoryLocationRepository,
        InventoryTransactionRepositoryInterface $inventoryTransactionRepository
    ) {
        $this->inventoryLocationRepository = $inventoryLocationRepository;
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @throws InsufficientInventoryException
     */
    public function reserveProduct(Product $product, $quantity)
    {
        if (! $product->isInventoryRequired()) {
            return;
        }

        try {
            $inventoryLocationId = $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity(
                $product,
                $quantity
            );

            $inventoryLocation = $this->inventoryLocationRepository->findOneById($inventoryLocationId);
        } catch (EntityNotFoundException $e) {
            throw new InsufficientInventoryException;
        }

        $debitTransaction = new InventoryTransaction($inventoryLocation, InventoryTransaction::TYPE_HOLD);
        $debitTransaction->setProduct($product);
        $debitTransaction->setDebitQuantity($quantity);
        $debitTransaction->setMemo('Hold product for customer');

        $creditTransaction = new InventoryTransaction(null, InventoryTransaction::TYPE_HOLD);
        $creditTransaction->setProduct($product);
        $creditTransaction->setCreditQuantity($quantity);
        $creditTransaction->setMemo('Hold product for customer');

        $this->throwValidationErrors($debitTransaction);

        $this->inventoryTransactionRepository->persist($debitTransaction);
        $this->inventoryTransactionRepository->persist($creditTransaction);
    }
}
