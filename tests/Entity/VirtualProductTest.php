<?php
use inklabs\kommerce\Entity\VirtualProduct;

class VirtualProductTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers VirtualProduct::__construct
     */
    public function test_construct()
    {
        $virtual_product = new VirtualProduct;
        $virtual_product->id = 1;
        $virtual_product->sku = 'TST101';
        $virtual_product->name = 'Test Product';
        $virtual_product->price = 500;
        $virtual_product->quantity = 10;
        $virtual_product->product_group_id = NULL;
        $virtual_product->require_inventory = TRUE;
        $virtual_product->show_price = TRUE;
        $virtual_product->active = TRUE;
        $virtual_product->visible = TRUE;
        $virtual_product->is_taxable = TRUE;
        $virtual_product->shipping = TRUE;
        $virtual_product->shipping_weight = 16;
        $virtual_product->description = 'Test product description';
        $virtual_product->rating = NULL;
        $virtual_product->default_image = NULL;
        $virtual_product->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $virtual_product->updated = NULL;

        $this->assertEquals(1, $virtual_product->id);
    }
}
