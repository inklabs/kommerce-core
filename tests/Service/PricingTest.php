<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class PricingTest extends Helper\DoctrineTestCase
{
    public function testCreate()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType('fixed');
        $pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType('fixed');
        $pricing->setCatalogPromotions([$catalogPromotion]);

        $this->assertInstanceOf('inklabs\kommerce\Entity\Price', $pricing->getPrice(new Entity\Product, 1));
        $this->assertInstanceOf('DateTime', $pricing->getDate());
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\ProductQuantityDiscount',
            $pricing->getProductQuantityDiscounts()[0]
        );
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\CatalogPromotion',
            $pricing->getCatalogPromotions()[0]
        );
    }

    public function testCreateWithEmptyDate()
    {
        $pricing = new Pricing;
        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\Price',
            $pricing->getPrice(new Entity\Product, 1)
        );
    }

    public function testLoadCatalogPromotions()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setCode('TST101');
        $catalogPromotion->setType('percent');
        $catalogPromotion->setValue(10);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $this->assertInstanceOf(
            'inklabs\kommerce\Entity\CatalogPromotion',
            $pricing->getCatalogPromotions()[0]
        );
    }
}
