<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class CatalogPromotionRepositoryTest extends EntityRepositoryTestCase
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

        return $catalogPromotion;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->catalogPromotionRepository,
            $this->dummyData->getCatalogPromotion()
        );
    }

    public function testFindOneById()
    {
        $originalCatalogPromotion = $this->setupCatalogPromotion();
        $this->setCountLogger();

        $catalogPromotion = $this->catalogPromotionRepository->findOneById(
            $originalCatalogPromotion->getId()
        );

        $catalogPromotion->getTag()->getCreated();

        $this->assertEquals($originalCatalogPromotion->getId(), $catalogPromotion->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindAll()
    {
        $originalCatalogPromotion = $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->findAll();

        $this->assertEquals($originalCatalogPromotion->getId(), $catalogPromotions[0]->getId());
    }

    public function testGetAllCatalogPromotions()
    {
        $originalCatalogPromotion = $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->getAllCatalogPromotions('Test');

        $this->assertEquals($originalCatalogPromotion->getId(), $catalogPromotions[0]->getId());
    }

    public function testGetAllCatalogPromotionsByIds()
    {
        $originalCatalogPromotion = $this->setupCatalogPromotion();

        $catalogPromotions = $this->catalogPromotionRepository->getAllCatalogPromotionsByIds([
            $originalCatalogPromotion->getId()
        ]);

        $this->assertEquals($originalCatalogPromotion->getId(), $catalogPromotions[0]->getId());
    }
}
