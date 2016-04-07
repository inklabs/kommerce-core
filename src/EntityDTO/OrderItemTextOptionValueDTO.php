<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemTextOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $textOptionName;

    /** @var string */
    public $textOptionValue;

    /** @var TextOptionDTO */
    public $textOption;
}
