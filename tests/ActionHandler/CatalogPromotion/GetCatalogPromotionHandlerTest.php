<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\GetCatalogPromotionQuery;
use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionRequest;
use inklabs\kommerce\Action\CatalogPromotion\Query\GetCatalogPromotionResponse;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCatalogPromotionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotionService = $this->mockService->getCatalogPromotionService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCatalogPromotionRequest($catalogPromotion->getId()->getHex());
        $response = new GetCatalogPromotionResponse();

        $handler = new GetCatalogPromotionHandler($catalogPromotionService, $dtoBuilderFactory);
        $handler->handle(new GetCatalogPromotionQuery($request, $response));

        $this->assertTrue($response->getCatalogPromotionDTO() instanceof CatalogPromotionDTO);
    }
}
