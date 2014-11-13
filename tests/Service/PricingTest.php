<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service\Pricing;
use Doctrine\Common\Collections\ArrayCollection;

class PricingTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
    }

    public function testGetPriceBasic()
    {
        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 1500;
        $expectedPrice->quantityPrice = 1500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->quantityPrice = 3000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origQuantityPrice = 15000;
        $expectedPrice->quantityPrice = 15000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 10));
    }

    public function testAddCatalogPromotions()
    {
        $this->pricing->setCatalogPromotions([
            new Entity\CatalogPromotion,
            new Entity\CatalogPromotion,
        ]);
    }

    public function getProductQuantityDiscount($quantity, $value)
    {
        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setDiscountType('exact');
        $productQuantityDiscount->setQuantity($quantity);
        $productQuantityDiscount->setValue($value);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(false);
        $productQuantityDiscount->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        return $productQuantityDiscount;
    }

    public function testSetProductQuantityDiscount()
    {
        $productQuantityDiscount1 = $this->getProductQuantityDiscount(1, 500);
        $productQuantityDiscount2 = $this->getProductQuantityDiscount(2, 400);
        $productQuantityDiscount3 = $this->getProductQuantityDiscount(3, 300);

        $productQuantityDiscounts = new ArrayCollection([
            $productQuantityDiscount1,
            $productQuantityDiscount3,
            $productQuantityDiscount2,
        ]);

        $this->pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        $expected = [
            $productQuantityDiscount3,
            $productQuantityDiscount2,
            $productQuantityDiscount1,
        ];

        $reflection = new \ReflectionClass('inklabs\kommerce\Service\Pricing');
        $property = $reflection->getProperty('productQuantityDiscounts');
        $property->setAccessible(true);
        $resultProductQuantityDiscounts = $property->getValue($this->pricing);

        $this->assertEquals($expected, $resultProductQuantityDiscounts);
    }

    public function testGetPriceWithCatalogPromotionPercent()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1200;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 1200;
        $expectedPrice->origQuantityPrice = 1500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1200;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 2400;
        $expectedPrice->origQuantityPrice = 3000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1200;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 12000;
        $expectedPrice->origQuantityPrice = 15000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 10));
    }

    public function testGetPriceWithCatalogPromotionFixed()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('$1 Off');
        $catalogPromotion->setDiscountType('fixed');
        $catalogPromotion->setValue(100);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1400;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 1400;
        $expectedPrice->origQuantityPrice = 1500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1400;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 2800;
        $expectedPrice->origQuantityPrice = 3000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1400;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $expectedPrice->quantityPrice = 14000;
        $expectedPrice->origQuantityPrice = 15000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 10));
    }

    public function testGetPriceWithCatalogPromotionTag()
    {
        $tag = new Entity\Tag;
        $tag->setId(1);
        $tag->setName('Test Tag');

        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setTag($tag);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->pricing->setCatalogPromotions([$catalogPromotion]);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(1500);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 1500;
        $expectedPrice->origUnitPrice = 1500;
        $expectedPrice->quantityPrice = 3000;
        $expectedPrice->origQuantityPrice = 3000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));

        $product->addTag($tag);
        $expectedPrice->unitPrice = 1200;
        $expectedPrice->quantityPrice = 2400;
        $expectedPrice->addCatalogPromotion($catalogPromotion);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));
    }

    public function testGetPriceWithProductOptions()
    {
        $option = new Entity\Option;
        $option->setName('Size');
        $option->setType('radio');
        $option->setDescription('Navy T-shirt size');

        $productSmall = new Entity\Product;
        $productSmall->setSku('TS-NAVY-SM');
        $productSmall->setName('Navy T-shirt (small)');
        $productSmall->setUnitPrice(900);

        $option->addProduct($productSmall);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(1500);
        $product->addOption($option);
        $product->addSelectedOptionProduct($productSmall);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 2400;
        $expectedPrice->origQuantityPrice = 2400;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 4800;
        $expectedPrice->origQuantityPrice = 4800;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 2));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 2400;
        $expectedPrice->origUnitPrice = 2400;
        $expectedPrice->quantityPrice = 24000;
        $expectedPrice->origQuantityPrice = 24000;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 10));
    }

    public function testGetPriceWithProductQuantityDiscountExact()
    {
        $productQuantityDiscount6 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount6->setDiscountType('exact');
        $productQuantityDiscount6->setQuantity(6);
        $productQuantityDiscount6->setValue(475);
        $productQuantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount12 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount12->setDiscountType('exact');
        $productQuantityDiscount12->setQuantity(12);
        $productQuantityDiscount12->setValue(350);
        $productQuantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount24 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount24->setDiscountType('exact');
        $productQuantityDiscount24->setQuantity(24);
        $productQuantityDiscount24->setValue(325);
        $productQuantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
        $product->addProductQuantityDiscount($productQuantityDiscount24);
        $product->addProductQuantityDiscount($productQuantityDiscount12);
        $product->addProductQuantityDiscount($productQuantityDiscount6);

        $productQuantityDiscounts = $product->getProductQuantityDiscounts();
        $this->pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 500;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 500;
        $expectedPrice->origQuantityPrice = 500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 475;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 2850;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 6));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 350;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 4200;
        $expectedPrice->origQuantityPrice = 6000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 12));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 325;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 7800;
        $expectedPrice->origQuantityPrice = 12000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountFixed()
    {
        $productQuantityDiscount6 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount6->setDiscountType('fixed');
        $productQuantityDiscount6->setQuantity(6);
        $productQuantityDiscount6->setValue(25);
        $productQuantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount12 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount12->setDiscountType('fixed');
        $productQuantityDiscount12->setQuantity(12);
        $productQuantityDiscount12->setValue(150);
        $productQuantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount24 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount24->setDiscountType('fixed');
        $productQuantityDiscount24->setQuantity(24);
        $productQuantityDiscount24->setValue(175);
        $productQuantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
        $product->addProductQuantityDiscount($productQuantityDiscount24);
        $product->addProductQuantityDiscount($productQuantityDiscount12);
        $product->addProductQuantityDiscount($productQuantityDiscount6);

        $productQuantityDiscounts = $product->getProductQuantityDiscounts();
        $this->pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 500;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 500;
        $expectedPrice->origQuantityPrice = 500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 475;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 2850;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 6));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 350;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 4200;
        $expectedPrice->origQuantityPrice = 6000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 12));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 325;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 7800;
        $expectedPrice->origQuantityPrice = 12000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountPercent()
    {
        $productQuantityDiscount6 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount6->setDiscountType('percent');
        $productQuantityDiscount6->setQuantity(6);
        $productQuantityDiscount6->setValue(5);
        $productQuantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount12 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount12->setDiscountType('percent');
        $productQuantityDiscount12->setQuantity(12);
        $productQuantityDiscount12->setValue(30);
        $productQuantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $productQuantityDiscount24 = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount24->setDiscountType('percent');
        $productQuantityDiscount24->setQuantity(24);
        $productQuantityDiscount24->setValue(35);
        $productQuantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);
        $product->addProductQuantityDiscount($productQuantityDiscount24);
        $product->addProductQuantityDiscount($productQuantityDiscount12);
        $product->addProductQuantityDiscount($productQuantityDiscount6);

        $productQuantityDiscounts = $product->getProductQuantityDiscounts();
        $this->pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 500;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 500;
        $expectedPrice->origQuantityPrice = 500;
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 1));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 475;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 2850;
        $expectedPrice->origQuantityPrice = 3000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 6));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 350;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 4200;
        $expectedPrice->origQuantityPrice = 6000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 12));

        $expectedPrice = new Entity\Price;
        $expectedPrice->unitPrice = 325;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->quantityPrice = 7800;
        $expectedPrice->origQuantityPrice = 12000;
        $expectedPrice->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($expectedPrice, $this->pricing->getPrice($product, 24));
    }
}
