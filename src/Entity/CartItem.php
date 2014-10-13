<?php
namespace inklabs\kommerce\Entity;

class CartItem
{
    use Accessors;

    public $id;
    public $product;
    public $quantity;
    public $created;
    public $updated;

    public function __construct(Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}
