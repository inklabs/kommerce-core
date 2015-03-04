<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /* @var Entity\CatalogPromotion */
    protected $catalogPromotion;

    /**
     * @return CatalogPromotion
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion');
    }

    /**
     * @return Entity\CatalogPromotion
     */
    private function getDummyCatalogPromotion($num)
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% OFF Test ' . $num);
        $catalogPromotion->setCode('20PCT' . $num);
        $catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);
        return $catalogPromotion;
    }

    private function setupCatalogPromotion()
    {
        $catalogPromotion1 = $this->getDummyCatalogPromotion(1);

        $this->entityManager->persist($catalogPromotion1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupCatalogPromotion();

        $catalogPromotion = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $catalogPromotion->getId());
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

        $this->assertSame(1, $catalogPromotions[0]->getId());
    }

    public function testGetAllCatalogPromotionsByIds()
    {
        $this->setupCatalogPromotion();

        $catalogPromotions = $this->getRepository()
            ->getAllCatalogPromotionsByIds([1]);

        $this->assertSame(1, $catalogPromotions[0]->getId());
    }
}
