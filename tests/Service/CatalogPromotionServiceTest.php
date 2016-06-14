<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCatalogPromotionRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class CatalogPromotionServiceTest extends ServiceTestCase
{
    /** @var CatalogPromotionRepositoryInterface | \Mockery\Mock */
    protected $catalogPromotionRepository;

    /** @var CatalogPromotionService */
    protected $catalogPromotionService;

    public function setUp()
    {
        parent::setUp();

        $this->catalogPromotionRepository = $this->mockRepository->getCatalogPromotionRepository();
        $this->catalogPromotionService = new CatalogPromotionService($this->catalogPromotionRepository);
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->catalogPromotionService,
            $this->catalogPromotionRepository,
            $this->dummyData->getCatalogPromotion()
        );
    }

    public function testFindOneById()
    {
        $catalogPromotion1 = $this->dummyData->getAttribute();
        $this->catalogPromotionRepository->shouldReceive('findOneById')
            ->with($catalogPromotion1->getId())
            ->andReturn($catalogPromotion1)
            ->once();

        $catalogPromotion = $this->catalogPromotionService->findOneById($catalogPromotion1->getId());

        $this->assertSame($catalogPromotion1, $catalogPromotion);
    }

    public function testFindAll()
    {
        $catalogPromotion1 = $this->dummyData->getAttribute();
        $this->catalogPromotionRepository->shouldReceive('findAll')
            ->andReturn([$catalogPromotion1])
            ->once();

        $catalogPromotions = $this->catalogPromotionService->findAll();

        $this->assertSame($catalogPromotion1, $catalogPromotions[0]);
    }

    public function testGetAllCatalogPromotions()
    {
        $catalogPromotion1 = $this->dummyData->getAttribute();
        $this->catalogPromotionRepository->shouldReceive('getAllCatalogPromotions')
            ->andReturn([$catalogPromotion1])
            ->once();

        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotions();

        $this->assertSame($catalogPromotion1, $catalogPromotions[0]);
    }

    public function testAllGetCatalogPromotionsByIds()
    {
        $catalogPromotion1 = $this->dummyData->getAttribute();
        $this->catalogPromotionRepository->shouldReceive('getAllCatalogPromotionsByIds')
            ->with([$catalogPromotion1->getId()], null)
            ->andReturn([$catalogPromotion1])
            ->once();

        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotionsByIds([
            $catalogPromotion1->getId()
        ]);

        $this->assertSame($catalogPromotion1, $catalogPromotions[0]);
    }
}
