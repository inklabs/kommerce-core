<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class PriceTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $price = new Price;
        $price->origUnitPrice = 2500;
        $price->unitPrice = 1750;
        $price->origQuantityPrice = 2500;
        $price->quantityPrice = 1750;
        $price->addCatalogPromotion(new CatalogPromotion);
        $price->addProductQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEntityValid($price);
        $this->assertTrue($price->getCatalogPromotions()[0] instanceof CatalogPromotion);
        $this->assertTrue($price->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
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

        $three = new Price;
        $three->unitPrice         = 3;
        $three->origUnitPrice     = 3;
        $three->quantityPrice     = 3;
        $three->origQuantityPrice = 3;
        $three->addCatalogPromotion($catalogPromotion1);
        $three->addCatalogPromotion($catalogPromotion2);
        $three->addProductQuantityDiscount($productQuantityDiscount1);
        $three->addProductQuantityDiscount($productQuantityDiscount2);

        $this->assertEquals($three, Price::add($one, $two));
    }

    public function testAddAndPreventDuplicates()
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
