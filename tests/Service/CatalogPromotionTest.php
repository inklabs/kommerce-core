<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CatalogPromotionTest extends Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->catalogPromotions = [
            $this->getDummyCatalogPromotion(1),
            $this->getDummyCatalogPromotion(2),
            $this->getDummyCatalogPromotion(3),
        ];

        $this->entityManager->persist($this->catalogPromotions[0]);
        $this->entityManager->persist($this->catalogPromotions[1]);
        $this->entityManager->persist($this->catalogPromotions[2]);
        $this->entityManager->flush();

        $this->catalogPromotionService = new CatalogPromotion($this->entityManager);
    }

    private function getDummyCatalogPromotion($num)
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setCode('test' . $num);
        $catalogPromotion->setName('test' . $num);
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(10);
        $catalogPromotion->setRedemptions(0);
        $catalogPromotion->setFlagFreeShipping(false);
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
