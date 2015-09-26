<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionValueDTO
{
    public $id;
    public $sku;
    public $optionName;
    public $optionValueName;
    public $created;
    public $updated;

    /** @var OptionValueDTO */
    public $optionValue;
}
