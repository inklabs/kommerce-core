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

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Product $product, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->product = $product;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->initializeProductDTO();
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

    protected function initializeProductDTO()
    {
        $this->productDTO = new ProductDTO;
    }

    public function withTags()
    {
        foreach ($this->product->getTags() as $tag) {
            $this->productDTO->tags[] = $this->dtoBuilderFactory->getTagDTOBuilder($tag)
                ->withImages()
                ->build();
        }

        return $this;
    }

    public function withTagsAndOptions(PricingInterface $pricing)
    {
        foreach ($this->product->getTags() as $tag) {
            $this->productDTO->tags[] = $this->dtoBuilderFactory->getTagDTOBuilder($tag)
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
            $this->productDTO->images[] = $this->dtoBuilderFactory->getImageDTOBuilder($image)
                ->build();
        }

        foreach ($this->product->getTags() as $tag) {
            foreach ($tag->getImages() as $image) {
                $this->productDTO->tagImages[] = $this->dtoBuilderFactory->getImageDTOBuilder($image)
                    ->build();
            }
        }

        return $this;
    }

    public function withPrice(PricingInterface $pricing)
    {
        $this->productDTO->price = $this->dtoBuilderFactory->getPriceDTOBuilder($this->product->getPrice($pricing))
            ->withAllData()
            ->build();

        return $this;
    }

    public function withProductQuantityDiscounts(Pricing $pricing)
    {
        $productQuantityDiscounts = $this->product->getProductQuantityDiscounts();
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        foreach ($productQuantityDiscounts as $productQuantityDiscount) {
            $this->productDTO->productQuantityDiscounts[] = $this->dtoBuilderFactory
                ->getProductQuantityDiscountDTOBuilder($productQuantityDiscount)
                    ->withPrice($pricing)
                    ->build();
        }

        return $this;
    }

    public function withOptionProducts()
    {
        foreach ($this->product->getOptionProducts() as $optionProduct) {
            $this->productDTO->optionProducts[] = $this->dtoBuilderFactory
                ->getOptionProductDTOBuilder($optionProduct)
                    ->withOption()
                    ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->product->getProductAttributes() as $productAttribute) {
            $this->productDTO->productAttributes[] = $this->dtoBuilderFactory
                ->getProductAttributeDTOBuilder($productAttribute)
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->product);
        return $this->productDTO;
    }
}
