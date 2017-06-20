<?php
namespace inklabs\kommerce\Lib;

use DateTime;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;

interface PricingInterface
{
    public function getDate(): DateTime;
    public function getPrice(Product $product, int $quantity): Price;
}
