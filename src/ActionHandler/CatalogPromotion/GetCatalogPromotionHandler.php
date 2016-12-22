<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\GetCatalogPromotionQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CatalogPromotionServiceInterface;

final class GetCatalogPromotionHandler
{
    /** @var CatalogPromotionServiceInterface */
    private $catalogPromotionService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(CatalogPromotionServiceInterface $catalogPromotionService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->catalogPromotionService = $catalogPromotionService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetCatalogPromotionQuery $query)
    {
        $catalogPromotion = $this->catalogPromotionService->findOneById(
            $query->getRequest()->getCatalogPromotionId()
        );

        $query->getResponse()->setCatalogPromotionDTOBuilder(
            $this->dtoBuilderFactory->getCatalogPromotionDTOBuilder($catalogPromotion)
        );
    }
}
