<?php
namespace inklabs\kommerce\EntityDTO;

class OptionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $name;
    public $description;
    public $sortOrder;
    public $type;

    /** @var TagDTO[] */
    public $tags = [];

    /** @var OptionProductDTO[] */
    public $optionProducts = [];

    /** @var OptionValueDTO[] */
    public $optionValues = [];
}
