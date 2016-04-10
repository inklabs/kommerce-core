<?php
namespace inklabs\kommerce\EntityDTO;

class OptionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var int */
    public $sortOrder;

    /** @var OptionTypeDTO */
    public $type;

    /** @var TagDTO[] */
    public $tags = [];

    /** @var OptionProductDTO[] */
    public $optionProducts = [];

    /** @var OptionValueDTO[] */
    public $optionValues = [];
}
