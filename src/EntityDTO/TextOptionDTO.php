<?php
namespace inklabs\kommerce\EntityDTO;

class TextOptionDTO
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
}
