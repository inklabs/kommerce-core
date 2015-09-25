<?php
namespace inklabs\kommerce\EntityDTO;

class OptionProductDTO
{
    public $id;
    public $encodedId;
    public $name;
    public $sku;
    public $shippingWeight;
    public $sortOrder;
    public $created;
    public $updated;

    /** @var ProductDTO */
    public $product;

    /** @var OptionDTO */
    public $option;
}
