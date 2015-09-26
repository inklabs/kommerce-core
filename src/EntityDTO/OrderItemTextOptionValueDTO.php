<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemTextOptionValueDTO
{
    public $id;
    public $textOptionName;
    public $textOptionValue;
    public $created;
    public $updated;

    /** @var TextOptionDTO */
    public $textOption;
}
