<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemTextOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $textOptionName;
    public $textOptionValue;

    /** @var TextOptionDTO */
    public $textOption;
}
