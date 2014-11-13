<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Product
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
    public $tags = [];
    public $images = [];
    public $productQuantityDiscounts = [];
    public $price;

    public function __construct(Entity\Product $product)
    {
        $this->product = $product;

        $this->id                  = $product->getId();
        $this->encodedId           = Lib\BaseConvert::encode($product->getId());
        $this->slug                = Lib\Slug::get($product->getName());
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

    public static function factory(Entity\Product $product)
    {
        return new static($product);
    }

    public function export()
    {
        unset($this->product);
        return $this;
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = Tag::factory($tag)
                ->export();
        }
        return $this;
    }

    public function withTagsWithImages()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = Tag::factory($tag)
                ->withImages()
                ->export();
        }
        return $this;
    }

    public function withImages()
    {
        foreach ($this->product->getImages() as $image) {
            $this->images[] = Image::factory($image)
                ->export();
        }
        return $this;
    }

    public function withPrice(\inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->price = Price::factory($this->product->getPrice($pricing))
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProductQuantityDiscounts(\inklabs\kommerce\Service\Pricing $pricing)
    {
        $productQuantityDiscounts = $this->product->getProductQuantityDiscounts();
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $productQuantityDiscount->setProduct($this->product);
            $this->productQuantityDiscounts[] = ProductQuantityDiscount::factory($productQuantityDiscount)
                ->withPrice($pricing)
                ->export();
        }

        return $this;
    }

    public function withAllData(\inklabs\kommerce\Service\Pricing $pricing)
    {
        return $this
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->withPrice($pricing)
            ->withImages();
    }
}
