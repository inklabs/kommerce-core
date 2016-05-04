<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;

/**
 * @method InventoryTransaction findOneById($id)
 */
class FakeInventoryTransactionRepository extends AbstractFakeRepository implements
    InventoryTransactionRepositoryInterface
{
    protected $entityName = 'InventoryTransaction';

    /** @var InventoryTransaction[] */
    protected $entities = [];

    /**
     * @param Product $product
     * @return InventoryTransaction[]
     */
    public function findAllByProduct(Product $product)
    {
        $inventoryTransactions = [];

        foreach ($this->entities as $inventoryTransaction) {
            if ($inventoryTransaction->getProduct()->getId() === $product->getId()) {
                $inventoryTransactions[] = $inventoryTransaction;
            }
        }

        return $inventoryTransactions;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return int
     * @throws EntityNotFoundException
     */
    public function findInventoryIdForProductAndQuantity(Product $product, $quantity)
    {
        $locationsAvailableQuantity = [];
        foreach ($this->findAllByProduct($product) as $inventoryTransaction) {
            $inventoryLocationId = $inventoryTransaction->getInventoryLocation()->getId();

            if (! isset($locationsAvailableQuantity[$inventoryLocationId])) {
                $locationsAvailableQuantity[$inventoryLocationId] = 0;
            }

            $locationsAvailableQuantity[$inventoryLocationId] +=
                ($inventoryTransaction->getCreditQuantity() - $inventoryTransaction->getDebitQuantity()) ;
        }

        asort($locationsAvailableQuantity);

        foreach ($locationsAvailableQuantity as $inventoryLocationId => $availableQuantity) {
            if ($quantity <= $availableQuantity) {
                return $inventoryLocationId;
            }
        }

        throw $this->getEntityNotFoundException();
    }
}
