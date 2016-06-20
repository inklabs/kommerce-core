<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByIdsQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class GetProductsByIdsHandler
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

    public function handle(GetProductsByIdsQuery $query)
    {
        $products = $this->productService->getProductsByIds(
            $query->getRequest()->getProductIds()
        );

        foreach ($products as $product) {
            $query->getResponse()->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }
    }
}
