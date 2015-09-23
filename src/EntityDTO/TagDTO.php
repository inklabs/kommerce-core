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

    /** @var Product[] */
    public $products = [];

    /** @var Image[] */
    public $images = [];

    /** @var Option[] */
    public $options = [];

    /** @var TextOption[] */
    public $textOptions = [];
}
