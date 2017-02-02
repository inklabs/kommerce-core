<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CatalogPromotion\DeleteCatalogPromotionCommand;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCatalogPromotionHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        CatalogPromotion::class,
        Tag::class,
    ];

    public function testHandle()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $this->persistEntityAndFlushClear($catalogPromotion);
        $command = new DeleteCatalogPromotionCommand(
            $catalogPromotion->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $catalogPromotion = $this->getRepositoryFactory()->getCatalogPromotionRepository()->findOneById(
            $command->getCatalogPromotionId()
        );
    }
}
