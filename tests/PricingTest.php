<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\ProductQuantityDiscount;

class PricingTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));
        $this->pricing = new Pricing($date);
    }

    /**
     * @covers Pricing::getPrice
     */
    public function testGetPriceBasic()
    {
        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 1500;

        // Expected
        $price = new Price;
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 1500;
        $price->quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 3000;
        $price->quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Price;
        $price->orig_unit_price = 1500;
        $price->unit_price = 1500;
        $price->orig_quantity_price = 15000;
        $price->quantity_price = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyCatalogPromotions
     */
    public function testGetPriceWithCatalogPromotionPercent()
    {
        $catalog_promotion = new CatalogPromotion;
        $catalog_promotion->name = '20% Off';
        $catalog_promotion->discount_type = 'percent';
        $catalog_promotion->value = 20;
        $catalog_promotion->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $catalog_promotion->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $this->pricing->addCatalogPromotion($catalog_promotion);

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 1500;

        // Expected
        $price = new Price;
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 1200;
        $price->orig_quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 2400;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Price;
        $price->unit_price = 1200;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 12000;
        $price->orig_quantity_price = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyCatalogPromotions
     */
    public function testGetPriceWithCatalogPromotionFixed()
    {
        $catalog_promotion = new CatalogPromotion;
        $catalog_promotion->name = '$1 Off';
        $catalog_promotion->discount_type = 'fixed';
        $catalog_promotion->value = 100;
        $catalog_promotion->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $catalog_promotion->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $this->pricing->addCatalogPromotion($catalog_promotion);

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 1500;

        // Expected
        $price = new Price;
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 1400;
        $price->orig_quantity_price = 1500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 2800;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Price;
        $price->unit_price = 1400;
        $price->orig_unit_price = 1500;
        $price->addCatalogPromotion($catalog_promotion);
        $price->quantity_price = 14000;
        $price->orig_quantity_price = 15000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyCatalogPromotions
     */
    public function testGetPriceWithCatalogPromotionTag()
    {
        $tag = new Tag;
        $tag->id = 1;
        $tag->name = 'Test Tag';

        $catalog_promotion = new CatalogPromotion;
        $catalog_promotion->name = '20% Off';
        $catalog_promotion->discount_type = 'percent';
        $catalog_promotion->value = 20;
        $catalog_promotion->tag = $tag;
        $catalog_promotion->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $catalog_promotion->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $this->pricing->addCatalogPromotion($catalog_promotion);

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 1500;

        // Expected
        $price = new Price;
        $price->unit_price = 1500;
        $price->orig_unit_price = 1500;
        $price->quantity_price = 3000;
        $price->orig_quantity_price = 3000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Add tag
        $product->tags[] = $tag;
        $price->unit_price = 1200;
        $price->quantity_price = 2400;
        $price->addCatalogPromotion($catalog_promotion);
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyProductOptionPrices
     */
    public function testGetPriceWithProductOptions()
    {
        $option = new Option;
        $option->name = 'Size';
        $option->type = 'radio';
        $option->description = 'Navy T-shirt size';

        $product_small = new Product;
        $product_small->sku = 'TS-NAVY-SM';
        $product_small->name = 'Navy T-shirt (small)';
        $product_small->price = 900;

        $option->addProduct($product_small);

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 1500;
        $product->addOption($option);
        $product->addSelectedOptionProduct($product_small);

        // Expected
        $price = new Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 2400;
        $price->orig_quantity_price = 2400;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 4800;
        $price->orig_quantity_price = 4800;
        $this->assertEquals($price, $this->pricing->getPrice($product, 2));

        // Expected
        $price = new Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 24000;
        $price->orig_quantity_price = 24000;
        $this->assertEquals($price, $this->pricing->getPrice($product, 10));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyProductQuantityDiscounts
     */
    public function testGetPriceWithProductQuantityDiscountExact()
    {
        $quantity_discount_6 = new ProductQuantityDiscount;
        $quantity_discount_6->discount_type = 'exact';
        $quantity_discount_6->quantity = 6;
        $quantity_discount_6->value = 475;
        $quantity_discount_6->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_6->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_12 = new ProductQuantityDiscount;
        $quantity_discount_12->discount_type = 'exact';
        $quantity_discount_12->quantity = 12;
        $quantity_discount_12->value = 350;
        $quantity_discount_12->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_12->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_24 = new ProductQuantityDiscount;
        $quantity_discount_24->discount_type = 'exact';
        $quantity_discount_24->quantity = 24;
        $quantity_discount_24->value = 325;
        $quantity_discount_24->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_24->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 500;
        $product->addQuantityDiscount($quantity_discount_6);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_24);

        // Expected
        $price = new Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyProductQuantityDiscounts
     */
    public function testGetPriceWithProductQuantityDiscountFixed()
    {
        $quantity_discount_6 = new ProductQuantityDiscount;
        $quantity_discount_6->discount_type = 'fixed';
        $quantity_discount_6->quantity = 6;
        $quantity_discount_6->value = 25;
        $quantity_discount_6->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_6->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_12 = new ProductQuantityDiscount;
        $quantity_discount_12->discount_type = 'fixed';
        $quantity_discount_12->quantity = 12;
        $quantity_discount_12->value = 150;
        $quantity_discount_12->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_12->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_24 = new ProductQuantityDiscount;
        $quantity_discount_24->discount_type = 'fixed';
        $quantity_discount_24->quantity = 24;
        $quantity_discount_24->value = 175;
        $quantity_discount_24->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_24->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 500;
        $product->addQuantityDiscount($quantity_discount_6);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_24);

        // Expected
        $price = new Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }

    /**
     * @covers Pricing::getPrice
     * @covers Pricing::applyProductQuantityDiscounts
     */
    public function testGetPriceWithProductQuantityDiscountPercent()
    {
        $quantity_discount_6 = new ProductQuantityDiscount;
        $quantity_discount_6->discount_type = 'percent';
        $quantity_discount_6->quantity = 6;
        $quantity_discount_6->value = 5;
        $quantity_discount_6->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_6->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_12 = new ProductQuantityDiscount;
        $quantity_discount_12->discount_type = 'percent';
        $quantity_discount_12->quantity = 12;
        $quantity_discount_12->value = 30;
        $quantity_discount_12->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_12->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $quantity_discount_24 = new ProductQuantityDiscount;
        $quantity_discount_24->discount_type = 'percent';
        $quantity_discount_24->quantity = 24;
        $quantity_discount_24->value = 35;
        $quantity_discount_24->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $quantity_discount_24->end = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 500;
        $product->addQuantityDiscount($quantity_discount_6);
        $product->addQuantityDiscount($quantity_discount_12);
        $product->addQuantityDiscount($quantity_discount_24);

        // Expected
        $price = new Price;
        $price->unit_price = 500;
        $price->orig_unit_price = 500;
        $price->quantity_price = 500;
        $price->orig_quantity_price = 500;
        $this->assertEquals($price, $this->pricing->getPrice($product, 1));

        // Expected
        $price = new Price;
        $price->unit_price = 475;
        $price->orig_unit_price = 500;
        $price->quantity_price = 2850;
        $price->orig_quantity_price = 3000;
        $price->addQuantityDiscount($quantity_discount_6);
        $this->assertEquals($price, $this->pricing->getPrice($product, 6));

        // Expected
        $price = new Price;
        $price->unit_price = 350;
        $price->orig_unit_price = 500;
        $price->quantity_price = 4200;
        $price->orig_quantity_price = 6000;
        $price->addQuantityDiscount($quantity_discount_12);
        $this->assertEquals($price, $this->pricing->getPrice($product, 12));

        // Expected
        $price = new Price;
        $price->unit_price = 325;
        $price->orig_unit_price = 500;
        $price->quantity_price = 7800;
        $price->orig_quantity_price = 12000;
        $price->addQuantityDiscount($quantity_discount_24);
        $this->assertEquals($price, $this->pricing->getPrice($product, 24));
    }
}
