<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class PricingTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:CatalogPromotion',
        'kommerce:Tag',
    ];

    public function testCreate()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setType(Entity\Promotion::TYPE_FIXED);
        $pricing->setProductQuantityDiscounts([$productQuantityDiscount]);

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setType(Entity\Promotion::TYPE_FIXED);
        $pricing->setCatalogPromotions([$catalogPromotion]);

        $this->assertTrue($pricing->getPrice(new Entity\Product, 1) instanceof Entity\Price);
        $this->assertTrue($pricing->getDate() instanceof \DateTime);
        $this->assertTrue($pricing->getProductQuantityDiscounts()[0] instanceof Entity\ProductQuantityDiscount);
        $this->assertTrue($pricing->getCatalogPromotions()[0] instanceof Entity\CatalogPromotion);
    }

    public function testCreateWithEmptyDate()
    {
        $pricing = new Pricing;
        $this->assertTrue($pricing->getPrice(new Entity\Product, 1) instanceof Entity\Price);
    }

    public function testLoadCatalogPromotions()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setCode('TST101');
        $catalogPromotion->setType(Entity\Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(10);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $pricing = new Pricing;
        $pricing->loadCatalogPromotions($this->entityManager);

        $this->assertTrue($pricing->getCatalogPromotions()[0] instanceof Entity\CatalogPromotion);
    }
}
