<?php
namespace inklabs\kommerce\EntityDTO;

class ProductDTO
{
    public $id;
    public $encodedId;
    public $slug;
    public $sku;
    public $name;
    public $unitPrice;
    public $quantity;
    public $productGroup;
    public $isInventoryRequired;
    public $isPriceVisible;
    public $isActive;
    public $isVisible;
    public $isTaxable;
    public $isShippable;
    public $shippingWeight;
    public $description;
    public $rating;
    public $defaultImage;
    public $created;
    public $updated;
    public $isInStock;

    /** @var Tag[] */
    public $tags = [];

    /** @var Image[] */
    public $images = [];

    /** @var Image[] */
    public $tagImages = [];

    /** @var ProductQuantityDiscount[] */
    public $productQuantityDiscounts = [];

    /** @var OptionProduct[] */
    public $optionProducts = [];

    /** @var ProductAttribute[] */
    public $productAttributes = [];

    /** @var Price */
    public $price;
}
