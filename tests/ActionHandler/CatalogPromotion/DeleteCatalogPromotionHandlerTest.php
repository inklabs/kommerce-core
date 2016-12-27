<?php
namespace inklabs\kommerce\ActionHandler\CartPriceRule;

use inklabs\kommerce\Action\CatalogPromotion\DeleteCatalogPromotionCommand;
use inklabs\kommerce\ActionHandler\CatalogPromotion\DeleteCatalogPromotionHandler;
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

        $repositoryFactory = $this->getRepositoryFactory();
        $handler = new DeleteCatalogPromotionHandler(
            $repositoryFactory->getCatalogPromotionRepository()
        );
        $handler->handle($command);
        $this->entityManager->clear();

        $this->expectException(EntityNotFoundException::class);

        $catalogPromotion = $repositoryFactory->getCatalogPromotionRepository()
            ->findOneById($command->getCatalogPromotionId());
    }
}
