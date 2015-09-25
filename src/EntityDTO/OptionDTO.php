<?php
namespace inklabs\kommerce\EntityDTO;

class OptionDTO
{
    public $id;
    public $encodedId;
    public $name;
    public $description;
    public $sortOrder;
    public $type;
    public $created;
    public $updated;

    /** @var TagDTO[] */
    public $tags = [];

    /** @var OptionProductDTO[] */
    public $optionProducts = [];

    /** @var OptionValueDTO[] */
    public $optionValues = [];
}
