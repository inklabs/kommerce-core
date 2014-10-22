<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service as Service;

class Product
{
    use Accessor\Time;
    use OptionSelector;

    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $quantity;
    protected $productGroup;
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

    private $quantityDiscounts = [];
    private $priceObj;

    public function __construct()
    {
        $this->setCreated();
        $this->tags = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function setPriceObj($priceObj)
    {
        $this->priceObj = $priceObj;
    }

    public function getPriceObj()
    {
        return $this->priceObj;
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

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
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

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addImage($image)
    {
        $this->images[] = $image;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts[] = $quantityDiscount;
    }

    public function getQuantityDiscounts()
    {
        return $this->quantityDiscounts;
    }

    public function getData()
    {
        $class = new \stdClass;
        $class->id                  = $this->getId();
        $class->encodedId           = Service\BaseConvert::encode($this->getId());
        $class->sku                 = $this->getSku();
        $class->name                = $this->getName();
        $class->price               = $this->getPrice();
        $class->quantity            = $this->getQuantity();
        $class->isInventoryRequired = $this->getIsInventoryRequired();
        $class->isPriceVisible      = $this->getIsPriceVisible();
        $class->isVisible           = $this->getIsVisible();
        $class->isActive            = $this->getIsActive();
        $class->isTaxable           = $this->getIsTaxable();
        $class->isShippable         = $this->getIsShippable();
        $class->shippingWeight      = $this->getShippingWeight();
        $class->description         = $this->getDescription();
        $class->rating              = $this->getRating();
        $class->defaultImage        = $this->getDefaultImage();

        $class->isInStock = $this->inStock();

        $class->priceObj = $this->getPriceObj();
        if (! empty($class->priceObj)) {
            $class->priceObj = $class->priceObj->getData();
        }

        return $class;
    }

    public function getAllData()
    {
        $class = $this->getData();

        $class->priceObj = $this->getPriceObj();
        if (! empty($class->priceObj)) {
            $class->priceObj = $class->priceObj->getAllData();
        }

        $class->tags = [];
        foreach ($this->getTags() as $tag) {
            $class->tags[] = $tag->getData();
        }

        $class->images = [];
        foreach ($this->getImages() as $image) {
            $class->images[] = $image->getData();
        }

        return $class;
    }
}
