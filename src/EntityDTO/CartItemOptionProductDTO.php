<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemOptionProductDTO
{
    public $id;
    public $created;
    public $updated;

    /** @var OptionProductDTO */
    public $optionProduct;
}
