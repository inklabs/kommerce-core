<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemOptionValueDTO
{
    public $id;
    public $created;
    public $updated;

    /** @var OptionValueDTO */
    public $optionValue;
}
