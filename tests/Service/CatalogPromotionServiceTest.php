<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCatalogPromotionRepository;

class CatalogPromotionServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeCatalogPromotionRepository */
    protected $catalogPromotionRepository;

    /** @var CatalogPromotionService */
    protected $catalogPromotionService;

    public function setUp()
    {
        $this->catalogPromotionRepository = new FakeCatalogPromotionRepository;
        $this->catalogPromotionService = new CatalogPromotionService($this->catalogPromotionRepository);
    }

    public function testCreate()
    {
        $catalogPromotion = $this->getDummyCatalogPromotion();
        $this->catalogPromotionService->create($catalogPromotion);
        $this->assertTrue($catalogPromotion instanceof CatalogPromotion);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $catalogPromotion = $this->getDummyCatalogPromotion();
        $this->assertNotSame($newName, $catalogPromotion->getName());

        $catalogPromotion->setName($newName);
        $this->catalogPromotionService->edit($catalogPromotion);
        $this->assertSame($newName, $catalogPromotion->getName());
    }

    public function testFind()
    {
        $this->catalogPromotionRepository->create(new CatalogPromotion);

        $catalogPromotion = $this->catalogPromotionService->findOneById(1);
        $this->assertTrue($catalogPromotion instanceof CatalogPromotion);
    }

    public function testFindAll()
    {
        $catalogPromotions = $this->catalogPromotionService->findAll();
        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }

    public function testGetAllCatalogPromotions()
    {
        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }

    public function testAllGetCatalogPromotionsByIds()
    {
        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotionsByIds([1]);
        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }
}
