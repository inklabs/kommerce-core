<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper;

class CatalogPromotionRepositoryTest extends Helper\TestCase\EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        CatalogPromotion::class,
        Tag::class,
    ];

    /** @var CatalogPromotionRepositoryInterface */
    protected $catalogPromotionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->catalogPromotionRepository = $this->getRepositoryFactory()->getCatalogPromotionRepository();
    }

    private function setupCatalogPromotion()
    {
        $tag = $this->dummyData->getTag();
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setTag($tag);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();

        $this->catalogPromotionRepository->create($catalogPromotion);
        $this->assertSame(1, $catalogPromotion->getId());

        $catalogPromotion->setName('New Name');
        $this->assertSame(null, $catalogPromotion->getUpdated());

        $this->catalogPromotionRepository->update($catalogPromotion);
        $this->assertTrue($catalogPromotion->getUpdated() instanceof DateTime);

        $this->catalogPromotionRepository->delete($catalogPromotion);
        $this->assertSame(null, $catalogPromotion->getId());
    }

    public function testFind()
    {
        $this->setupCatalogPromotion();

        $this->setCountLogger();

        $catalogPromotion = $this->catalogPromotionRepository->findOneById(1);

        $catalogPromotion->getTag()->getName();

        $this->assertTrue($catalogPromotion instanceof CatalogPromotion);
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindAll()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->findAll();

        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }

    public function testGetAllCatalogPromotions()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->getAllCatalogPromotions('Test');

        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }

    public function testGetAllCatalogPromotionsByIds()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->getAllCatalogPromotionsByIds([1]);

        $this->assertTrue($catalogPromotions[0] instanceof CatalogPromotion);
    }
}
