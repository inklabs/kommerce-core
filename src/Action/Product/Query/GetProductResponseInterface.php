<?php
namespace inklabs\kommerce\Action\Product\Query;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;

interface GetProductResponseInterface
{
    public function setProductDTOBuilder(ProductDTOBuilder $productDTOBuilder);
}
