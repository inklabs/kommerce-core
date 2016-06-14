<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByTagQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class GetProductsByTagHandler
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

    public function handle(GetProductsByTagQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $products = $this->productService->getProductsByTagId($query->getRequest()->getTagId(), $pagination);

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($products as $product) {
            $query->getResponse()->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }
    }
}
