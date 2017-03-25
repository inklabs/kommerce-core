<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductStock;

class InventoryLocationRepository extends AbstractRepository implements InventoryLocationRepositoryInterface
{
    public function listProductStockForInventoryLocation($inventoryLocationId, Pagination & $pagination)
    {
        $results = $this->getQueryBuilder()
            ->select('Product AS product')
            ->addSelect('SUM(InventoryTransaction.creditQuantity) AS credit')
            ->addSelect('SUM(InventoryTransaction.debitQuantity) AS debit')
            ->addSelect(
                '0 + COALESCE(SUM(InventoryTransaction.creditQuantity), 0) ' .
                '- COALESCE(SUM(InventoryTransaction.debitQuantity), 0) AS quantity'
            )
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
