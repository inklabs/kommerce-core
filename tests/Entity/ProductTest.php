<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->id = 1;
        $this->product->sku = 'TST101';
        $this->product->name = 'Test Product';
        $this->product->price = 500;
        $this->product->quantity = 10;
        $this->product->product_group_id = null;
        $this->product->require_inventory = true;
        $this->product->show_price = true;
        $this->product->active = true;
        $this->product->visible = true;
        $this->product->is_taxable = true;
        $this->product->shipping = true;
        $this->product->shipping_weight = 16;
        $this->product->description = 'Test product description';
        $this->product->rating = null;
        $this->product->default_image = null;
        $this->product->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->product->updated = null;

        $this->assertEquals(1, $this->product->id);
    }

    public function testRequiredInStock()
    {
        $this->product->require_inventory = true;

        $this->product->quantity = 0;
        $this->assertFalse($this->product->inStock());

        $this->product->quantity = 1;
        $this->assertTrue($this->product->inStock());
    }

    public function testNotRequiredInStock()
    {
        $this->product->require_inventory = false;

        $this->assertTrue($this->product->inStock());
    }

    public function testGetRating()
    {
        $this->product->rating = 150;
        $this->assertSame(1.5, $this->product->getRating());

        $this->product->rating = 500;
        $this->assertSame(5, $this->product->getRating());
    }

    public function testaddQuantityDiscount()
    {
        $this->product = new Product;
        $this->product->addQuantityDiscount(new ProductQuantityDiscount);

        $this->assertEquals(1, count($this->product->quantity_discounts));
    }

    public function testSortQuantityDiscounts()
    {
        $this->product = new Product;

        $quantity_discount_6 = new ProductQuantityDiscount;
        $quantity_discount_6->id = 1;
        $quantity_discount_6->quantity = 6;

        $quantity_discount_12 = new ProductQuantityDiscount;
        $quantity_discount_12->id = 2;
        $quantity_discount_12->quantity = 12;

        $quantity_discount_24 = new ProductQuantityDiscount;
        $quantity_discount_24->id = 3;
        $quantity_discount_24->quantity = 24;

        $this->product->addQuantityDiscount($quantity_discount_6);
        $this->product->addQuantityDiscount($quantity_discount_12);
        $this->product->addQuantityDiscount($quantity_discount_24);

        $expect = [
            1 => $quantity_discount_6,
            2 => $quantity_discount_12,
            3 => $quantity_discount_24,
        ];

        $this->assertEquals($expect, $this->product->quantity_discounts);

        $this->product->sortQuantityDiscounts();

        $expect = [
            3 => $quantity_discount_24,
            2 => $quantity_discount_12,
            1 => $quantity_discount_6,
        ];

        $this->assertEquals($expect, $this->product->quantity_discounts);
    }
}
