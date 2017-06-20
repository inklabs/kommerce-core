<?php
namespace inklabs\kommerce\ActionResponse\Product;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetProductResponse implements ResponseInterface
{
    /** @var ProductDTOBuilder */
    private $productDTOBuilder;

    /** @var Pricing */
    private $pricing;

    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    public function setProductDTOBuilder(ProductDTOBuilder $productDTOBuilder): void
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getProductDTO(): ProductDTO
    {
        return $this->productDTOBuilder
            ->withPrice($this->pricing)
            ->build();
    }

    public function getProductDTOWithAllData(): ProductDTO
    {
        return $this->productDTOBuilder
            ->withAllData($this->pricing)
            ->build();
    }
}
