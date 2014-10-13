<?php
use inklabs\kommerce\Entity\Product;

class ProductTest extends PHPUnit_Framework_TestCase
{
    private function setup_product()
    {
        $product = new Product;
        $product->sku = 'TST101';
        $product->name = 'Test Product';

        return $product;
    }

    /**
     * @covers Product::__construct
     */
    public function test_construct()
    {
        $product = new Product;
        $product->id = 1;
        $product->sku = 'TST101';
        $product->name = 'Test Product';
        $product->price = 500;
        $product->quantity = 10;
        $product->product_group_id = NULL;
        $product->require_inventory = TRUE;
        $product->show_price = TRUE;
        $product->active = TRUE;
        $product->visible = TRUE;
        $product->is_taxable = TRUE;
        $product->shipping = TRUE;
        $product->shipping_weight = 16;
        $product->description = 'Test product description';
        $product->rating = NULL;
        $product->default_image = NULL;
        $product->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $product->updated = NULL;

        $this->assertEquals(1, $product->id);
    }

    /**
     * @covers Product::in_stock
     */
    public function test_required_in_stock()
    {
        $product = $this->setup_product();
        $product->require_inventory = TRUE;

        $product->quantity = 0;
        $this->assertFalse($product->in_stock());

        $product->quantity = 1;
        $this->assertTrue($product->in_stock());
    }

    /**
     * @covers Product::in_stock
     */
    public function test_not_required_in_stock()
    {
        $product = $this->setup_product();
        $product->require_inventory = FALSE;

        $this->assertTrue($product->in_stock());
    }

    /**
     * @covers Product::get_rating
     */
    public function test_get_rating()
    {
        $product = $this->setup_product();

        $product->rating = 150;
        $this->assertSame(1.5, $product->get_rating());

        $product->rating = 500;
        $this->assertSame(5, $product->get_rating());
    }
}
