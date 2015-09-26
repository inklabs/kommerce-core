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
    public $isInStock;
    public $created;
    public $updated;

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
