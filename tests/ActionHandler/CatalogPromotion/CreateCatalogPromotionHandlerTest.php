<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use DateTime;
use inklabs\kommerce\Action\CatalogPromotion\CreateCatalogPromotionCommand;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCatalogPromotionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $catalogPromotionService = $this->mockService->getCatalogPromotionService();
        $catalogPromotionService->shouldReceive('create')
            ->once();

        $tagService = $this->mockService->getTagService();

        $name = '50% OFF Everything';
        $promotionTypeId = PromotionType::PERCENT;
        $value = 50;
        $reducesTaxSubtotal = true;
        $startDate = new DateTime();
        $endDate = new DateTime();
        $maxRedemptions = 100;
        $tagId = self::UUID_HEX;

        $command = new CreateCatalogPromotionCommand(
            $name,
            $promotionTypeId,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startDate,
            $endDate,
            $tagId
        );
        $handler = new CreateCatalogPromotionHandler($catalogPromotionService, $tagService);
        $handler->handle($command);
    }
}
