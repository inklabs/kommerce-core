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

    /**
     * @param Product $product
     * @param int $quantity
     * @return UuidInterface
     */
    public function findInventoryIdWithAvailableQuantityForProduct(Product $product, $quantity);

    /**
     * @param UuidInterface $inventoryLocationId
     * @param Pagination|null $pagination
     * @return InventoryTransaction[]
     */
    public function listByInventoryLocation(UuidInterface $inventoryLocationId, Pagination & $pagination = null);
}
