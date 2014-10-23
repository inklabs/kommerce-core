<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Service as Service;

class Product
{
    private $product;

    public $id;
    public $sku;
    public $name;
    public $price;
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

    public $tags = [];
    public $images = [];

    public $quantityDiscounts = [];
    public $priceObj;

    public function __construct($product)
    {
        $this->product = $product;

        $this->id                  = $product->getId();
        $this->encodedId           = Service\BaseConvert::encode($product->getId());
        $this->sku                 = $product->getSku();
        $this->name                = $product->getName();
        $this->price               = $product->getPrice();
        $this->quantity            = $product->getQuantity();
        $this->isInventoryRequired = $product->getIsInventoryRequired();
        $this->isPriceVisible      = $product->getIsPriceVisible();
        $this->isVisible           = $product->getIsVisible();
        $this->isActive            = $product->getIsActive();
        $this->isTaxable           = $product->getIsTaxable();
        $this->isShippable         = $product->getIsShippable();
        $this->shippingWeight      = $product->getShippingWeight();
        $this->description         = $product->getDescription();
        $this->rating              = $product->getRating();
        $this->defaultImage        = $product->getDefaultImage();

        $this->isInStock = $product->inStock();

        return $this;
    }

    public function withPriceObj()
    {
        $this->priceObj = $this->product->getPriceObj();
        if (! empty($this->priceObj)) {
            $this->priceObj = $this->priceObj->getData();
        }
        return $this;
    }

    public function withAllPriceObj()
    {
        $this->priceObj = $this->product->getPriceObj();
        if (! empty($this->priceObj)) {
            $this->priceObj = $this->priceObj->getAllData();
        }
        return $this;
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag->getData();
        }
        return $this;
    }

    public function withImages()
    {
        foreach ($this->product->getImages() as $image) {
            $this->images[] = $image->getData();
        }
        return $this;
    }

    public function getAllData()
    {
        return $this
            ->withAllPriceObj()
            ->withTags()
            ->withImages();
    }
}
