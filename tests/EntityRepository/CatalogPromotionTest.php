<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CatalogPromotion',
        'kommerce:Tag',
    ];

    /**
     * @return CatalogPromotion
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion');
    }

    private function setupCatalogPromotion()
    {
        $tag = $this->getDummyTag();
        $catalogPromotion = $this->getDummyCatalogPromotion();
        $catalogPromotion->setTag($tag);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCatalogPromotion();

        $this->setCountLogger();

        $catalogPromotion = $this->getRepository()
            ->find(1);

        $catalogPromotion->getTag()->getName();

        $this->assertTrue($catalogPromotion instanceof Entity\CatalogPromotion);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testFindAll()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->getRepository()
            ->findAll();

        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testGetAllCatalogPromotions()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->getRepository()
            ->getAllCatalogPromotions('Test');

        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testGetAllCatalogPromotionsByIds()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->getRepository()
            ->getAllCatalogPromotionsByIds([1]);

        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }
}
