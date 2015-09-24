<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDiscountDTO
{
    public $id;
    public $quantity;
    public $created;
    public $updated;

    /** @var ProductDTO */
    public $product;
}
