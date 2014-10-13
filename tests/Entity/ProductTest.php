<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    private function setupProduct()
    {
        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';

        return $product;
    }

    /**
     * @covers Product::__construct
     */
    public function testConstruct()
    {
        $product = new Product;
        $product->id = 1;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 500;
        $product->quantity = 10;
        $product->product_group_id = null;
        $product->require_inventory = true;
        $product->show_price = true;
        $product->active = true;
        $product->visible = true;
        $product->is_taxable = true;
        $product->shipping = true;
        $product->shipping_weight = 16;
        $product->description = 'Test product description';
        $product->rating = null;
        $product->default_image = null;
        $product->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $product->updated = null;

        $this->assertEquals(1, $product->id);
    }

    /**
     * @covers Product::inStock
     */
    public function testRequiredInStock()
    {
        $product = $this->setupProduct();
        $product->require_inventory = true;

        $product->quantity = 0;
        $this->assertFalse($product->inStock());

        $product->quantity = 1;
        $this->assertTrue($product->inStock());
    }

    /**
     * @covers Product::inStock
     */
    public function testNotRequiredInStock()
    {
        $product = $this->setupProduct();
        $product->require_inventory = false;

        $this->assertTrue($product->inStock());
    }

    /**
     * @covers Product::getRating
     */
    public function testGetRating()
    {
        $product = $this->setupProduct();

        $product->rating = 150;
        $this->assertSame(1.5, $product->getRating());

        $product->rating = 500;
        $this->assertSame(5, $product->getRating());
    }
}
