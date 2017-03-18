<?php
namespace inklabs\kommerce\ActionResponse\Product;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;

class ListProductsResponse
{
    /** @var ProductDTOBuilder[] */
    private $productDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder)
    {
        $this->productDTOBuilders[] = $productDTOBuilder;
    }

    /**
     * @return ProductDTO[]
     */
    public function getProductDTOs()
    {
        $productDTOs = [];
        foreach ($this->productDTOBuilders as $productDTOBuilder) {
            $productDTOs[] = $productDTOBuilder->build();
        }
        return $productDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
