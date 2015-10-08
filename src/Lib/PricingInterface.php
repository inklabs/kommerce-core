<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;

interface PricingInterface
{
    public function getDate();

    /**
     * @param Product $product
     * @param int $quantity
     * @return Price
     */
    public function getPrice(Product $product, $quantity);
}
