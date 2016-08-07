<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use DateTime;
use inklabs\kommerce\Action\Product\CreateProductQuantityDiscountCommand;
use inklabs\kommerce\ActionHandler\Product\CreateProductQuantityDiscountHandler;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateProductQuantityDiscountHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('createProductQuantityDiscount')
            ->once();

        $promotionTypeId = PromotionType::PERCENT;
        $value = 50;
        $reducesTaxSubtotal = true;
        $startDate = new DateTime();
        $endDate = new DateTime();
        $maxRedemptions = 100;
        $productId = self::UUID_HEX;
        $quantity = 10;
        $flagApplyCatalogPromotions = false;

        $command = new CreateProductQuantityDiscountCommand(
            $promotionTypeId,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startDate,
            $endDate,
            $productId,
            $quantity,
            $flagApplyCatalogPromotions
        );

        $handler = new CreateProductQuantityDiscountHandler($productService);
        $handler->handle($command);
    }
}
