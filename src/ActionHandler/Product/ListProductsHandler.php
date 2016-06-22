<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\ListProductsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\ProductServiceInterface;

final class ListProductsHandler
{
    /** @var ProductServiceInterface */
    private $tagService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ProductServiceInterface $tagService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->tagService = $tagService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListProductsQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagService->getAllProducts(
            $query->getRequest()->getQueryString(),
            $pagination
        );

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($tags as $tag) {
            $query->getResponse()->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($tag)
            );
        }
    }
}
