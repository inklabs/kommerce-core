<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\CatalogPromotion */
    protected $mockCatalogPromotionRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var CatalogPromotion */
    protected $catalogPromotionService;

    /** @var Entity\CatalogPromotion */
    protected $catalogPromotion;

    public function setUp()
    {
        $this->mockCatalogPromotionRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\CatalogPromotion');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->catalogPromotionService = new CatalogPromotion($this->entityManager);
    }

    private function setupCatalogPromotion()
    {
        $this->catalogPromotion = new Entity\CatalogPromotion;
        $this->catalogPromotion->setCode('TST');
        $this->catalogPromotion->setName('test');
        $this->catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $this->catalogPromotion->setValue(10);
        $this->catalogPromotion->setRedemptions(0);
        $this->catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($this->catalogPromotion);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $catalogPromotion = $this->catalogPromotionService->find(0);
        $this->assertSame(null, $catalogPromotion);
    }

    public function testFind()
    {
        $this->setupCatalogPromotion();
        $this->entityManager->clear();

        $catalogPromotion = $this->catalogPromotionService->find(1);
        $this->assertSame(1, $catalogPromotion->id);
    }

    public function testGetAllCatalogPromotions()
    {
        $this->mockCatalogPromotionRepository
            ->shouldReceive('getAllCatalogPromotions')
            ->andReturn([new Entity\CatalogPromotion]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockCatalogPromotionRepository);

        $catalogPromotionService = new CatalogPromotion($this->mockEntityManager);

        $catalogPromotions = $catalogPromotionService->getAllCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof View\CatalogPromotion);
    }

    public function testAllGetCatalogPromotionsByIds()
    {
        $this->mockCatalogPromotionRepository
            ->shouldReceive('getAllCatalogPromotionsByIds')
            ->andReturn([new Entity\CatalogPromotion]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockCatalogPromotionRepository);

        $catalogPromotionService = new CatalogPromotion($this->mockEntityManager);

        $catalogPromotions = $catalogPromotionService->getAllCatalogPromotionsByIds([1]);
        $this->assertTrue($catalogPromotions[0] instanceof View\CatalogPromotion);
    }
}
