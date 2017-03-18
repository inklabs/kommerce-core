<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\GetProductsByIdsQuery;
use inklabs\kommerce\ActionResponse\Product\GetProductsByIdsResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetProductsByIdsHandler implements QueryHandlerInterface
{
    /** @var GetProductsByIdsQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetProductsByIdsQuery $query,
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
        $resposne = new GetProductsByIdsResponse($this->pricing);

        $products = $this->productRepository->getProductsByIds(
            $this->query->getProductIds()
        );

        foreach ($products as $product) {
            $resposne->addProductDTOBuilder(
                $this->dtoBuilderFactory->getProductDTOBuilder($product)
            );
        }

        return $resposne;
    }
}
