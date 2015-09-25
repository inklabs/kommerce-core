<?php
namespace inklabs\kommerce\EntityDTO;

class OptionValueDTO
{
    public $id;
    public $encodedId;
    public $sortOrder;
    public $name;
    public $sku;
    public $shippingWeight;
    public $created;
    public $updated;

    /** @var OptionDTO */
    public $option;

    /** @var PriceDTO */
    public $price;
}
