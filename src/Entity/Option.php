<?php
namespace inklabs\kommerce\Entity;

class Option
{
    use Accessors;

    public $id;
    public $name;
    public $type; // select, radio, checkbox, text, textarea, file, date, time, datetime
    public $description;
    public $sort_order;
    public $created;

    public $products = [];

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }
}
