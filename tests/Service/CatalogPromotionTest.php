<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    /* @var CatalogPromotion */
    protected $catalogPromotionService;
    protected $catalogPromotions;

    public function setUp()
    {
        $this->catalogPromotions = [
            $this->getCatalogPromotion(1),
            $this->getCatalogPromotion(2),
            $this->getCatalogPromotion(3),
        ];

        foreach ($this->catalogPromotions as $catalogPromotion) {
            $this->entityManager->persist($catalogPromotion);
        }
        $this->entityManager->flush();

        $this->catalogPromotionService = new CatalogPromotion($this->entityManager);
    }

    private function getCatalogPromotion($num)
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setCode('test' . $num);
        $catalogPromotion->setName('test' . $num);
        $catalogPromotion->setType('percent');
        $catalogPromotion->setValue(10);
        $catalogPromotion->setRedemptions(0);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        return $catalogPromotion;
    }

    public function testFindAll()
    {
        $catalogPromotions = $this->catalogPromotionService->findAll();

        $this->assertEquals($this->catalogPromotions, $catalogPromotions);
    }
}
