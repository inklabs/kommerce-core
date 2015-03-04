<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Tag */
    protected $tag;

    /* @var Entity\CatalogPromotion */
    protected $catalogPromotion;

    public function setUp()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Tag');

        $this->entityManager->persist($this->tag);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

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

    public function testFind()
    {
        $catalogPromotion1 = $this->getDummyCatalogPromotion(1);

        $this->entityManager->persist($catalogPromotion1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $catalogPromotion = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $catalogPromotion->getId());
    }

    public function testFindAll()
    {
        $catalogPromotion1 = $this->getDummyCatalogPromotion(1);

        $this->entityManager->persist($catalogPromotion1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $catalogPromotions = $this->getRepository()
            ->findAll();

        $this->assertTrue($catalogPromotions[0] instanceof Entity\CatalogPromotion);
    }

    public function testGetAllCatalogPromotions()
    {
        $catalogPromotion1 = $this->getDummyCatalogPromotion(1);

        $this->entityManager->persist($catalogPromotion1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $catalogPromotions = $this->getRepository()
            ->getAllCatalogPromotions('Test');

        $this->assertSame(1, $catalogPromotions[0]->getId());
    }

    public function testGetAllCatalogPromotionsByIds()
    {
        $catalogPromotion1 = $this->getDummyCatalogPromotion(1);

        $this->entityManager->persist($catalogPromotion1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $catalogPromotions = $this->getRepository()
            ->getAllCatalogPromotionsByIds([1]);

        $this->assertSame(1, $catalogPromotions[0]->getId());
    }
}
