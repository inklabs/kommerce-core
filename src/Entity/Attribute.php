<?php
namespace inklabs\kommerce\Entity;

class Attribute
{
    use Accessors;

    public $id;
    public $name;
    public $description;
    public $sort_order;
    public $created;
    public $updated;

    public $attribute_values = [];

    public function addAttributeValue(AttributeValue $attribute_value)
    {
        $this->attribute_values[] = $attribute_value;
    }
}
