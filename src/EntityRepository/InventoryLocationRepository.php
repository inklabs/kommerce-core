<?php
namespace inklabs\kommerce\EntityRepository;

use Generator;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductStock;
use inklabs\kommerce\Lib\UuidInterface;

class InventoryLocationRepository extends AbstractRepository implements InventoryLocationRepositoryInterface
{
    public function listProductStockForInventoryLocation(
        UuidInterface $inventoryLocationId,
        Pagination & $pagination
    ): Generator {
        $results = $this->getQueryBuilder()
            ->select('Product AS product')
            ->addSelect('SUM(InventoryTransaction.quantity) AS quantity')
            ->from(Product::class, 'Product')
            ->leftJoin(
                InventoryTransaction::class,
                'InventoryTransaction',
                'WITH',
                'InventoryTransaction.product = Product.id'
            )
            ->where('InventoryTransaction.inventoryLocation = :inventoryLocationId')
            ->setIdParameter('inventoryLocationId', $inventoryLocationId)
            ->orderBy('Product.sku')
            ->groupBy('Product.id')
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            yield new ProductStock($result['product'], $result['quantity']);
        }
    }
}
