<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Product implements ViewInterface
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
        $this->isInventoryRequired = $product->isInventoryRequired();
        $this->isPriceVisible      = $product->isPriceVisible();
        $this->isVisible           = $product->isVisible();
        $this->isActive            = $product->isActive();
        $this->isTaxable           = $product->isTaxable();
        $this->isShippable         = $product->isShippable();
        $this->shippingWeight      = $product->getShippingWeight();
        $this->description         = $product->getDescription();
        $this->rating              = $product->getRating();
        $this->defaultImage        = $product->getDefaultImage();
        $this->created             = $product->getCreated();
        $this->updated             = $product->getUpdated();

        $this->isInStock = $product->inStock();
    }

    public function export()
    {
        unset($this->product);
        return $this;
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->withImages()
                ->export();
        }
        return $this;
    }

    public function withTagsAndOptions(Lib\PricingInterface $pricing)
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->withImages()
                ->withOptions($pricing)
                ->withTextOptions()
                ->export();
        }
        return $this;
    }

    public function withImages()
    {
        foreach ($this->product->getImages() as $image) {
            $this->images[] = $image->getView()
                ->export();
        }

        foreach ($this->product->getTags() as $tag) {
            foreach ($tag->getImages() as $image) {
                $this->tagImages[] = $image->getView()
                    ->export();
            }
        }

        return $this;
    }

    public function withPrice(Lib\PricingInterface $pricing)
    {
        $this->price = $this->product->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProductQuantityDiscounts(Lib\PricingInterface $pricing)
    {
        $productQuantityDiscounts = $this->product->getProductQuantityDiscounts();
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $productQuantityDiscount->setProduct($this->product);
            $this->productQuantityDiscounts[] = $productQuantityDiscount->getView()
                ->withPrice($pricing)
                ->export();
        }

        return $this;
    }

    public function withOptionProducts()
    {
        foreach ($this->product->getOptionProducts() as $optionProduct) {
            $this->optionProducts[] = $optionProduct->getView()
                ->withOption()
                ->export();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->product->getProductAttributes() as $productAttribute) {
            $this->productAttributes[] = $productAttribute->getView()
                ->withAttribute()
                ->withAttributeValue()
                ->export();
        }

        return $this;
    }

    public function withAllData(Lib\PricingInterface $pricing)
    {
        return $this
            ->withTagsAndOptions($pricing)
            ->withProductQuantityDiscounts($pricing)
            ->withPrice($pricing)
            ->withImages()
            ->withProductAttributes()
            ->withOptionProducts();
    }
}
