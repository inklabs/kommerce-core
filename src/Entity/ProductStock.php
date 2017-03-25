<?php
namespace inklabs\kommerce\Entity;

class ProductStock
{
    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
