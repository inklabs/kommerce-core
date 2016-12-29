<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\CreateCatalogPromotionCommand;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCatalogPromotionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CatalogPromotion::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);

        $name = '50% OFF Everything';
        $promotionTypeSlug = PromotionType::percent()->getSlug();
        $value = 50;
        $maxRedemptions = 100;
        $reducesTaxSubtotal = true;
        $startAt = self::FAKE_TIMESTAMP;
        $endAt = self::FAKE_TIMESTAMP;

        $command = new CreateCatalogPromotionCommand(
            $name,
            $promotionTypeSlug,
            $value,
            $reducesTaxSubtotal,
            $maxRedemptions,
            $startAt,
            $endAt,
            $tag->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $catalogPromotion = $this->getRepositoryFactory()->getCatalogPromotionRepository()->findOneById(
            $command->getCatalogPromotionId()
        );
        $this->assertSame($name, $catalogPromotion->getName());
        $this->assertSame($promotionTypeSlug, $catalogPromotion->getType()->getSlug());
        $this->assertSame($value, $catalogPromotion->getValue());
        $this->assertSame($maxRedemptions, $catalogPromotion->getMaxRedemptions());
        $this->assertSame($reducesTaxSubtotal, $catalogPromotion->getReducesTaxSubtotal());
        $this->assertSame($startAt, $catalogPromotion->getStartAt());
        $this->assertSame($endAt, $catalogPromotion->getEndAt());
        $this->assertEntitiesEqual($tag, $catalogPromotion->getTag());
    }
}
