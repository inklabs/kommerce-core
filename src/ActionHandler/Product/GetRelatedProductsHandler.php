<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRelatedProductsQuery;
use inklabs\kommerce\ActionResponse\Product\GetRelatedProductsResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetRelatedProductsHandler implements QueryHandlerInterface
{
    /** @var GetRelatedProductsQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetRelatedProductsQuery $query,
        PricingInterface $pricing,
        ProductRepositoryInterface $productRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->pricing = $pricing;
        $this->productRepository = $productRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new GetRelatedProductsResponse($this->pricing);

        $products = $this->productRepository->getRelatedProductsByIds(
            $this->query->getProductIds(),
            $this->query->getLimit()
        );

        foreach ($products as $product) {
            $response->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }

        return $response;
    }
}
