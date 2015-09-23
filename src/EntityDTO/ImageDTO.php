<?php
namespace inklabs\kommerce\EntityDTO;

class ImageDTO
{
    public $id;
    public $encodedId;
    public $path;
    public $width;
    public $height;
    public $sortOrder;
    public $created;
    public $updated;

    /** @var ProductDTO */
    public $product;

    /** @var TagDTO */
    public $tag;
}
