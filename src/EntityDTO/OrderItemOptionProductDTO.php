<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionProductDTO
{
    public $id;
    public $sku;
    public $optionName;
    public $optionProductName;
    public $created;
    public $updated;

    /** @var OptionProductDTO */
    public $optionProduct;
}
