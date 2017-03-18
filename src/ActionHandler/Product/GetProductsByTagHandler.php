<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByTagQuery;
use inklabs\kommerce\ActionResponse\Product\GetProductsByTagResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetProductsByTagHandler implements QueryHandlerInterface
{
    /** @var GetProductsByTagQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetProductsByTagQuery $query,
        PricingInterface $pricing,
        ProductRepositoryInterface $productRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->pricing = $pricing;
        $this->productRepository = $productRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new GetProductsByTagResponse($this->pricing);

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $products = $this->productRepository->getProductsByTagId($this->query->getTagId(), $pagination);

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($products as $product) {
            $response->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }

        return $response;
    }
}
