<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemTextOptionValueDTO
{
    public $id;
    public $textOptionValue;
    public $created;
    public $updated;

    /** @var TextOptionDTO */
    public $textOption;
}
