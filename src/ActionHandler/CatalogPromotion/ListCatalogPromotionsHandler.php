<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\ListCatalogPromotionsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListCatalogPromotionsHandler implements QueryHandlerInterface
{
    /** @var ListCatalogPromotionsQuery */
    private $query;

    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListCatalogPromotionsQuery $query,
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
        $paginationDTO = $this->query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $catalogPromotions = $this->catalogPromotionRepository->getAllCatalogPromotions(
            $this->query->getRequest()->getQueryString(),
            $pagination
        );

        $this->query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($catalogPromotions as $catalogPromotion) {
            $this->query->getResponse()->addCatalogPromotionDTOBuilder(
                $this->dtoBuilderFactory->getCatalogPromotionDTOBuilder($catalogPromotion)
            );
        }
    }
}
