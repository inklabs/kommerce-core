<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use DateTime;
use inklabs\kommerce\Action\Product\CreateProductQuantityDiscountCommand;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateProductQuantityDiscountHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        ProductQuantityDiscount::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);
        $promotionTypeId = PromotionType::PERCENT;
        $value = 50;
        $reducesTaxSubtotal = true;
        $startDate = new DateTime();
        $endDate = new DateTime();
        $maxRedemptions = 100;
        $quantity = 10;
        $flagApplyCatalogPromotions = false;
        $command = new CreateProductQuantityDiscountCommand(
            $promotionTypeId,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startDate,
            $endDate,
            $product->getId()->getHex(),
            $quantity,
            $flagApplyCatalogPromotions
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $productQuantityDiscount = $this->getRepositoryFactory()->getProductQuantityDiscountRepository()->findOneById(
            $command->getProductQuantityDiscountId()
        );
        $this->assertSame($promotionTypeId, $productQuantityDiscount->getType()->getId());
        $this->assertSame($value, $productQuantityDiscount->getValue());
        $this->assertSame($reducesTaxSubtotal, $productQuantityDiscount->getReducesTaxSubtotal());
        $this->assertSame($quantity, $productQuantityDiscount->getQuantity());
        $this->assertSame($flagApplyCatalogPromotions, $productQuantityDiscount->getFlagApplyCatalogPromotions());
        // TODO: Fix these:
        //$this->assertSame($maxRedemptions, $productQuantityDiscount->getMaxRedemptions());
        //$this->assertSame($startDate->getTimestamp(), $productQuantityDiscount->getStart()->getTimestamp());
        //$this->assertSame($endDate->getTimestamp(), $productQuantityDiscount->getEnd()->getTimestamp());
    }
}
