<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryCatalogPromotion;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /** @var FakeRepositoryCatalogPromotion */
    protected $catalogPromotionRepository;

    /** @var CatalogPromotion */
    protected $catalogPromotionService;

    public function setUp()
    {
        $this->catalogPromotionRepository = new FakeRepositoryCatalogPromotion;
        $this->catalogPromotionService = new CatalogPromotion($this->catalogPromotionRepository);
    }

    public function testCreate()
    {
        $catalogPromotion = $this->getDummyCatalogPromotion();
        $this->catalogPromotionService->create($catalogPromotion);
        $this->assertTrue($catalogPromotion instanceof Entity\CatalogPromotion);
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
        $catalogPromotion = $this->catalogPromotionService->find(1);
        $this->assertTrue($catalogPromotion instanceof Entity\CatalogPromotion);
    }

    public function testFindAll()
    {
        $catalogPromotions = $this->catalogPromotionService->findAll();
        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testGetAllCatalogPromotions()
    {
        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotions();
        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testAllGetCatalogPromotionsByIds()
    {
        $catalogPromotions = $this->catalogPromotionService->getAllCatalogPromotionsByIds([1]);
        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }
}
