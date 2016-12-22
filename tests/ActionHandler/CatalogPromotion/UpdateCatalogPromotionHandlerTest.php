<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\UpdateCatalogPromotionCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateCatalogPromotionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCatalogPromotionService();
        $couponService->shouldReceive('update')
            ->once();

        $couponDTO = $this->getDTOBuilderFactory()
            ->getCatalogPromotionDTOBuilder($this->dummyData->getCatalogPromotion())
            ->build();

        $command = new UpdateCatalogPromotionCommand($couponDTO);
        $handler = new UpdateCatalogPromotionHandler($couponService);
        $handler->handle($command);
    }
}
