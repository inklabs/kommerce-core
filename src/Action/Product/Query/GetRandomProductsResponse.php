<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class GetRandomProductsResponse implements GetRandomProductsResponseInterface
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
