<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class GetProductsByTagResponse implements GetProductsByTagResponseInterface
{
    /** @var ProductDTO[] */
    protected $productDTOs = [];

    /** @var PaginationDTO */
    protected $paginationDTO;

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

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTO = $paginationDTOBuilder
            ->build();
    }

    public function getProductDTOs()
    {
        return $this->productDTOs;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
