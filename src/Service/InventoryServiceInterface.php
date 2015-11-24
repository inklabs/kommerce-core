<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Product;

interface InventoryServiceInterface
{
    /**
     * @param Product $product
     * @param int $quantity
     */
    public function reserveProduct(Product $product, $quantity);
}
