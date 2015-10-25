<?php
namespace inklabs\kommerce\EntityDTO;

class TagDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $slug;
    public $name;
    public $code;
    public $description;
    public $defaultImage;
    public $sortOrder;
    public $isVisible;
    public $isActive;

    /** @var ProductDTO[] */
    public $products = [];

    /** @var ImageDTO[] */
    public $images = [];

    /** @var OptionDTO[] */
    public $options = [];

    /** @var TextOptionDTO[] */
    public $textOptions = [];
}
