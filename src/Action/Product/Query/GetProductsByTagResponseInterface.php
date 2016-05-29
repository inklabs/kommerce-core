<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;

interface GetProductsByTagResponseInterface
{
    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
