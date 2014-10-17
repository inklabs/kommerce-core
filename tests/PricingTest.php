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
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 1500;
        $price->quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 3000;
        $price->quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 15000;
        $price->quantity_price = 15000;
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
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 1200;
        $price->orig_quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 2400;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 12000;
        $price->orig_quantity_price = 15000;
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
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 1400;
        $price->orig_quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 2800;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalogPromotion);
        $price->quantity_price = 14000;
        $price->orig_quantity_price = 15000;
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
        $price->unit_price = 1500;
        $price->orig_unit_price = 1500;
        $price->quantity_price = 3000;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Add tag
        $product->addTag($tag);
        $price->unit_price = 1200;
        $price->quantity_price = 2400;
        $price->addCatalogPromotion($catalogPromotion);
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));
    }

    public function testGetPriceWithProductOptions()
    {
        $option = new Entity\Option;
        $option->setName('Size');
        $option->setType('radio');
        $option->setDescription('Navy T-shirt size');

        $product_small = new Entity\Product;
        $product_small->setSku('TS-NAVY-SM');
        $product_small->setName('Navy T-shirt (small)');
        $product_small->setPrice(900);

        $option->addProduct($product_small);

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(1500);
        $product->addOption($option);
        $product->addSelectedOptionProduct($product_small);

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 2400;
        $price->orig_quantity_price = 2400;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 4800;
        $price->orig_quantity_price = 4800;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 24000;
        $price->orig_quantity_price = 24000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    public function testGetPriceWithProductQuantityDiscountExact()
    {
        $quantity_discount_6 = new Entity\ProductQuantityDiscount;
        $quantity_discount_6->setDiscountType('exact');
        $quantity_discount_6->setQuantity(6);
        $quantity_discount_6->setValue(475);
        $quantity_discount_6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_12 = new Entity\ProductQuantityDiscount;
        $quantity_discount_12->setDiscountType('exact');
        $quantity_discount_12->setQuantity(12);
        $quantity_discount_12->setValue(350);
        $quantity_discount_12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_24 = new Entity\ProductQuantityDiscount;
        $quantity_discount_24->setDiscountType('exact');
        $quantity_discount_24->setQuantity(24);
        $quantity_discount_24->setValue(325);
        $quantity_discount_24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addQuantityDiscount($quantity_discount_24);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_6);

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountFixed()
    {
        $quantity_discount_6 = new Entity\ProductQuantityDiscount;
        $quantity_discount_6->setDiscountType('fixed');
        $quantity_discount_6->setQuantity(6);
        $quantity_discount_6->setValue(25);
        $quantity_discount_6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_12 = new Entity\ProductQuantityDiscount;
        $quantity_discount_12->setDiscountType('fixed');
        $quantity_discount_12->setQuantity(12);
        $quantity_discount_12->setValue(150);
        $quantity_discount_12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_24 = new Entity\ProductQuantityDiscount;
        $quantity_discount_24->setDiscountType('fixed');
        $quantity_discount_24->setQuantity(24);
        $quantity_discount_24->setValue(175);
        $quantity_discount_24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addQuantityDiscount($quantity_discount_24);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_6);

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    public function testGetPriceWithProductQuantityDiscountPercent()
    {
        $quantity_discount_6 = new Entity\ProductQuantityDiscount;
        $quantity_discount_6->setDiscountType('percent');
        $quantity_discount_6->setQuantity(6);
        $quantity_discount_6->setValue(5);
        $quantity_discount_6->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_6->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_12 = new Entity\ProductQuantityDiscount;
        $quantity_discount_12->setDiscountType('percent');
        $quantity_discount_12->setQuantity(12);
        $quantity_discount_12->setValue(30);
        $quantity_discount_12->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_12->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $quantity_discount_24 = new Entity\ProductQuantityDiscount;
        $quantity_discount_24->setDiscountType('percent');
        $quantity_discount_24->setQuantity(24);
        $quantity_discount_24->setValue(35);
        $quantity_discount_24->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $quantity_discount_24->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $product = new Entity\Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setPrice(500);
        $product->addQuantityDiscount($quantity_discount_24);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_6);

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Entity\Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }
}
