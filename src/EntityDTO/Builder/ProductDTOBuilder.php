<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Slug;

class ProductDTOBuilder
{
    /** @var Product */
    protected $product;

    /** @var ProductDTO */
    protected $productDTO;

    public function __construct(Product $product)
    {
        $this->product = $product;

        $this->productDTO = new ProductDTO;
        $this->productDTO->id                  = $this->product->getId();
        $this->productDTO->slug                = Slug::get($this->product->getName());
        $this->productDTO->sku                 = $this->product->getSku();
        $this->productDTO->name                = $this->product->getName();
        $this->productDTO->unitPrice           = $this->product->getUnitPrice();
        $this->productDTO->quantity            = $this->product->getQuantity();
        $this->productDTO->isInventoryRequired = $this->product->isInventoryRequired();
        $this->productDTO->isPriceVisible      = $this->product->isPriceVisible();
        $this->productDTO->isVisible           = $this->product->isVisible();
        $this->productDTO->isActive            = $this->product->isActive();
        $this->productDTO->isTaxable           = $this->product->isTaxable();
        $this->productDTO->isShippable         = $this->product->isShippable();
        $this->productDTO->shippingWeight      = $this->product->getShippingWeight();
        $this->productDTO->description         = $this->product->getDescription();
        $this->productDTO->rating              = $this->product->getRating();
        $this->productDTO->defaultImage        = $this->product->getDefaultImage();
        $this->productDTO->created             = $this->product->getCreated();
        $this->productDTO->updated             = $this->product->getUpdated();

        $this->productDTO->isInStock = $this->product->inStock();
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->productDTO->tags[] = $tag->getDTOBuilder()
                ->withImages()
                ->build();
        }

        return $this;
    }

    public function withTagsAndOptions(PricingInterface $pricing)
    {
        foreach ($this->product->getTags() as $tag) {
            $this->productDTO->tags[] = $tag->getDTOBuilder()
                ->withImages()
                ->withOptions($pricing)
                ->withTextOptions()
                ->build();
        }

        return $this;
    }

    public function withImages()
    {
        foreach ($this->product->getImages() as $image) {
            $this->productDTO->images[] = $image->getDTOBuilder()
                ->build();
        }

        foreach ($this->product->getTags() as $tag) {
            foreach ($tag->getImages() as $image) {
                $this->productDTO->tagImages[] = $image->getDTOBuilder()
                    ->build();
            }
        }

        return $this;
    }

    public function withPrice(PricingInterface $pricing)
    {
        $this->productDTO->price = $this->product->getPrice($pricing)->getDTOBuilder()
            ->withAllData()
            ->build();

        return $this;
    }

    public function withProductQuantityDiscounts(Pricing $pricing)
    {
        $productQuantityDiscounts = $this->product->getProductQuantityDiscounts();
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $this->productDTO->productQuantityDiscounts[] = $productQuantityDiscount->getDTOBuilder()
                ->withPrice($pricing)
                ->build();
        }

        return $this;
    }

    public function withOptionProducts()
    {
        foreach ($this->product->getOptionProducts() as $optionProduct) {
            $this->productDTO->optionProducts[] = $optionProduct->getDTOBuilder()
                ->withOption()
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->product->getProductAttributes() as $productAttribute) {
            $this->productDTO->productAttributes[] = $productAttribute->getDTOBuilder()
                ->withAttribute()
                ->withAttributeValue()
                ->build();
        }

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withTagsAndOptions($pricing)
            ->withProductQuantityDiscounts($pricing)
            ->withPrice($pricing)
            ->withImages()
            ->withProductAttributes()
            ->withOptionProducts();
    }

    public function build()
    {
        return $this->productDTO;
    }
}
