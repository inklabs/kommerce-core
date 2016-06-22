<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;

interface ListProductsResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder);
}
