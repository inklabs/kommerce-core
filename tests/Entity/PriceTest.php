<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class PriceTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $price = new Price;

        $this->assertSame(null, $price->origQuantityPrice);
        $this->assertSame(null, $price->unitPrice);
        $this->assertSame(null, $price->origQuantityPrice);
        $this->assertSame(null, $price->quantityPrice);
        $this->assertSame(0, count($price->getCatalogPromotions()));
        $this->assertSame(0, count($price->getProductQuantityDiscounts()));
    }

    public function testCreate()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount();

        $price = new Price;
        $price->origUnitPrice = 2500;
        $price->unitPrice = 1750;
        $price->origQuantityPrice = 2500;
        $price->quantityPrice = 1750;
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $this->assertEntityValid($price);
        $this->assertSame(2500, $price->origUnitPrice);
        $this->assertSame(1750, $price->unitPrice);
        $this->assertSame(2500, $price->origQuantityPrice);
        $this->assertSame(1750, $price->quantityPrice);
        $this->assertSame($catalogPromotion, $price->getCatalogPromotions()[0]);
        $this->assertSame($productQuantityDiscount, $price->getProductQuantityDiscounts()[0]);
    }

    public function testAdd()
    {
        $catalogPromotion1 = $this->dummyData->getCatalogPromotion(1);
        $catalogPromotion2 = $this->dummyData->getCatalogPromotion(2);
        $productQuantityDiscount1 = $this->dummyData->getProductQuantityDiscount();
        $productQuantityDiscount2 = $this->dummyData->getProductQuantityDiscount();

        $one = new Price;
        $one->unitPrice         = 1;
        $one->origUnitPrice     = 1;
        $one->quantityPrice     = 1;
        $one->origQuantityPrice = 1;
        $one->addCatalogPromotion($catalogPromotion1);
        $one->addProductQuantityDiscount($productQuantityDiscount1);

        $two = new Price;
        $two->unitPrice         = 2;
        $two->origUnitPrice     = 2;
        $two->quantityPrice     = 2;
        $two->origQuantityPrice = 2;
        $two->addCatalogPromotion($catalogPromotion2);
        $two->addProductQuantityDiscount($productQuantityDiscount2);

        $expectedPrice = new Price;
        $expectedPrice->unitPrice         = 3;
        $expectedPrice->origUnitPrice     = 3;
        $expectedPrice->quantityPrice     = 3;
        $expectedPrice->origQuantityPrice = 3;
        $expectedPrice->addCatalogPromotion($catalogPromotion1);
        $expectedPrice->addCatalogPromotion($catalogPromotion2);
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount1);
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount2);

        $this->assertEquals($expectedPrice, Price::add($one, $two));
    }

    public function testAddPreventsDuplicates()
    {
        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount();

        $one = new Price;
        $one->addCatalogPromotion($catalogPromotion);
        $one->addProductQuantityDiscount($productQuantityDiscount);

        $two = new Price;
        $two->addCatalogPromotion($catalogPromotion);
        $two->addProductQuantityDiscount($productQuantityDiscount);

        $three = new Price;
        $three->unitPrice         = 0;
        $three->origUnitPrice     = 0;
        $three->quantityPrice     = 0;
        $three->origQuantityPrice = 0;
        $three->addCatalogPromotion($catalogPromotion);
        $three->addProductQuantityDiscount($productQuantityDiscount);

        $this->assertEquals($three, Price::add($one, $two));
    }
}
