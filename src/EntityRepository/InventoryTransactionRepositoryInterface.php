<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method InventoryTransaction findOneById(UuidInterface $id)
 */
interface InventoryTransactionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param Product $product
     * @return InventoryTransaction[]
     */
    public function findAllByProduct(Product $product);

    public function findInventoryIdWithAvailableQuantityForProduct(Product $product, int $quantity): UuidInterface;

    /**
     * @param UuidInterface $inventoryLocationId
     * @param Pagination|null $pagination
     * @return InventoryTransaction[]
     */
    public function listByInventoryLocation(UuidInterface $inventoryLocationId, Pagination & $pagination = null);
}
