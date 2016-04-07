<?php
namespace inklabs\kommerce\EntityDTO;

class ImageDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $path;

    /** @var int */
    public $width;

    /** @var int */
    public $height;

    /** @var int */
    public $sortOrder;

    /** @var ProductDTO */
    public $product;

    /** @var TagDTO */
    public $tag;
}
