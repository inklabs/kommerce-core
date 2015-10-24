<?php
namespace inklabs\kommerce\EntityDTO;

class TextOptionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $name;
    public $description;
    public $sortOrder;
    public $type;

    /** @var TagDTO[] */
    public $tags = [];
}
