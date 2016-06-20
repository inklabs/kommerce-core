<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;

interface GetProductsByIdsResponseInterface
{
    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder);
}
