<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetRandomProductsQuery;
use inklabs\kommerce\ActionResponse\Product\GetRandomProductsResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetRandomProductsHandler implements QueryHandlerInterface
{
    /** @var GetRandomProductsQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetRandomProductsQuery $query,
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
        $response = new GetRandomProductsResponse($this->pricing);

        $products = $this->productRepository->getRandomProducts(
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
