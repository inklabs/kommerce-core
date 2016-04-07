<?php
namespace inklabs\kommerce\EntityDTO;

class TextOptionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var int */
    public $sortOrder;

    /** @var int */
    public $type;

    /** @var TagDTO[] */
    public $tags = [];
}
