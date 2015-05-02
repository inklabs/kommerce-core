<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity;

interface PricingInterface
{
    public function getDate();

    /**
     * @param Entity\Product $product
     * @param int $quantity
     * @return Entity\Price
     */
    public function getPrice(Entity\Product $product, $quantity);
}
