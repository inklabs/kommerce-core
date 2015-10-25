<?php
namespace inklabs\kommerce\EntityDTO;

class ImageDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $path;
    public $width;
    public $height;
    public $sortOrder;

    /** @var ProductDTO */
    public $product;

    /** @var TagDTO */
    public $tag;
}
