<?php
namespace inklabs\kommerce;

class PricingTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pricing = new Entity\Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
    }

    public function testGetPriceBasic()
    {
        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);

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
        $this->pricing->addCatalogPromotions([
            new Entity\CatalogPromotion,
            new Entity\CatalogPromotion,
        ]);
    }

    public function testGetPriceWithCatalogPromotionPercent()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->pricing->addCatalogPromotion($catalogPromotion);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);

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

        $this->pricing->addCatalogPromotion($catalogPromotion);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);

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

        $this->pricing->addCatalogPromotion($catalogPromotion);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);

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
        $productSmall->setPrice(900);

        $option->addProduct($productSmall);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);
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
        $quantityDiscount6 = new Entity\ProductQuantityDiscount;
        $quantityDiscount6->setDiscountType('exact');
        $quantityDiscount6->setQuantity(6);
        $quantityDiscount6->setValue(475);
        $quantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount12 = new Entity\ProductQuantityDiscount;
        $quantityDiscount12->setDiscountType('exact');
        $quantityDiscount12->setQuantity(12);
        $quantityDiscount12->setValue(350);
        $quantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount24 = new Entity\ProductQuantityDiscount;
        $quantityDiscount24->setDiscountType('exact');
        $quantityDiscount24->setQuantity(24);
        $quantityDiscount24->setValue(325);
        $quantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addProductQuantityDiscount($quantityDiscount24);
        $product->addProductQuantityDiscount($quantityDiscount12);
        $product->addProductQuantityDiscount($quantityDiscount6);

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
        $price->addProductQuantityDiscount($quantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($quantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($quantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountFixed()
    {
        $quantityDiscount6 = new Entity\ProductQuantityDiscount;
        $quantityDiscount6->setDiscountType('fixed');
        $quantityDiscount6->setQuantity(6);
        $quantityDiscount6->setValue(25);
        $quantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount12 = new Entity\ProductQuantityDiscount;
        $quantityDiscount12->setDiscountType('fixed');
        $quantityDiscount12->setQuantity(12);
        $quantityDiscount12->setValue(150);
        $quantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount24 = new Entity\ProductQuantityDiscount;
        $quantityDiscount24->setDiscountType('fixed');
        $quantityDiscount24->setQuantity(24);
        $quantityDiscount24->setValue(175);
        $quantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addProductQuantityDiscount($quantityDiscount24);
        $product->addProductQuantityDiscount($quantityDiscount12);
        $product->addProductQuantityDiscount($quantityDiscount6);

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
        $price->addProductQuantityDiscount($quantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($quantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($quantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountPercent()
    {
        $quantityDiscount6 = new Entity\ProductQuantityDiscount;
        $quantityDiscount6->setDiscountType('percent');
        $quantityDiscount6->setQuantity(6);
        $quantityDiscount6->setValue(5);
        $quantityDiscount6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount12 = new Entity\ProductQuantityDiscount;
        $quantityDiscount12->setDiscountType('percent');
        $quantityDiscount12->setQuantity(12);
        $quantityDiscount12->setValue(30);
        $quantityDiscount12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantityDiscount24 = new Entity\ProductQuantityDiscount;
        $quantityDiscount24->setDiscountType('percent');
        $quantityDiscount24->setQuantity(24);
        $quantityDiscount24->setValue(35);
        $quantityDiscount24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantityDiscount24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addProductQuantityDiscount($quantityDiscount24);
        $product->addProductQuantityDiscount($quantityDiscount12);
        $product->addProductQuantityDiscount($quantityDiscount6);

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
        $price->addProductQuantityDiscount($quantityDiscount6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 350;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 4200;
        $price->origQuantityPrice = 6000;
        $price->addProductQuantityDiscount($quantityDiscount12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unitPrice = 325;
        $price->origUnitPrice = 500;
        $price->quantityPrice = 7800;
        $price->origQuantityPrice = 12000;
        $price->addProductQuantityDiscount($quantityDiscount24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }
}
