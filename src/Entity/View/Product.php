<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

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

    /* @var Tag[] */
    public $tags = [];

    /* @var Image[] */
    public $images = [];

    /* @var Image[] */
    public $tagImages = [];

    /* @var ProductQuantityDiscount[] */
    public $productQuantityDiscounts = [];

    /* @var Price */
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

    public function withTagsWithImages()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->withImages()
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

    public function withPrice(Pricing $pricing)
    {
        $this->price = $this->product->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProductQuantityDiscounts(Pricing $pricing)
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

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->withPrice($pricing)
            ->withImages();
    }
}
