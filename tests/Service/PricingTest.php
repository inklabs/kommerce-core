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

        // Expected
        $price = new Entity\Price;
        $price->origUnitPrice = 1500;
        $price->unitPrice = 1500;
        $price->origQuantityPrice = 1500;
        $price->quantityPrice = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->origUnitPrice = 1500;
        $price->unitPrice = 1500;
        $price->origQuantityPrice = 3000;
        $price->quantityPrice = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->origUnitPrice = 1500;
        $price->unitPrice = 1500;
        $price->origQuantityPrice = 15000;
        $price->quantityPrice = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1200;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 1200;
        $price->origQuantityPrice = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1200;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 2400;
        $price->origQuantityPrice = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1200;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 12000;
        $price->origQuantityPrice = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1400;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 1400;
        $price->origQuantityPrice = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1400;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 2800;
        $price->origQuantityPrice = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1400;
        $price->origUnitPrice = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantityPrice = 14000;
        $price->origQuantityPrice = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    public function testGetPriceWithCatalogPromotionTag()
    {
        $tag = new Entity\Tag;
        // $tag->id = 1;
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 1500;
        $price->origUnitPrice = 1500;
        $price->quantityPrice = 3000;
        $price->origQuantityPrice = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Add tag
        $product->addTag($tag);
        $price->unitPrice = 1200;
        $price->quantityPrice = 2400;
        $price->addCatalogPromotion($catalogPromotion);
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 2400;
        $price->origUnitPrice = 2400;
        $price->quantityPrice = 2400;
        $price->origQuantityPrice = 2400;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 2400;
        $price->origUnitPrice = 2400;
        $price->quantityPrice = 4800;
        $price->origQuantityPrice = 4800;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 2400;
        $price->origUnitPrice = 2400;
        $price->quantityPrice = 24000;
        $price->origQuantityPrice = 24000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 500;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 500;
        $price->origQuantityPrice = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 475;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 2850;
        $price->origQuantityPrice = 3000;
        $price->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 500;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 500;
        $price->origQuantityPrice = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 475;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 2850;
        $price->origQuantityPrice = 3000;
        $price->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
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

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 500;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 500;
        $price->origQuantityPrice = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 475;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 2850;
        $price->origQuantityPrice = 3000;
        $price->addProductQuantityDiscount($productQuantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($productQuantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($productQuantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }
}
