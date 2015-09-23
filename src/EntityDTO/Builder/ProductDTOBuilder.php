<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\BaseConvert;
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
        $this->productDTO->encodedId           = BaseConvert::encode($this->product->getId());
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

    public function build()
    {
        return $this->productDTO;
    }
}
