<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service\Pricing;

class Product
{
    use Accessor\Time;
    use OptionSelector;

    protected $id;
    protected $sku;
    protected $name;
    protected $unitPrice;
    protected $quantity;
    protected $isInventoryRequired;
    protected $isPriceVisible;
    protected $isActive;
    protected $isVisible;
    protected $isTaxable;
    protected $isShippable;
    protected $shippingWeight;
    protected $description;
    protected $rating;
    protected $defaultImage;

    protected $tags;
    protected $images;
    protected $productQuantityDiscounts;

    public function __construct()
    {
        $this->setCreated();
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->productQuantityDiscounts = new ArrayCollection();
    }

    public function getPrice(Pricing $pricing, $quantity = 1)
    {
        return $pricing->getPrice(
            $this,
            $quantity
        );
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setIsInventoryRequired($isInventoryRequired)
    {
        $this->isInventoryRequired = $isInventoryRequired;
    }

    public function getIsInventoryRequired()
    {
        return $this->isInventoryRequired;
    }

    public function setIsPriceVisible($isPriceVisible)
    {
        $this->isPriceVisible = $isPriceVisible;
    }

    public function getIsPriceVisible()
    {
        return $this->isPriceVisible;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function setIsShippable($isShippable)
    {
        $this->isShippable = $isShippable;
    }

    public function getIsShippable()
    {
        return $this->isShippable;
    }

    public function setShippingWeight($shippingWeight)
    {
        $this->shippingWeight = $shippingWeight;
    }

    public function getShippingWeight()
    {
        return $this->shippingWeight;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDefaultImage($defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }

    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = $isTaxable;
    }

    public function getIsTaxable()
    {
        return $this->isTaxable;
    }

    public function setRating($rating)
    {
        return $this->rating = $rating;
    }

    public function getRating()
    {
        return ($this->rating / 100);
    }

    public function inStock()
    {
        if (($this->isInventoryRequired and $this->quantity > 0) or ( ! $this->isInventoryRequired)) {
            return true;
        } else {
            return false;
        }
    }

    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }
}
