<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRelatedProductsQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class GetRelatedProductsHandler
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

    public function handle(GetRelatedProductsQuery $query)
    {
        $products = $this->productService->getRelatedProductsByIds(
            $query->getRequest()->getProductIds(),
            $query->getRequest()->getLimit()
        );

        foreach ($products as $product) {
            $query->getResponse()->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }
    }
}
