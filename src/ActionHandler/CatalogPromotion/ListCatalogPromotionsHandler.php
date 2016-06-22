<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\ListCatalogPromotionsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\CatalogPromotionServiceInterface;

final class ListCatalogPromotionsHandler
{
    /** @var CatalogPromotionServiceInterface */
    private $catalogPromotionService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CatalogPromotionServiceInterface $catalogPromotionService,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->catalogPromotionService = $catalogPromotionService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListCatalogPromotionsQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotions(
            $query->getRequest()->getQueryString(),
            $pagination
        );

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($catalogPromotions as $catalogPromotion) {
            $query->getResponse()->addCatalogPromotionDTOBuilder(
                $this->dtoBuilderFactory->getCatalogPromotionDTOBuilder($catalogPromotion)
            );
        }
    }
}
