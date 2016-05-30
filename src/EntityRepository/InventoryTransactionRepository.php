<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InventoryTransactionRepository extends AbstractRepository implements InventoryTransactionRepositoryInterface
{
    /**
     * @param Product $product
     * @return InventoryTransaction[]
     */
    public function findAllByProduct(Product $product)
    {
        return $this->getQueryBuilder()
            ->select('InventoryTransaction')
            ->from(InventoryTransaction::class, 'InventoryTransaction')
            ->where('InventoryTransaction.product = :productId')
            ->setIdParameter('productId', $product->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return UuidInterface
     * @throws EntityNotFoundException
     */
    public function findInventoryIdForProductAndQuantity(Product $product, $quantity)
    {
        $locationsAvailableQuantity = [];
        foreach ($this->findAllByProduct($product) as $inventoryTransaction) {
            $inventoryLocationId = $inventoryTransaction->getInventoryLocation()->getId()->toString();

            if (! isset($locationsAvailableQuantity[$inventoryLocationId])) {
                $locationsAvailableQuantity[$inventoryLocationId] = 0;
            }

            $locationsAvailableQuantity[$inventoryLocationId] += $inventoryTransaction->getQuantity();
        }

        asort($locationsAvailableQuantity);

        foreach ($locationsAvailableQuantity as $inventoryLocationId => $availableQuantity) {
            if ($quantity <= $availableQuantity) {
                return Uuid::fromString($inventoryLocationId);
            }
        }

        throw $this->getEntityNotFoundException();
    }
}
