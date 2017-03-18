<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductQuery;
use inklabs\kommerce\ActionResponse\Product\GetProductResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetProductHandler implements QueryHandlerInterface
{
    /** @var GetProductQuery */
    private $query;

    /** @var Pricing */
    private $pricing;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetProductQuery $query,
        Pricing $pricing,
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
        $response = new GetProductResponse($this->pricing);

        $product = $this->productRepository->findOneById(
            $this->query->getProductId()
        );

        $response->setProductDTOBuilder(
            $this->dtoBuilderFactory->getProductDTOBuilder($product)
        );

        return $response;
    }
}
