<?php
namespace inklabs\kommerce\EntityDTO;

class ProductDTO
{
    use UuidDTOTrait, TimeDTOTrait;

    /** @var string */
    public $slug;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var int */
    public $unitPrice;

    /** @var int */
    public $quantity;

    /** @var bool */
    public $isInventoryRequired;

    /** @var bool */
    public $isPriceVisible;

    /** @var bool */
    public $isActive;

    /** @var bool */
    public $isVisible;

    /** @var bool */
    public $isTaxable;

    /** @var bool */
    public $isShippable;

    /** @var bool */
    public $isInStock;

    /** @var int */
    public $shippingWeight;

    /** @var string */
    public $description;

    /** @var float */
    public $rating;

    /** @var string */
    public $defaultImage;

    /** @var TagDTO[] */
    public $tags = [];

    /** @var ImageDTO[] */
    public $images = [];

    /** @var ImageDTO[] */
    public $tagImages = [];

    /** @var ProductQuantityDiscountDTO[] */
    public $productQuantityDiscounts = [];

    /** @var OptionProductDTO[] */
    public $optionProducts = [];

    /** @var ProductAttributeDTO[] */
    public $productAttributes = [];

    /** @var PriceDTO */
    public $price;
}
