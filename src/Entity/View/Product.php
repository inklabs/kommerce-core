<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class Product
{
    private $product;

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
    public $tags = [];
    public $images = [];
    public $productQuantityDiscounts = [];
    public $price;

    public function __construct(Entity\Product $product)
    {
        $this->product = $product;

        $this->id                  = $product->getId();
        $this->encodedId           = Service\BaseConvert::encode($product->getId());
        $this->slug                = Service\Slug::get($product->getName());
        $this->sku                 = $product->getSku();
        $this->name                = $product->getName();
        $this->unitPrice           = $product->getUnitPrice();
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
        $this->created             = $product->getCreated();
        $this->updated             = $product->getUpdated();

        $this->isInStock = $product->inStock();

        return $this;
    }

    public function export()
    {
        unset($this->product);
        return $this;
    }

    public function withPrice()
    {
        // $this->price = $this->product->getPrice();
        if (! empty($this->price)) {
            $this->price = $this->price
                ->getView()
                ->withAllData()
                ->export();
        }
        return $this;
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag
                ->getView()
                ->export();
        }
        return $this;
    }

    public function withTagsWithImages()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag
                ->getView()
                ->withImages()
                ->export();
        }
        return $this;
    }

    public function withImages()
    {
        foreach ($this->product->getImages() as $image) {
            $this->images[] = $image
                ->getView()
                ->export();
        }
        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->product->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->productQuantityDiscounts[] = $productQuantityDiscount
                ->getView()
                ->withPrice()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTags()
            ->withProductQuantityDiscounts()
            ->withPrice()
            ->withImages();
    }
}
