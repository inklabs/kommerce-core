<?php
namespace inklabs\kommerce\Entity;

class Tag
{
    use Accessors;
    use OptionSelector;

    public $id;
    public $name;
    public $description;
    public $default_image;
    public $is_product_group;
    public $sort_order;
    public $visible;
    public $created;
    public $updated;
}
