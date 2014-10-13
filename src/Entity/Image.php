<?php
namespace inklabs\kommerce\Entity;

class Image
{
    use Accessors;

    public $id;
    public $product_id;
    public $path;
    public $width;
    public $height;
    public $sort_order = 0;
    public $created;
}
