<?php
namespace inklabs\kommerce\Entity;

class AttributeValue
{
    use Accessors;

    public $id;
    public $sku;
    public $name;
    public $description;
    public $sort_order;
    public $created;
    public $updated;
}
