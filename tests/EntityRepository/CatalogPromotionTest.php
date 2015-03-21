<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
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

    private function getDummyCatalogPromotion($num = 1)
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% OFF Test ' . $num);
        $catalogPromotion->setCode('20PCT' . $num);
        $catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);

        return $catalogPromotion;
    }

    private function getDummyTag()
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsActive(true);
        $tag->setIsVisible(true);

        return $tag;
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
