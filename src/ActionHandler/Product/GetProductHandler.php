<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class GetProductHandler
{
    /** @var ProductServiceInterface */
    private $productService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ProductServiceInterface $productService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->productService = $productService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetProductQuery $query)
    {
        $product = $this->productService->findOneById(
            $query->getRequest()->getProductId()
        );

        $query->getResponse()->setProductDTOBuilder(
            $this->dtoBuilderFactory->getProductDTOBuilder($product)
        );
    }
}
