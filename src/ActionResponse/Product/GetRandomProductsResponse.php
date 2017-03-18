<?php
namespace inklabs\kommerce\ActionResponse\Product;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class GetRandomProductsResponse
{
    /** @var ProductDTO[] */
    protected $productDTOs = [];

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder)
    {
        $this->productDTOs[] = $productDTOBuilder
            ->withPrice($this->pricing)
            ->build();
    }

    public function getProductDTOs()
    {
        return $this->productDTOs;
    }
}
