<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\GetCatalogPromotionQuery;
use inklabs\kommerce\ActionResponse\CatalogPromotion\GetCatalogPromotionResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCatalogPromotionHandler implements QueryHandlerInterface
{
    /** @var GetCatalogPromotionQuery */
    private $query;

    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCatalogPromotionQuery $query,
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetCatalogPromotionResponse();

        $catalogPromotion = $this->catalogPromotionRepository->findOneById(
            $this->query->getCatalogPromotionId()
        );

        $response->setCatalogPromotionDTOBuilder(
            $this->dtoBuilderFactory->getCatalogPromotionDTOBuilder($catalogPromotion)
        );

        return $response;
    }
}
