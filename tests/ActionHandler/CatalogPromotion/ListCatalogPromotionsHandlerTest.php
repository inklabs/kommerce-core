<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\ListCatalogPromotionsQuery;
use inklabs\kommerce\Action\CatalogPromotion\Query\ListCatalogPromotionsRequest;
use inklabs\kommerce\Action\CatalogPromotion\Query\ListCatalogPromotionsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCatalogPromotionsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $catalogPromotionService = $this->mockService->getCatalogPromotionService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'query';
        $request = new ListCatalogPromotionsRequest($queryString, new PaginationDTO);
        $response = new ListCatalogPromotionsResponse;

        $handler = new ListCatalogPromotionsHandler($catalogPromotionService, $dtoBuilderFactory);
        $handler->handle(new ListCatalogPromotionsQuery($request, $response));

        $this->assertTrue($response->getCatalogPromotionDTOs()[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
