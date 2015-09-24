<?php
namespace inklabs\kommerce\EntityDTO;

class TagDTO
{
    public $id;
    public $encodedId;
    public $slug;
    public $name;
    public $code;
    public $description;
    public $defaultImage;
    public $sortOrder;
    public $isVisible;
    public $isActive;
    public $created;
    public $updated;

    /** @var ProductDTO[] */
    public $products = [];

    /** @var ImageDTO[] */
    public $images = [];

    /** @var OptionDTO[] */
    public $options = [];

    /** @var TextOptionDTO[] */
    public $textOptions = [];
}
